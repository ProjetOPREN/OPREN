<!DOCTYPE html>
<html>
  <header>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  </header>

<body><!-- !PAGE CONTENT! -->
<div class="w3-main">
	<?php if(!$this->session->userdata('Login')){
		redirect('Administrateur/index');
	}
	?>
  
  <!-- Formulaire Inscription -->
  <div class="w3-container" id="contact" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-light-blue"><b>Ajouter une Personne</b></h1>
    <form action="<?php echo site_url('Administrateur/add_user')?>" method="POST">
      <div class="w3-section">
        <label>Nom</label>
        <input class="w3-input w3-border" type="text" name="Nom"value="<?php if(isset($_POST['Nom'])){echo $_POST['Nom'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('Nom') . '</div>';
		} ?>
      <div class="w3-section">
        <label>Prénom</label>
        <input class="w3-input w3-border" type="text" name="Prenom" value="<?php if(isset($_POST['Prenom'])){echo $_POST['Prenom'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('Prenom') . '</div>';
		} ?>
      <div class="w3-section">
        <label>Téléphone</label>
        <input class="w3-input w3-border" type="tel" name="Telephone" value="<?php if(isset($_POST['Telephone'])){echo $_POST['Telephone'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('Telephone') . '</div>';
		} ?>
      <div class="w3-section">
        <label>E-mail</label>
        <input class="w3-input w3-border" type="email" name="Mail" value="<?php if(isset($_POST['Mail'])){echo $_POST['Mail'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('Email') . '</div>';
		} ?>
      <div class="w3-section">
        <label>Mot de passe</label>
        <input class="w3-input w3-border" type="password" name="Password" value="<?php if(isset($_POST['Password'])){echo $_POST['Password'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('password') . '</div>';
		} ?>
	<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom">Ajouter</button>
	</form>   

<!-- End page content -->
</div>
</body>
</html>