<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * \file Matchs.php
 * \brief Controllers de des Matchs
 * \author Sina Khoubi
 * \date 15/11/2017
 *
 */

class Map extends CI_Controller {


 	public function __construct()

    {
        parent::__construct();
		$this->load->model('Personnalisation_model','dbColor');

    }

/**
 * \fn public index()
 * \brief Fonction index qui affiche les différents matchs qui ont/auront lieu
 *
 */
  
	public function index()
	{
        //ICI l'accès au données de la bdd à faire, dans le tableau 'data'
        
		$data['page_title'] = TITLE_HOME;
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
        $this->load->view('page_map',$data);
	}

}
