<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * \file MesMessages_model.php
 * \brief Model qui s'occupe des messages de l'application
 * \author BOUGAUD Yves, NGUYEN Damien
 * \date 06 Février 2018
 *
 */



class MesMessages_model extends CI_MODEL
{

function __construct(){
	parent::__construct();
	$this->load->database('default',TRUE);
	$this->load->helper('date');
	$this->load->library('encryption');
	
}
/**
	 * \fn public getDiscussions()
	 * \brief Renvoie le nom et prénom des personnes avec qui l'utilisateur communique.
	 * \return un tableau avec nom, prenom et email.
	 */
function getDiscussions(){
	$this->db->select('Personnes.email AS email');//'Personnes.nom AS nom, Personnes.prenom AS prenom, Personnes.email AS email
	$this->db->distinct();
	$this->db->from('Messages');
	$this->db->join('Personnes','Personnes.email = Messages.Destinataire');
	$this->db->where('Messages.Emetteur', $this->session->userdata('email')) ;
	$query = $this->db->get();
	
	$this->db->select('Personnes.email AS email'); // Personnes.nom AS nom, Personnes.prenom AS prenom, Personnes.email AS email
	$this->db->distinct();
	$this->db->from('Messages');
	$this->db->join('Personnes','Personnes.email = Messages.Emetteur');
	$this->db->where('Messages.Destinataire', $this->session->userdata('email')) ;
	$querybis = $this->db->get();
	
	$querytab = $query->result_array();
	$querytab2 = $querybis->result_array();
	$result = array_merge($querytab, $querytab2);
	//
	$result = $this->supprimeDoublons($result);
	// On tri en fonction des adresse email.
	$result = array_unique($result);
	$resultfinal = array();
	$tabcourant = array();
	foreach($result as $keyrow => $value){
		$this->db->select('nom, prenom, email');
		$this->db->from('Personnes');
		$this->db->where('email', $value);
		$query = $this->db->get();
		$tabcourant = $query->result_array();
		$resultfinal = array_merge($resultfinal, $tabcourant);
	}
	return  $resultfinal;
	
	
}
	/**
	 * \fn public supprimeDoublons($tab)
	 * \brief Supprime les doublons d'un tableau à deux dimensions (Utilisé par getDiscussions).
	 * \param $tab : le tab où l'on vas supprimer les doublons.
	 * \return un nouveau tableau sans doublons.
	 */
function supprimeDoublons($tab){
	$tableau = array();
	foreach($tab as $keyrow => $row){
		foreach($row as $key => $value){
			$tableau[$keyrow] = $value;
		}
	}
	return $tableau;
}

	/**
	 * \fn public getMessages($email, $emailsession)
	 * \brief Met la clé de confirmation et le boolean actif à faux en base de données.
	 * \param $email : email de l'utilisateur avec lequel la personne communique.
	 * \param $emailsession : le mail de la personne qui est connecté.
	 * \return l'ensemble des messages entre ces deux personnes.
	 */
function getMessages($email, $emailsession){
	$this->db->select('Message, Date, Emetteur, Destinataire');
	$this->db->from('Messages');
	$this->db->where('Emetteur', $email);
	$this->db->where('Destinataire', $emailsession);
	$this->db->or_where('Messages.Emetteur', $emailsession);
	$this->db->where('Messages.Destinataire', $email);
	$this->db->order_by('Date ASC' );	
	$query = $this->db->get();
	$result = $query->result_array();
	$result = $this->decryptMessages($result);
	return $result;
}
/**
	 * \fn public getNomPrenom($email)
	 * \brief Donne le nom et prénom de l'utilisateur avec l'adresse mail $email (Utiliser notamment pour de l'affichage).
	 * \param $email : l'email de l'utilisateur.
	 * \return un tableau avec son nom et prenom.
	 */
function getNomPrenom($email){
		$this->db->select('nom, prenom');
		$this->db->from('Personnes');
		$this->db->where('email',$email) ;
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	/**
	 * \fn public decryptMessages($tab)
	 * \brief Dechiffre tous les messages contenus dans le tableau $tab.
	 * \param $tab :  un tab de messages chiffré.
	 * \return le tableau avec les messages en clair.
	 */
function decryptMessages($tab){
	$this->encryption->initialize(array('driver' => 'openssl'));
	foreach($tab as $keyrow => $row){
		$tab[$keyrow]['Message'] = $this->encryption->decrypt($row['Message']);
	}
	return $tab;
}

	/**
	 * \fn public changeBoolean()
	 * \brief Change la Valeur du boolean pour les notification pour les messages.
	 */
function changeBoolean(){
		$boolean =  $this->session->userdata('boolean');
		$this->session->set_userdata('boolean', !$boolean);
		$this->db->set('booleanEmail',!$boolean);
		$this->db->where('email', $this->session->userdata('email'));
		$this->db->update('Personnes');
	}
	/**
	 * \fn public recupBoolean($email)
	 * \brief Récupère le Boolean de notification pour les messages de l'utilisateur avec l'adresse $email.
	 * \param $mail : l'email de l'utilisateur à qui on veut avoir le boolean.
	 * \return La valeur du boolean.
	 */
function recupBoolean($email){
		$this->db->select('booleanEmail');
		$this->db->from('Personnes');
		$this->db->where('email',$email) ;
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/**
	 * \fn public envoyer($data)
	 * \brief Envoye en base de données le message entre deux utilisateurs.
	 * \param $data : structure contenant le destinataire , l'emetteur, le message et la date de l'envoie du message.
	 * \return un boolean vrai si il y est non sinon.
	 */
function envoyer($data){
	$this->db->set('Emetteur',$data['Emetteur']);
	$this->db->set('Destinataire',$data['Destinataire']);
	$this->db->set('Message',$data['Messages']);
	$this->db->set('Date',mdate("%Y-%m-%d %H:%i:%s"), now());
	$this->db->insert('Messages');
}
}
	
