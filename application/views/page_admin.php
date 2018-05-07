
<!DOCTYPE html>
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

<script>
$(document).ready(function(){
   var message = "<?php if(isset($message)){echo $message;}  ?>";
   var typeMessage = "<?php if(isset($message)){echo $typeMessage;} ?>";
   	$.notify(message,typeMessage);
   
});

</script>
		<div class='w3-main w3-blue'>
			<div class="w3-container container-button w3-row-padding">
					<form method='POST' action='<?php echo site_url('Administrateur/afficher_utilisateurs') ?>'>
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Afficher Utilisateurs</button>
					</form>

					<form method='POST' action='<?php echo site_url('Administrateur/afficher_Alertes') ?>'>
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Afficher Alertes</button>
					</form>

					<form method='POST' action='<?php echo site_url('Administrateur/afficher_offres') ?>'>
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Afficher Offres</button>
					</form>
					
					<form method='POST' action='<?php echo site_url('Administrateur/afficher_covoiturages') ?>'>
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Afficher Covoiturages</button>
					</form>
					
					<form method='POST' action='<?php echo site_url('Administrateur/afficher_siteArrives') ?>'>
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Afficher Sites d'Arrivée</button>
					</form>
					
					<form method='POST' action='<?php echo site_url('Administrateur/afficher_siteDeparts') ?>'>
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Afficher Sites de Départ</button>
					</form>
					
					<form method='POST' action='<?php echo site_url('Administrateur/afficher_CovPas') ?>'>
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Afficher CovPas</button>
					</form>
			</div>
			
			<!-- POUR AJOUTER DES LIGNES DANS LA BDD -->
			
			<div class="w3-container container-button w3-row-padding">
					<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_user') ?>" target="_blank" >
						<button class="w3-button w3-blue w3-padding-large w3-hover-black" >Ajouter une Personne</button>
					</form>
					<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_demande') ?>" target="_blank" >
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Ajouter une Alerte</button>
					</form>
					<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_offre')?>" target="_blank" >
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Ajouter une Offre</button>
					</form>
					<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_acceptCovoit') ?>" target="_blank" >
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Ajouter une relation Cov-Pass</button>
					</form>
					<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_arrivee') ?>" target="_blank" >
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Ajouter un Site d'Arrivée</button>
					</form>
					<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_depart') ?>" target="_blank" >
						<button class="w3-button w3-blue w3-padding-large w3-hover-black">Ajouter un Site de Départ</button>
					</form>
			</div>
			
			<!-- POUR SUPPRIMER DES LIGNES DANS LA BDD -->
			
			<div class="w3-container container-button w3-row-padding">
				<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_del_user') ?>" target='_blank'>
					<button class="w3-button w3-blue w3-padding-large w3-hover-black">Supprimer Personne</button>
				</form>
				<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_del_demande') ?>" target='_blank'>
					<button class="w3-button w3-blue w3-padding-large w3-hover-black">Supprimer une Alerte</button>
				</form>
				
				<form method='POST' action='afficher_form_del_offre' target='_blank'>
					<button class="w3-button w3-blue w3-padding-large w3-hover-black">Supprimer Offre</button>
				</form> 
				<form method='POST' action="<?php echo site_url('Administrateur/supp_cov_pass') ?>" target='_blank'>
					<button class="w3-button w3-blue w3-padding-large w3-hover-black">Supprimer Cov-Pass</button>
				</form>
				<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_del_arrivee') ?>" target='_blank'>
					<button class="w3-button w3-blue w3-padding-large w3-hover-black">Supprimer Site d'Arrivée</button>
				</form>
				<form method='POST' action="<?php echo site_url('Administrateur/afficher_form_del_depart') ?> "target='_blank'>
					<button class="w3-button w3-blue w3-padding-large w3-hover-black">Supprimer Site de Départ</button>
				</form>
			</div>

			
		</div>

		<div class="w3-container container-stat">
				<form method='POST' action="<?php echo site_url('Administrateur/show_stats') ?>" target='_blank'>
					<button class="w3-button w3-blue w3-padding-large w3-hover-black">Statistiques</button>
				</form>
				<form action="<?php echo site_url('Administrateur/modif_color')?>">
					<button class="w3-button  w3-blue w3-padding-large w3-hover-black" >Modifier les couleurs du site</button>
				</form>
		</div>

		<div class="w3-container" id="showcase"> 
			<h1 class="w3-xxxlarge w3-text-light-blue" id="resultat"><b>Résultats</b></h1>
			<hr class="w3-round">
		</div>
		<div id="div-result" class="w3-container">
		<?php
			if(isset($users)){

				echo "<table id='table-result'><tr class='w3-blue tr-title'><td> Email </td> <td> Nom </td> <td> Prenom </td> <td> telephone </td> </tr>";
				if(empty($users)){
					echo "</table></br><p id='p-aucunResult'>Aucun résultat</p>";
				}else{
					foreach ($users as $row) {
						echo "<tr class='tr-line'>";
						foreach ($row as $key => $value) {
							echo " <td>". $value . "</td>";
						}
						echo "</tr> ";
					}
					echo "</table>";
				}
			}
			
			if(isset($arrive)){

				echo "<table id='table-result'><tr class='w3-blue tr-title'> <td> idArrive </td> <td> Nom </td> <td> adresse </td> </tr>";
				if(empty($arrive)){
					echo "</table></br><p id='p-aucunResult'>Aucun résultat</p>";
				}else{
					foreach ($arrive as $row) {
						echo "<tr class='tr-line'>";
						foreach ($row as $key => $value) {
							echo " <td>". $value . "</td>";
						}
						echo "</tr> ";
					}
					echo "</table>";
				}
				
			}
			
			if(isset($depart)){
				echo "<table id='table-result'><tr class='w3-blue tr-title'> <td> idDepart </td> <td> Nom </td> <td> adresse </td> </tr>";
				if(empty($depart)){
					echo "</table></br><p id='p-aucunResult'>Aucun résultat</p>";
				}else{
					foreach ($depart as $row) {
						echo "<tr class='tr-line'>";
						foreach ($row as $key => $value) {
							echo " <td>". $value . "</td>";
						}
						echo "</tr> ";
					}
					echo "</table>";
				}
			}

			if(isset($offres)){

				echo "<table id='table-result'><tr class='w3-blue tr-title'><td> idOffre </td> <td> Email Cond </td> <td> Départ </td> <td> Arrivée </td> <td> Date </td> <td> Heure </td></tr>";
				if(empty($offres)){
					echo "</table></br><p id='p-aucunResult'>Aucun résultat</p>";
				}else{
					foreach ($offres as $row) {
						echo "<tr class='tr-line'>";
						foreach ($row as $key => $value) {
							echo " <td>". $value . "</td>";
						}
						echo "</tr> ";
					}
					echo "</table>";
				}
				
			}

			if(isset($demandes)){

				echo "<table id='table-result'><tr class='w3-blue tr-title'><td> idDemande </td> <td> Email Pass </td> <td> Départ </td> <td> Arrivée </td> <td> Date </td> <td> Heure </td></tr>";
				if(empty($demandes)){
					echo "</table></br><p id='p-aucunResult'>Aucun résultat</p>";
				}else{
					foreach ($demandes as $row) {
						echo "<tr class='tr-line'>";
						foreach ($row as $key => $value) {
							echo " <td>". $value . "</td>";
						}
						echo "</tr> ";
					}
					echo "</table>";
				}
				
			}

			if(isset($covoit)){

				echo "<table id='table-result'><tr class='w3-blue tr-title'><td> idCovoit </td> <td> Nombre Place </td> <td> Info </td> <td> idOffre </td> </tr>";
				if(empty($covoit)){
					echo "</table></br><p id='p-aucunResult'>Aucun résultat</p>";
				}else{
					foreach ($covoit as $row) {
						echo "<tr class='tr-line'>";
						foreach ($row as $key => $value) {
							echo " <td>". $value . "</td>";
						}
						echo "</tr> ";
					}
					echo "</table>";
				}
			}
			
			if(isset($CovPas)){

				echo "<table id='table-result'><tr class='w3-blue tr-title'><td> idCovoit </td> <td> Nom Conducteur </td> <td> Prenom Conducteur </td> <td> Nombre place </td><td> info </td> <td> idDemande </td>
						<td> Lieu Depart </td> <td> Lieu Arrive </td> <td> mail passager </td></tr>";
				if(empty($CovPas)){
					echo "</table></br><p id='p-aucunResult'>Aucun résultat</p>";
				}else{
					foreach ($CovPas as $row) {
						echo "<tr class='tr-line'>";
						foreach ($row as $key => $value) {
							echo " <td>". $value . "</td>";
						}
						echo "</tr> ";
					}
					echo "</table>";
				}
			}

		?>

		</div>
	</body>
</html>
