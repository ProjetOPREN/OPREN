<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * \file Offre_model.php
 * \brief Model qui s'occupe de la page des offres de l'application
 * \date 14 Novembre 2017
 *
 */



class Offre_model extends CI_MODEL{

	public function match_with_alert($data){
		$this->db->select('emailPers');
		$this->db->from('Alertes');
		$this->db->where('jour',$data['date']);
		$this->db->where('heure1 <= "' . $data['heure'] . ':00"');
		$this->db->where('heure2 >= "' . $data['heure'] . ':00"');
		
		$query = $this->db->get();
		return  $query->result_array();
	}
	

/**
 * \fn public add_offers($data)
 * \param $data: Un tableau contenant les informations pour une offre
 * \brief Ajoute une offre 
 */

	public function add_offers($data){
		$this->db->select('jour,heure');
		$this->db->from('Dates');

		$query = $this->db->get();
		$dates = $query->result_array();

		$trouve = FALSE; 
		foreach ($dates as $row) {
			if(($row['jour'] == $data['date']) && ($row['heure'] == $data['heure'] . ":00")){
				$trouve = TRUE;
			}
		}

		if(!$trouve){
			$this->db->set('jour',$data['date']);
			$this->db->set('heure',$data['heure']);
			$this->db->insert('Dates');
		}

		$this->db->set('nom',$data['arrivee_nom']);
		$this->db->set('adresse',$data['arrivee_adress']);
		$this->db->insert('SiteArrive');

		$this->db->select('idArrive');
		$this->db->from('SiteArrive');
		$this->db->order_by('idArrive','desc');
		$this->db->limit(1);

		$query = $this->db->get();
		$idArrive = $query->result_array();

		$this->db->set('nom',$data['depart_nom']);
		$this->db->set('adresse',$data['depart_adress']);
		$this->db->insert('SiteDepart');

		$this->db->select('idDepart');
		$this->db->from('SiteDepart');
		$this->db->order_by('idDepart','desc');
		$this->db->limit(1);

		$query = $this->db->get();
		$idDepart = $query->result_array();

		$this->db->set('emailCond',$data['idCond']);
		$this->db->set('depart',$idDepart[0]['idDepart']);
		$this->db->set('arrivee',$idArrive[0]['idArrive']);
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
		$this->db->set('nBplace',$data['place']);
		$this->db->set('infovoiture',$data['infoVoit']);
		$this->db->insert('Covoiturages');
		
		return $this->match_with_alert($data);
	}
	
	/**
* \fn public get_all_siteArrive()
* \brief Demande toutes le nom des sites d'arrivée à la BDD
* \return Un tableau avec les informations de toutes les noms.
*/
	public function get_all_siteArrive(){
		$this->db->select('nom,adresse ');
		$this->db->from('SiteArrive');
		
		$query = $this->db->get();
		return $query->result_array();
	
		}
	
/**
* \fn public get_all_offers()
* \brief Demande toutes les offres à la BDD
* \return Un tableau avec les informations de toutes les offres
*/

	
	public function get_all_offers(){
		$this->db->select('Offres.idOffre, Personnes.nom, Personnes.prenom, SiteDepart.nom AS SiteDepart, SiteDepart.adresse AS AdresseDepart, SiteArrive.nom AS SiteArrive, SiteArrive.adresse AS AdresseArrive, Offres.jour, Offres.heure, Covoiturages.idCovoit, Covoiturages.nBplace');
		$this->db->from('Personnes, SiteDepart, SiteArrive, Offres, Covoiturages');
		$this->db->where('Personnes.email = Offres.emailCond');
		$this->db->where('Offres.idOffre = Covoiturages.idOffre');
		$this->db->where('SiteArrive.idArrive = Offres.arrivee');
		$this->db->where('SiteDepart.idDepart = Offres.depart');
		$this->db->where('Covoiturages.nBplace > 0');

		$query = $this->db->get();

		return $query->result_array();
	}
	
	/**
	* \fn public get_offers_date($date)
	* \brief Demande toutes les offres à la BDD en fonction de la date $date
	* \param date date des offres que l'on recherche.L
	* \return Un tableau avec les informations de toutes les offres en fonction de la date
	*/
	public function get_offers_date($date){
		$this->db->select('Offres.idOffre, Personnes.nom, Personnes.prenom, Personnes.email, SiteDepart.nom AS SiteDepart, SiteDepart.adresse AS AdresseDepart, SiteArrive.nom AS SiteArrive, SiteArrive.adresse AS AdresseArrive, Offres.jour, Offres.heure, Covoiturages.idCovoit , Covoiturages.nBplace');
		$this->db->from('Personnes, SiteDepart, SiteArrive, Offres, Covoiturages');
		$this->db->where('Personnes.email = Offres.emailCond');
		$this->db->where('Offres.idOffre = Covoiturages.idOffre');
		$this->db->where('SiteArrive.idArrive = Offres.arrivee');
		$this->db->where('SiteDepart.idDepart = Offres.depart');
		$this->db->where('Offres.jour', $date);
		$this->db->where('Covoiturages.nBplace > 0');

		$query = $this->db->get();

		return $query->result_array();
	}
	/**
	* \fn public get_one_offer($idOffre)
	* \brief Demande l'offre en fonction de l'id idOffre
	* \param idOffre l'id de l'offre que l'on demande.
	* \return Un tableau avec les informations de l'offre.
	*/
	public function get_one_offer($idOffre){
		$this->db->select('Offres.idOffre, SiteDepart.idDepart, SiteArrive.idArrive, Offres.jour, Offres.heure, Covoiturages.idCovoit');
		$this->db->from('SiteDepart, SiteArrive, Offres, Covoiturages');
		$this->db->where('Offres.idOffre = Covoiturages.idOffre');
		$this->db->where('SiteArrive.idArrive = Offres.arrivee');
		$this->db->where('SiteDepart.idDepart = Offres.depart');
		$this->db->where('Offres.idOffre',$idOffre);


		$query = $this->db->get();

		return $query->result_array();
	}
	
	/**
	* \fn public subPlace($idCovoit)
	* \brief Enlève une place dans le covoit qui a l'id idCovoit
	* \param idCovoit l'id du covoiturage qui nous intéresse.
	*/
	public function subPlace($idCovoit){
		$this->db->from('Covoiturages');
		$this->db->where('Covoiturages.idCovoit',$idCovoit);

		$query = $this->db->get();
		$result = $query->result_array(); 
		$nBplace = $result[0]['nBplace']-1;
		$this->db->set('nBplace', $nBplace);
		$this->db->where('idCovoit', $idCovoit);
		$this->db->update('Covoiturages'); 
		// gives UPDATE mytable SET field = field+1 WHERE id = 2
	}
	
	/**
	 * \fn public getEmailCond($idOffre)
	 * \brief Donne l'adresse email du conducteur de l'offre avec l'id $idOffre.
	 * \param idOffre : l'id correspondant à l'offre du conducteur concerné..
	 */	
	public function getEmailCond($idOffre){
		$this->db->select('emailCond');
		$this->db->from('Offres');
		$this->db->where('idOffre',$idOffre);

		$query = $this->db->get();

		return $query->result_array();
	}
}