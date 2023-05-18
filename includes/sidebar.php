<div class="col-md-4">
  
                <!-- Blog Search Well -->
                <div class="well">
                <h4>Blog Search</h4>
                <form action="search.php" method="post">
                <div class="input-group">
                <input name="search" type="text" class= "form-control">
                <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>
                </div>
                </form>
                </div>




                   <!-- Login Page -->
                   <div class="well">
                <h4>LOGIN</h4>
                <form action="includes/login.php" method="post">
                <div class="form-group">
                <input name="username" type="text" class= "form-control" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                <input name="password" type="password" class= "form-control" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                <input class="btn btn-primary" type="submit" name="login" value="Submit">
                </div>
                


                </form>
                </div>









                <!-- Blog Categories Well -->
                <div class="well">
                <?php
                if (isset($_POST['submit'])) {
                $search = $_POST['search'];

                $query = "SELECT * FROM posts WHERE post_tags LIKE '% $search%' ";
                $search_query = mysqli_query($connection, $query);

                if(!$search_query){
                die("Query Failed" .mysqli_error($connection));
                }
                }
                ?>



                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                
                                

                <?php

                $query = "SELECT * FROM categories";
                $select_categories_sidebar = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_categories_sidebar )) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                echo "<li><a href='category.php?category= $cat_id'>{$cat_title}</a></li>";
                }


                ?>

                            </ul>
                        </div>

                </div>

                <!-- Side Widget Well -->
                <?php
                include "widget.php";
                ?>
            </div>

        </div>