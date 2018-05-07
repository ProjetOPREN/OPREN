<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* \file Connexion.php
* \brief Controllers de l'Accueil
* \author Audrey Martin
* \date 08/10/2017
*
*/
class Connexion extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
	$this->load->model('Personnalisation_model','dbColor');
    $this->load->model('Connexion_model','dbConnexion');
    //chargement de la librairie pour la validation du formulaire
    $this->load->library('form_validation');
    //chargement du helper form
    $this->load->helper('form');
    //chargement du helper security
    $this->load->helper('security');
    // chargement de library pour crypter
    $this->load->library('encryption');

    $this->load->helper('url');
    //
    $this->load->helper(array('form', 'url'));
    $this->load->library('upload');
  }
  /**
  * \fn public index()
  * \brief Fonction index qui affiche la page de connexion de l'application
  *
  */

  public function index()
  {
    $data['page_title'] = TITLE_HOME;
	$data['couleurs'] = $this->dbColor->get_current_colors();
    $this->load->view('header',$data);
    $this->load->view('page_connexion');
  }
  
  /**
  * \fn public redirectionInscription()
  * \brief Fonction redirectionInscription qui affiche la page de l'inscription
  *
  */
  public function redirectionInscription()
  {
    $data['page_title'] = TITLE_HOME;
	$data['couleurs'] = $this->dbColor->get_current_colors();
    $this->load->view('header',$data);
    $this->load->view('page_inscription');
  }
  
   /**
  * \fn public redirectionMDP()
  * \brief Fonction redirectionMDP qui affiche la page de reinitialisation de mot de passe
  *
  */
  public function redirectionMDP()
  {
    $data['page_title'] = TITLE_HOME;
	$data['couleurs'] = $this->dbColor->get_current_colors();
    $this->load->view('header',$data);
    $this->load->view('redirectionMDP');
  }
  /**
  * \fn public inscription()
  * \brief  Fonction qui vérifie les champs du formulaire d'inscription,
  *			qui ensuite les envoies dans a bdd pour permettre à l'utilisateur
  *			de s'inscrire. On lui envoie ensuite un mail pour confirmer son inscription.
  *
  */
  public function inscription(){
    // Vérification des formulaires
    $this->form_validation->set_message('Password', 'differs[Password2]', 'Les mots de passes ne correspondent pas');
    $this->form_validation->set_rules('Nom', 'Nom', 'regex_match["^[A-Za-zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\\s-]{2,50}$"]|required');
    $this->form_validation->set_rules('Prenom', 'Prénom', 'required|regex_match["^[A-Za-zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\\s-]{2,50}$"]');
    $this->form_validation->set_rules('Telephone', 'Téléphone', 'trim|required|is_numeric|min_length[10]|max_length[10]|regex_match["^0[0-9]{9}"]');
    $this->form_validation->set_rules('Mail', 'Mail', 'trim|required|valid_email|is_unique[Personnes.email]');
    $this->form_validation->set_rules('Password', 'Mot de passe', 'required|regex_match["^[A-Za-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ\#\!\^\$\(\)\{\}\?\+\*\.,-_=/§µ%¨&~°`@|¤<>]{5,50}$"]');
    $this->form_validation->set_rules('Password2', 'Confirmation Mot de Passe', 'required|matches[Password]');
    $data['page_title'] = TITLE_HOME;

if ($this->form_validation->run() == false) {
  $data['error'] = "Vos identifiants ne correspondent à aucun compte.";
  $data['couleurs'] = $this->dbColor->get_current_colors();
  $this->load->view('header',$data);
  $this->load->view('page_inscription');
}else {
  $data['Nom'] = htmlspecialchars($_POST['Nom']);
  $data['Prenom'] = htmlspecialchars($_POST['Prenom']);
  $data['Telephone'] = $_POST['Telephone'];
  $data['Mail'] = htmlspecialchars($_POST['Mail']);
  $mdp = htmlspecialchars($_POST['Password']);
  $this->encryption->initialize(array('driver' => 'openssl'));
  $mdpcrypt = $this->encryption->encrypt($mdp);
  $data['Mdp'] = $mdpcrypt;

  $email = $_POST['Mail'];
  $this->dbConnexion->add_Personne($data);

  $cle = md5(rand(0, 1000));
  $this->dbConnexion->updateCleInscription($cle, $email);

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

  $this->email->initialize($config);

  $this->email->from('contact@covoit-karen.org', 'Équipe Karen');
  $this->email->to($email);

  $this->email->subject('Confirmation d\'inscription KAREN');
  $this->email->message('Bonjour,' .PHP_EOL. 'Vous venez de vous inscrire sur la plateforme de covoiturage KAREN.' .PHP_EOL.
  'Afin d\'activer votre compte, veuillez cliquer sur le lien suivant : ' . PHP_EOL .
  'http://opren.istic.univ-rennes1.fr/index.php/Connexion/verifCompte/' . $email . '/' . $cle . PHP_EOL .
  'Vous pouvez désormais rechercher et offrir des covoiturages. '  .PHP_EOL.
  'Merci de votre confiance.' . PHP_EOL . PHP_EOL. 'L\'Équipe KAREN.');

  $this->email->send();

  $this->session->set_flashdata('validation',"Votre inscription a bien été enregistrée. Vous allez recevoir un mail de confirmation dans quelques minutes.");
  redirect('Accueil/index');
}
}
 /**
  * \fn public verifCompte()
  * \brief Fonction verifCompte qui valide le compte de l'utilisateur à la suite de l'inscription.
  * $email : email de l'utilisateur utilisé sur le site.
  * $cle : cle envoye dans l'email pour permettre de valaider le compte.
  *
  */
public function verifCompte($email, $cle) {
  $result= $this->dbConnexion->verifyCompte($email, $cle);
  if($result)
  {
    $this->session->set_flashdata('validation',"Votre inscription a bien été confirmée. Vous pouvez désormez vous connecter et naviguer sur le site. Merci de votre confiance.");
    redirect('Accueil/index');
  }
}
/**
* \fn public connexion()
* \brief Fonction connexion qui connecte l'utilisateur au site en vérifiant 
*		 ses identifiants de connexion.
*
*/
public function connexion(){
  $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
  $this->form_validation->set_rules('password', 'Mot de passe', 'required|regex_match["^[A-Za-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ\#\!\^\$\(\)\{\}\?\+\*\.,-_=/§µ%¨&~°`@|¤<>]{5,50}$"]');

  $data['page_title'] = TITLE_HOME;
  if ($this->form_validation->run() == false){
    $data['error'] = "Vos identifiants ne correspondent à aucun compte.";
	$data['couleurs'] = $this->dbColor->get_current_colors();
    $this->load->view('header',$data);
    $this->load->view('page_connexion');
  }
  else{
    //Récupérer les données saisies envoyées en POST

    $email =$_POST['email'];
    $password =$_POST['password'];
    //On va vers le model pour faire l'accès bdd, et récupérer les résultats
    $result = $this->dbConnexion->user_login($email, $password); 

    $verifCompte = $this->dbConnexion->verificationCompteActiver($email);

    $data['page_title'] = TITLE_HOME;
	//$data['couleurs'] = $this->dbColor->get_all_colors();
	$data['couleurs'] = $this->dbColor->get_current_colors();
    $this->load->view('header',$data);
    if($result) {
      if($verifCompte) {
        //Formulaire rempli correctement, mais pas de compte correspond aux identifiants
        $this->session->set_userdata('email', $result[0]['email']);
        $this->session->set_userdata('prenom', $result[0]['prenom']);
        $this->session->set_userdata('nom', $result[0]['nom']);
        $this->session->set_userdata('telephone', $result[0]['telephone']);
		$this->session->set_userdata('boolean', $result[0]['booleanEmail']);
        $data['page_title'] = TITLE_HOME;
        redirect('Accueil');
      }
      else {
        $data['error'] = "Votre compte n'est pas activé.";
		$data['couleurs'] = $this->dbColor->get_current_colors();
        $this->load->view('header',$data);
        $this->load->view('page_connexion',$data);
      }
    }
    else {
		
      $data['error'] = "Vos identifiants ne correspondent à aucun compte.";
	  $data['couleurs'] = $this->dbColor->get_current_colors();
      $this->load->view('header',$data);
      $this->load->view('page_connexion',$data);
    }
  }
}

 /**
  * \fn public connexionFB()
  * \brief Fonction connexionFB qui permet a l'utilisateur de se connecter via Facebook.
  *
  */

public function connexionFB(){
	


  if(isset($_COOKIE['fbdata'])) { 
        // on récupère les informations depuis le cookie 
        $clean = explode("=",$_COOKIE['fbdata'] );
        $data = explode("," , $clean[0]);
        $fbnom = explode(" ", $data[0])[1];
		$fbprenom = explode(" ", $data[0])[0];
        $fbmail = trim($data[1], ' ');
        $fbid = $data[2];
		
    }

        //si l'adresse mail n'est pas accessible
	if($fbmail == "undefined"){
		$data['error'] = "addresse mail non accessible";
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
		$this->load->view('page_connexion',$data);
		
	}
	
	else{
		print_r($this->dbConnexion->checkMail($fbmail));
		//test si le compte existe dans la bdd
		$result = $this->dbConnexion->user_login($fbmail,$fbid);
		//le compte existe
		if($result){
      // on connecte l'utilisateur
			$this->session->set_userdata('email', $result[0]['email']);
			$this->session->set_userdata('prenom', $result[0]['prenom']);
			$this->session->set_userdata('nom', $result[0]['nom']);
			$this->session->set_userdata('telephone', $result[0]['telephone']);
			$this->session->set_userdata('boolean', $result[0]['booleanEmail']);
			$data['page_title'] = TITLE_HOME;
			redirect('Accueil');
		}

    //l'adresse mail existe, mais n'a pas été crée via facebook		
		else if($this->dbConnexion->checkMail($fbmail)){
			redirect('Connexion');
		}
		
		//le compte n'existe pas
		else{
      // on crée le compte
			$data['Prenom'] = $fbprenom;
			$data['Nom'] = $fbnom;
			$data['Telephone'] = "";
			$data['Mail'] = $fbmail;
			$cle = md5(rand(0, 1000));
			$this->dbConnexion->updateCleInscription($cle, $email);
			$this->encryption->initialize(array('driver' => 'openssl'));
			$mdpcrypt = $this->encryption->encrypt($fbid);
			$data['Mdp'] = $mdpcrypt;
			$this->dbConnexion->add_Personne($data);
			
			$result = $this->dbConnexion->user_login($fbmail,$fbid);
			
      //on connecte la personne
			$this->session->set_userdata('email', $result[0]['email']);
			$this->session->set_userdata('prenom', $result[0]['prenom']);
			$this->session->set_userdata('nom', $result[0]['nom']);
			$this->session->set_userdata('telephone', $result[0]['telephone']);
			$this->session->set_userdata('boolean', $result[0]['booleanEmail']);
			$data['page_title'] = TITLE_HOME;
			redirect('Accueil');
		}
	} 
}

 /**
  * \fn public MotDePasse()
  * \brief  Fonction MotDePasse qui permet à l'utilisateur de réinitialisé son MDP 
  * 		si il l'a oublié. On vérifie si son adresse mail est dans la BDD et on envoie 
  *			le MDP par email.
  *
  */
public function MotDePasse(){
  date_default_timezone_set('Europe/Paris');
  $this->load->library('email');
  $this->load->library('encrypt');
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

  $email =$_POST['email'];
  $result = $this->dbConnexion->checkMail($email);
  if($result){
    $chaine="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $melange=str_shuffle($chaine);
    $nouvmdp = substr($melange, 0, 8);

    if(strlen($nouvmdp) == 8){
      $nouvmdpcrypt = $this->encrypt->encode($nouvmdp);
      $this->dbConnexion->updateMDP($email, $nouvmdpcrypt);

      $this->email->from('contact@covoit-karen.org', 'Équipe Karen');
      $this->email->to($email);

      $this->email->subject('Réinitialisation du mot de passe');
      $this->email->message('Bonjour,' .PHP_EOL. 'Vous avez demandé à ce que votre mot de passe soit réinitialisé.' .PHP_EOL. 'Votre nouveau mot de passe est ' .$nouvmdp. '.' .PHP_EOL. 'Cordialement.');

      $this->email->send();

      //$this->session->set_flashdata('validation',"Votre mail a bien été envoyé. Vous recevrez une réponse dans quelques moment.");
    }

    else {
      $data['error'] = "La réinitialisation du mot de passe a échouée. Veuillez contacter le service Karen depuis la page Contact.";
    }
  }
  else {
    $data['error'] = "L'adresse mail ne correspond à aucun mail connu.";
  }
  redirect('Accueil/index');
}

/**
* \fn public deconnexion()
* \brief Déconnecte l'utilisateur de l'interface
*/
public function deconnexion()
{
  session_unset();
  session_destroy();
  redirect('Accueil');
}
}
