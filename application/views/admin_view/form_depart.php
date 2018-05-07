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
    <h1 class="w3-xxxlarge w3-text-light-blue"><b>Ajouter un Site de Départ</b></h1>
    <form action="<?php echo site_url('Administrateur/add_siteDepart')?>" method="POST">
      <div class="w3-section">
        <label>Nom</label>
        <input class="w3-input w3-border" type="text" name="Nom" required>
      </div>
      <div class="w3-section">
        <label>Adresse</label>
        <input class="w3-input w3-border" type="text" name="Adresse" required>
      </div>
	<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom">Ajouter</button>
	</form>   

<!-- End page content -->
</div>
</body>
</html>