

<!-- !PAGE CONTENT! -->
<!--<script> 
	function afficher(){
		alert('Voulez vous réserver ce covoiturage ?') ;
		var boutton="";
		boutton=
	}
</script>-->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <!-- Header -->
  <?php
		
		if(empty($_POST['date']) && empty($_POST['recup'])){
			$date = '2018-01-21';
		}else if(!empty($_POST['date'])&&empty($_POST['recup'])){
			$date =$_POST['date'];
		}else{
			$date =$_POST['recup'];
		}
          switch ($date) {
            case '2018-01-21': $date = "21 Janvier 2018";break;
			case '2018-01-22': $date = "22 Janvier 2018";break;
			case '2018-01-23': $date = "23 Janvier 2018";break;
			case '2018-01-24': $date = "24 Janvier 2018";break;
			case '2018-01-25': $date = "25 Janvier 2018";break;
			case '2018-01-26': $date = "26 Janvier 2018";break;
			case '2018-01-27': $date = "27 Janvier 2018";break;
			case '2018-01-28': $date = "28 Janvier 2018";break;
            default: $date = "undefined"; break;
          }            
      
    
  ?>
  
  <div class="w3-container" style="margin-top:6px;" id="showcase">   
    <h1 class="w3-xxxlarge title_color"><b>Liste des covoiturages du <?php echo htmlspecialchars($date); ?></b></h1>
    <hr class="w3-round bar">
  </div>

  </br>

  <form action="<?php echo site_url('Recherches/chercher_date')?>" method="POST">
  <select name="date">
    <option value="2018-01-21">21 Janvier 2018</option>
    <option value="2018-01-22">22 Janvier 2018</option>
    <option value="2018-01-23">23 Janvier 2018</option>
    <option value="2018-01-24">24 Janvier 2018</option>
	<option value="2018-01-25">25 Janvier 2018</option>
    <option value="2018-01-26">26 Janvier 2018</option>
    <option value="2018-01-27">27 Janvier 2018</option>
    <option value="2018-01-28">28 Janvier 2018</option>
  </select>
  <br><br>
  <br><button type="submit" class="w3-button w3-block w3-padding-large primary_color w3-margin-bottom" style="width:500px">Changer de date</button></br>
</form>

<form action="<?php echo site_url('Recherches/afficher_form_alerte');?>" method="POST">
	<input type='hidden' value="<?php echo $date; ?>" name="date">
	<button type="submit" class="w3-button w3-block w3-padding-large primary_color w3-margin-bottom" style="width:500px">Créer votre alerte</button>
</form>
  <!-- Rediriger vers un formulaire de demande. -->
  
  <?php
      $error = $this->session->flashdata('error');
      if(!empty($error)){
        echo '<div class="error_message">' . $error . '</div>';
      } 
    foreach ($offres as $keyrow => $row) {
      echo "<div class='w3-col m4 w3-margin-bottom' style='margin:1%;'>";
      echo "<div class='w3-light-grey'>";
      echo "<div class='w3-container'><form action='" . site_url("Recherches/reserver") . "' method='POST' > ";
      
 
      foreach ($row as $key => $value) {
          
          switch ($key) {
            case 'nom': echo "<h3>" . $value . " " . $row['prenom'] . "</h3>"; break;
            case 'prenom' : break;
			case 'email' : $email = $value; break;
            case 'SiteDepart': echo "<p>Lieu de départ: " . $value . "</p>" ; break;
            case 'SiteArrive' : echo "<p>Lieu d'arrivée: " . $value . "</p>"; break;
            case 'AdresseDepart' : echo "<p>Adresse: " . $value . "</p>"; break;
            case 'AdresseArrive' : echo "<p>Adresse: " . $value . "</p>"; break;
            case 'jour' : echo "<p>Jour de départ: " . $value . "</p>"; break;
            case 'heure' : echo "<p>Heure de départ: " . $value . "</p>"; break;
            case 'nBplace' : echo "<p>Place(s) restante(s): " . $value . "</p>"; break;
            case 'idOffre': echo "<input type='hidden' name ='idOffre' value=" . $offres[$keyrow]['idOffre'] . ">";break;
            case 'idCovoit': echo "<input type='hidden' name ='idCovoit' value=" . $offres[$keyrow]['idCovoit'] . ">";break;
			
            default: echo "<p>" . $key . " : " . $value . "</br>"; break;
          }            

        
        
      }
      echo "</div>";
      echo "<button class='w3-button primary_color w3-padding-large w3-hover-black' style='display:inline-block; float:right; position:relative; right:1%;'>Réserver</button></form>";
	  echo "<form action='" . site_url("MonCompte/Discussion") . "' method='POST' style='display: inline-block;' > ";
	  echo "<input type=\"hidden\" name=\"email\" value=".$email."/>";
	  echo "<button class='w3-button primary_color w3-padding-large w3-hover-black' style='display:inline-block; float:left position:relative; left:10%;'>Message</button></form>";
      echo "</div></div>";
    }
  ?>
  

</body>
</html>

