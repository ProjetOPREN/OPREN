<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * \file Administration_model.php
 * \brief Model qui s'occupe de la page d'administration de l'application
 * \date 01 Novembre 2017
 *
 */



class Connexion_admin_model extends CI_MODEL
{

function __construct(){
	parent::__construct();
	$db2 = $this->load->database('admin',TRUE);
}

/******************************************************************************************************
**** FONCTIONS login Admin
*******************************************************************************************************/

/**
 * \fn public login
 * \brief log l'admin 
 * \return un boolean pour savoir si il a réussi a se loger. 
 */
 
 public function login($login_admin,$password_admin){
		$db2 = $this->load->database('admin',TRUE);
		$db2->select('Login');
		$db2->from('Login');
		$db2->where('Login',$login_admin);
		
		$query = $db2->get();
		
		if($query->num_rows() == 1){
		    $result_array = $query->result_array();
		    
		    $db2->select('MDP');
			$db2->from('Login');
			$db2->where('Login',$result_array[0]['Login']);
			$query_mdp = $db2->get();
			$result_array_mdp = $query_mdp->result_array();
			$mdpBDD = $result_array_mdp[0]['MDP'];
			

			if(crypt($password_admin, $mdpBDD)=== $mdpBDD){
				return $result_array; 
			}else{
				return false;
			}
		
	   }else{
	    	return false;
	   }
 
 }
}