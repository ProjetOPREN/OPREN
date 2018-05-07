
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Formulaire de connexion -->
  <div class="w3-container" id="contact" style="margin-top:30px">
    <h1 class="w3-xxxlarge title_color"><b>Matchs</b></h1>
	<hr class="w3-round bar">
	
	<h2>QUALIFICATIONS (21 et 22 janvier)</h2>
	<h2>TABLEAU FINAL (DU 23 AU 28 JANVIER)</h2>
	<form id="test1" name="formu" action="http://opren.istic.univ-rennes1.fr/index.php/Recherches/chercher_date" method="post">
	<input type="hidden" name="recup" value="2018-01-23"/>
	</form>
	<h3><a href='#' onclick='formu.submit()'>Mardi 23 janvier 2018 - Début des matchs à 10 h 30</a><h3>
	
	<form id="test2" action="http://opren.istic.univ-rennes1.fr/index.php/Recherches/chercher_date" method="post">
	<input type="hidden" name="recup" value="2018-01-24"/>
	</form>
	<h3><a href='#' onclick='document.getElementById("test2").submit()'>Mercredi 24 janvier 2018 - Début des matchs à 11h</a></h3>
	
	<form id="test3" action="http://opren.istic.univ-rennes1.fr/index.php/Recherches/chercher_date" method="post">
	<input type="hidden" name="recup" value="2018-01-25"/>
	</form>
	<h3><a href='#' onclick='document.getElementById("test3").submit()'>Jeudi 25 Janvier 2018 - Début des matchs à 11h</a></h3>
	
	<form id="test4" action="http://opren.istic.univ-rennes1.fr/index.php/Recherches/chercher_date" method="post">
	<input type="hidden" name="recup" value="2018-01-26"/>
	</form>
	<h3><a href='#' onclick='document.getElementById("test4").submit()'>Vendredi 26 janvier 2018 - Début des matchs à 13h</a></h3>
	
	<form id="test5" action="http://opren.istic.univ-rennes1.fr/index.php/Recherches/chercher_date" method="post">
	<input type="hidden" name="recup" value="2018-01-27"/>
	</form>
	<h3><a href='#' onclick='document.getElementById("test5").submit()'>Samedi 27 janvier 2018 - Début des matchs à 14 h 30</a></h3>
	
	<form id="test6" action="http://opren.istic.univ-rennes1.fr/index.php/Recherches/chercher_date" method="post">
	<input type="hidden" name="recup" value="2018-01-28"/>
	</form>
	<h3><a href='#' onclick='document.getElementById("test6").submit()'>Dimanche 28 Janvier 2018 -</a></h3>
	<h4>14h - Finale du tournoi de double  (en direct sur TV Rennes 35 Bretagne)</h4>
	<h4>16h30 - Finale du tournoi de simple  (en direct sur TV Rennes 35 Bretagne et Eurosport)</h4>
	<select name="selection" onchange="document.location.href = this.options[this.selectedIndex].value;">
		<option selected="selected">Choissisez le jour du match</option>
		<option value="/../index.php/Offres/index">Mardi 23 janvier 2018</option>
		<option value="/../index.php/Offres/index">Mercredi 24 janvier 2018</option>
		<option value="/../index.php/Offres/index">Jeudi 25 janvier 2018</option>
		<option value="/../index.php/Offres/index">Vendredi 26 janvier 2018</option>
		<option value="/../index.php/Offres/index">Samedi 27 janvier 2018</option>
		<option value="/../index.php/Offres/index">Dimanche 28janvier 2018</option>
	</select>
	
</body>
</html>