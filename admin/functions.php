<?php
//to redirect to  a page
function redirect($location){
    global $connection;

     header("Location: $location ");
    exit;        
}
?>

<?php 
function ifItIsmethod($method= null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}
?>

<?php
function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}
?>

<?php
function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }


}


?>





<?php
function confirmQuery($result)
{
    global $connection;
    if (!$result) {
        die("Query Failed." . mysqli_error($connection));
    }
}
?>





<?php
//function to insert the categories into the database  using prepared statement
function insert_categories(){
    global $connection;

    if(isset($_POST['submit'])){
    $cat_title = $_POST['cat_title'];
    $user_id = $_SESSION['user_id'];
    
    $statement = mysqli_prepare($connection,"INSERT INTO categories(cat_title, user_id) VALUES (?, ?)" );
    mysqli_stmt_bind_param($statement, "si", $cat_title , $user_id);
    mysqli_stmt_execute($statement);


    if(!$statement){
        die('Query Failed' .mysqli_stmt_error($statement));

    }
    }
}






// find all categories
function findAllcategories(){
    global $connection;
    $query = "SELECT * FROM categories";
$select_categories_query = mysqli_query($connection,$query);

while($row = mysqli_fetch_assoc($select_categories_query )) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

echo "<tr>";
echo "<td>{$cat_id}</td>";
echo "<td>{$cat_title}</td>";
echo "<td><a  onClick = \" javascript: return confirm('Are you sure you want to delete?');\"   href = 'admin_category.php?Delete={$cat_id}'>Delete</a></td>";
echo "<td><a href = 'admin_category.php?Edit={$cat_id}'>Edit</a></td>";
echo "</tr>";

}

}


// Delete Query
function delete_categories(){
    global $connection;

    if(isset($_GET['Delete'])){

        $the_cat_id=$_GET['Delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
        $delete_query = mysqli_query($connection,$query);
        header("Locations: admin_category.php");
    
    
    
    
    }
}


?>
<?php

// Users online
function users_online(){
    // instant count using ajax(instant loader)
    if (isset($_GET['usersonline'])) {


        global $connection;
        if(!$connection){
            session_start();
            include("../includes/db.php");


            $session = session_id();
            $time = time();
            $time_out_in_seconds = 3000;
            $time_out = $time - $time_out_in_seconds;
    
    
            // To count the users online
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $query = mysqli_query($connection, $query);
            $count_users_online_query = mysqli_num_rows($query);
    
            // logic
            if ($count_users_online_query == null) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    
            }
            // Query to display the users online
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $number_of_users_online = mysqli_num_rows($users_online_query);
        }   

    }    //get isset request


}
users_online();
?>


<?php  

//To escape ...more security features 
function escape($string){
    global $connection;


    return mysqli_real_escape_string($connection, trim($string));
}


?>

<?php 
//function to refactor he admin index (recordcount of the different tables in the system) in the dashboard
function recordcount($table){
    global $connection;
    $query = "SELECT * FROM .$table";
    $query = mysqli_query($connection, $query);
    return $recordcount = mysqli_num_rows($query);

}
?>


<?php 
// function to check status then return the record count then display in the graph
function checkStatus($table, $column , $status){
    global $connection;
$query = "SELECT * FROM $table WHERE $column = '$status'";
$query = mysqli_query($connection, $query);
return $count = mysqli_num_rows($query);

}
?>








<?php
// new registration system
// check whether a user is an admin or not
//check for the logged in status
function is_Admin(){

if(isLoggedIn()){
            $result = query("SELECT user_role FROM  users WHERE user_id =".$_SESSION['user_id']."");
            $row = fetchRecords($result);
            if($row['user_role'] == 'Admin'){
            return true;
            }else {
            return false;
        }
 }
    return false;

}
?>



<?php 
//to get the username displayed
function getUsername(){
    return isset($_SESSION['username']) ? strtoupper($_SESSION['username']) : null;
}
?>




<?php
//database helper function to fetch records from the database
function fetchRecords($result){
    return mysqli_fetch_assoc($result);

}


//count records helper function
function countRecords($result){
    return mysqli_num_rows($result);
}



?>












<?php
//check if a username exists
function username_exists($username){
        global $connection;
        $query = "SELECT username FROM  users WHERE username = '$username'";
        $check_username = mysqli_query($connection , $query);
        confirmQuery($check_username);

        if(mysqli_num_rows($check_username) > 0){
        return true; 

        }else {
        return false;
        }
}
?>



<?php

// Check if an email exists
function email_exists($email) {
    global $connection;

    // Prepare the statement
    $statement = mysqli_prepare($connection, "SELECT user_email FROM users WHERE user_email = ?");

    // Bind the parameter
    mysqli_stmt_bind_param($statement, "s", $email);

    // Execute the statement
    mysqli_stmt_execute($statement);

    // Store the result
    mysqli_stmt_store_result($statement);

    // Check the number of rows

    // Return true if email exists, false otherwise
    if (mysqli_stmt_num_rows($statement) > 0) {
        return true;
    } else {
        return false;
    }
    
}

?>



<?php
//function to  register a user
function register_user($username,$email,$password){
    global $connection;
            // prevent sql injection
            $username = mysqli_real_escape_string($connection, $username);
            $email = mysqli_real_escape_string($connection, $email);
            $password = mysqli_real_escape_string($connection, $password);

            // To encrypt passwords
            $password = password_hash($password, PASSWORD_BCRYPT, array('cost', 10));

            // query to insert into the database
            $query = "INSERT IGNORE INTO users(username, user_email, user_password, user_role)";
            $query .= "VALUES('{$username}', '{$email}', '{$password}', 'Subscriber')";
            $register_user_query = mysqli_query($connection, $query);
            confirmQuery($register_user_query);

        }
?>




<?php 
//function to  login a user
function login_user($username, $password){

     global $connection;
// require 'vendor/autoload.php';
// require './classes/Config.php';


     $username = trim($username);
     $password = trim($password);
     $username = mysqli_real_escape_string($connection, $username);
     $password = mysqli_real_escape_string($connection, $password);
     $query = "SELECT * FROM users WHERE username = '{$username}' ";


    //  if (isset($_GET['code'])) {
    //     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    //     $client->setAccessToken($token['access_token']);

    //     //query to insert the google user_id (access token) to the database
    //     $result = mysqli_query($connection, "insert into users(google_id) values ('{$token}')");
    //     confirmQuery($result)
    
        // //getting the profile information
        // $google_oauth = new Google_Service_Oauth2($client);
        // $google_account_info = $google_oauth->userinfo->get();
    
        // $userinfo = [
        // 'email' => $google_account_info['email'],
        // 'user_firstname' => $google_account_info['givenName'],
        // 'user_lastname' => $google_account_info['familyName'],
        // 'gender' => $google_account_info['gender'],
        // 'full_name' => $google_account_info['name'],
        // 'picture' => $google_account_info['picture'],
        // 'verified_email' => $google_account_info['verifiedEmail'],
        // 'token' => $google_account_info['id'],
        // ];

        // Process the Google login
// Verify the Google ID token and retrieve user information
// Example using Google API client library:

// $payload = $client->verifyIdToken($google_id_token);

// if ($payload) {
//     $google_user_id = $payload['sub'];
//     $google_email = $payload['email'];
    
//     // Perform necessary checks and processing for Google login
//     // Example:
//     // Check if the user with the given Google user ID exists in the database
//     $query = "SELECT * FROM google_users WHERE google_user_id = '{$google_user_id}'";
//     $select_user_query = mysqli_query($connection, $query);
    
//     if (!$select_user_query) {
//         die("QUERY FAILED" . mysqli_error($connection));
//     }
    
//     if (mysqli_num_rows($select_user_query) > 0) {
//         // User exists, log in the user
//         $_SESSION['user_id'] = $google_user_id;
//         $_SESSION['email'] = $google_email;
        
//         redirect("/blogsystem/admin");
//     } else {
//         // User does not exist, create a new user account
//         $query = "INSERT INTO google_users (google_user_id, email) VALUES ('{$google_user_id}', '{$google_email}')";
//         $insert_user_query = mysqli_query($connection, $query);
        
//         if (!$insert_user_query) {
//             die("QUERY FAILED" . mysqli_error($connection));
//         }
        
//         // Log in the new user
//         $_SESSION['user_id'] = $google_user_id;
//         $_SESSION['email'] = $google_email;
        
//         redirect("/blogsystem/admin");
//     }
// } else {
//     // Invalid Google ID token, handle error condition
//     // Example:
//     echo "Invalid Google ID token. Login failed.";
// }

//     }


     $select_user_query = mysqli_query($connection, $query);
     if (!$select_user_query) {

         die("QUERY FAILED" . mysqli_error($connection));

     }
     while ($row = mysqli_fetch_array($select_user_query)) {

         $db_user_id = $row['user_id'];
         $db_username = $row['username'];
         $db_user_password = $row['user_password'];
         $db_user_firstname = $row['user_firstname'];
         $db_user_lastname = $row['user_lastname'];
         $db_user_role = $row['user_role'];


         if (password_verify($password,$db_user_password)) {

             $_SESSION['user_id'] = $db_user_id;
             $_SESSION['username'] = $db_username;
             $_SESSION['firstname'] = $db_user_firstname;
             $_SESSION['lastname'] = $db_user_lastname;
             $_SESSION['user_role'] = $db_user_role;
            
             redirect("/blogsystem/admin");

         } else {
             return false;
         }
     }

     return true;
 }

 
?>

<?php 
// The current user
function currentUser(){
   
    if(isset($_SESSION['username'])){
        return $_SESSION['username'];
    }
    return false;
}

?>

<?php
function imagePlaceholder($image=''){

if(!$image){
        return 'php.jpg';
}else{
        return $image;
}

}
?>


<?php 
function loggedInUserId() {
    if (isLoggedIn()) {
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'");
        $user = mysqli_fetch_assoc($result);
        return mysqli_num_rows($result)>=1 ? $user['user_id']: false;
           
        }
    return false;
}

?>




<?php
function query($query){
    global $connection;
    $result=mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

?>




<?php 
//function to show user liked a post
function userLikedThisPost($post_id = ' ')
{
    $result = query("select * from likes where user_id=" . loggedInUserId() . " and post_id={$post_id}");
    return mysqli_num_rows($result) >= 1 ? true : false;

}
?>

<?php 
//fetch post likes frpm the database
function getPostlikes($post_id = ' '){
    $result = query("select * from likes where post_id={$post_id} ");
    echo mysqli_num_rows($result);
}
?>




<?php
//my Data functions
//User Specifics


function getAllUserPosts(){
    return  query("select * from posts where user_id=" . loggedInUserId() . " ");
}



function getAllPostUserComments(){
    return  query("select * from posts inner join comments on posts.post_id = comments.comment_post_id where user_id=" . loggedInUserId() . " ");
}


function getAllPostUserCategories(){
    return  query("select * from categories where user_id=" . loggedInUserId() . " ");
}

function getAllUserPublishedPosts(){
    return  query("select * from posts where user_id=" . loggedInUserId() . " and post_status= 'published' ");
}

function getAllUserDraftPosts(){
    return  query("select * from posts where user_id=" . loggedInUserId() . " and post_status= 'draft' ");
}

function getAllUserApprovedComments(){
    return  query("select * from posts inner join comments on posts.post_id = comments.comment_post_id where user_id=" . loggedInUserId() . " and comment_status= 'Approved' ");
}

function getAllUserUnapprovedComments(){
    return  query("select * from posts inner join comments on posts.post_id = comments.comment_post_id where user_id=" . loggedInUserId() . " and comment_status= 'Unapproved' ");
}









?>