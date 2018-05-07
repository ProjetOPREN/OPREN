<!DOCTYPE html>
<html>
  <header>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
  </header>

<body><!-- !PAGE CONTENT! -->
<div class="w3-main">

<div class="w3-container" id="showcase"> 
			<h1 class="w3-xxxlarge w3-text-light-blue" id="resultat"><b>Résultats</b></h1>
			<hr class="w3-round">
		</div>
		<?php if(!$this->session->userdata('Login')){
		redirect('Administrateur/index');
		}
		?>
		
		<?php 
			
			echo "<table id='table-result'><tr class='w3-blue tr-title'> <td> Stats	 </td> <td> Résultat </td></tr>";
		
			echo "<tr class='tr-line'> <td> Nombre d'utilisateur </td> <td>". $var['nbUsers'] . "</td>";
			
			echo "<tr class='tr-line'> <td> Nombre de covoiturage </td> <td>". $var2['nbOffres'] . "</td>";

			echo "<tr class='tr-line'> <td> covoiturage avec 1+ passagers </td> <td>". $var4['donnee'] . "</td>";

			echo "<tr class='tr-line'> <td> covoiturage avec 0 passagers </td> <td>". $var5['donnee'] . "</td>";

			echo "</table>";

			echo "<table id='table-result2'><tr class='w3-blue tr-title'> <td> Jours	 </td> <td> Nombre covoiturage </td></tr>";

			foreach($var3 as $row){
				echo "<tr class='tr-line'>";
				foreach ($row as $key => $value) {
					echo " <td>". $value . "</td>";
				}
				echo "</tr>";

			}

			echo "</table>";

			//echo "<tr class='tr-line'> <td> Nombre de covoiturage par jour  </td>";


			/*foreach($offresJour['offresJour'] as $row){
				echo "<tr class='tr-line'> <td> Nombre de covoiturage par jour  </td>";
				foreach($row as $key=>$value){
				echo "<td>" . $value . "</td>";
				}
			}
			//echo "<td>". $offresJour['offresJour'] . "</td>";
			
			foreach($offresJour as $value){
			
			echo "<tr class='tr-line'> <td> Nombre de covoiturage </td> <td>". $value['offresJour'] . "</td>";
			echo "<tr class='tr-line'> <td> Nombre de covoiturage </td> <td>". $value['jour'] . "</td>";
			}*/
		?>
		

</div>
</body>
</html>