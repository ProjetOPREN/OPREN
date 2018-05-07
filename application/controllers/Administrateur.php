<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * \file Administrateur.php
 * \brief Controllers de l'Administrateur
 * \date 01/11/2017
 */


class Administrateur extends CI_Controller {


 	public function __construct()

    {
        parent::__construct();
        $this->load->model('Administrateur_model','dbAdmin');
		$this->load->model('Personnalisation_model','dbColor');
		// Chargement de library pour chiffrer ( nous n'utilisons pas la même librairie coté admin 
		// que celle utilisé coté utilisateur.
		$this->load->library('encrypt');
    }

/**
 * \fn public index()
 * \brief Fonction index qui affiche la page d'accueil d'administration
 *
 */
  
	public function index(){
	if($this->session->userdata('Login')){
		$this->load->view('page_admin');
	}else{
		$this->load->view('page_connexion_admin');
	}
	}
/******************************************************************************************************
**** FONCTIONS UTILISATEURS
*******************************************************************************************************/

/**
 * \fn public afficher_utilisateurs()
 * \brief Fonction qui affiche tous les utilisateurs de la bdd
 *
 */
  
  public function afficher_utilisateurs()
  {
    $data['users'] = $this->dbAdmin->get_all_users();
    $this->load->view('page_admin', $data);
  }

/**
 * \fn public afficher_form_user()
 * \brief Fonction qui affiche le formulaire pour ajouter un nouvel utilisateur
 *
 */

  public function afficher_form_user(){
    $this->load->view('admin_view/form_user');
  }

/**
 * \fn public add_user()
 * \brief Ajoute un nouvel utilisateur à la bdd, en vérifiant que les champs sont bien remplis.
 *
 */

  public function add_user(){
	$this->form_validation->set_rules('Nom', 'Nom', 'regex_match["^[A-Za-zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]{2,50}$"]|required|trim');
	$this->form_validation->set_rules('Prenom', 'Prénom', 'trim|required|regex_match["^[A-Za-zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]{2,50}$"]');
	$this->form_validation->set_rules('Telephone', 'Téléphone', 'trim|required|is_numeric|min_length[10]|max_length[10]|regex_match["^0[0-9]{9}"]');
	$this->form_validation->set_rules('Mail', 'Mail', 'trim|required|valid_email|is_unique[Personnes.email]|max_length[50]|min_length[7]');
	$this->form_validation->set_rules('Password', 'Mot de passe', 'required|regex_match["^[A-Za-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ\#\!\^\$\(\)\{\}\?\+\*\.,-_=/§µ%¨&~°`@|¤<>]{5,50}$"]');
	
	if($this->form_validation->run() == false) {
		$data['error'] = "Vos identifiants ne correspondent à aucun compte.";
		$this->load->view('admin_view/form_user');
    }else{
		$data['Nom'] = htmlspecialchars($_POST['Nom']);
		$data['Prenom'] = htmlspecialchars($_POST['Prenom']);
		$data['Telephone'] = $_POST['Telephone'];
		$data['Mail'] = htmlspecialchars($_POST['Mail']);
		$mdp= htmlspecialchars($_POST['Password']);
		$data['Mdp'] = $this->encrypt->encode($mdp);
		$this->dbAdmin->add_user($data);
		redirect('Administrateur/index');
	}
  }

/**
 * \fn public afficher_form_del_user()
 * \brief Fonction qui affiche le formulaire pour supprimer un utilisateur
 *
 */
  public function afficher_form_del_user(){

    $data['users'] = $this->dbAdmin->get_all_idPers();

    $this->load->view('admin_view/form_del_user',$data);

  }

  /**
 * \fn public del_user()
 * \brief supprime un utilisateur de la bdd
 *
 */

  public function del_user(){

    $data['users'] = $_POST['users'];

    $this->dbAdmin->del_user($data);

    redirect('Administrateur/index');
  }


/******************************************************************************************************
**** FONCTIONS SITES
*******************************************************************************************************/

/**
 * \fn public afficher_siteArrives()
 * \brief Permet d'afficher tous les sites d'arrivées
 */

  public function afficher_siteArrives()
  {
    $data['arrive'] = $this->dbAdmin->get_all_siteA();
    $this->load->view('page_admin', $data);
  }

/**
 * \fn public afficher_form_arrivee()
 * \brief Permet d'afficher le formulaire pour un nouveau site d'arrivée
 */

  public function afficher_form_arrivee(){
    $this->load->view('admin_view/form_arrivee');
  }

/**
 * \fn public add_siteArrivee()
 * \brief Permet d'ajouter un nouveau site d'arrivée
 */

  public function add_siteArrivee(){
    $data['Nom'] = htmlspecialchars($_POST['Nom']);
    $data['Adresse'] = htmlspecialchars($_POST['Adresse']);

    $this->dbAdmin->add_arrivee($data);

    redirect('Administrateur/index');
  }
  
/**
 * \fn public afficher_form_del_arrivee()
 * \brief Fonction qui affiche le formulaire pour supprimer une arrivee
 *
 */
  public function afficher_form_del_arrivee(){

    $data['arrivee'] = $this->dbAdmin->get_all_idArrivee();

    $this->load->view('admin_view/form_del_arrivee',$data);

  }

  /**
 * \fn public del_arrivee()
 * \brief supprime une arrivee de la bdd
 *
 */

  public function del_arrivee(){

    $data['arrivee'] = $_POST['arrivee'];

    $this->dbAdmin->del_arrivee($data);

    redirect('Administrateur/index');
  }

/**
 * \fn public afficher_siteDeparts()
 * \brief Affiche tous les sites de départs
 */

  public function afficher_siteDeparts()
  {
    $data['depart'] = $this->dbAdmin->get_all_siteD();
    $this->load->view('page_admin', $data);
  }

/**
 * \fn public afficher_form_départ()
 * \brief Affiche le formulaire d'ajout d'un site de départ
 */

  public function afficher_form_depart(){
    $this->load->view('admin_view/form_depart');
  }

/**
 * \fn public add_siteDepart()
 * \brief Permet d'ajouter un nouveau site de départ
 */

  public function add_siteDepart(){
    $data['Nom'] = htmlspecialchars($_POST['Nom']);
    $data['Adresse'] = htmlspecialchars($_POST['Adresse']);

    $this->dbAdmin->add_depart($data);

    redirect('Administrateur/index');
  }

/**
 * \fn public afficher_form_del_depart()
 * \brief Fonction qui affiche le formulaire pour supprimer un depart
 *
 */
  public function afficher_form_del_depart(){

    $data['depart'] = $this->dbAdmin->get_all_idDepart();

    $this->load->view('admin_view/form_del_depart',$data);

  }

  /**
 * \fn public del_depart()
 * \brief supprime un depart de la bdd
 *
 */

  public function del_depart(){

    $data['depart'] = $_POST['depart'];

    $this->dbAdmin->del_depart($data);

    redirect('Administrateur/index');
  }


/******************************************************************************************************
**** FONCTIONS OFFRES
*******************************************************************************************************/

/**
 * \fn public afficher_offres()
 * \brief Permet d'afficher les offres
 */

public function afficher_offres(){
  $data['offres'] = $this->dbAdmin->get_all_offers();
  $this->load->view('page_admin', $data);
}

/**
 * \fn public afficher_form_offre()
 * \brief Permet d'afficher le formulaire d'une offre
 */
public function afficher_form_offre(){
    $data['conducteurs'] = $this->dbAdmin->get_all_idPers();
    $data['departs'] = $this->dbAdmin->get_all_idDepart();
    $data['arrivees'] = $this->dbAdmin->get_all_idArrivee();
    $this->load->view('admin_view/form_offre',$data);
}

/**
 * \fn public ajouter_offre()
 * \brief Permet d'ajouter une offre
 */
public function ajouter_offre(){
  $data['idCond'] = htmlspecialchars($_POST['idCond']);
  $data['depart'] = htmlspecialchars($_POST['idDepart']);
  $data['arrivee'] = htmlspecialchars($_POST['idArrivee']);
  $data['date'] = $_POST['date'];
  $data['place'] = $_POST['nbPlace'];
  $data['infoVoit'] = htmlspecialchars($_POST['infoVoit']);
  $data['heure'] = $_POST['heure'];
  $this->dbAdmin->add_offers($data);
  redirect('Administrateur/index');
}

/**
 * \fn public afficher_form_del_offre()
 * \brief Fonction qui affiche le formulaire pour supprimer une offre
 *
 */
public function afficher_form_del_offre(){

    $data['offres'] = $this->dbAdmin->get_all_idOffre();

    $this->load->view('admin_view/form_del_offre',$data);

  }

  
  /**
 * \fn public del_offre()
 * \brief supprime une offre de la bdd
 *
 */

  public function del_offre(){

    $data['offre'] = $_POST['offre'];

    $this->dbAdmin->del_offre($data);

    redirect('Administrateur/index');
  }

/******************************************************************************************************
**** FONCTIONS DEMANDES
*******************************************************************************************************/

/**
 * \fn public afficher_Alertes()
 * \brief Permet d'afficher les alertes
 */

public function afficher_Alertes(){
  $data['demandes'] = $this->dbAdmin->get_all_requests();
  $this->load->view('page_admin', $data);
}



/**
 * \fn public afficher_form_demande()
 * \brief Permet d'afficher le formulaire d'une demande
 */

public function afficher_form_demande(){
    $data['passagers'] = $this->dbAdmin->get_all_idPers();
    $data['departs'] = $this->dbAdmin->get_all_idDepart();
    $data['arrivees'] = $this->dbAdmin->get_all_idArrivee();
    $this->load->view('admin_view/form_demande',$data);
}

/**
 * \fn public del_alertes()
 * \brief Permet d'afficher les demandes
 */
public function del_alertes(){
  $data['alerte'] = $_POST['Alerte'];
  $this->dbAdmin->del_alertes($data);
  redirect('Administrateur/index');
  
}

/**
 * \fn public afficher_form_del_alertes()
 * \brief Fonction qui affiche le formulaire pour supprimer une alerte
 *
 */
  public function afficher_form_del_alertes(){

    $data['demandes'] = $this->dbAdmin->get_all_idAlertes();

    $this->load->view('admin_view/form_del_alertes',$data);

  }

/**
 * \fn public ajouter_demande()
 * \brief Permet d'ajouter une demande et teste si une ou plusieurs offres peuvent intéressé l'utilisateur
 */

public function ajouter_demande(){
	
  $request['idPass'] = $_POST['idPass'];
  $request['depart'] = $_POST['depart'];
  $request['arrivee'] = $_POST['arrivee'];
  $request['date'] = $_POST['date'];
  $request['heure'] = $_POST['heure'];

  $offres = $this->dbAdmin->request_matchWith_offer($request);

  if($offres->num_rows()>=1){
    $data['message'] =  $offres->num_rows . ' offres correpond(ent) à votre demande';
    $data['typeMessage'] = 'info';
  }else{
    $data['message'] = 'Aucune offre ne correspond à votre demande';
    $data['typeMessage'] = 'info';
  }

  $this->dbAdmin->add_request($request);
  $this->load->view('page_admin',$data);
}

/**
 * \fn public afficher_form_del_demande()
 * \brief Fonction qui affiche le formulaire pour supprimer une demande
 *
 */
  public function afficher_form_del_demande(){

    $data['demandes'] = $this->dbAdmin->get_all_idRequest();

    $this->load->view('admin_view/form_del_demande',$data);

  }

  /**
 * \fn public del_demande()
 * \brief supprime une demande de la bdd
 *
 */

  public function del_demande(){

    $data['demande'] = $_POST['demande'];

    $this->dbAdmin->del_request($data);

    redirect('Administrateur/index');
  }

/******************************************************************************************************
**** FONCTIONS COVOITURAGES & COV_PAS
*******************************************************************************************************/

  /**
 * \fn public afficher_covoiturages()
 * \brief Fonction qui affiche tous les covoiturages
 *
 */
  
  public function afficher_covoiturages(){
    $data['covoit'] = $this->dbAdmin->get_all_covoit();
    $this->load->view('page_admin', $data);
  }

/**
 * \fn public afficher_form_acceptCovoit()
 * \brief Permet d'afficher un formulaire pour qu'un passager puisse accepter une offre de covoiturage
 */

  public function afficher_form_acceptCovoit(){
    $data['covoit'] = $this->dbAdmin->get_all_idCovoit();
    $data['demande'] = $this->dbAdmin->get_all_idRequest();
    $this->load->view('admin_view/form_covpass',$data);
  }

/**
 * \fn public add_cov_pass()
 * \brief Permet d'ajouter une relation covoiturage passager
 */

  public function add_cov_pass(){
    $data['idCovoit'] = $_POST['idCovoit'];
    $data['idDemande'] = $_POST['idDemande'];
    
    $this->dbAdmin->add_cov_pass($data);
    redirect('Administrateur/index');
  }
  

/**
 * \fn public afficher_CovPas()
 * \brief Affiche les relation covoiturage passager
 */
  public function afficher_CovPas(){
	$data['CovPas'] = $this->dbAdmin->get_all_cov_pas();
	$this->load->view('page_admin', $data);
  }

  /******************************************************************************************************
**** FONCTIONS STATS
*******************************************************************************************************/

	public function show_stats(){
		
	$data['var'] = $this->dbAdmin->get_stat();
  $data['var2'] = $this->dbAdmin->get_stat2();
  $data['var3'] = $this->dbAdmin->get_stat3();
  $data['var4'] = $this->dbAdmin->get_stat4();
  $data['var5'] = $this->dbAdmin->get_stat5();
	$this->load->view('admin_view/form_stat', $data);
	
	}

  /******************************************************************************************************
**** FONCTIONS COULEURS DU SITE
*******************************************************************************************************/

public function modif_color(){
	if($this->session->userdata('Login')){
		$data['setsColor'] = $this->dbColor->get_all_setColor();
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('page_modifier_couleur',$data);
	}else{
		redirect('page_connexion_admin');
	}
}

	
	public function modify_colors(){
		if($_POST['button']=="update"){
			echo $_POST['primaire'] . " " . $_POST['fond'] . " " . $_POST['bar'] . " " . $_POST['titre'];
			$this->dbColor->update_colors($_POST['primaire'],$_POST['fond'], $_POST['bar'],$_POST['titre']);
			$this->session->set_flashdata('confirm','Les couleurs courantes du site ont été modifiées.');
			redirect('Administrateur/modif_color');

		}else if($_POST['button']=="add"){
			$ok = $this->dbColor->add_colors($_POST['primaire'],$_POST['fond'], $_POST['bar'],$_POST['titre']);
			if($ok){
				$this->session->set_flashdata('confirm','Le set de couleur a été enregistré.');
			}else{
				$this->session->set_flashdata('error','Ce set de couleur existe déjà.');
			}
			redirect('Administrateur/modif_color');
			
		}else if($_POST['button']=="delete"){
			$this->dbColor->delete_colors($_POST['primaire'],$_POST['fond'], $_POST['bar'],$_POST['titre']);
			$this->session->set_flashdata('confirm','Le set de couleur a été supprimé.');
			redirect('Administrateur/modif_color');

		}else{
			$this->session->set_flashdata('error','Erreur, veuillez sélectionner avec un bouton valide.');
			redirect('Administrateur/modif_color');

		}
	}
  
}
