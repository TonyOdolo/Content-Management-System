<?php
include "db.php";
?>

<?php session_start();  ?>


<?php
if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
} 
// To prevent sql injections
$username = mysqli_real_escape_string($connection, $username);
$password = mysqli_real_escape_string($connection, $password);
// query to bring out the users table fields
$query = " SELECT * FROM users where username = '$username'";
$select_user_query = mysqli_query($connection, $query);
while($row = mysqli_fetch_assoc($select_user_query)){
    $db_id = $row['user_id'];
    $db_username = $row['username'];
    $db_user_password = $row['user_password'];
    $db_firstname = $row['user_firstname'];
    $db_lastname = $row['user_lastname'];
    $db_email = $row['user_email'];
    $db_role = $row['user_role'];
}


// To verify the password
if( password_verify($password, $db_user_password) ){
    $_SESSION['username'] = $db_username;
    $_SESSION['user_firstname'] = $db_firstname;
    $_SESSION['user_lastname'] = $db_lastname;
    $_SESSION['user_role'] = $db_role;

    header("Location: ../admin/index.php ");
}else {
    header("Location: ../index.php ");

}

?>

