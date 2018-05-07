<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <div class="w3-container" style="margin-top:30px;" id="showcase">
    <h1 class="w3-xxxlarge title_color"><b>Mes Alertes</b></h1>
    <hr class="bar">
	<br/>
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
      echo "<div class='w3-container'><form action='" . site_url("MonCompte/annulerAlertes") . "' method='POST' > ";

	  

      foreach ($row as $key => $value) {

          switch ($key) {
		      	case 'idAlerte': echo "<input type='hidden' name ='idAlerte' value=" . $users[$keyrow]['idAlerte'] . ">";break;
            case 'Jour' : echo "<p>Jour de l'alerte : " . $value . "</p>"; break;
            case 'heureD' : echo "<p>Heure de début : " . $value . "</p>"; break;
            case 'heureF' : echo "<p>Heure de fin : " . $value . "</p>" ; break;



            default: echo "<p>" . $key . " : " . $value . "</br>"; break;
          }



      }
      
      echo "</div>";
      echo "<button class='w3-button primary_color w3-padding-large w3-hover-black' style='display:block; margin:auto;'>Annuler</button></form>";
      echo "</div></div>";
    }
}else{
	echo "Vous n'avez aucune alerte.";
}
  ?>

</body>
</html>
