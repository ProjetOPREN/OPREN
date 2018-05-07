<!DOCTYPE html>
<html>

	<header>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
		<script src="<?php echo js_url('side_bar') ?>"></script>

		<style>
		body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
		body {font-size:16px;}
		.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
		.w3-half img:hover{opacity:1}
		</style>

		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
		<link rel="stylesheet" href="<?php echo css_url("style-admin"); ?>" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
     	<script src="<?php echo js_url('notify'); ?>"></script>
     	<script type="text/javascript" src="<?php echo js_url('admin'); ?>"></script>
	</header>
	
	<body>
<div class="w3-main">
  <!-- Formulaire de connexion -->
  <div class="w3-container" id="contact" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-light-blue"><b>Connexion</b></h1>
    <form action="<?php echo site_url('Connexion_admin/connexion')?>" method="POST">
       <div class="w3-section">
        <label>Login</label>
        <input class="w3-input w3-border" type="text" name="Login" value="<?php if(isset($_POST['Login'])){echo $_POST['Login'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('Login') . '</div>';
		} ?>
      <div class="w3-section">
        <label>Mot de passe</label>
        <input class="w3-input w3-border" type="password" name="Password" value="<?php if(isset($_POST['Password'])){echo $_POST['Password'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('Password') . '</div>';
		} ?>
	<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom">Connexion</button>
	</form> 
    
  </form>  
  </body>  
  
  
  
  
  
  
  
  
  