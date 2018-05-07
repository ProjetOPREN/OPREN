<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:30px;" id="showcase">   
    <h1 class="w3-xxxlarge title_color"><b>KAREN</b></h1>
    <hr class="w3-round bar">
	<br/>
	</div>
	<?php

 	if(isset($confirmation)){
 		echo '<div style="color:green;background-color:#7FDE9C;text-align:center;padding:4px;">' . $confirmation . $_SESSION['id_user'] . ' </div></br>';
 	}
?>
<?php 
      $validation = $this->session->flashdata('validation');
      if(!empty($validation)){
        echo '<div style="color:white;background-color:#90DFC0;text-align:center;margin-bottom:20px">' . $validation . '</div>';
      }
  ?>
<form action="<?php echo site_url('Recherches/chercher_page')?>"><button class="w3-button primary_color w3-padding-large w3-hover-black" style="display:block; margin: auto; width :300px; height:150px">Je recherche un covoiturage</button></form>
</br>
<form action="<?php echo site_url('Offres/index')?>"><button class="w3-button primary_color w3-padding-large w3-hover-black" style="display:block; margin: auto; width :300px; height:150px">J'offre un covoiturage</button></form>

  </div>


  
<!-- End page content -->

</body>
</html>
  
<!-- End page content -->
