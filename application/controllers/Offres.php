<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * \file Offres.php
 * \brief Controllers des Offres
 * \date 08/10/2017
 */


class Offres extends CI_Controller {


 	public function __construct()

    {
        parent::__construct();
		$this->load->model('Personnalisation_model','dbColor');
        $this->load->model('Offre_model','dbOffre');
    }

/**
 * \fn public index()
 * \brief Fonction index qui affiche le formulaire pour offrir un covoiturage
 *
 */
  
	public function index()
	{
		if($this->session->userdata('email')){
			$data['page_title'] = TITLE_HOME;
			$data['SiteArrive'] = $this->dbOffre->get_all_siteArrive();
			$data['couleurs'] = $this->dbColor->get_current_colors();
			$this->load->view('header',$data);
        	$this->load->view('page_offre');
		}else{
			redirect('Connexion/index');
		}
		
	}
	
	/**
	* \fn public add_offer()
	* \brief Fonction add_offer qui ajoute une offre de covoiturage en vérifiant 
	*		 que les champs rentrès par l'utilisateur sont bien formés.
	*		 On envoie un mail ensuite a l'utilisateur pour lui confirmer que 
	*		 son offre covoiturage a bien été prise en compte.
	*
	*/
	public function add_offer(){
		
	$this->form_validation->set_rules('depart_nom', 'Depart_Nom', 'regex_match["^[A-Za-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ\\s\'-]{2,100}$"]|required|trim');
	$this->form_validation->set_rules('depart_adress', 'Depart_Adresse', 'required|regex_match["."]');
	$this->form_validation->set_rules('arrivee_nom', 'Arrivee_Nom', 'regex_match["^[A-Za-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ\\s\'-]{2,100}$"]|required|trim');
	$this->form_validation->set_rules('arrivee_adress', 'Arrivee_Adresse', 'required|regex_match["."]');
	$this->form_validation->set_rules('date', 'Date', 'required|regex_match["^2018-01-2[0-8]"]');
	$this->form_validation->set_rules('infoVoit', 'InfoVoit', 'regex_match["."]');
	$this->form_validation->set_rules('nbPlace', 'NbPlace', 'required|regex_match["[0-6]{1}"]');
	$this->form_validation->set_rules('heure', 'Heure', 'required|regex_match["^((([0-1][0-9])?(2[0-4])?){1}:[0-5][0-9])$"]');
	
	
	if ($this->form_validation->run() == false) {
			$data['page_title'] = TITLE_HOME;
			$data['error'] = "Votre champs n'est pas bien remplis.";
			$data['couleurs'] = $this->dbColor->get_current_colors();
			$this->load->view('header',$data);
			$this->load->view('page_offre');
	}else {
		  $lieuDepart = $_POST['depart_nom'];
		  $adresseDepart = $_POST['depart_adress'];
		  
		  $lieuArrive = $_POST['arrivee_nom'];
		  $adresseArrive = $_POST['arrivee_adress'];
		  
		  $date = $_POST['date'];
		  $heure = $_POST['heure'];
		  $infoVoiture = $_POST['infoVoit'];
		  
		  $data['idCond'] = $this->session->userdata['email'];
		  $data['depart_nom'] = htmlspecialchars($lieuDepart);
		  $data['arrivee_nom'] = htmlspecialchars($lieuArrive);
		  $data['depart_adress'] = htmlspecialchars($adresseDepart);
		  $data['arrivee_adress'] = htmlspecialchars($adresseArrive);
		  $data['date'] = $date;
		  $data['place'] = $_POST['nbPlace'];
		  $data['infoVoit'] = htmlspecialchars($infoVoiture);
		  $data['heure'] = $heure;
		  $emailAlert = $this->dbOffre->add_offers($data);
		  
		  
		  
		  date_default_timezone_set('Europe/Paris');
		  $this->load->library('email');
		  $config['protocol'] = 'mail';

		  $config['charset'] = 'utf-8';

		  $config['smtp_host'] = 'auth.smtp.1and1.fr';
		  $config['smtp_user'] = 'contact@covoit-karen.org';
		  $config['smtp_pass'] = 'projetOPREN35.';
		  $config['smtp_port'] = '465';
		  $config['smtp_timeout'] = '10';
		  $this->email->initialize($config);
		  
		  $email = $this->session->userdata('email');
		  
		  $this->email->from('contact@covoit-karen.org', 'Équipe Karen');
		  $this->email->to($email);
		  
		  $this->email->subject('Confirmation d\'offre de covoiturage');
		  $this->email->message('Bonjour,' .PHP_EOL. 'Vous venez d\'offrir un covoiturage sur la plateforme KAREN.' .PHP_EOL. 
		  'Le covoiturage à été enregistré avec l\'adresse mail: ' .$email. '. Voici un récapitulatif de votre covoiturage :' .PHP_EOL. 
		  'Lieu de départ : ' . $lieuDepart . ', ' . $adresseDepart .PHP_EOL.
		  'Date de départ : ' . $date .PHP_EOL. 
		  'Heure de départ : ' . $heure .PHP_EOL.
		  'Lieu d\'arrivé : ' . $lieuArrive . ', ' . $adresseArrive .PHP_EOL.
		  'Informations sur le véhicule : ' . $infoVoiture .PHP_EOL.
		  'Merci de votre confiance.' . PHP_EOL . PHP_EOL. 'L\'Équipe KAREN.');
		  
		  $this->email->send();
		  
		  
		  foreach($emailAlert as $row){ 
			$email = $row['emailPers'];
			$this->email->from('contact@covoit-karen.org', 'Équipe Karen');
			$this->email->to($email);
			
			$this->email->subject('Alerte Covoiturage');
			$this->email->message('Bonjour,' .PHP_EOL . 'Une nouvelle offre de covoiturage a été postée.'.PHP_EOL .
			'Lieu de départ : ' . $lieuDepart . ', ' . $adresseDepart .PHP_EOL .
			'Date de départ : ' . $date .PHP_EOL .
			'Heure de départ : ' . $heure .PHP_EOL .
			'Pour plus d\'informations, rendez-vous sur notre site.' . PHP_EOL .
			'Merci de votre confiance.' . PHP_EOL . PHP_EOL . 'L\'Équipe KAREN.');
			$this->email->send();
		  }
		  
		  $this->session->set_flashdata('validation',"Votre covoiturage a bien été enregistrée. Vous allez recevoir un mail de confirmation dans quelques minutes.");
		if(isset($_POST['retour'])){
			if($_POST['retour']==TRUE){
				redirect('Offres/afficher_retour');
			}else{
				redirect('Accueil/index');
		 	}
		}else{
			redirect('Accueil/index');
		}
		 
		 
	}
}
	
	/**
	 * \fn public afficher_retour()
	 * \brief Fonction afficher_retour qui l'offre de retour si l'utilisateur a
	 *		  coché cette option en remplissant le formulaire d'offre.
	 *
	 */
	public function afficher_retour(){
		$data['page_title'] = "Offre retour";
		$data['retour'] = TRUE;
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
        $this->load->view('page_offre', $data);
	}

}
