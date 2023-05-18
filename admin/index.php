<?php include "Includes/admin_header.php" ?>

    <div id="wrapper">
  

        <!-- Navigation -->

        <?php include "Includes/admin_navigation.php" ?>   

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

                        


                               
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
<!-- Query to count the total number of posts -->
<?php
$query = "SELECT * FROM posts";
$query = mysqli_query($connection, $query);
$posts_count_query = mysqli_num_rows($query);
echo " <div class='huge'>{$posts_count_query}</div>";
?>                  
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>




    <!-- comments widget -->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
<!-- Query to count the total number of comments -->
<?php
$query = "SELECT * FROM comments";
$query = mysqli_query($connection, $query);
$comments_count_query = mysqli_num_rows($query);
echo " <div class='huge'>{$comments_count_query}</div>";
?> 
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>




    <!-- users widget -->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                    <!-- Query to count the total number of users -->
<?php
$query = "SELECT * FROM users";
$query = mysqli_query($connection, $query);
$users_count_query = mysqli_num_rows($query);
echo " <div class='huge'>{$users_count_query}</div>";
?> 
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>


    <!-- categories widget -->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                    <!-- Query to count the total number of categories -->
<?php
$query = "SELECT * FROM categories";
$query = mysqli_query($connection, $query);
$categories_count_query = mysqli_num_rows($query);
echo " <div class='huge'>{$categories_count_query}</div>";
?>  
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="admin_category.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class = "row">




   <!-- Query to display published posts -->
<?php
$query = "SELECT * FROM posts WHERE post_status = 'published'";
$select_published_posts_query = mysqli_query($connection, $query);
$published_posts_count_query = mysqli_num_rows($select_published_posts_query);
?>    




    <!-- Query to display draft posts -->
<?php
$query = "SELECT * FROM posts WHERE post_status = 'draft'";
$select_draft_posts_query = mysqli_query($connection, $query);
$draft_posts_count_query = mysqli_num_rows($select_draft_posts_query);
?>


    <!-- Query to display draft posts -->
<?php
$query = "SELECT * FROM comments WHERE comment_status = 'Unapproved'";
$select_unapproved_comments_query = mysqli_query($connection, $query);
$Unapproved_comments_count_query = mysqli_num_rows($select_unapproved_comments_query);
?>


   <!-- Query to display Subscribers -->
<?php
$query = "SELECT * FROM users WHERE user_role = 'Subscriber'";
$select_subscribers_query = mysqli_query($connection, $query);
$Subscribers_count_query = mysqli_num_rows($select_subscribers_query);
?>












<!-- Dashboard chat -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data', 'Count'],
        //   to display the data dynamically
          <?php
          $element_text = ['All Posts',  'Published Posts' , 'Draft Posts','Comments', 'Unapproved Comments', 'Users','Subscribers','Categories'];
          $element_count = [$posts_count_query,$published_posts_count_query, $draft_posts_count_query,  $comments_count_query,  $Unapproved_comments_count_query, $users_count_query,  $Subscribers_count_query, $categories_count_query];

          for ($i = 0; $i < 8; $i++){
            echo "['{$element_text[$i]}', {$element_count[$i]}],";
          }
  
          ?>
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
        <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>


</div>






                <!-- /.row -->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "Includes/admin_footer.php" ?>   
