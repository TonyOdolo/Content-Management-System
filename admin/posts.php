<?php
 include "Includes/admin_header.php"; 
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
                            <small><?php echo $_SESSION['username']?></small>
                        </h1>



                        <?php
                        if(isset($_GET['source'])){
                            $source = $_GET['source'];
                        }else {
                            $source = '';

                        }



                            switch($source){
                            case 'add_post';

                            include ("Includes/add_post.php");

                            break;

                            case 'edit_post';
                            include ("Includes/edit_post.php");
                            break;
                            

                            default:
                                include("Includes/view_all_posts.php");
                            break;
                        }
                        
                        
                        ?>

                    
                    
               
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
