<?php  
include "includes/db.php";
include "includes/header.php";
include "includes/navigation.php";

require './classes/google_config.php';


//check if a user is logged in
checkIfUserIsLoggedInAndRedirect('/blogsystem/admin');
	if(ifItIsMethod('post')){
		if(isset($_POST['username']) && isset($_POST['password'])){
			login_user($_POST['username'],$_POST['password']);
		} else {

		redirect('/blogsystem/login.php');
		
		}
	}
?>



<!-- Page Content -->
<div class="container">

	<div class="form-gap"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">


							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<div class="panel-body">


								<form id="login-form" role="form" autocomplete="off" class="form" method="post">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

											<input name="username" type="text" class="form-control" placeholder="Enter Username">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input name="password" type="password" class="form-control" placeholder="Enter Password">
										</div>
									</div>

									<div class="form-group">

										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>
									<div >
									<a href="/blogsystem/registration.php" >Create New Account</a>
									</div>
									<span>Or</span>
									<div>
									<center><p> Sign in with</p></center>
									</div>
									<div >
									<div >
									<center><div id="g-signin-button" class="g-signin2" data-width="300" data-height="30" data-longtitle="true"></div></center>
									</div>
									</div>
									
									



									<!-- Adding social media buttons -->
									<div class="form-group">
										
										<i class="fa fa-twitter" ></i>
										<i class="fa fa-facebook" ></i>
										

											<!-- < ?php
											echo "<a href= '" . $client->createAuthUrl() . "'><i class='fa fa-google' ></i></a>";  
											?> -->
										
										<i class="fa fa-linkedin" ></i>
										
										
										<?php 
											// Sign In with GitHub
											$accessToken = isset($_SESSION['my_access_token_accessToken']) ? $_SESSION['my_access_token_accessToken'] : '';
											// echo '<p>Acces Token:</p>';
											// echo '<br />';

											// echo '<p><code>' . $accessToken . '</code></p>';

											if (!empty($accessToken)) {
												//User is logged in
												echo "Logged in";
											} else {
												// User is not logged in
												echo '<a href="https://github.com/login/oauth/authorize?client_id=eaebb1f00991bd4ca8ba"><i class="fa fa-github"></i></a>';
											}
											
											?>

									</div>


								</form>

							</div><!-- Body-->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

	


	

	<hr>

	



	<?php include "includes/footer.php";?>

</div> <!-- /.container -->







<script>
window.onLoadCallback = function(){
  gapi.auth2.init({
      client_id: '<?=$googleCredentials->getClientId()?>',
    });
}



// promise that would be resolved when gapi would be loaded
var gapiPromise = (function(){
  var deferred = $.Deferred();
  window.onLoadCallback = function(){
    deferred.resolve(gapi);
  };
  return deferred.promise()
}());

var authInited = gapiPromise.then(function(){
  gapi.auth2.init({
      client_id: '<?=$googleCredentials->getClientId()?>',
    });
})


$('#g-signin2').click(function(){
  gapiPromise.then(function(){
    // will be executed after gapi is loaded
  });

  authInited.then(function(){
    // will be executed after gapi is loaded, and gapi.auth2.init was called
  });
});
</script>





<!-- <script>

// Initialize the Google Sign-In library
function init() {
    gapi.load('auth2', function() {

		alert("fkjdfhg kjf");
    return;
      gapi.auth2.init({
        client_id : '<?=$googleCredentials->getClientId()?>',
      });
    });
  }
  
  // Function to handle sign-in success
  function onSignIn(googleUser) {
    alert("fkjdfhg kjf");
    return;
    // Get the user's profile information
    var profile = googleUser.getBasicProfile();
  
    // Display the logged-in username
    var username = profile.getName();
    document.getElementById('username').textContent = 'Logged in as: ' + username;
    document.getElementById('username').style.display = 'block';
  }
  
  // Attach the event listener to the sign-in button
  document.addEventListener('DOMContentLoaded', function() {
    var signinButton = document.getElementById('g-signin-button');
    signinButton.addEventListener('click', function() {
      gapi.auth2.getAuthInstance().signIn().then(onSignIn);
    });
  });

 </script> -->


