<!-- !PAGE de la conversation! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <div class="w3-container" id="contact" style="margin-top:30px">
    <?php
    $nom = $prenom[0]['nom'];
    $prenom2 = $prenom[0]['prenom'];
    ?>
    <h1 class="w3-xxxlarge w3-text-light-blue "><b>Votre conversation avec <?php echo $prenom2 ." ". $nom ?> </b></h1>
    <hr style="width:200px;border:5px solid gold" class="w3-round">
    <?php
	print_r($voir);
    echo "<div class='w3-container'><form action='" . site_url("MonCompte/Envoyer") . "' method='POST' > ";
    echo "<div class='w3-light-grey w3-panel' ' >";
    foreach ($messages as $keyrow => $row) {
      if($row['Emetteur'] == $this->session->userdata('email')){
		echo "</br>";
		echo "</br>";
        echo "<div class= 'w3-light-grey w3-right-align'>";
        $date = new DateTime($row['Date']);
        $date = $date->format('d/m/Y H:i');
        echo "Le ". $date ." : ";
        echo "</div>";
        echo "<div class='w3-row'>";
        echo "<div class= 'w3-container w3-half '>";
        echo "</div>";
        echo "<div class='w3-round-xlarge w3-light-blue w3-right-align  w3-panel w3-container w3-half' >";
		
      }else{
		  echo "</br>";
		  echo "</br>";
        echo "<div class= 'w3-light-grey w3-left-align'>";
        $date = new DateTime($row['Date']);
        $date = $date->format('d/m/Y H:i');
        echo "Le ". $date ." : ";
        echo "</div>";
        echo "<div class='w3-row'>";
        echo "<div class=' w3-round-xlarge w3-gray w3-left-align w3-panel w3-container w3-half '>";
		

      }
	
      echo "<span>" . $row['Message'] . "</span>";
      echo "<br/>";
      echo "</div>";
      echo "</div>";


    }

    echo "<textarea class='w3-section' style='resize:none; width:100%; height:150px;' maxlength ='300' placeholder='Écrivez votre message ici...' name='Message'></textarea>";
    echo "</div>";
    echo "<button type='submit' class='class='w3-button primary_color w3-button w3-block w3-padding-large primary_color w3-margin-bottom'>Envoyer</button>";

    echo "<input type=\"hidden\" name=\"Destinataire\" value=".$destinataire[0]['Destinataire']."/>";

    echo "</form>";
    echo "</div>";
    ?>

  </div>
  <!-- End page content -->
</div>
</body>
</html>
