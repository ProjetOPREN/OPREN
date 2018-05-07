<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <div class="w3-container" id="contact" style="margin-top:30px">
    <h1 class="w3-xxxlarge title_color"><b>Mes Messages</b></h1>
	<hr class="w3-round bar">
	<form method ="POST" name="active" action="<?php echo  site_url('MonCompte/activer') ?>" >
	<button class="w3-button primary_color w3-padding-large w3-hover-black" > <?php if($_SESSION['boolean']){echo "Je désactive les emails.";} else{ echo "J'active les emails."; }?> </button>
	</form>
	<?php
	$validation = $this->session->flashdata('validation');
	if(!empty($validation)){
		echo '<div style="color:white;background-color:#90DFC0;text-align:center;margin-bottom:20px">' . $validation . '</div>';
	}
	if(!empty($discussion)){
	
    foreach ($discussion as $keyrow => $row) {
	echo "<form id=\"Messages\" name =\"form\" action=\"http://opren.istic.univ-rennes1.fr/index.php/MonCompte/Discussion \" method=\"post\">";
	echo "<div class='w3-col m4 w3-margin-bottom' >";
	$email = $row['email'];
	echo "<input type=\"hidden\" name=\"email\" value=".$email."/>";
	echo "<button class='w3-button primary_color w3-padding-large w3-hover-black' style='display:block;  width :300px; height:150px;'>";
	echo "<h3><a onclick=\"form.submit()\">" . $row['prenom'] . " " . $row['nom'] . "</a></h3>";
	echo "</button>";
	
	echo "</form>";	
	
	
	echo "<br/>";
    }
      echo "</div>";
	}else {
		echo "Vous n'avez aucun message.";
	}
  ?>
  </div>
<!-- End page content -->
</hr>
</div>
</body>
</html>

