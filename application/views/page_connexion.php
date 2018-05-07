<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">
  <!-- Formulaire de connexion -->
  <div class="w3-container" id="contact" style="margin-top:30px">
    <h1 class="w3-xxxlarge title_color"><b>Connexion</b></h1>
  <hr class="w3-round bar">
  
    <form action="<?php echo site_url('Connexion/connexion')?>" method="POST">
      <div class="w3-section">
        <label>E-mail</label>
        <input class="w3-input w3-border" type="email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" required>
      </div>
    <div class="w3-section">
        <label>Mot de passe</label>
        <input class="w3-input w3-border" type="password" name="password" required>
    </div>
    <?php 
	if(isset($error)){
        echo '<div class="erorr_message">' . $error . ' </div></br>';
    } ?>
  <button type="submit" class="w3-button w3-block w3-padding-large primary_color w3-margin-bottom">Connexion</button>
  </form>  
  </div>
    <center> <fb:login-button Class = "fb-login-button"
    data-max-rows = "1"
    data-size = "large"
    data-button-type = "continue_with" scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

 </center> 
   <center><a href="<?php echo site_url('Connexion/redirectionInscription'); ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Vous n'êtes pas encore inscrit?</br> Cliquez ici pour vous inscrire.</a></center> 
  <center><a href="<?php echo site_url('Connexion/redirectionMDP'); ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Mot de passe oublié ?</a></center> <!-- Mot de passe oublié -->



<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.

      testAPI();
    } 
  }
  function logout() {
            FB.logout(function(response) {
              // user is now logged out
            });
}
  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }


  
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '229513594287010', // Numéro d'app à modifier 
      cookie     : true,  // autorise les cookies
      xfbml      : true,  // autorise les plug-in sociaux sur cette page
      version    : 'v2.12' 
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/fr_FR/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me',{fields :'name,email,id'}, function(response) {
    console.log(response);
    var id = response.email;
    document.cookie = "fbdata =" + response.name + "," + response.email + "," + response.id;
	document.cookie = name + '=; Max-Age=0'
    console.log(document.cookie);    

    window.location.href = "<?php echo site_url('Connexion/connexionFB/');?>";
    
	
    });
  }
  
  
  
</script>

  


 

<div id="status">
</div>

<!-- End page content -->
  </div>
</body>
</html>

