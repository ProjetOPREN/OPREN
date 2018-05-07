<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * \file Administration_model.php
 * \brief Model qui s'occupe de la page d'administration de l'application
 * \date 01 Novembre 2017
 *
 */



class MonCompte_model extends CI_MODEL
{

function __construct(){
	parent::__construct();
	$this->load->database('default',TRUE);
}


	/**
	 * \fn public get_offre_user()
	 * \brief Récupère les offres de l'utilisateur connecté.
	 * \return un tableau avec toutes les informations sur l'offre si il y en a sinon vide.
	 */
	function get_offre_user(){
		$this->db->select('SiteDepart.nom AS Dnom, SiteDepart.adresse AS Dadresse, SiteArrive.nom AS Anom, SiteArrive.adresse AS Aadresse, Offres.jour, Offres.heure, Covoiturages.nBplace, Covoiturages.infovoiture, Offres.idOffre AS idOffre, SiteArrive.idArrive AS idArrive, SiteDepart.idDepart AS idDepart');
		$this->db->from('Offres');
		$this->db->join('SiteDepart','SiteDepart.idDepart = Offres.depart');
		$this->db->join('SiteArrive','SiteArrive.idArrive = Offres.arrivee');
		$this->db->join('Covoiturages','Offres.idOffre = Covoiturages.idOffre');
		$this->db->where('emailCond', $this->session->userdata('email')); 
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * \fn public get_infos()
	 * \brief Récupère les informations personnelles de l'utilisateur connecté.
	 * \return un tableau avec toutes les informations sur la personne.
	 */
	function get_infos(){
		$this->db->select('nom, prenom, telephone, email, mdp');
		$this->db->from('Personnes');
		$this->db->where('email', $this->session->userdata('email')) ;
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	/**
	 * \fn public get_reservation()
	 * \brief Récupère les réservations de l'utilisateur connecté.
	 * \return un tableau avec toutes les réservations de l'utilisateur si il y en a sinon vide.
	 */
	function get_reservation(){
        $this->db->select('Offres.jour AS jour, Offres.heure AS heure, SiteArrive.nom AS Anom ,SiteArrive.adresse AS Aadresse , SiteDepart.nom AS Dnom,SiteDepart.adresse AS Dadresse, Covoiturages.nBplace AS NbPlace, Covoiturages.infovoiture AS info, Passagers.idPassager AS idPass, SiteArrive.idArrive AS idArrive, SiteDepart.idDepart AS idDepart');
        $this->db->from('Covoiturages');
        $this->db->join('CovPas','Covoiturages.idCovoit = CovPas.idCovoit');
        $this->db->join('Passagers','Passagers.idPassager = CovPas.idPassager'); 
        $this->db->join('Offres','Covoiturages.idOffre = Offres.idOffre'); 
        $this->db->join('SiteDepart','SiteDepart.idDepart = Offres.depart');
		$this->db->join('SiteArrive','SiteArrive.idArrive = Offres.arrivee');
        $this->db->where('emailPass', $this->session->userdata('email')) ;
        $query = $this->db->get();
		return $query->result_array();
	}
	
	/**
	 * \fn public annuler_covoiturage($idOffre)
	 * \brief Supprime de la base de données le covoiturage avec l'id $idOffre.
	 * \param idOffre : l'idOffres du covoiturage à supprimer.
	 */
	function annuler_covoiturage($idOffre) {
		$this->db->delete('Covoiturages', array('Covoiturages.idOffre' => $idOffre));
		$this->db->delete('Offres', array('Offres.idOffre' => $idOffre));
	}
	
	/**
	 * \fn public annuler_reservation($idPassager, $idOffre)
	 * \brief Supprime de la base de données la réservation avec les id $idOffre et $idPassager.
	 * \param idOffre : l'idOffres de la réservation à supprimer.
	 * \param idPassager : l' idPassager de la personne qui a annulé la réservation. 
	 */
	function annuler_reservation($idPassager, $idOffre) {
		$this->db->delete('CovPas', array('idPassager' => $idPassager));
		$this->db->delete('Passagers', array('idPassager' => $idPassager));

		$this->db->set('Covoiturages.nBplace', 'Covoiturages.nBplace+1', FALSE);
		$this->db->where('Covoiturages.idOffre', $idOffre);
		$this->db->update('Covoiturages');
	}
	
	
	/**
	 * \fn public getListePassagers($idOffre)
	 * \brief Donne la liste des passagers pour l'offre avec l'id $idOffre.
	 * \param îdOffre : l'idOffres du covoiturage concerné
	 * \return un tableau avec les idPassager de tout les passagers si il y en a sinon vide.
	 */
	function getListePassagers($idOffre) {
		$this->db->select('CovPas.idPassager');
		$this->db->from('CovPas');
		$this->db->join('Covoiturages', 'Covoiturages.idCovoit = CovPas.idCovoit');
		$this->db->where('Covoiturages.idOffre', $idOffre);

		$query = $this->db->get();
		return $query->result_array();
	}
	/************************************************************************************
	 *                      Fonction pour la modification des infos                     *
	 ***********************************************************************************/
	
	/**
	 * \fn public modifier_nom($nom)
	 * \brief Modifie le nom du l'utilisateur en le remplaçant par $nom.
	 * \param nom : le nouveau nom de l'utilisateur.
	 */	
	function modifier_nom($nom){
		$this->db->set('nom', $nom);
		$this->db->where('email', $this->session->userdata('email'));
		$this->db->update('Personnes');
		$this->session->set_userdata('nom',$nom);
	}
	
	/**
	 * \fn public modifier_prenom($prenom)
	 * \brief Modifie le prenom du l'utilisateur en le remplaçant par $prenom.
	 * \param prenom : le nouveau prenom de l'utilisateur.
	 */	
	function modifier_prenom($prenom){
		$this->db->set('prenom', $prenom);
		$this->db->where('email', $this->session->userdata('email'));
		$this->db->update('Personnes');
		$this->session->set_userdata('prenom',$prenom);
	}
	
	/**
	 * \fn public modifier_tel($tel)
	 * \brief Modifie le téléphone du l'utilisateur en le remplaçant par $tel.
	 * \param tel : le nouveau téléphone de l'utilisateur.
	 */	
	function modifier_tel($tel){
		$this->db->set('telephone', $tel);
		$this->db->where('email', $this->session->userdata('email'));
		$this->db->update('Personnes');
		$this->session->set_userdata('telephone',$tel);
	}
	
	/**
	 * \fn public modifier_mdp($nouvmdp)
	 * \brief Modifie le MDP du l'utilisateur en le remplaçant par $nouvmdp.
	 * \param nouvmdp : le nouveau MDP de l'utilisateur.
	 */	
	function modifier_mdp($nouvmdp){
		$this->db->set('mdp', $nouvmdp);
		$this->db->where('email', $this->session->userdata('email'));
		$this->db->update('Personnes');
	}
	
	/**
	 * \fn public get_alertes_user()
	 * \brief Donne les informations des alertes de l'utilisateur connecté.
	 * \return un tableau avec les informations sur les alertes de l'utilisateur.
	 */	
	function get_alertes_user(){ 
		$this->db->select('Alertes.idAlerte AS idAlerte, Alertes.jour AS Jour, heure1 AS heureD, heure2 AS heureF'); 
		$this->db->from('Alertes'); 
		$this->db->where('emailPers', $this->session->userdata('email')); 
		$query = $this->db->get(); 
		return $query->result_array(); 
	}
	
	/**
	 * \fn public annuler_alertes($idAlerte)
	 * \brief Supprime de la BDD l'alert avec l'id idAlerte.
	 * \param idAlerte : l'idAlerte de l'entrée à supprimer dans la table Alertes.
	 */	
	function annuler_alertes($idAlerte){
		$this->db->delete('Alertes',array('Alertes.idAlerte' => $idAlerte) );
	}
	
	/**
	 * \fn public getIDOffre($idPassager)
	 * \brief Donne l'idOffre correspondant à l'idPassager $idPassager.
	 * \param idPassager : l'id du Passagers concerné.
	 */	
	function getIDOffre($idPassager) {
		$this->db->select('Covoiturages.idOffre AS idOffre');
		$this->db->from('Covoiturages');
		$this->db->join('CovPas', 'CovPas.idCovoit = Covoiturages.idCovoit');
		$this->db->where('CovPas.idPassager', $idPassager);
		$query = $this->db->get();
		return $query->result_array();
	}
}
