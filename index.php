<?php

include"includes/db.php";
include"includes/header.php";
include"includes/navigation.php";

?>


    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">







<?php
// catching the get request

$per_page = 2;
if(isset($_GET['page'])){
    $page = $_GET['page'];
    

}else {
    $page = "";
}

if ($page == "" || $page == 1) {
    $page_1 = 0;
} else {
    $page_1 = ($page * $per_page) - $per_page;
}






// Not to show everything to Subscibers but everything to admin
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin') {
$query = "SELECT * FROM posts ";
} else {
    $query = "SELECT * FROM posts WHERE post_status = 'published'";

}
// Pagination
$query = mysqli_query($connection, $query);

$count_all_published_posts_query = mysqli_num_rows($query);

if($count_all_published_posts_query < 1){
echo "<h1 class= 'text-center'> No Posts Available";
}else {

$count_all_published_posts_query = ceil($count_all_published_posts_query / $per_page);










$query = "SELECT * FROM  posts  WHERE  post_status = 'published' LIMIT $page_1, $per_page";
$select_all_posts_query =mysqli_query($connection,$query);
    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_user = $row['post_user'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = substr($row['post_content'], 0, 400);
        $post_status = $row['post_status'];




        ?>
    <h1 class="page-header">

    <?php
if (isset($_SESSION['my_access_token_accessTo'])) {
    // Session variable is set
    echo "User is logged in.";
    // Perform actions for logged-in user
}
//  else {
//     // Session variable is not set
//     echo "User is not logged in.";
//     // Redirect to the login page or display a login form
// }
?>




        Blog
        <small>Posts</small>
    </h1>

    <!-- First Blog Post -->

     <h2>
        <a href="post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
    </h2>
    <p class="lead">
        by <a href="author_posts.php?author=<?php echo $post_user ?> & p_id = <?php echo $post_id; ?>"><?php echo $post_user; ?></a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
    <hr>
    <a href = "post.php?p_id=<?php echo $post_id; ?>">
    <img class="img-responsive" src="/blogsystem/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
    </a>
    <hr>
    <p><?php echo $post_content ?></p>
    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
    <hr>
 
    



<?php }  } ?>

 </div>



            <!-- Blog Sidebar Widgets Column -->
<?php
include"includes/sidebar.php";
?>
        <!-- /.row -->

        </div>

        <!-- Pagination -->
        <ul   class = "pager">
            <?php

            for ($i=1; $i <= $count_all_published_posts_query ; $i++) {
                if ($i == $page) {


                    echo "<li><a href= 'index.php?page={$i}'>{$i}</a>";


                }else{


                    echo "<li><a href= 'index.php?page={$i}'>{$i}</a>";

                }
            }
            ?>
        </ul>













<?php
include"includes/footer.php";
?>