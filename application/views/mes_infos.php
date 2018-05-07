<div class="w3-main" style="margin-left:340px;margin-right:40px">
<div class="w3-container" style="margin-top:30px;" id="showcase">   
    <h1 class="w3-xxxlarge title_color"><b>Mon Compte</b></h1>
    <hr class="w3-round bar">
  </div>

  </br>


  
  <?php
      $error = $this->session->flashdata('error');
      if(!empty($error)){
        echo '<div class="error_message">' . $error . '</div>';
      }

    foreach ($users as $keyrow => $row) {
      echo "<div class='w3-container' style ='margin : auto;'><form action='" . site_url("MonCompte/modifier") . "' method='POST' > ";
      
 
      foreach ($row as $key => $value) {
          
          switch ($key) {
			case 'nom' : echo "<h3>" . "Nom : ".$value . "</h3>";break;
			case 'prenom' : echo "<h3>" . "Prénom : ".$value . "</h3>";break;
			case 'telephone' : echo "<h3>" . "Téléphone : ".$value . "</h3>";break;
			case 'email' : echo "<h3>" . "Email : ".$value . "</h3>";break;
            case 'mdp' : echo "<h3>" . "Mot de passe : *****". "</h3>";break;
            default: echo "<h3>" . $key . " : " . $value . "</h3>"; break;
          }            

        
        
      }
      echo "</div>";
      echo "<button class='w3-button primary_color w3-padding-large w3-hover-black' style='display:block; margin:auto;' onClick='afficher()'>Modifier</button></form>";
      echo "</div>";
    }
  ?>
  </div>
</body>
</html>

