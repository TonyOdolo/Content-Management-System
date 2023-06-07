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
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>





<table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Comments</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>In Response to(Post)</th>
                                <th>Date</th>
                                <th>Approve</th>
                                <th>Unapprove</th>
                                <th>Delete</th>
                                
                               
                            </tr>
                        </thead>
                        <tbody>


<?php
print_r($_GET['id']);

$query = "SELECT * FROM comments WHERE  comment_post_id =".mysqli_real_escape_string($connection, $_GET['id']). " ";
$select_comments_query = mysqli_query($connection,$query);

while ($row = mysqli_fetch_assoc($select_comments_query)) {
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_content = $row['comment_content'];
    $comment_email = $row['comment_email'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];

    echo "<tr>";
    echo "<td>$comment_id</td>";
    echo "<td>{$comment_author}</td>";
    echo "<td>{$comment_content}</td>";
    echo "<td>{$comment_email}</td>";
    echo "<td>{$comment_status}</td>";

    $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id} ";
    $select_comment_post_id_query = mysqli_query($connection,$query);  
    while($row = mysqli_fetch_assoc($select_comment_post_id_query)) {
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
        echo "<td><a href = '../post.php?p_id=$post_id'>{$post_title}</a></td>";
    }

    echo "<td>{$comment_date}</td>";
    echo "<td><a href = 'post_comments.php?Approve=$comment_id&id=". $_GET['id']."'>Approve</a></td>";
    echo "<td><a href = 'post_comments.php?Unapprove=$comment_id&id=". $_GET['id']."'>Unapprove</a></td>";
    echo "<td><a onClick = \" javascript: return confirm('Are you sure you want to delete?');\"  href='post_comments.php?delete=$comment_id&id =".$_GET['id']."'>Delete</a></td>";
    echo "</tr>";



}
?>    
                       
                    </tbody>
                    </table>

                    <!-- To delete a comment -->

<?php
if(isset($_GET['delete'])){
    $the_comment_id = $_GET['delete'];
    $query = "DELETE FROM comments WHERE comment_id =$the_comment_id";
    $delete_comments_query = mysqli_query($connection, $query);
    header("Location: post_comments.php?id =". $_GET['id']."");
}
?>

<!-- query to Unapprove comments -->

<?php
if(isset($_GET['Unapprove'])){
    $the_comment_id = $_GET['Unapprove'];
    $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id =$the_comment_id";
    $Unapprove_comments_query = mysqli_query($connection, $query);
    header("Location:post_comments.php?id=".$_GET['id']."");
}
?>

<!-- query to Approve comments -->

<?php
if(isset($_GET['Approve'])){
    $the_comment_id = $_GET['Approve'];
    $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id =$the_comment_id";
    $Approve_comments_query = mysqli_query($connection, $query);
    header("Location:post_comments.php?id=".$_GET['id']."");
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








