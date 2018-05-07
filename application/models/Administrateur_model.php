<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * \file Administration_model.php
 * \brief Model qui s'occupe de la page d'administration de l'application
 * \date 01 Novembre 2017
 *
 */



class Administrateur_model extends CI_MODEL
{

function __construct(){
	parent::__construct();
	$this->load->database('default',TRUE);
}
/******************************************************************************************************
**** FONCTIONS Personnes
*******************************************************************************************************/


/**
 * \fn public get_all_users()
 * \brief Demande à la BDD tous les utilisateurs
 * \return un tableau avec les emails, les noms, les prénoms et les téléphones.
 */
	function get_all_users(){
		$this->db->select('email,nom,prenom,telephone');
		$this->db->from('Personnes');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
 * \fn public get_all_idPers()
 * \brief Demande à la BDD toutes les clés primaires des utilisateurs
 * \return un tableau avec les emails des utilisateurs
 */

	function get_all_idPers(){
		$this->db->select('email');
		$this->db->from('Personnes');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
 * \fn public add_user($data)
 * \param Un tableau contenant les informations d'un nouvel utilisateur
 * \brief Ajoute un utilisateur à la BDD
 */

	public function add_user($data){
		$this->db->set('nom',$data['Nom']);
		$this->db->set('prenom',$data['Prenom']);
		$this->db->set('telephone',$data['Telephone']);
		$this->db->set('email',$data['Mail']);
		$this->db->set('mdp',$data['Mdp']);
		$this->db->insert('Personnes');

	}


/******************************************************************************************************
**** FONCTIONS Covoiturages & COV_PAS
*******************************************************************************************************/

/**
 * \fn public get_all_covoit()
 * \brief Demande à la BDD tous les Covoiturages
 * \return Un tableau de Covoiturages
 */

	public function get_all_covoit(){
		$this->db->select('idCovoit,nBplace,infovoiture,idOffre');
		$this->db->from('Covoiturages');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
 * \fn public get_all_idCovoit()
 * \brief Demande à la BDD tous les id des Covoiturages
 * \return Un tableau avec les id des Covoiturages
 */

	public function get_all_idCovoit(){
		$this->db->select('idCovoit');
		$this->db->from('Covoiturages');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
 * \fn public add_cov_pass($data)
 * \param $data: Un tableau contenant les informations nécessaires pour accepter une demande
 * \brief Enregistre une liaison entre une demande et un covoiturage
 */
	public function add_cov_pass($data){
		$this->db->set('idDemande',$data['idDemande']);
		$this->db->set('idCovoit',$data['idCovoit']);
		$this->db->insert('CovPas');
	}

/**
 * \fn public get_all_cov_pas()
 * \brief Demande à la BDD la liste des covoiturage et passagers
 * \return Un tableau avec les covoiturage et passagers
 */

	public function get_all_cov_pas(){
	$this->db->select('Offres.idOffre, Personnes.nom AS NomConducteur, Personnes.prenom AS PrenomConducteur,Covoiturages.nBplace, Covoiturages.infovoiture, SiteDepart.nom AS LieuDepart, SiteArrive.nom AS LieuArrive ,  Passagers.emailPass');
	$this->db->from('CovPas, Covoiturages, Offres, Personnes, SiteArrive, SiteDepart, Passagers');
	$this->db->where('CovPas.idCovoit = Covoiturages.idCovoit');
	$this->db->where('Covoiturages.idOffre = Offres.idOffre');
	$this->db->where('Offres.emailCond = Personnes.email');
	$this->db->where('Offres.depart = SiteDepart.idDepart');
	$this->db->where('Offres.arrivee = SiteArrive.idArrive');

	$query = $this->db->get();

	return $query->result_array();

	}


/******************************************************************************************************
**** FONCTIONS SITES DE DEPART
*******************************************************************************************************/

/**
 * \fn public add_depart($data)
 * \param $data: Un tableau contenant les informations pour ajouter un site de départ
 * \brief Ajoute un site de départ à la BDD
 */

	public function add_depart($data){
		$this->db->set('nom',$data['Nom']);
		$this->db->set('adresse',$data['Adresse']);
		$this->db->insert('SiteDepart');
	}

/**
* \fn public get_all_idDepart()
* \brief Demande tous les id des sites de départ à la BDD
* \return Un tableau avec tous les id des sites de départ
*/

	public function get_all_idDepart(){
		$this->db->select('idDepart');
		$this->db->from('SiteDepart');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
* \fn public get_all_siteD()
* \brief Demande tous les sites de départ à la BDD
* \return Un tableau avec tous les sites de départ
*/

	public function get_all_siteD(){
		$this->db->select('idDepart,nom,adresse');
		$this->db->from('SiteDepart');

		$query = $this->db->get();

		return $query->result_array();
	}


/******************************************************************************************************
**** FONCTIONS SITES D'ARRIVEE
*******************************************************************************************************/

/**
 * \fn public add_arrivee($data)
 * \param $data: Un tableau contenant les informations pour ajouter un site d'arrivée
 * \brief Ajoute un site d'arrivée à la BDD
 */

	public function add_arrivee($data){
		$this->db->set('nom',$data['Nom']);
		$this->db->set('adresse',$data['Adresse']);
		$this->db->insert('SiteArrive');
	}

/**
* \fn public get_all_idArrivee()
* \brief Demande tous les id des sites d'arrivée à la BDD
* \return Un tableau avec tous les id des sites d'arrivée
*/

	public function get_all_idArrivee(){
		$this->db->select('idArrive');
		$this->db->from('SiteArrive');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
* \fn public get_all_siteA()
* \brief Demande tous les sites d'arrivée à la BDD
* \return Un tableau avec tous les sites d'arrivée
*/

	public function get_all_siteA(){
		$this->db->select('idArrive,nom,adresse');
		$this->db->from('SiteArrive');

		$query = $this->db->get();

		return $query->result_array();
	}

/******************************************************************************************************
**** FONCTIONS OFFRES
*******************************************************************************************************/

/**
 * \fn public get_all_idOffre()
 * \brief Demande tous les id des offres de Covoiturages à la BDD
 * \return Un tableau avec les id de toutes les offres
 */

	public function get_all_idOffre(){
		$this->db->select('idOffre');
		$this->db->from('Offres');

		$query = $this->db->get();

		return $query->result_array();
	}


/**
* \fn public get_all_offers()
* \brief Demande toutes les offres à la BDD
* \return Un tableau avec les informations de toutes les offres
*/

	public function get_all_offers(){
		$this->db->select('idOffre,emailCond,SiteDepart.nom AS SiteDepart , SiteArrive.nom AS SiteArrive,jour,heure');
		$this->db->from('Offres, SiteArrive, SiteDepart');
		$this->db->where('Offres.depart = SiteDepart.idDepart');
		$this->db->where('Offres.arrivee = SiteArrive.idArrive');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
 * \fn public add_offers($data)
 * \param $data: Un tableau contenant les informations pour une offre
 * \brief Ajoute une offre à la BDD
 */

	public function add_offers($data){
		$this->db->select('jour,heure');
		$this->db->from('Dates');

		$query = $this->db->get();
		$dates = $query->result_array();

		$trouve = FALSE;
		foreach ($dates as $row) {
			if(($row['jour'] == $data['date']) && ($row['heure'] == $data['heure']. ":00")){
				$trouve = TRUE;
			}
		}

		if(!$trouve){
			$this->db->set('jour',$data['date']);
			$this->db->set('heure',$data['heure']);
			$this->db->insert('Dates');
		}

		$this->db->set('emailCond',$data['idCond']);
		$this->db->set('depart',$data['depart']);
		$this->db->set('arrivee',$data['arrivee']);
		$this->db->set('jour',$data['date']);
		$this->db->set('heure',$data['heure']);
		$this->db->insert('Offres');


		$this->db->select('idOffre');
		$this->db->from('Offres');
		$this->db->order_by('idOffre','desc');
		$this->db->limit(1);

		$query = $this->db->get();
		$idOffre = $query->result_array();

		$this->db->set('idOffre',$idOffre[0]['idOffre']);
		$this->db->set('nbPlace',$data['place']);
		$this->db->set('infovoiture',$data['infoVoit']);
		$this->db->insert('Covoiturages');
	}

/******************************************************************************************************
**** FONCTIONS DEMANDES
*******************************************************************************************************/

/**
 * \fn public get_all_requests()
 * \brief Demande toutes les demandes de Covoiturages à la BDD
 * \return Un tableau avec les informations de toutes les demandes
 */

	public function get_all_requests(){
		$this->db->select('idAlerte,emailPass,SiteArrive.nom AS LieuArrive, SiteDepart.nom AS LieuDepart,Alertes.jour,heure');
		$this->db->from('Alertes, Passagers, SiteArrive, SiteDepart');
		$this->db->where('Passagers.depart = SiteDepart.idDepart');
		$this->db->where('Passagers.arrivee = SiteArrive.idArrive');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
 * \fn public get_all_idRequest()
 * \brief Demande tous les id des demandes de Covoiturages à la BDD
 * \return Un tableau avec les id de toutes les demandes
 */

	public function get_all_idRequest(){
		$this->db->select('idPassager');
		$this->db->from('Passagers');

		$query = $this->db->get();

		return $query->result_array();
	}


/**
 * \fn public get_all_idAlertes()
 * \brief Demande tous les id des demandes de Covoiturages à la BDD
 * \return Un tableau avec les id de toutes les demandes
 */

	public function get_all_idAlertes(){
		$this->db->select('idAlerte');
		$this->db->from('Alertes');

		$query = $this->db->get();

		return $query->result_array();
	}


/**
 * \fn public request_matchWith_offer()
 * \param $data: Un tableau avec les informations de la demande
 * \brief Récupère une ou plusieurs offres qui peuvent matcher avec la demande en paramètre
 * \return Un tableau avec les informations de ou des offres qui correspondent
 */

	public function request_matchWith_offer($data){
		$this->db->select('idOffre');
		$this->db->from('Offres');
		$this->db->where('depart',$data['depart']);
		$this->db->where('arrivee',$data['arrivee']);
		$this->db->where('jour',$data['date']);

		$query = $this->db->get();

		return $query;
	}

/**
 * \fn public add_request($data)
 * \param $data: Un tableau avec les informations de la demande
 * \brief Ajoute une nouvelle demande de covoiturage à la BDD
 */

	public function add_request($data){
		$this->db->select('jour,heure');
		$this->db->from('Dates');

		$query = $this->db->get();
		$dates = $query->result_array();

		$trouve = FALSE;
		foreach ($dates as $row) {
			if(($row['jour'] == $data['date']) && ($row['heure'] == $data['heure']. ":00")){
				$trouve = TRUE;
			}
		}

		if(!$trouve){
			$this->db->set('jour',$data['date']);
			$this->db->set('heure',$data['heure']);
			$this->db->insert('Dates');
		}

		$this->db->set('emailPass',$data['idPass']);
		$this->db->set('depart',$data['depart']);
		$this->db->set('arrivee',$data['arrivee']);
		$this->db->set('jour',$data['date']);
		$this->db->set('heure',$data['heure']);
		$this->db->insert('Passagers');

	}

/******************************************************************************************************
**** FONCTIONS SUPPRESSION
*******************************************************************************************************/


/**
 * \fn public del_user($data)
 * \param $data: l'email de l'user à supr
 * \brief supprime l'user de la bdd
 */
	public function del_user($data){


		$this->db->where('email', $data['users']);
		$this->db->delete('Personnes');


	}


	/**
 * \fn public del_request($data)
 * \param $data: l'id de la demande à suppr
 * \brief supprime la demande de la bdd
 */
	public function del_request($data){


		$this->db->where('idPassager', $data['demande']);
		$this->db->delete('Passagers');


	}

		/**
 * \fn public del_offre($data)
 * \param $data: l'id de l'offre à suppr
 * \brief supprime l'offre de la bdd ainsi que le covoiturage associé
 */

	public function del_offre($data){

		$this->db->where('idOffre',$data['offre'] );
		$this->db->delete('Covoiturages');

		$this->db->where('idOffre', $data['offre']);
		$this->db->delete('Offres');


	}

			/**
 * \fn public del_depart($data)
 * \param $data: l'id du depart à suppr
 * \brief supprime le depart de la bdd
 */
	public function del_depart($data){


		$this->db->where('idDepart', $data['depart']);
		$this->db->delete('SiteDepart');


	}

	/**
	 * \fn public del_arrivee($data)
	 * \param $data: l'id de l'arrivee à suppr
	 * \brief supprime l'arrivee de la bdd
	 */
		public function del_arrivee($data){


		$this->db->where('idArrive', $data['arrivee']);
		$this->db->delete('SiteArrive');
	}

	/**
	 * \fn public get_stat()
	 * \brief Donne le nombre utilisateurs sur la plateforme.
	 * \return un tableau avec l'entier.
	 */

	public function get_stat(){

		$sql = "SELECT count(*) as nbUsers FROM Personnes ;";

		$query = $this->db->query($sql);

		$result = $query->row_array();

		return $result;

	}
	
	/**
	 * \fn public get_stat2()
	 * \brief Donne le nombre d'offres sur la plateforme.
	 * \return un tableau avec l'entier.
	 */
	public function get_stat2(){
		$sql = "SELECT count(*) as nbOffres FROM Offres ;";

		$query = $this->db->query($sql);

		$result = $query->row_array();

		return $result;
	}
	
	/**
	 * \fn public get_stat3()
	 * \brief Donne le nombre d'offres par jour sur la plateforme.
	 * \return un tableau avec l'entier.
	 */
	public function get_stat3(){
		$sql = "SELECT  jour, COUNT(*) as offresJour FROM Offres GROUP BY jour;" ;

		$query = $this->db->query($sql);

		return $query->result_array();


	}
	
	/**
	 * \fn public get_stat4()
	 * \brief Donne le nombre de covoiturage qui ont au moins un passager sur la plateforme.
	 * \return un tableau avec l'entier.
	 */
	public function get_stat4(){
		$sql = "SELECT COUNT(DISTINCT Covoiturages.idCovoit) as donnee FROM Covoiturages, CovPas WHERE Covoiturages.idCovoit = CovPas.idCovoit";

		$query = $this->db->query($sql);

		$result = $query->row_array();

		return $result;

	}
	
	/**
	 * \fn public get_stat5()
	 * \brief Donne le nombre de covoiturage qui n'ont pas de passager sur la plateforme.
	 * \return un tableau avec l'entier.
	 */
	public function get_stat5(){
		
		$sql = "SELECT COUNT(DISTINCT Covoiturages.idCovoit) as donnee FROM Covoiturages WHERE Covoiturages.idCovoit NOT IN (SELECT CovPas.idCovoit FROM CovPas)";
		$query = $this->db->query($sql);

		$result = $query->row_array();

		return $result;

	}




}
