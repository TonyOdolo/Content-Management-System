<?php
require_once 'vendor/autoload.php';
require './classes/google_config.php';


// Validate the ID token and extract user information
function validateIdToken($idToken) {
  $client = new Google_Client(['client_id' => '466262686595-45cjjaf5u6cp539jb4aa90kvk6o8vugq.apps.googleusercontent.com']);
  $payload = $client->verifyIdToken($idToken);

    print_r($idToken);
    die;

  if ($payload) {
    $userId = $payload['sub'];
    $email = $payload['email'];
    $firstname =  $payload['givenName'];
    // Process the user information as needed
    // For example, you can store the user's email in a session or database
    $_SESSION['user_email'] = $email;
    $_SESSION['user_firstname'] = $firstname;
  } else {
    echo "Invalid ID token. Authentication failed.";
  }
}

// Call the function with the ID token received from the client-side
validateIdToken($_POST['id_token']);


?>







 


<!-- // Access the credentials

$clientSecret = $googleCredentials->getClientSecret();
$redirectURI = $googleCredentials->getRedirectUri(); -->

  







































// //authenticate code from google OAuth Flow
// if (isset($_GET['code'])) {
//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//     $client->setAccessToken($token['access_token']);

//     //getting the profile information
//     $google_oauth = new Google_Service_Oauth2($client);
//     $google_account_info = $google_oauth->userinfo->get();

//     $userinfo = [
//         'email' => $google_account_info['email'],
//         'user_firstname' => $google_account_info['givenName'],
//         'user_lastname' => $google_account_info['familyName'],
//         'gender' => $google_account_info['gender'],
//         'full_name' => $google_account_info['name'],
//         'picture' => $google_account_info['picture'],
//         'verified_email' => $google_account_info['verifiedEmail'],
//         'token' => $google_account_info['id'],
//     ];
// }

//     //check if user already exists in the database
//     $query = "select * all from users where email ='{$userinfo['email']}'";
//     $result = mysqli_query($connection, $query);
// 	if (mysqli_num_rows($result) > 0) {
// 		//user exists
// 		while ($row = mysqli_fetch_assoc($result)) {

// 	}

    

// }







// if (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["email"])) {
//     // Store the received data in session variables
//     $_SESSION["google_id"] = $_POST["id"];
//     $_SESSION["username"] = $_POST["name"];
//     $_SESSION["user_email"] = $_POST["email"];

//     // Escape the email for security
//     $email = mysqli_real_escape_string($connection, $_POST["email"]);

//     // Check if the user already exists in the database
//     $sql = "SELECT * FROM users WHERE user_email='" . $email . "'";
//     $result = mysqli_query($connection, $sql);

//     if (mysqli_num_rows($result) > 0) {
//         // User exists, update the Google ID
//         $sql2 = "UPDATE users SET google_id='" . $_POST["id"] . "' WHERE user_email='" . $email . "'";
//     } else {
//         // User does not exist, insert the new user
//         $username = mysqli_real_escape_string($connection, $_POST["name"]);
//         $googleId = mysqli_real_escape_string($connection, $_POST["id"]);
//         $sql2 = "INSERT INTO users (username, user_email, google_id) VALUES ('" . $username . "', '" . $email . "', '" . $googleId . "')";
//     }

//     // Execute the query
//     if (mysqli_query($connection, $sql2)) {
//         echo "Updated Successful";
//     } else {
//         echo "Error: " . mysqli_error($connection);
//     }

// } else {
//     echo "Invalid request";
// }

// ? >


<!-- // <script type="text/javascript"> -->

// 	function onSignIn(googleUser) {

// 	  var profile = googleUser.getBasicProfile();



//       if(profile){

//           $.ajax({

//                 type: 'POST',
//                 url: 'login.php',
//                 data: {id:profile.getId(), name:profile.getName(), email:profile.getEmail()}

//             }).done(function(data){

//                 console.log(data);

//                 window.location.href = '/blogsystem/admin';

//             }).fail(function() { 

//                 alert( "Posting failed." );

//             });

//       }


    
//     }
<!-- // </script> -->
