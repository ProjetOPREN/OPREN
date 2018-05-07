
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  
  <!-- Formulaire Inscription -->
  <div class="w3-container" id="contact" style="margin-top:30px">
    <h1 class="w3-xxxlarge title_color"><b>Inscription</b></h1>
    <hr class="w3-round bar">	
		
	<form action="<?php echo site_url('Connexion/inscription')?>" method="POST">
		<div class="w3-section">
		<label>Nom</label>
        <input class="w3-input w3-border" type="text" name="Nom" maxlength="50" placeholder="Nom" value="<?php if(isset($_POST['Nom'])){echo $_POST['Nom'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div class="error_message">' . form_error('Nom') . '</div>';
		} ?>
      <div class="w3-section">
        <label>Prénom</label>
        <input class="w3-input w3-border" type="text" name="Prenom" maxlength="50" placeholder="Prénom" value="<?php if(isset($_POST['Prenom'])){echo $_POST['Prenom'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div class="error_message">' . form_error('Prenom') . '</div>';
		} ?>
      <div class="w3-section">
        <label>Téléphone</label>
        <input class="w3-input w3-border" type="tel" name="Telephone" placeholder="0607080910" value="<?php if(isset($_POST['Telephone'])){echo $_POST['Telephone'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div class="error_message">' . form_error('Telephone') . '</div>';
		} ?>
      <div class="w3-section">
        <label>E-mail</label>
        <input class="w3-input w3-border" type="email" name="Mail"  placeholder="mail@exemple.fr" value="<?php if(isset($_POST['Mail'])){echo $_POST['Mail'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div class="error_message">' . form_error('Mail') . '</div>';
		} ?>
      <div class="w3-section">
        <label>Mot de passe</label>
        <input class="w3-input w3-border" type="password" name="Password" placeholder="*****" value="<?php if(isset($_POST['Password'])){echo $_POST['Password'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div class="error_message">' . form_error('Password') . '</div>';
		} ?>
		<div class="w3-section">
        <label>Confirmation mot de passe</label>
        <input class="w3-input w3-border" type="password" name="Password2" placeholder="*****" value="<?php if(isset($_POST['Password2'])){echo $_POST['Password2'];} ?>" required>
      </div>
	  <?php if(isset($error)){
        echo '<div class="error_message">' . form_error('Password2') . '</div>';
		} ?>
  <button type="submit" class="w3-button w3-block w3-padding-large primary_color w3-margin-bottom">S'inscrire</button>
  </form>

<!-- End page content -->

</form>
</div>
</body>
</html>

