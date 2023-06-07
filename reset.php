<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php

//Getting the url
if(!isset($_GET['email']) && !isset($_GET['token'])){
    redirect('index');
}


//pull out data from the database to ensure its the same data from the same user

// $email = 'tonyodolo391@gmail.com';
// $token = '85db56da1b010f914783995b15ea3dccae48470e06b78416aec58cea76c9881f00b6cbf3bc65df18059567cfc3e8a19d2825';
if($statement = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token=?')){
    mysqli_stmt_bind_param($statement, "s", $_GET['token']);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $username, $user_email, $token);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    // if($_GET['TOKEN'] !== $TOKEN ||  $_GET['email'] !==$email){
    //     redirect('index');
    // }

    if(isset($_POST['password']) && isset($_POST['confirmpassword'])){
        if($_POST['password'] === $_POST['confirmpassword']){

            $password = $_POST['password'];
            $hashedPasseord = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
            if($statement = mysqli_prepare($connection, "UPDATE users SET token='',user_password='{$hashedPasseord}' WHERE user_email = ?")){
                mysqli_stmt_bind_param($statement, "s", $_GET['email']);
                mysqli_stmt_execute($statement);
                if(mysqli_stmt_affected_rows($statement)>=1){
                    redirect('/blogsystem/login');
                }

                mysqli_stmt_close($statement);
               
            }



        }
        
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

                                
                        <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class= "form-group">
                                    <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input id="password" name="password" placeholder="password" class="form-control"  type="password">
                                    </div>
                                    </div>

                                    <div class= "form-group">
                                    <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok-sign"></i></span>
                                                <input id="confirm-password" name="confirmpassword" placeholder="Confirm password" class="form-control"  type="password">
                                    </div>
                                    </div>

                                    <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">

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