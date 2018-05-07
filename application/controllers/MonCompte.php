<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * \file MonCompte.php
 * \brief Controllers de MonCompte
 * \date 01/11/2017
 */


class MonCompte extends CI_Controller {


 	public function __construct()

    {
        parent::__construct();
		$this->load->model('Personnalisation_model','dbColor');
        $this->load->model('MonCompte_model', 'dbmoncompte');
        $this->load->model('Recherche_model','dbDemande');
        $this->load->model('MesMessages_model','dbMessage');
		$this->load->library('encryption');
    }

/**
 * \fn public MesReservations()
 * \brief Fonction MesReservations qui affiche une page avec toutes 
 *		  les réservations de l'utilisateur connecté.
 *
 */
  
	public function MesReservations() {
		$data['page_title'] = TITLE_HOME;
		$data['users'] = $this->dbmoncompte->get_reservation();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('mes_reservations',$data);
	}
	
	/**
	 * \fn public MonCompte()
	 * \brief Fonction MonCompte qui affiche une page avec toutes
	 *		  les informations de l'utilisateur connecté.
	 *
	 */
	public function MonCompte() {
		$data['page_title'] = TITLE_HOME;
		$data['users'] = $this->dbmoncompte->get_infos();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('mes_infos',$data);
	}
	
	/**
	 * \fn public MesAlertes()
	 * \brief Fonction MesAlertes qui affiche une page avec toutes 
	 *		  les alertes de l'utilisateur connecté.
	 *
	 */
	public function MesAlertes() {
		$data['page_title'] = TITLE_HOME;
    	$data['users'] = $this->dbmoncompte->get_alertes_user();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('mes_alertes',$data);
	}
	
	/**
	 * \fn public MesCovoiturages()
	 * \brief Fonction MesCovoiturages qui affiche une page avec tous 
	 *		  les covoiturages de l'utilisateur connecté.
	 *
	 */
	public function MesCovoiturages() {
		$data['page_title'] = TITLE_HOME;
    	$data['users'] = $this->dbmoncompte->get_offre_user();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('mes_covoiturages',$data);
	}
	
	/**
	 * \fn public MesMessages()
	 * \brief Fonction MesMessages qui affiche une page avec toutes les 
	 *		  les discussions de l'utilisateur connecté.
	 *
	 */
	public function MesMessages(){
		$data['page_title'] = TITLE_HOME;
		$data['discussion'] = $this->dbMessage->getDiscussions();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('page_messages',$data);
	}
	
	/**
	 * \fn public Discussion()
	 * \brief Fonction Discussion qui affiche une page avec les messages
	 *		  entre l'utilisateur connecté et un autre utilisateur.
	 *
	 */
	public function Discussion(){
		if($this->session->userdata('email')){
			
			$data['page_title'] = TITLE_HOME;
			$email = $_POST['email']; 
			$email = str_replace("/", "",$email);
			$emailsession = $this->session->userdata('email');
			$resultat = $this->dbMessage->getNomPrenom($email);
			$data['prenom'] = $resultat;
			$result = $this->dbMessage->getMessages($email,$emailsession);
			$data['messages'] = $result;
			$destinataire = array();
			$destinataire[0]['Destinataire'] = $email;
			$data['destinataire'] = $destinataire;
			$data['couleurs'] = $this->dbColor->get_current_colors();
			$this->load->view('header',$data);
			$this->load->view('page_discussion',$data);
		}
		else {
			redirect('Connexion/index');
		}
	}
	
	/**
	 * \fn public Envoyer()
	 * \brief Fonction Envoyer qui permet d'envoyer le message d'un utilisateur vers un autre.
	 *		  On le stocke en base de données et on envoie un mail au destinataire (si il à activer l'option) 
	 *		  pour lui dire qu'il vient de recevoir un message.
	 *
	 */
	public function Envoyer(){
		$this->form_validation->set_message('Message', 'Messages', 'max_length[300]');
		$messages = htmlspecialchars($_POST['Message']);
		$this->encryption->initialize(array('driver' => 'openssl'));
		$messageschiffre =  $this->encryption->encrypt($messages);
		$data['Messages'] = $messageschiffre;
		$data['Emetteur'] = $this->session->userdata('email');
		$email = $_POST['Destinataire']; 
		$email = str_replace("/", "",$email);
		$data['Destinataire'] = $email;
		$this->dbMessage->envoyer($data);
		$emailvoir = $this->envoyermail($data);
		// On redirige vers la page de discussion.
		$data['page_title'] = TITLE_HOME;
		$emailsession = $this->session->userdata('email');
		$resultat = $this->dbMessage->getNomPrenom($email);
		$destinataire = array();
		$destinataire[0]['Destinataire'] = $email;
		$data['destinataire'] = $destinataire;
		$data['prenom'] = $resultat;
		$data['voir'] = $emailvoir;
		$result = $this->dbMessage->getMessages($email,$emailsession);
		$data['messages'] = $result;
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('page_discussion',$data);
	}
	
	
	/**
	 * \fn public activer()
	 * \brief Fonction activer qui active/désactive les notifications par email
	 *		  à chaque nouveau message d'un autre utilisateur.
	 *
	 */
	public function activer(){
		$this->dbMessage->changeBoolean();
		$boolean = $this->session->userdata('boolean');
		if($boolean){
			$this->session->set_flashdata('validation' ," Vous venez d'activez la notification par email");
		}else{
			$this->session->set_flashdata('validation' ," Vous venez de désactivez la notification par email");
		}
		$data['page_title'] = TITLE_HOME;
		$data['discussion'] = $this->dbMessage->getDiscussions();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('page_messages',$data);
	}
	
	
	/**
	 * \fn public envoyermail()
	 * \brief Fonction envoyermail qui envoie le mail à l'utilisateur qui va recevoir
	 *		  le message.
	 * $data : 	tableau où se trouve toutes les informations, l'Emetteur, le Destinataire
	 *			et la date du message.
	 *
	 */
	public function envoyermail($data){
		$boolean = $this->dbMessage->recupBoolean($data['Destinataire']);
		$nomprenom = $this->dbMessage->getNomPrenom($data['Destinataire']);
		if($boolean[0]['booleanEmail']){
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

			$this->email->initialize($config);

			$this->email->from('contact@covoit-karen.org', 'Équipe Karen');
			$this->email->to($data['Destinataire']);

			$this->email->subject('Nouveau Message sur KAREN');
			$this->email->message('Bonjour,' .PHP_EOL. 'Vous venez de recevoir un nouveau message de la part de '.$nomprenom[0]['nom'] .' '.$nomprenom[0]['prenom'] .' sur la plateforme de covoiturage KAREN.' .PHP_EOL.
			'Connectez vous a la plateforme KAREN pour pouvoir lire le message' . PHP_EOL .
			'Merci de votre confiance.' . PHP_EOL . PHP_EOL. 'L\'Équipe KAREN.');

			$this->email->send();
		}
	}
	
	/**
	 * \fn public annulerReservation()
	 * \brief Fonction annulerReservation qui permet à un utilisateur
	 *		  d'annuler une réservation qu'il avait faite auparavant.
	 *		  On envoie un mail au conducteur qui avait offert le covoiturage.
	 *
	 */
	public function annulerReservation() {
		$data['page_title'] = TITLE_HOME;
		$idPassager = $_POST['idPass'];
		$idArrive = $_POST['idArrive'];
		$idDepart = $_POST['idDepart'];
		
		$idOffre = $this->dbmoncompte->getIDOffre($idPassager);
		echo $idOffre[0]['idOffre'];
		$emailConducteur = $this->dbDemande->getEmailConducteur($idOffre[0]['idOffre']);
		
		$recapitulatif = $this->dbDemande->getRecapitulatif($idDepart, $idArrive, $idOffre[0]['idOffre']);
		
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
		
		$emailPassager = $this->session->userdata('email');
		
		$this->email->initialize($config);
		
		$this->email->from('contact@covoit-karen.org', 'Équipe Karen');
		$this->email->to($emailPassager);

		/**Mail au passager qui a réserver le covoiturage **/

		$this->email->subject('Annulation de votre réservation');
		$this->email->message('Bonjour,' . PHP_EOL . 'Nous vous confirmons l\'annulation de votre réservation. ' . PHP_EOL .
		'Voici un récapitulatif de la réservation annulée :' . PHP_EOL .
		'Lieu de départ : ' . $recapitulatif[0]['Dnom'] . ', ' . $recapitulatif[0]['Dadresse'] . PHP_EOL .
		'Date de départ : ' .$recapitulatif[0]['jour'] . PHP_EOL .
		'Heure de départ : ' .$recapitulatif[0]['heure'] . PHP_EOL .
		'Lieu d\'arrivé : ' . $recapitulatif[0]['Anom'] . ', ' . $recapitulatif[0]['Aadresse'] . PHP_EOL . PHP_EOL .
		'Nous avons également prevenu, par mail, le conducteur de votre annulation.' . PHP_EOL .
		'Merci de votre confiance.' . PHP_EOL . PHP_EOL. 'L\'Équipe KAREN.');

		$this->email->send();

		/**Mail au conducteur qui a offert le covoiturage **/

		$this->email->from('contact@covoit-karen.org', 'Équipe Karen');
		$this->email->to($emailConducteur[0]['emailCond']);

		$this->email->subject('Annulation de réservation d\'un passager');
		$this->email->message('Bonjour,' . PHP_EOL . 'Une personne vient d\'annuler sa réservation concernant votre covoiturage.' .PHP_EOL .
		'Une place s\'est donc ajoutée automatiquement à votre covoiturage.' .PHP_EOL .
		'Voici le récapitulatif de votre offre :' .PHP_EOL.
		'Lieu de départ : ' . $recapitulatif[0]['Dnom'] . ', ' . $recapitulatif[0]['Dadresse'] . PHP_EOL .
		'Date de départ : ' .$recapitulatif[0]['jour'] . PHP_EOL .
		'Heure de départ : ' .$recapitulatif[0]['heure'] . PHP_EOL .
		'Lieu d\'arrivé : ' . $recapitulatif[0]['Anom'] . ', ' . $recapitulatif[0]['Aadresse'] . PHP_EOL .
		'Informations sur le véhicule : ' . $recapitulatif[0]['infovoiture'] . PHP_EOL . PHP_EOL .
		'Merci de votre confiance.' . PHP_EOL . PHP_EOL . 'L\'Équipe KAREN.');
		
		$this->email->send();
		
		$this->dbmoncompte->annuler_reservation($idPassager, $idOffre[0]['idOffre']);

		$this->session->set_flashdata('annulation',"Votre réservation a bien été annulé. Vous recevrez un email de confirmation dans quelques instants. Merci de votre confiance.");
		redirect('MonCompte/MesReservations');
	}
	
	
	/**
	 * \fn public annulerCovoiturage()
	 * \brief Fonction annulerCovoiturage qui permet à un utilisateur qui
	 *		  avait proposé un covoiturage de l'annuler. Les passagers qui avaient réservé 
	 *		  ce covoiturage seront prévenus par mail de l'annulation du conducteur.
	 *
	 */
	public function annulerCovoiturage() {
		$data['page_title'] = TITLE_HOME;
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

		$this->email->initialize($config);

		$idOffre = $_POST['idOffre'];
		$idArrive = $_POST['idArrive'];
		$idDepart = $_POST['idDepart'];
		$listeIDPassagers = $this->dbmoncompte->getListePassagers($idOffre);
		$recapitulatif = $this->dbDemande->getRecapitulatif($idDepart, $idArrive, $idOffre);

		for ($i = 0; $i < sizeof($listeIDPassagers); $i++) { 
			$this->dbmoncompte->annuler_reservation($listeIDPassagers[$i]['idPassager'], $idOffre);
			$emailPassager = $this->dbDemande->getEmailPassager($listeIDPassagers[$i]['idPassager']);

			/** Envoie d'un mail à chaque passager ayant réserver le covoiturage **/

			$this->email->from('contact@covoit-karen.org', 'Équipe Karen');
			$this->email->to($emailPassager);

			$this->email->subject('Annulation de votre covoiturage');
			$this->email->message('Bonjour,' . PHP_EOL . 'Un des covoiturages que vous avez réservé a été annulé.' .PHP_EOL .
			'Vous pouvez toujours réserver un autre covoiturage depuis la page de recherche.' .PHP_EOL .
			'Voici le récapitulatif du covoiturage annulé :' .PHP_EOL.
			'Lieu de départ : ' . $recapitulatif[0]['Dnom'] . ', ' . $recapitulatif[0]['Dadresse'] . PHP_EOL .
			'Date de départ : ' .$recapitulatif[0]['jour'] . PHP_EOL .
			'Heure de départ : ' .$recapitulatif[0]['heure'] . PHP_EOL .
			'Lieu d\'arrivé : ' . $recapitulatif[0]['Anom'] . ', ' . $recapitulatif[0]['Aadresse'] . PHP_EOL .
			'Informations sur le véhicule : ' . $recapitulatif[0]['infovoiture'] . PHP_EOL . PHP_EOL .
			'Merci de votre confiance.' . PHP_EOL . PHP_EOL . 'L\'Équipe KAREN.');
		
			$this->email->send();
		}

		/**Mail au conducteur qui a offert le covoiturage **/
		$emailConducteur = $this->session->userdata('email');

		$this->email->from('contact@covoit-karen.org', 'Équipe Karen');
		$this->email->to($emailConducteur);

		$this->email->subject('Annulation de réservation d\'un passager');
		$this->email->message('Bonjour,' . PHP_EOL . 'Une personne vient d\'annuler sa réservation concernant votre covoiturage.' .PHP_EOL .
		'Une place s\'est donc ajoutée automatiquement à votre covoiturage.' .PHP_EOL .
		'Voici le récapitulatif de votre offre :' .PHP_EOL.
		'Lieu de départ : ' . $recapitulatif[0]['Dnom'] . ', ' . $recapitulatif[0]['Dadresse'] . PHP_EOL .
		'Date de départ : ' .$recapitulatif[0]['jour'] . PHP_EOL .
		'Heure de départ : ' .$recapitulatif[0]['heure'] . PHP_EOL .
		'Lieu d\'arrivé : ' . $recapitulatif[0]['Anom'] . ', ' . $recapitulatif[0]['Aadresse'] . PHP_EOL .
		'Informations sur le véhicule : ' . $recapitulatif[0]['infovoiture'] . PHP_EOL . PHP_EOL .
		'Merci de votre confiance.' . PHP_EOL . PHP_EOL . 'L\'Équipe KAREN.');
		
		$this->email->send();

		$this->dbmoncompte->annuler_covoiturage($idOffre);

		$this->session->set_flashdata('annulation',"Votre covoiturage a bien été annulé. Vous recevrez un email de confirmation dans quelques instants. Merci de votre confiance.");
		redirect('MonCompte/MesCovoiturages');
	}
	
	
	/**
	 * \fn public annulerAlertes()
	 * \brief Fonction annulerAlertes qui permet a l'utilisateur d'annuler sa
	 *		  demande d'Alertes dès qu'un covoiturage apparaisaient sur la plateforme.
	 *
	 */
	public function annulerAlertes(){
		$data['page_title'] = TITLE_HOME;

		$idAlerte = $_POST['idAlerte'];

		$this->dbmoncompte->annuler_Alertes($idAlerte);
		$this->session->set_flashdata('annulation',"Votre alerte a bien été annulée. Merci de votre confiance.");
		redirect('MonCompte/MesAlertes');
	}
	/**
	 * \fn public modifier()
	 * \brief Fonction modifier qui affiche une page avec des champs
	 *		  pour permettre à l'utilisateur de modifier ses informations
	 *		  personnelles.
	 *
	 */
	public function modifier(){
		$data['page_title'] = TITLE_HOME;
		$data['users'] = $this->dbmoncompte->get_infos();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('modifier_infos',$data);
	}	
	
	/**
	 * \fn public modification()
	 * \brief Fonction modification qui modifie les informations personnelles
	 *		  de l'utilisateur en fonction des champs qu'il a remplis.
	 *		  On vérifie si les champs sont bien formés ainsi que l'ancienMDP
	 *		  est le bon (si il a modifié le MDP).
	 *
	 */
	public function modification(){
		if(!empty($_POST['nom'])){
			$this->form_validation->set_rules('nom', 'Nom', 'regex_match["^[A-Za-zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\\s-]{2,50}$"]');
			if ($this->form_validation->run() == false){
				$this->session->set_flashdata('erreurnom' ," Votre nouveau nom est incorrect.");
			}else{
				$nom = htmlspecialchars($_POST['nom']);
				$this->dbmoncompte->modifier_nom($nom);
				$this->session->set_flashdata('validationnom' ," Votre nom a bien été modifié");
			}
			$this->form_validation->reset_validation();
		}
		if(!empty($_POST['prenom'])){
			$this->form_validation->set_rules('prenom', 'Prénom', 'regex_match["^[A-Za-zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\\s-]{2,50}$"]');
			if ($this->form_validation->run() == false){
				$this->session->set_flashdata('erreurprenom' ," Votre nouveau prenom est incorrect.");
			}else{
				$prenom = htmlspecialchars($_POST['prenom']);
				$this->dbmoncompte->modifier_prenom($prenom);
				$this->session->set_flashdata('validationprenom' ," Votre prénom a bien été modifié");
			}
			$this->form_validation->reset_validation();
		}
		if(!empty($_POST['telephone'])){
			$this->form_validation->set_rules('telephone', 'Téléphone', 'trim|is_numeric|min_length[10]|max_length[10]|regex_match["^0[0-9]{9}"]');
			if ($this->form_validation->run() == false){
				$this->session->set_flashdata('erreurtel' ," Votre nouveau numéro de téléphone est incorrect.");
			}else{
				$tel = htmlspecialchars($_POST['telephone']);
				$this->dbmoncompte->modifier_tel($tel);
				$this->session->set_flashdata('validationtel' ," Votre numéro de téléphone a bien été modifié");
			}
			$this->form_validation->reset_validation();
		}
		
		if(!empty($_POST['ancienMDP']) && !empty($_POST['nouvMDP']) && !empty($_POST['confMDP'])){
			$this->form_validation->set_rules('ancienMDP', 'Ancien Mot de passe', 'regex_match["^[A-Za-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ\#\!\^\$\(\)\{\}\?\+\*\.,-_=/§µ%¨&~°`@|¤<>]{5,50}$"]');
			$this->form_validation->set_rules('nouvMDP', 'Nouveau Mot de passe', 'regex_match["^[A-Za-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ\#\!\^\$\(\)\{\}\?\+\*\.,-_=/§µ%¨&~°`@|¤<>]{5,50}$"]');
			$this->form_validation->set_rules('confMDP', 'Confirmation Mot de Passe', 'matches[nouvMDP]');
			$this->form_validation->set_message('ancienMDP', 'differs[$this->encrypt->decode($this->session->userdata(\'mdp\'))]', 'L\'ancien mot de passe ne correspond pas');
			$this->form_validation->set_message('nouvMDP', 'differs[confMDP]', 'Les mots de passes ne correspondent pas');
			if ($this->form_validation->run() == false){
				if($this->encryption->decrypt($this->session->userdata('mdp')) != $_POST['ancienMDP']){
					$this->session->set_flashdata('erreurancienmdp' ,"Votre ancien mot de passe ne correspond pas.");
				}
				else if ($_POST['nouvMDP'] != $_POST['confMDP']){
					$this->session->set_flashdata('erreurnouvmdp' ,"Vous n'avez pas mis deux fois le même mot de passe.");
					}
				else {
					$this->session->set_flashdata('erreurmdp' ,"Le nouveau n'est pas au bon format.");
				}
			}else{
				$mdp = htmlspecialchars($_POST['nouvMDP']);
				$nouvmdp = $this->encryption->encrypt($mdp);
				$this->dbmoncompte->modifier_mdp($nouvmdp);
				$this->session->set_flashdata('validationmdp' ," Votre mot de passe a bien été modifié");
			}
		}
	
	redirect('MonCompte/modifier');
	}
}
