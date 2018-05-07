<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins"/>
    <link rel="stylesheet" href="<?php echo css_url("style"); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <script src="<?php echo js_url('side_bar') ?>"></script>
	 <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <title><?php echo $page_title ?></title>

    <style>
   body{background-color:<?php echo $couleurs['fond'];?>}
   .primary_color{background-color:<?php echo $couleurs['primaire'];?>}
   .title_color{color:<?php echo $couleurs['titre'];?>}
   .bar{margin-bottom:30px;width:200px;border:5px solid <?php echo $couleurs['bar'];?>}

    body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
    body {font-size:16px;}
    .w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
    .w3-half img:hover{opacity:1}
    </style>
  </head>
<body id="body">

<!-- Sidebar/menu -->
<nav class="w3-sidebar primary_color w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:275px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Fermer le menu</a>
  
  <div class="w3-container" >
	
    <h3 class="w3-padding-64">KAREN     <img src="/karen_logo.png"/></br><a style="text-decoration: none;" href="http://www.openderennes.org/">Open de Tennis</a></h3>
    
  </div>
  <!-- Bouton de Connexion/Deconnexion -->
  <div class="w3-bar-block" style="margin-bottom:30px">
	<a href="<?php if(isset($_SESSION['email'])) { echo site_url('Connexion/Deconnexion'); } else { echo site_url('Connexion/index');} ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">
	<?php if(isset($_SESSION['email'])){echo "Déconnexion";}else{ echo "Connexion" ;}?></a>
  </div>
  <hr class="w3-round bar">
  <div class="w3-bar-block">
    <a href="<?php echo base_url(); ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Accueil</a>
	
	<!-- Boutons s'affichant si un utilisateur est connecté -->
    <?php if(isset($_SESSION['email'])) { echo '<a href="' . site_url('MonCompte/MonCompte') . '" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">'; echo "Mon Compte";} ?>
	<?php if(isset($_SESSION['email'])) { echo '<a href="' . site_url('MonCompte/MesAlertes') . '" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">'; echo "Mes Alertes";} ?>
	<?php if(isset($_SESSION['email'])) { echo '<a href="' . site_url('MonCompte/MesReservations') . '" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">'; echo "Mes Réservations";} ?>
	<?php if(isset($_SESSION['email'])) { echo '<a href="' . site_url('MonCompte/MesCovoiturages') . '" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">'; echo "Mes Covoiturages";} ?>
	<?php if(isset($_SESSION['email'])) { echo '<a href="' . site_url('MonCompte/MesMessages') . '" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">'; echo "Mes Messages";} ?>

    <a href="<?php echo site_url('Matchs/index'); ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Matchs</a>
	<a href="<?php echo site_url('Map/index'); ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Carte de Rennes</a>
    <a href="<?php echo site_url('Contact/index'); ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Contact</a>
	<a href="<?php echo site_url('Contact/aProposDe'); ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">À propos</a>
  <a href="<?php echo site_url('Contact/faq'); ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">FAQ</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large primary_color w3-xlarge w3-padding">
  <a href="javascript:void(0)" onclick="w3_open()"><img width="5%" height="5%" style="float:left; margin:0 10px 0 1px;" src="/icon.png"/></a>
</header>



<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
