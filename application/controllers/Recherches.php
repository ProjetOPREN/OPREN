<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * \file Recherches.php
 * \brief Controllers des Recherches de covoiturage
 * \author Audrey Martin
 * \date 08/10/2017
 *
 */



class Recherches extends CI_Controller {


 	public function __construct()

    {
        parent::__construct();
		$this->load->model('Personnalisation_model','dbColor');
        $this->load->model('Offre_model','dbOffre');
        $this->load->model('Recherche_model','dbDemande');
    }

	/**
	 * \fn public chercher_page()
	 * \brief Fonction chercher_page qui affiche la page qui permet à l'utilisateur
	 *		  de sélectionner une date pour regarder les offres.
	 *
	 */
	public function chercher_page()
	{
		$data['page_title'] = TITLE_HOME;

		//$data['offres'] = $this->dbOffre->get_all_offers();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
        $this->load->view('page_choix_date');
	}
	
	/**
	 * \fn public chercher_date()
	 * \brief Fonction chercher_date qui les offres en fonction de la date
	 *		  choisie par l'utilisateur.
	 *
	 */
	public function chercher_date()	{
		if(empty($_POST['date']) && empty($_POST['recup'])){
			$date = '2018-01-21';
		}else if(!empty($_POST['date'])&&empty($_POST['recup'])){
			$date =$_POST['date'];
		}else{
			$date =$_POST['recup'];
		}
		$data['page_title'] = TITLE_HOME;

		$data['offres'] = $this->dbOffre->get_offers_date($date);
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
        $this->load->view('page_recherche',$data);


	}
	/**
	 * \fn public reserver()
	 * \brief Fonction reserver qui permet à un utilisateur de réserver une offre d'un autre.
	 *		  On envoie un mail pour confirmer la réservation a l'utilisateur et un autre email
	 *		  au conducteur qui avait proposer l'offre.
	 *
	 */
	public function reserver(){
		if(isset($_POST['idOffre']) && isset($_POST['idCovoit'])){
			if($this->session->userdata('email')){

				$data['emailPass'] = $this->session->userdata('email');

				//On vérifie qu'une personne ne puisse pas réserver une de ses offres
				$emailCond = $this->dbOffre->getEmailCond($_POST['idOffre']);

				if($emailCond[0]['emailCond']!=$data['emailPass']){

					//On vérifie que la personne ne puisse pas réserver une offre qu'elle a déjà réservé.
					$emailsPassagers = $this->dbDemande->getEmailPassagers($_POST['idCovoit']);

					$trouve = false;
					foreach ($emailsPassagers as $row) {
						foreach ($row as $key => $value) {
							if($value==$data['emailPass']){
								$trouve = true;
							}
						}
					}

					if(!($trouve)){

						$demandes = $this->dbDemande->get_demandesInvalid_pers($data['emailPass']);

						if(empty($demandes)){

							$infosOffre = $this->dbOffre->get_one_offer($_POST['idOffre']);
							$this->dbDemande->add_request_from_offer($infosOffre[0],$_POST['idCovoit']);
							$this->dbOffre->subPlace($_POST['idCovoit']);

							$idoffre = $infosOffre[0]['idOffre'];
							$iddepart = $infosOffre[0]['idDepart'];
							$idarrivee = $infosOffre[0]['idArrive'];
							$recapitulatif = $this->dbDemande->getRecapitulatif($iddepart, $idarrivee, $idoffre);

							date_default_timezone_set('Europe/Paris');
							$this->load->library('email');

							$config['protocol'] = 'mail';
							$config['newline']    = "\r\n";
							$config['mailtype'] = 'text';
							$config['charset'] = 'utf-8';
							$config['smtp_host'] = 'auth.smtp.1and1.fr';
							$config['smtp_user'] = 'contact@covoit-karen.org';
							$config['smtp_pass'] = 'projetOPREN35.';
							$config['smtp_port'] = '465';
							$config['smtp_timeout'] = '5';
							$config['priority'] = '1';

							$mailConducteur = $this->dbDemande->getEmailConducteur($idoffre);
							$conducteur = $this->dbDemande->getCoordonnees($mailConducteur[0]['emailCond']);

							$this->email->initialize($config);

							$email = $this->session->userdata('email');

							$this->email->from('contact@covoit-karen.org', 'Équipe Karen');
							$this->email->to($email);

							/**Mail au passager qui a réserver le covoiturage **/

							$this->email->subject('Confirmation de réservation');
							$this->email->message('Bonjour,' . PHP_EOL . 'Vous venez de réserver un covoiturage. ' . PHP_EOL .
							'La réservation à été effectuée avec l\'adresse mail: ' .$email. '. Voici un récapitulatif de votre réservation :' . PHP_EOL .
							'Lieu de départ : ' . $recapitulatif[0]['Dnom'] . ', ' . $recapitulatif[0]['Dadresse'] . PHP_EOL .
							'Date de départ : ' .$recapitulatif[0]['jour'] . PHP_EOL .
							'Heure de départ : ' .$recapitulatif[0]['heure'] . PHP_EOL .
							'Lieu d\'arrivé : ' . $recapitulatif[0]['Anom'] . ', ' . $recapitulatif[0]['Aadresse'] . PHP_EOL .
							'Informations sur le véhicule : ' . $recapitulatif[0]['infovoiture'] . PHP_EOL . PHP_EOL .
							'Afin de pouvoir vous mettre en relation avec le conducteur, voici ses ' . 'coordonnées :' . PHP_EOL .
							'Nom : ' . $conducteur[0]['nom'] . ' ' . $conducteur[0]['prenom'] . PHP_EOL .
							'Téléphone : ' . $conducteur[0]['telephone'] . PHP_EOL .
							'Mail : ' . $mailConducteur[0]['emailCond'] . PHP_EOL . PHP_EOL .
							'Merci de votre confiance.' . PHP_EOL . PHP_EOL. 'L\'Équipe KAREN.');

							$this->email->send();

							//$this->email->initialize($config);

							$this->email->from('contact@covoit-karen.org', 'Équipe Karen');
							$this->email->to($mailConducteur[0]['emailCond']);

							$passager = $this->dbDemande->getCoordonnees($email);

							/** Mail au conducteur, qui a poster l'offre **/

							$this->email->subject('Réservation de votre offre de covoiturage');
							$this->email->message('Bonjour,' . PHP_EOL . 'Une personne vient de réserver votre covoiturage.' .PHP_EOL .
							'Voici le récapitulatif de votre offre :' .PHP_EOL.
							'Lieu de départ : ' . $recapitulatif[0]['Dnom'] . ', ' . $recapitulatif[0]['Dadresse'] . PHP_EOL .
							'Date de départ : ' .$recapitulatif[0]['jour'] . PHP_EOL .
							'Heure de départ : ' .$recapitulatif[0]['heure'] . PHP_EOL .
							'Lieu d\'arrivé : ' . $recapitulatif[0]['Anom'] . ', ' . $recapitulatif[0]['Aadresse'] . PHP_EOL .
							'Informations sur le véhicule : ' . $recapitulatif[0]['infovoiture'] . PHP_EOL . PHP_EOL .
							'Afin de pouvoir vous mettre en relation avec le passager, voici ses ' . 'coordonnées :' . PHP_EOL .
							'Nom : ' . $passager[0]['nom'] . ' ' . $passager[0]['prenom'] . PHP_EOL .
							'Téléphone : ' . $passager[0]['telephone'] . PHP_EOL .
							'Mail : ' . $email . PHP_EOL . PHP_EOL .
							'Merci de votre confiance.' . PHP_EOL . PHP_EOL . 'L\'Équipe KAREN.');

							$this->email->send();

							$this->session->set_flashdata('validation',"Votre réservation a bien été enregistrée. Vous allez recevoir un mail de confirmation dans quelques minutes. Merci de votre confiance.");

							redirect('Accueil/index');

						}else{

							$this->session->set_flashdata('idCovoit',$_POST['idCovoit']);
							$this->session->set_flashdata('idOffre',$_POST['idOffre']);
							$data['Passagers'] = $demandes;
							$data['page_title'] = "Je choisis une demande";
							$data['couleurs'] = $this->dbColor->get_current_colors();
							$this->load->view('header',$data);
							$this->load->view('page_aff_demande',$data);
						}

					}else{
						$this->session->set_flashdata('error','Vous avez déjà réservée cette offre.');
						redirect('Recherches/chercher_date');

					}
				}else{
					$this->session->set_flashdata('error','Vous ne pouvez pas réserver une offre que vous avez postée.');
					redirect('Recherches/chercher_date');
				}


			}else{
				redirect('Connexion/index');
			}
		}else{
			redirect('Recherches/index');
		}

	}
	
	/**
	* \fn public add_cov_pass()
	* \brief Fonction add_cov_pass qui lie un passager à un covoiturage.
	*
	*/
	public function add_cov_pass(){
		$idOffre = $this->session->flashdata('idOffre');
		$idCovoit = $this->session->flashdata('idCovoit');
		if(!empty($idOffre) && !empty($idCovoit)){
			if($_POST['idPassager']!=""){

				$this->dbDemande->accepter_covoit($_POST['idPassager'],$idCovoit);
				$this->dbOffre->subPlace($_POST['idCovoit']);
				redirect('Accueil/index');

			}else{

				$infosOffre = $this->dbOffre->get_one_offer($idOffre);
				$this->dbDemande->add_request_from_offer($infosOffre[0],$idCovoit);
				$this->dbOffre->subPlace($_POST['idCovoit']);
				$this->session->set_flashdata('validation',"Votre réservation a bien été enregistrée.");
				redirect('Recherches/chercher_date()');

			}
		}else{
			redirect("Recherches/chercher_date()");
		}

	}


	/**
	 * \fn public afficher_form_alerte()
	 * \brief Permet d'afficher le formulaire d'alerte
	 */

	public function afficher_form_alerte(){
		if($this->session->userdata('email')){
			$data['date'] = ""/*$_POST['date']*/;
			$data['page_title'] = TITLE_HOME;
			$data['couleurs'] = $this->dbColor->get_current_colors();
			$this->load->view('header',$data);
		    $this->load->view('page_alerte',$data);
		}else{
			redirect('Connexion/index');
		}
	}

	/**
	 * \fn public ajouter_demande()
	 * \brief Permet d'ajouter une alerte et teste si une ou plusieurs offres peuvent intéressé l'utilisateur
	 */

public function ajouter_alerte(){
	// test de formulaire.
	$this->form_validation->set_rules('date', 'Date', 'required|regex_match["^2018-01-2[0-8]"]');
	$this->form_validation->set_rules('heure1', 'Heure', 'required|regex_match["^((([0-1][0-9])?(2[0-4])?){1}:[0-5][0-9])$"]');
	$this->form_validation->set_rules('heure2', 'Heure', 'required|regex_match["^((([0-1][0-9])?(2[0-4])?){1}:[0-5][0-9])$"]');

	if ($this->form_validation->run() == false) {
			$data['page_title'] = TITLE_HOME;
			$data['couleurs'] = $this->dbColor->get_current_colors();
			$this->load->view('header',$data);
			$this->load->view('page_alerte');
	}else {
		if (!empty($_POST)) {
			$request['idPers'] = $this->session->userdata['email'];
			$request['jour'] = $_POST['date'];
			$request['heure1'] = $_POST['heure1'] . ":00";
			$request['heure2'] = $_POST['heure2'] . ":00";

			$sitesId = $this->dbDemande->add_alert($request);
			$this->session->set_flashdata('validation',"Votre alerte de covoiturage a bien été enregistrée.");
			redirect('Accueil/index');
		}
	}
	}
}
