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
//function to insert the categories into the database 
function insert_categories(){
    global $connection;

    if(isset($_POST['submit'])){
    $cat_title = $_POST['cat_title'];
    
    $query = "INSERT INTO categories(cat_title) VALUES ('{$cat_title}')";

    $create_category_query = mysqli_query($connection,$query);
    if(!$create_category_query){
        die('Query Failed' .mysqli_error($connection));

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