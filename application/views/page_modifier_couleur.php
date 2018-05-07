<html>
<header>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
		<script src="<?php echo js_url('side_bar') ?>"></script>

		<style>
		body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
		body {font-size:16px;}
		.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
		.w3-half img:hover{opacity:1}
		</style>

		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
		<link rel="stylesheet" href="<?php echo css_url("style-admin"); ?>" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
     	<script src="<?php echo js_url('notify'); ?>"></script>
     	<script type="text/javascript" src="<?php echo js_url('admin'); ?>"></script>

	
</header>
<body>
<?php if(!$this->session->userdata('Login')){
		redirect('Administrateur/index');
	}
	?>

<div  class="w3-main" style="padding:2%;">
<?php
$error = $this->session->flashdata('error');
      if(!empty($error)){
        echo '<div class="error_message">' . $error . '</div>';
      } 
$confirm = $this->session->flashdata('confirm');
      if(!empty($confirm)){
        echo '<div class="confirm_message">' . $confirm . '</div>';
       } 
?>
<div class='w3-light-grey' style='padding:2%;'>
    <form action="<?php echo site_url('Administrateur/modify_colors'); ?>" method="POST" style='margin:1%;text-align:center;'>
	<p class="w3-xlarge">Couleurs courantes du site</p>
        Couleur principale:<input name="primaire" type="color" value="<?php echo $couleurs['primaire'];?>"></br>
        Couleur de fond:<input name="fond" type="color" value="<?php echo $couleurs['fond'];?>"></br>
        Couleur des bars:<input name="bar" type="color" value="<?php echo $couleurs['bar'];?>"></br>
        Couleur des titres:<input name="titre" type="color" value="<?php echo $couleurs['titre'];?>"></br></br>
        <button class="w3-button w3-blue w3-padding-large w3-hover-black" name="button" type="submit" value="update">Confirmer les couleurs</button></br>
        <button class="w3-button w3-blue w3-padding-large w3-hover-black" name="button" type="submit" value="add">Ajouter un set de couleur</button></br>
    </form>
</div>
<div>
    <?php

        if(isset($setsColor)){
			$numSet = 0;
			$setCourant = true;
            foreach ($setsColor as $keyrow => $row) {
				if(!$setCourant){
					echo " <form action=" . site_url('Administrateur/modify_colors') . " method='POST'>";
					echo "<div class='w3-col m4' style='margin:0.5%;text-align:center;width:30%;display: inline-block;'>";
					echo "<div class='w3-light-grey' style='padding:2%;'>";
					echo "<div class='w3-container'>";

					echo "<p class='w3-xlarge'>Set de couleurs N°" . $numSet . "</p>";
					foreach ($row as $key => $value) {

							switch($key){
								case 'primaire' : echo 'Couleur principale:<input name="primaire" type="color" value="' . $value . '" readonly="readonly"></br>';break;
								case 'fond': echo 'Couleur de fond:<input name="fond" type="color" value="' . $value . '" readonly></br>';break;
								case 'bar': echo 'Couleur des bars:<input name="bar" type="color" value="' . $value . '" readonly></br>';break;
								case 'titre': echo 'Couleur des titres:<input name="titre" type="color" value="' . $value . '" readonly></br>';break;
								 default: break;
							}
							
										 
						
					}
				  

					echo "</div>";
					echo "<button class='w3-button w3-blue w3-padding-large w3-hover-black' style='width:50%;margin:1%;' name='button' type='submit' value='update'>Confirmer les couleurs</button></br>";
					echo "<button class='w3-button w3-blue w3-padding-large w3-hover-black' style='width:50%;margin:1%;' name='button' type='submit' value='delete'>Supprimer ce set</button></br>";
					echo "</div></div>";
					echo "</form>";
				}else{
					$setCourant = false;
				}
				
				$numSet = $numSet + 1;

            }
        }

    ?>
</div>
</div>
</body>
</html>






