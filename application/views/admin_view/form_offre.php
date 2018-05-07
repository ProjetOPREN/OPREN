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
    <form action="<?php echo site_url('Administrateur/ajouter_offre')?>" method="POST">
      <div class="w3-section">
        <label>Conducteur:</label>
        <select class="w3-input w3-border" type="text" name="idCond" required>
          <?php foreach ($conducteurs as $row) {
                  foreach ($row as $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                  }
            }
          ?>
        </select>
        </br>
        <label>Site de Départ:</label>
        <select class="w3-input w3-border" type="text" name="idDepart" required>
          <?php foreach ($departs as $row) {
                  foreach ($row as $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                  }
            }
          ?>
        </select>
        </br>
        <label>Site d'Arrivée:</label>
        <select class="w3-input w3-border" type="text" name="idArrivee" required>
          <?php foreach ($arrivees as $row) {
                  foreach ($row as $value) {
                    echo "<option value=" . $value . ">" . $value . "</option>";
                  }
            }
          ?>
        </select>
        </br>
        <label>Info de la voiture:</label></br>
        <input class="w3-input w3-border" type="text" name="infoVoit">
        </br>
        <label>Nombre de place:</label></br>
        <select class="w3-input w3-border" type="text" name="nbPlace" required>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
        </select>
        </br>
        <label>Date:</label>
        <input class="w3-input w3-border" type="date" name="date" required value="31-12-2018">
        <label>Heure:</label>
        <input class="w3-input w3-border" type="text" name="heure" required value="10:15">

      </div>
	<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom">Ajouter</button>
	</form>   

<!-- End page content -->
</div>
</body>
</html>