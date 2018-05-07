
<!-- \author LE Mikael , BOUGAUD Yves, MARTIN Audrey
     \date 08/10/2017
 -->
 
 <?php 
      $validation = $this->session->flashdata('validation');
      if(!empty($validation)){
        echo '<div class="confirm_message">' . $validation . '</div>';
      }
      
  ?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <!-- Header -->
  <div class="w3-container" style="margin-top:30px;" id="showcase">   
    <h1 class="w3-xxxlarge title_color"><b>Choix de la date du covoiturage</b></h1>
    <hr class="w3-round bar">
	 <?php 
      $validation = $this->session->flashdata('validation');
      if(!empty($validation)){
        echo '<div class="confirm_message">' . $validation . '</div>';
      }
      
  ?>
    <h2>Sélectionnez la date souhaitée</h2>
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
  <button type="submit" class="w3-button w3-block w3-padding-large primary_color w3-margin-bottom">Valider</button>
</form>

</body>
</html>