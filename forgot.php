<?php use PHPMailer\PHPMailer\PHPMailer;  ?>


<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>




<?php

require './vendor/autoload.php';
require './classes/Config.php';



// security
if(!ifItIsMethod('get') && !isset($_GET['forgot'])){
    redirect('index');
}

//check for a post request so tht the email can be submitted
if(ifItIsMethod('post')){
    if(isset($_POST['email'])){
        $email = escape($_POST['email']);
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        //check if email exists
        if(email_exists($email)){
           $statement=  mysqli_prepare($connection, "UPDATE users SET token= '{$token}' WHERE user_email = ?");
           mysqli_stmt_bind_param($statement, "s" , $email);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);


            
            //CONFIGURE PHPMAILER
            $mail = new PHPMailer();
            

            //Server settings
            $mail->isSMTP();                                     
            $mail->Host       = Config::SMTP_HOST;                      
            $mail->Port       = Config::SMTP_PORT;                                 
            $mail->Username   = Config::SMTP_USER;                     
            $mail->Password   = Config::SMTP_PASSWORD;                               
            $mail->SMTPSecure = 'tls'; 
            $mail->SMTPAuth   = true;
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //receiptient
            $mail->setFrom('tonyodolo391@gmail.com', 'Tony Odolo');
            $mail->addAddress($email);
            $mail->Subject = 'This is a test Email';
            
            $mail->Body = '<p>Please click here to reset your password: <a href="http://localhost/blogsystem/reset.php?email=' . $email . '&token=' . $token . '">http://localhost/blogsystem/reset.php?email=' . $email . '&token=' . $token . '</a></p>';

            if($mail->send()){
                $emailsent = true;
            }else{
                echo "Email not sent";

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

                        <?php if(!isset($emailsent)): ?>


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                      
                                    </form>

                                </div><!-- Body-->
                                <?php else: ?>
                                <!-- display this if sent -->
                                   
                                <h2>Please check your email</h2>

                                <?php endif; ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

