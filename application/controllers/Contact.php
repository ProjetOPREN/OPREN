<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * \file Contact.php
 * \brief Controllers pour les contacts
 * \author Audrey Martin
 * \date 08/10/2017
 *
 */



class Contact extends CI_Controller {


 	public function __construct()

    {
        parent::__construct();
		$this->load->model('Personnalisation_model','dbColor');

    }

/**
 * \fn public index()
 * \brief Fonction index qui affiche le formulaire de contact
 *
 */
  
	public function index()
	{

		$data['page_title'] = TITLE_HOME;
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
        $this->load->view('page_contact',$data);
	}
	
	
	/**
	* \fn public aProposDe()
	* \brief Fonction aProposDe qui affiche la page de présentation de l'équipe du Projet.
	*
	*/
	public function aProposDe() {
		$data['page_title'] = TITLE_HOME;
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
        $this->load->view('page_apropos',$data);
	}
	
	
	/**
	* \fn public faq()
	* \brief Fonction faq qui affiche la page de FAQ.
	*
	*/
	public function faq() {
		$data['page_title'] = TITLE_HOME;
		$data['couleurs'] = $this->dbColor->get_current_colors();
		$this->load->view('header',$data);
        $this->load->view('FAQ',$data);
	}
	
	
	/**
	* \fn public contacter()
	* \brief Fonction contacter qui permet d'envoyer le message de l'utilisateur vers notre adresse
	*		 email contact@covoit-karen.org.
	*
	*/
	public function contacter()	{
		date_default_timezone_set('Europe/Paris');
		$this->load->library('email');
		
		$config['protocol'] = 'mail';
		$config['charset'] = 'utf-8';
		$config['smtp_host'] = 'auth.smtp.1and1.fr';
		$config['smtp_user'] = 'contact@covoit-karen.org';
		$config['smtp_pass'] = 'projetOPREN35.';
		$config['smtp_port'] = '465';
		$config['smtp_timeout'] = '5';
		$config['priority'] = '1';

		$this->email->initialize($config);
		
		$email =$_POST['Mail'];
		$nom =$_POST['Nom'];
		$objet =$_POST['Objet'];
		$texte =$_POST['Texte'];
		$this->email->from($email, $nom);
		$this->email->to('contact@covoit-karen.org');

		$this->email->subject($objet);
		$this->email->message($texte);

		$this->email->send();
		
		$this->session->set_flashdata('validation',"Votre mail a été envoyé. Merci de votre confiance.");
		
		redirect('Accueil/index');
		
		
	}
}
