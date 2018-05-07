
<!-- \author LE Mikael , MARTIN Audrey
     \date 08/10/2017
 -->

<!-- !PAGE CONTENT! -->
<div  class="w3-main" style="margin-left:340px;margin-right:40px">
  
  <!-- Formulaire d'Offres -->
  <div class="w3-container" id="contact" style="margin-top:30px">
    <h1 class="w3-xxxlarge title_color"><b><?php echo $page_title ?></b></h1>
     <hr class="w3-round bar">
    <form action="ajouter_alerte" method="POST">
       </div>
      <div class="w3-section">
        <label>Nom</label>
        <input class="w3-input w3-border" type="text" name="Message" value="<?php echo $this->session->userdata['nom']; ?>" disabled>
      </div>
    <div class="w3-section">
      <label>Prénom</label>
      <input class="w3-input w3-border" type="text" name="Message" value="<?php echo $this->session->userdata['prenom']; ?>" disabled>
    </div>
    <div class="w3-section">
        <label>Téléphone</label>
        <input class="w3-input w3-border" type="tel" name="Message" value="<?php echo $this->session->userdata['telephone']; ?>" disabled>
      </div>

    <div class="w3-section">
        <label>Date</label>
        <input type="date" max="2018-01-28" min="2018-01-20" name="date" placeholder="<?php echo $date; ?>" value="<?php echo $date; ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('Message') . '</div>';
		} ?>

      <div class="w3-section">
        <label>Sélectionnez un interval:</label>
        <input type="time" name="heure1" placeholder="08:00" value="<?php if(isset($_POST['heure1'])){echo $_POST['heure1'];} ?>" required>
		 <input type="time" name="heure2" placeholder="08:15" value="<?php if(isset($_POST['heure2'])){echo $_POST['heure2'];} ?>" required>
     
      </div>
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;">' . form_error('Message') . '</div>';
		} ?>
      </br>
      <button type="submit" class="w3-button w3-block w3-padding-large primary_color w3-margin-bottom">Valider l'alerte</button>
    </form>   

<!-- End page content -->
</div>
</body>
</html>
