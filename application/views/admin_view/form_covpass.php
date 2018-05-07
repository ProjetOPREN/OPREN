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
    <h1 class="w3-xxxlarge w3-text-light-blue"><b>Ajouter une Offre</b></h1>
    <form action="<?php echo site_url('Administrateur/add_cov_pass')?>" method="POST">
      <div class="w3-section">
        <label>IdDemande:</label>
        <select class="w3-input w3-border" type="text" name="idDemande" required>
          <?php foreach ($demande as $row) {
                  foreach ($row as $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                  }
            }
          ?>
        </select>
        </br>
        <label>idCovoit:</label>
        <select class="w3-input w3-border" type="text" name="idCovoit" required>
          <?php foreach ($covoit as $row) {
                  foreach ($row as $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                  }
            }
          ?>
        </select>
      </div>
	<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom">Ajouter</button>
	</form>   

<!-- End page content -->
</div>
</body>
</html>