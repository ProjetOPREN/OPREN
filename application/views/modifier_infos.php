<div class="w3-main" style="margin-left:340px;margin-right:40px">
<div class="w3-container" style="margin-top:30px;" id="showcase">   
    <h1 class="w3-xxxlarge title_color"><b>Mon Compte</b></h1>
    <hr class="w3-round bar">
  </div>

  </br>
  <form action="<?php echo site_url('MonCompte/modification'); ?>" method="POST">
	<div class="w3-section">
            <label>Nom</label>
            <input class="w3-input w3-border" type="text" name="nom" placeholder="<?php echo $this->session->userdata['nom']; ?>"  >
          </div>
		  <?php 
			$erreur = $this->session->flashdata('erreurnom');
			if(!empty($erreur)){
				echo '<div style="color:white;background-color:#FA0000;text-align:center;margin-bottom:20px">' . $erreur . '</div>';
			}
			?> 
			<?php 
			$validation = $this->session->flashdata('validationnom');
			if(!empty($validation)){
				echo '<div style="color:white;background-color:#90DFC0;text-align:center;margin-bottom:20px">' . $validation . '</div>';
			}
			?>
    	  <div class="w3-section">
          <label>Prénom</label>
          <input class="w3-input w3-border" type="text" name="prenom" placeholder="<?php echo $this->session->userdata['prenom']; ?>" >
        </div>
		<?php 
			$erreur = $this->session->flashdata('erreurprenom');
			if(!empty($erreur)){
				echo '<div style="color:white;background-color:#FA0000;text-align:center;margin-bottom:20px">' . $erreur . '</div>';
			}
			?>
		<?php 
			$validation = $this->session->flashdata('validationprenom');
			if(!empty($validation)){
				echo '<div style="color:white;background-color:#90DFC0;text-align:center;margin-bottom:20px">' . $validation . '</div>';
			}
			?>
    	  <div class="w3-section">
            <label>Téléphone</label>
            <input class="w3-input w3-border" type="tel" name="telephone" placeholder="<?php echo $this->session->userdata['telephone']; ?>">
          </div>
		  <?php 
			$erreur = $this->session->flashdata('erreurtel');
			if(!empty($erreur)){
				echo '<div style="color:white;background-color:#FA0000;text-align:center;margin-bottom:20px">' . $erreur . '</div>';
			}
			?> 
		<?php 
			$validation = $this->session->flashdata('validationtel');
			if(!empty($validation)){
				echo '<div style="color:white;background-color:#90DFC0;text-align:center;margin-bottom:20px">' . $validation . '</div>';
			}
			?>
		<div class="w3-section">
            <label>Email</label>
            <input class="w3-input w3-border" type="tel" name="telephone" value="<?php echo $this->session->userdata['email']; ?>" disabled>
        </div>
		  
		<div class="w3-section">
            <label>Ancien mot de passe</label>
            <input class="w3-input w3-border" type="password" name="ancienMDP" placeholder="********">
          </div>
			<?php 
			$erreur = $this->session->flashdata('erreurancienmdp');
			if(!empty($erreur)){
				echo '<div style="color:white;background-color:#FA0000;text-align:center;margin-bottom:20px">' . $erreur . '</div>';
			}
			?>
		  <div class="w3-section">
            <label>Nouveau mot de passe</label>
            <input class="w3-input w3-border" type="password" name="nouvMDP" placeholder="********">
          </div>
		  <div class="w3-section">
            <label>Confirmez votre nouveau mot de passe</label>
            <input class="w3-input w3-border" type="password" name="confMDP" placeholder="********">
          </div>
          <?php 
			$erreur = $this->session->flashdata('erreurnouvmdp');
			if(!empty($erreur)){
				echo '<div class="error_message">' . $erreur . '</div>';
			}
			?>
		  <?php 
			$erreur = $this->session->flashdata('erreurmdp');
			if(!empty($erreur)){
				echo '<div class="error_message">' . $erreur . '</div>';
			}
			?>
		  <?php 
			$validation = $this->session->flashdata('validationmdp');
			if(!empty($validation)){
				echo '<div class="confirm_message">' . $validation . '</div>';
			}
			?>
			<button type="submit" class="w3-button w3-block w3-padding-large primary_color w3-margin-bottom">Modifier</button>
	</form>
  </div>
</body>
</html>
