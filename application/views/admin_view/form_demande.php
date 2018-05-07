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
  <!-- Formulaire Demande -->
  <div class="w3-container" id="contact" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-light-blue"><b>Ajouter une Demande</b></h1>
    <form action="<?php echo site_url('Administrateur/ajouter_demande')?>" method="POST">
      <div class="w3-section">
        <label>Passager:</label>
        <select class="w3-input w3-border" type="text" name="idPass" required>
          <?php foreach ($passagers as $row) {
                  foreach ($row as $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                  }
            }
          ?>
        </select>
        </br>
        <label>Site de Départ:</label>
        <select class="w3-input w3-border" type="text" name="depart" required>
          <?php foreach ($departs as $row) {
                  foreach ($row as $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                  }
            }
          ?>
        </select>
        </br>
        <label>Site d'Arrivée:</label>
        <select class="w3-input w3-border" type="text" name="arrivee" required>
          <?php foreach ($arrivees as $row) {
                  foreach ($row as $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                  }
            }
          ?>
        </select>
        </br>
        <label>Date:</label>
        <input class="w3-input w3-border" type="date" name="date" required value="2018-12-31">
        <label>Heure:</label>
        <input class="w3-input w3-border" type="text" name="heure" required value="10:15">

      </div>
	<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom">Ajouter</button>
	</form>   

<!-- End page content -->
</div>
</body>
</html>