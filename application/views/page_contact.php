
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  
  <!-- Formulaire Inscription -->
  <div class="w3-container" id="contact" style="margin-top:30px">
    <h1 class="w3-xxxlarge title_color"><b>Contact</b></h1>
    <hr class="w3-round bar">
	<?php 
      $validation = $this->session->flashdata('validation');
      if(!empty($validation)){
        echo '<div class="confirm_message">' . $validation . '</div>';
      }
      
  ?>
    <form action="<?php echo site_url('Contact/contacter')?>" method="POST">
      <div class="w3-section">
        <label>Nom</label>
        <input class="w3-input w3-border" type="text" name="Nom" required>
      </div>
      <div class="w3-section">
        <label>Mail</label>
        <input class="w3-input w3-border" type="text" name="Mail" required>
      </div>
      <div class="w3-section">
        <label>Objet</label>
        <input class="w3-input w3-border" type="text" name="Objet" required>
      </div>
      <textarea class="w3-section" style="resize:none; width:100%; height:150px;" placeholder="Écrivez votre message ici..." name="Texte"></textarea>
  <button type="submit" class="w3-button w3-block w3-padding-large primary_color w3-margin-bottom">Envoyer</button>
  </form>   

<!-- End page content -->
</div>
</body>
</html>