<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * \file Accueil.php
 * \brief Controllers de l'Accueil
 * \author Audrey Martin, Bougaud Yves
 * \date 08/10/2017
 *
 */


class Accueil extends CI_Controller {


 	public function __construct()

    {
        parent::__construct();
	$this->load->model('Personnalisation_model','dbColor');
    }

/**
 * \fn public index()
 * \brief Fonction index qui affiche la page d'accueil de l'application
 *
 */
  
	public function index()
	{
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$data['page_title'] = TITLE_HOME;
		
		$this->load->view('header',$data);
        $this->load->view('page_accueil',$data);
	}

}


