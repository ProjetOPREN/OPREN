
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  
  <!-- Formulaire Inscription -->
  <div class="w3-container" id="contact" style="margin-top:30px">
    <h1 class="w3-xxxlarge w3-text-light-blue"><b>Mot de passe oublié</b></h1>
    <hr style="width:200px;border:5px solid gold" class="w3-round">
    <form action="<?php echo site_url('Connexion/MotDePasse')?>" method="POST">
      <div class="w3-section">
        <label>Entrez votre adresse mail</label>
        <input class="w3-input w3-border" type="text" name="email" required>
      </div> 
	  <?php if(isset($error)){
        echo '<div style="color:red;background-color:#F9A4A4;text-align:center;padding:4px;">' . $error . ' </div></br>';
    } ?>
	<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom">Réinitialiser mon mot de passe.</button>
	</form>   

<!-- End page content -->
</div>
</body>
</html>
