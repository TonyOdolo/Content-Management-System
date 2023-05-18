<?php
 include "Includes/admin_header.php"; 
 ?>
<!-- use session to get the user from the database -->
 <?php 
 if(isset($_SESSION['username'])){
     $username = $_SESSION['username'];

    //  query to bring the users field on the front from the back(database)

     $query = " SELECT * FROM users where username  = '{$username}'";
     $select_users_profile_query = mysqli_query($connection, $query);
     while ($row = mysqli_fetch_assoc($select_users_profile_query)){
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_password = $row['user_password'];
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost', 10));
     }

    //  Now lets do the update
    if(isset($_POST['update_profile'])){
        $username = $_POST['username'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        
        $user_password = $_POST['user_password'];

        $query = "UPDATE users SET ";
        $query .= "username  = '{$username}', ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        
        $query .= "user_email   = '{$user_email}', ";
        $query .= "user_password   = '{$user_password}'";
        $query .= "WHERE username ='{$username}' ";
        $update_user_profile_query = mysqli_query($connection, $query);

    }


 }
 
 ?>









    <div id="wrapper">

        <!-- Navigation -->

        <?php
         include "Includes/admin_navigation.php";
          ?>   

            <!-- /.navbar-collapse -->
        

       <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">


                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION['username'] ?></small>
                        </h1>

<!-- To validate -->
                        <?php
function checkEmptyFields($fields) {
    $emptyFields = [];

    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            $emptyFields[] = $field;
        }
    }

    if (!empty($emptyFields)) {
        echo "<h3>Fields cannot be empty</h3>" ;
    }
}

$fieldsToCheck = ['user_firstname', 'user_lastname', 'username', 'user_email'];
checkEmptyFields($fieldsToCheck);
?>


<form action="" method="post" enctype="multipart/form-data">    


<div class="form-group">
<label for="user_firstname">Firstname</label>
<input value = "<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname">
</div>


<div class="form-group">
<label for="user_lastname">Lastname</label>
<input value = "<?php echo $user_lastname; ?>" type="text" class = "form-control" name="user_lastname">
</div>

<div class="form-group">
<label for="username">Username</label>
<input value = "<?php echo $username; ?>" type="text" class="form-control" name="username">
</div>

<div class="form-group">
<label for="user_email">Email</label>
<input value = "<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">

</div>
<div class="form-group">
<label for="user_password">Password</label>
<input autocomplete= "off" type="passwword" class="form-control" name="user_password">

</div>



<div class="form-group">
<input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
</div>
</form>
                    
                    
               
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php 
        include "Includes/admin_footer.php";
         ?>  
    
    







