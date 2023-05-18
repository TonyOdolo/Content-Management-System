
<!-- Query to use select options to change post_status  -->
<?php 
if(isset($_POST['checkBoxArray'])){

foreach($_POST['checkBoxArray'] as $postValueId){
    $bulk_options = $_POST['bulk_options'];

switch($bulk_options){
// To change post status to published
case 'published':
$query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
$update_to_published_status = mysqli_query($connection, $query);
confirmQuery($update_to_published_status);
break;




//  To change post status to draft
case 'draft':
$query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
$update_to_draft_status = mysqli_query($connection, $query);
confirmQuery($update_to_draft_status);
break;



//  To delete post
case 'delete':
$query = "DELETE * FROM posts  WHERE post_id = {$postValueId} ";
$delete_post_query = mysqli_query($connection, $query);
confirmQuery($delete_post_query);
break;


//  To clone post
case 'clone':
$query = "SELECT * FROM posts  WHERE post_id = {$postValueId} ";
$clone_post_query = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($clone_post_query)){
$post_author = $row['post_author'];
$post_title = $row['post_title'];
$post_category_id = $row['post_category_id'];
$post_status = $row['post_status'];
$post_image = $row['post_image'];
$post_content = $row['post_content'];
$post_tags = $row['post_tags'];
$post_date = $row['post_date'];

// query to copy into the database
$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,post_content,post_tags,post_status) ";            
$query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";
$copy_post_query = mysqli_query($connection, $query);
confirmQuery($copy_post_query);


}
confirmQuery($clone_post_query);
break;


}
}

}

?>



<form action= "" method = 'post'>
<table class="table table-bordered table-hover">

<div id = "bulkOptionsContainer" class = "col-xs-4">
<select class = "form-control" name= "bulk_options" id="">
    <option value = "">Select Options</option>
    <option value = "published">Publish</option>
    <option value = "draft">Draft</option>
    <option value = "delete">Delete</option>
    <option value = "clone">Clone</option>
</select>
</div>
<div class="col-xs-4">
    <input type="submit" name="submit" class= "btn btn-success" value = "Apply"> 
    <a class= "btn btn-primary" href = "posts.php?source=add_post"> Add New </a>
</div>
                        <thead>
                            <tr>
                                <th><input id ="selectAllBoxes" type = "checkbox"></th> 
                                <th>Id</th>u
                                <th>User</th>
                                <th>Post Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Tags</th>
                                <th>Comments</th>
                                <th>Date</th>
                                <th>Post Views Count</th>
                                <th>View Post</th>
                                <th>Edit</th>
                                <th>Delete</th>
                               
                            </tr>
                        </thead>
                        <tbody>


<?php

$query = "SELECT * FROM posts  ORDER BY post_id DESC";
$select_posts_query = mysqli_query($connection,$query);

while ($row = mysqli_fetch_assoc($select_posts_query)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count']; 
    $post_date = $row['post_date'];
    $post_views_count = $row['post_views_count'];


   
    echo "<tr>";
    ?>


    <td><input class ='checkBoxes' type = 'checkbox' name='checkBoxArray[]' value='<?php   echo $post_id;  ?>'></td>;


    <?php
    echo "<td> $post_id</td>";


if(!empty($post_author)){
    echo "<td>{$post_author}</td>";
}elseif(!empty($post_user)){
    echo "<td>{$post_user}</td>";

}

    




    echo "<td>{$post_title}</td>";

    $query = "SELECT * FROM categories where cat_id = {$post_category_id }";
    $select_categories_by_id = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_categories_by_id)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<td>{$cat_title}</td>";
    }


    echo "<td>{$post_status}</td>";
    echo "<td><img width  = '100' src = '../images/$post_image' alt=''image></td>";
    echo "<td>{$post_tags}</td>";


    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
    $query = mysqli_query($connection, $query);

    $row = mysqli_fetch_array($query);
  
    $comment_count = mysqli_num_rows($query);
    echo "<td><a href= 'post_comments.php?id={$post_id}' >{$comment_count}</a></td>";



    echo "<td>{$post_date}</td>";
    echo "<td><a href= 'posts.php?reset={$post_id}' >{$post_views_count}</a></td>";
    echo "<td><a href = '../post.php?p_id={$post_id}'>View Post</a></td>";
    echo "<td><a href = 'posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
    echo "<td><a onClick = \" javascript: return confirm('Are you sure you want to delete?');\"   href = 'posts.php?delete={$post_id}'>Delete</a></td>";
    echo "</tr>";
}
?>
                        
                    </tbody>
                    </table>

</form>



  <!--  To delete a post-->
<?php
if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE post_id = {$post_id} ";
    $delete_query = mysqli_query($connection, $query);
    header("Locations: posts.php");
}
?>


  <!--  To reset post view count-->
  <?php
if (isset($_GET['reset'])) {
    $post_id = escape($_GET['reset']);
    $query = "UPDATE posts SET post_views_count =0 WHERE post_id = " .mysqli_real_escape_string($connection, $_GET['reset'])." ";
    $reset_query = mysqli_query($connection, $query);
    header("Locations: posts.php");
}
?>


