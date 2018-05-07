<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * \file Connexion_admin.php
 * \brief Controllers de la connexion de l'admin
 * \author BOUGAUD Yves
 * \date 29/11/2017
 *
 */
class Connexion_admin extends CI_Controller {
  public function __construct()
    {
        parent::__construct();
		$this->load->model('Personnalisation_model','dbColor');
		$this->load->model('Connexion_admin_model','dbCoAd');

    }
/**
 * \fn public index()
 * \brief Fonction index qui affiche la page de connexion du panel.
 *
 */
  public function index()
  {
    $data['couleurs'] = $this->dbColor->get_current_colors();
	$this->load->view('page_connexion_admin');
  }
/**
 * \fn public connexion()
 * \brief Fonction qui permet à l'administrateur de se connecter au panel.
 *
 */
  public function connexion(){

    //Récupérer les données saisies envoyées en POST

		$email =$_POST['Login']; 
        $password =$_POST['Password']; 
        //On va vers le model pour faire l'accès bdd, et récupérer les résultats
        $result = $this->dbCoAd->login($email, $password);
        if(!$result)
          {
          //Formulaire rempli correctement, mais pas de compte correspond aux identifiants
           $data['error'] = "Vos identifiants ne correspondent à aucun compte.";
		   $data['couleurs'] = $this->dbColor->get_current_colors();
           $this->load->view('page_connexion_admin');
        }else
        {
           $this->session->set_userdata('Login', $result[0]['Login']);
           redirect('Administrateur/index');
        }
  }

  /**
 * \fn public deconnexion()
 * \brief Déconnecte l'utilisateur du panel.
 */
  public function deconnexion()
  {
      session_unset();
      session_destroy();
      $this->session->sess_destroy();
      redirect('Connexion/index');
  }
}
