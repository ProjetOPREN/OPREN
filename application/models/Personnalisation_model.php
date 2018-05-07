<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * \file Personnalisation_model.php
 * \brief Model qui s'occupe de la personnalisation du site
 * \date 28/03/2018
 *
 */



class Personnalisation_model extends CI_MODEL
{

function __construct(){
	parent::__construct();
	// la table Couleurs que l'on manipule dans ce model est dans la base de donn�es Admin.
	$db2 = $this->load->database('admin',TRUE);
}

/******************************************************************************************************
**** FONCTIONS login Admin
*******************************************************************************************************/

/**
 * \fn public get_all_colors
 * \brief Donne les couleurs du site enregistr�es en bdd
 * \return un tableau avec les diff�rentes couleurs
 */
 
 public function get_current_colors(){
 		$db2 = $this->load->database('admin',TRUE);
		$db2->select('primaire,titre,bar,fond');
		$db2->from('Couleurs');

		$query = $db2->get();
		$result = $query->result_array();
		if(empty($result)){
			return false;
		}else{
			return $result[0];
		}
 }
/**
 * \fn public update_colors($primaire,$fond,$bar,$titre)
 * \brief Mets � jour les diff�rentes couleurs choisies.
 * \param primaire : couleur primaire du site.
 * \param fond : couleur du fond.
 * \param bar : couleur de la bar.
 * \param titre : couleur du titre.
 */
public function update_colors($primaire,$fond,$bar,$titre){
	$db2 = $this->load->database('admin',TRUE);
	$data=array(
		'primaire' => $primaire,
        'fond' => $fond,
        'bar' => $bar,
        'titre' => $titre
	);
	$this->db->set('primaire','primaire',false);
	$this->db->set('titre','titre',false);
	$this->db->set('bar','bar',false);
	$this->db->set('fond','fond',false);
	$db2->where('idSetColor',1);
	$db2->update('Couleurs', $data);
	

}
	
/**
 * \fn public add_colors($primaire,$fond,$bar,$titre)
 * \brief Mets en base de donn�es le style de couleur pass� en param�tres.
 * \param primaire : couleur primaire du site.
 * \param fond : couleur du fond.
 * \param bar : couleur de la bar.
 * \param titre : couleur du titre.
 * \return vrai si ins�rer , faux si d�j� pr�sente en BDD.
 */
public function add_colors($primaire,$fond,$bar,$titre){
	$db2 = $this->load->database('admin',TRUE);

	//On v�rifie que le set n'a pas d�j� �t� enregistr� avant.
	$db2->select('primaire,fond,bar,titre');
	$db2->where('primaire',$primaire);
	$db2->where('fond',$fond);
	$db2->where('bar',$bar);
	$db2->where('titre',$titre);
	$db2->where('idSetColor > 1');
	$db2->from('Couleurs');

	$query = $db2->get();
	$result = $query->result_array();

	if(!empty($result)){
		return false;
	}
	
	$db2->set('primaire',$primaire);
	$db2->set('fond',$fond);
	$db2->set('bar',$bar);
	$db2->set('titre',$titre);
	$db2->insert('Couleurs');

	return true;
}

/**
 * \fn public get_all_setColor()
 * \brief Donne tout le contenue de la table Couleurs.
 * \return un tableau avec toutes les diff�rents style de couleur pr�sent en BDD.
 */
public function get_all_setColor(){
	$db2 = $this->load->database('admin',TRUE);
	$db2->select('primaire,fond,bar,titre');
	$db2->from('Couleurs');

	$query = $db2->get();
	return $query->result_array();
}

/**
 * \fn public delete_colors($primaire,$fond,$bar,$titre)
 * \brief Supprime un style de couleur de la table Couleurs.
 * \param primaire : couleur primaire du site.
 * \param fond : couleur du fond.
 * \param bar : couleur de la bar.
 * \param titre : couleur du titre.
 */
public function delete_colors($primaire,$fond,$bar,$titre){
	$db2 = $this->load->database('admin',TRUE);
	$db2->where('primaire',$primaire);
	$db2->where('fond',$fond);
	$db2->where('bar',$bar);
	$db2->where('titre',$titre);
	$db2->where('idSetColor > 1');
	$db2->delete('Couleurs');
	
}

}