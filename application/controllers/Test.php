<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Test extends CI_Controller {


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
	$data['couleurs'] = $this->dbColor->get_current_colors();
        $this->load->view('page_test',$data);
	}

}
