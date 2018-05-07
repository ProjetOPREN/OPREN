<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* \file Connexion_model.php
* \brief Model qui s'occupe des requête côté Personne, avec les connexions et les inscriptions
* \author Audrey Martin
* \date 13 Octobre 2017
*
*/



class Connexion_model extends CI_MODEL
{
	function __construct(){
		parent::__construct();
		$this->load->database('admin',FALSE);
		$this->load->library('encryption');
	}

	/**
	* \fn public add_personne($data)
	* \brief Permet d'ajouter une personne à la BDD avec les valeurs données en paramètre
	* \param $data: array qui contient les informations d'une personne
	*/

	public function add_personne($data){
		$this->db->set('nom',$data['Nom']);
		$this->db->set('prenom',$data['Prenom']);
		$this->db->set('telephone',$data['Telephone']);
		$this->db->set('email',$data['Mail']);
		$this->db->set('mdp',$data['Mdp']);
		$this->db->insert('Personnes');
	}

	/**
	* \fn public user_login($login_user,$password_user)
	* \brief Fonction qui permet de récupérer une Personne à partir de ses identifiants
	* \param $email_user, $password_user
	* \return retourne un array contenant la Personne correspondante, sinon false
	*/

	public function user_login($email_user, $password_user){
		$this->db->select('email,nom,prenom,telephone,booleanEmail');
		$this->db->from('Personnes');
		$this->db->where('email',$email_user);

		$query = $this->db->get();



		if($query->num_rows() == 1) {
			$result_array = $query->result_array();

			$this->db->select('mdp');
			$this->db->from('Personnes');
			$this->db->where('email',$result_array[0]['email']);
			$query_mdp = $this->db->get();
			$result_array_mdp = $query_mdp->result_array();
			$mdpBDD = $result_array_mdp[0]['mdp'];
			$this->encryption->initialize(array('driver' => 'openssl'));
			$mdpdecrypt = $this->encryption->decrypt($mdpBDD);
			if($mdpdecrypt === $password_user){
				return $result_array;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}
	/**
	 * \fn public checkMail($email_user)
	 * \brief vérifie si le l'adresse $email_user est en base de données.
	 * \param $email_user : email de l'utilisateur.
	 * \return un boolean vrai si il y est non sinon.
	 */
	public function checkMail($email_user){
		$this->db->select('email');
		$this->db->from('Personnes');
		$this->db->where('email',$email_user);

		$query = $this->db->get();
		if($query->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * \fn public updateMDP($email, $nouvmdpcrypt)
	 * \brief change le motdepasse de l'utilisateur.
	 * \param $email : email de l'utilisateur
	 * \param $nouvmdpcrypt : son nouveau mot de passe chiffrer.
	 */
	public function updateMDP($email, $nouvmdpcrypt) {
		$this->db->set('mdp', $nouvmdpcrypt);
		$this->db->where('email', $email);
		$this->db->update('Personnes');
	}
	
	/**
	 * \fn public verifyCompte($email, $cle)
	 * \brief Active le compte de l'utilisateur après inscription.
	 * \param $email : email de l'utilisateur.
	 * \param $cle : cle envoyer par mail.
	 * \return un boolean vrai si il l'a fait non sinon.
	 */
	public function verifyCompte($email, $cle) {
		$this->db->select('email', 'cle');
		$this->db->from('Personnes');
		$this->db->where('email', $email);
		$this->db->where('cle', $cle);

		$query = $this->db->get();
		if($query->num_rows() == 1){
			$this->db->set('actif', 1);
			$this->db->where('email', $email);
			$this->db->update('Personnes');
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * \fn public updateCleInscription($cle, $mail)
	 * \brief Met la clé de confirmation et le boolean actif à faux en base de données.
	 * \param $cle : la cle de confirmation que l'on envoie par mail.
	 * \param $mail : l'email de l'utilisateur qui vient de s'inscrire.
	 */
	public function updateCleInscription($cle, $mail) {
		$this->db->set('cle', $cle);
		$this->db->set('actif', 0);
		$this->db->where('email', $mail);
		$this->db->update('Personnes');
	}
	
	/**
	 * \fn public verificationCompteActiver($mail)
	 * \brief Vérifie si l'utilisateur qui se connecte à validé son compte.
	 * \param $mail : l'email de l'utilisateur qui tente de se connecte.
	 * \return un boolean vrai si il l'a fait non sinon.
	 */
	public function verificationCompteActiver($mail) {
		$this->db->select('email', 'actif');
		$this->db->from('Personnes');
		$this->db->where('email', $mail);
		$this->db->where('actif' , 1);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}
}
