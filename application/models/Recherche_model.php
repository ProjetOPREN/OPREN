<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * \file Recherche_model.php
 * \brief Model qui s'occupe de la page de recherche de l'application
 * \date 01 Novembre 2017
 *
 */



class Recherche_model extends CI_MODEL
{

	public function get_demandesInvalid_pers($email){
		$this->db->select('idPassager,SiteDepart.nom AS SiteDepart, SiteDepart.adresse AS AdresseDepart, SiteArrive.nom AS SiteArrive, SiteArrive.adresse AS AdresseArrive,jour,heure');
		$this->db->from('Passagers, SiteDepart, SiteArrive');
		$this->db->where('emailPass',$email);
		$this->db->where('SiteArrive.idArrive = Passagers.arrivee');
		$this->db->where('SiteDepart.idDepart = Passagers.depart');
		$this->db->where('idPassager NOT IN (SELECT idPassager from CovPas)');

		$query = $this->db->get();

		return $query->result_array();
	}

/**
 * \fn public request_matchWith_offer()
 * \param $data: Un tableau avec les informations de la demande
 * \brief Récupère une ou plusieurs offres qui peuvent matcher avec la demande en paramètre
 * \return Un tableau avec les informations de ou des offres qui correspondent
 */

	public function request_matchWith_offer($jour,$depart,$arrivee){
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

	public function add_alert($data){
		$this->db->select('jour,heure');
		$this->db->from('Dates');

		$query = $this->db->get();
		$dates = $query->result_array();

		$trouve = FALSE;
		foreach ($dates as $row) {
			if(($row['jour'] == $data['jour']) && ($row['heure'] == $data['heure1'])){
				$trouve = TRUE;
			}
		}
		if(!$trouve){
			$this->db->set('jour',$data['jour']);
			$this->db->set('heure',$data['heure1']);
			$this->db->insert('Dates');
		}
		
		$trouve = FALSE;
		foreach ($dates as $row) {
			if(($row['jour'] == $data['jour']) && ($row['heure'] == $data['heure2'])){
				$trouve = TRUE;
			}
		}
		if(!$trouve){
			$this->db->set('jour',$data['jour']);
			$this->db->set('heure',$data['heure2']);
			$this->db->insert('Dates');
		}

		$this->db->set('emailPers',$data['idPers']);
		$this->db->set('jour',$data['jour']);
		$this->db->set('heure1',$data['heure1']);
		$this->db->set('heure2',$data['heure2']);
		$this->db->insert('Alertes');

	}

	/**
	 * \fn public accepter_covoit($demande, $covoiturage)
	 * \brief Lie un passager avec avec un covoiturage.
	 * \param demande : l'id du passager.
	 * \param covoiturage : l'id du covoiturage.
	 */
	public function accepter_covoit($demande,$covoiturage){
		$this->db->set('idPassager',$demande);
		$this->db->set('idCovoit',$covoiturage);
		$this->db->insert('CovPas');
	}
	
	/**
	 * \fn public add_request_from_offer($dataOffer, $idCovoit)
	 * \brief Creer une entré dans la table Passagers et ensuite la lie avec la table CovPas.
	 * \param dataOffer : Structure avec plein d'informations sur l'offre.
	 * \param idCovoit : l'id du covoiturage.
	 */
	public function add_request_from_offer($dataOffer,$idCovoit){
		$this->db->set('emailPass',$this->session->userdata('email'));
		$this->db->set('depart',$dataOffer['idDepart']);
		$this->db->set('arrivee',$dataOffer['idArrive']);
		$this->db->set('jour',$dataOffer['jour']);
		$this->db->set('heure',$dataOffer['heure']);
		$this->db->insert('Passagers');

		$this->db->select('idPassager');
		$this->db->from('Passagers');
		$this->db->order_by('idPassager','desc');
		$this->db->limit(1);

		$demande = $this->db->get();
		$demande = $demande->result_array();

		$this->db->set('idPassager',$demande[0]['idPassager']);
		$this->db->set('idCovoit',$idCovoit);
		$this->db->insert('CovPas');
	}
	
	/**
	 * \fn public getRecapitulatif($idSiteDepart, $idSiteArrivee, $idOffre)
	 * \brief Donne un récapitulatif des offres en fonction d'un idSiteDepart et d'un idSiteArrivee.
	 * \param idOffre : l'id correspondant à l'offre concerné.
	 * \param idSiteDepart : l'id correspondant au SiteDepart concerné.
	 * \param idSiteArrivee : l'id correspondant au SiteArrive concerné.
	 */	
	public function getRecapitulatif($idSiteDepart, $idSiteArrivee, $idOffre) {
		$this->db->select('SiteDepart.nom AS Dnom, SiteDepart.adresse AS Dadresse, Offres.jour, Offres.heure, SiteArrive.nom AS Anom, SiteArrive.adresse AS Aadresse, Covoiturages.nBplace, Covoiturages.infovoiture');
		$this->db->from('SiteDepart, Offres, SiteArrive, Covoiturages');
		$this->db->where('idDepart', $idSiteDepart);
		$this->db->where('idArrive', $idSiteArrivee);
		$this->db->where('Offres.idOffre', $idOffre);
		$this->db->where('Covoiturages.idOffre', $idOffre);
		$query = $this->db->get();

		return $query->result_array();
	}
	/**
	 * \fn public getEmailPassager($idCovoit) (différente de l'autre fonction getEmailPassager)
	 * \brief Donne l'adresse email du passager de l'offre avec l'id $idCovoit.
	 * \param idCovoit : l'idCovoit correspondant à l'offre du passager concerné.
	 * \return un tableau avec l'adresse mail.
	 */	
	public function getEmailPassagers($idCovoit){
		$this->db->select('Passagers.emailPass');
		$this->db->from('Passagers, CovPas');
		$this->db->where('Passagers.idPassager = CovPas.idPassager');
		$this->db->where('CovPas.idCovoit', $idCovoit);


		$query = $this->db->get();

		return $query->result_array();

		/*SELECT Demandes.emailPass,CovPas.idCovoit AS cpCovoit, CovPas.idDemande AS cpDemande
		FROM Demandes, Covoiturages, CovPas
		WHERE Demandes.idDemande = CovPas.idDemande AND CovPas.idCovoit = ???*/
	}
	
	/**
	 * \fn public getEmailCond($idOffre)
	 * \brief Donne l'adresse email du conducteur de l'offre avec l'id $idOffre.
	 * \param idOffre : l'id correspondant à l'offre du conducteur concerné.
	 * \return un tableau avec l'adresse mail.
	 */	
	public function getEmailConducteur($idOffre) {
		$this->db->select('Offres.emailCond');
		$this->db->from('Offres');
		$this->db->where('Offres.idOffre', $idOffre);

		$query = $this->db->get();

		return $query->result_array();
	}
	
	/**
	 * \fn public getEmailPassager($idOffre)
	 * \brief Donne l'adresse email du passager de l'offre avec l'id $idOffre.
	 * \param idOffre : l'id correspondant à l'offre du passager concerné.
	 * \return un tableau avec l'adresse mail.
	 */	
	public function getEmailPassager($idPassager) {
		$this->db->select('Passagers.emailPass');
		$this->db->from('Passagers');
		$this->db->where('Passagers.idPassager', $idPassager);

		$query = $this->db->get();
		return $query->result_array();
	}
	
	/**
	 * \fn public getCoordonnees($email)
	 * \brief Donne les informations sur l'utilisteurs avec l'adresse email $email.
	 * \param email : l'email de l'utilisateur concerné.
	 * \return un tableau avec les coordonees.
	 */	
	public function getCoordonnees($email) {
		$this->db->select('Personnes.nom, Personnes.prenom, Personnes.telephone');
		$this->db->from('Personnes');
		$this->db->where('Personnes.email', $email);

		$query = $this->db->get();

		return $query->result_array();
	}

}
