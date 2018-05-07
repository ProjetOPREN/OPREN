<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <div class="w3-container" style="margin-top:30px;" id="showcase">   
    <h1 class="w3-xxxlarge title_color"><b>Mes Covoiturages</b></h1>
    <hr class="w3-round bar">
	<br/>
	</div>
<?php 
      $annulation = $this->session->flashdata('annulation');
      if(!empty($annulation)){
        echo '<div class="confirm_message">' . $annulation . '</div>';
      }
  ?>
<?php 
if(!empty($users)){
    foreach ($users as $keyrow => $row) {
      echo "<div class='w3-col m4 w3-margin-bottom' style='margin:1%;'>";
      echo "<div class='w3-light-grey'>";
	  echo "<div class='w3-container'><form action='" . site_url("MonCompte/annulerCovoiturage") . "' method='POST' > ";
      
 
      foreach ($row as $key => $value) {
          
          switch ($key) {
            case 'Dnom': echo "<p>Lieu de départ : " . $value . "</p>" ; break;
			      case 'Dadresse' : echo "<p>Adresse : " . $value . "</p>"; break;
            case 'Anom' : echo "<p>Lieu d'arrivée : " . $value . "</p>"; break;
            case 'Aadresse' : echo "<p>Adresse : " . $value . "</p>"; break;
            case 'jour' : echo "<p>Jour de départ : " . $value . "</p>"; break;
            case 'heure' : echo "<p>Heure de départ : " . $value . "</p>"; break;
			      case 'infovoiture' : echo "<p>Informations sur la voiture : " . $value . "</p>"; break;
			      case 'nBplace' : echo "<p>Nombre de place : " . $value . "</p>"; break;
			      case 'idOffre': echo "<input type='hidden' name ='idOffre' value=" . $users[$keyrow]['idOffre'] . ">";break;
            case 'idArrive': echo "<input type='hidden' name ='idArrive' value=" . $users[$keyrow]['idArrive'] . ">";break;
            case 'idDepart': echo "<input type='hidden' name ='idDepart' value=" . $users[$keyrow]['idDepart'] . ">";break;

            default: echo "<p>" . $key . " : " . $value . "</br>"; break;
          }            
      } 
      echo "</div>";
      echo "<button class='w3-button primary_color w3-padding-large w3-hover-black' style='display:block; margin:auto;'>Annuler</button></form>";
      echo "</div></div>";
    }
}else{
	echo "Vous n'avez aucun covoiturage.";
}
  ?>
  
</body>
</html>
