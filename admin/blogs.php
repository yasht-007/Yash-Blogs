<?php

   session_start();
   include "includes/auth-login.php";
   include "includes/unset-sessions.php";
   require "includes/connection.php";
   
   $sqlBlogs = "SELECT * FROM blog_post WHERE f_post_status != '2'";
   $queryBlogs = mysqli_query($conn, $sqlBlogs);
   $numBlogs = mysqli_num_rows($queryBlogs);
   ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Admin Panel : Blogs</title>
      <!-- Bootstrap Styles-->
      <link href="assets/css/bootstrap.css" rel="stylesheet" />
      <!-- FontAwesome Styles-->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- Custom Styles-->
      <link href="assets/css/custom-styles.css" rel="stylesheet" />
      <!-- Google Fonts-->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   </head>
   <body>
      <div id="wrapper">
         <?php include "header.php";
            include "sidebar.php"; ?>
         <div id="page-wrapper">
            <div id="page-inner">
               <div class="row">
                  <div class="col-md-12">
                     <h1 class="page-header">
                        Blog Posts
                     </h1>
                  </div>
               </div>
               <?php
                  if (isset($_REQUEST['addblog'])) {
                      if ($_REQUEST['addblog'] == "success") {
                          echo "<div class='alert alert-success'><strong>Success! </strong> Blog added.</div>";
                      }
                  }
                  
                  if (isset($_REQUEST['updateblog'])) {
                      if ($_REQUEST['updateblog'] == "success") {
                          echo "<div class='alert alert-success'><strong>Success! </strong> Blog updated.</div>";
                      }
                  }
                  
                  if (isset($_REQUEST['deleteblogpost'])) {
                      if ($_REQUEST['deleteblogpost'] == "success") {
                          echo "<div class='alert alert-success'><strong>Success! </strong> Blog post deleted.</div>";
                      } else if ($_REQUEST['deleteblogpost'] == "error") {
                  
                          echo "<div class='alert alert-success'><strong>Success! </strong> Blog post was not deleted due to unexpected error.</div>";
                      }
                  }
                  
                  ?>
               <!-- /. ROW  -->
               <div class="row">
                  <div class="col-lg-12">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           All Blogs
                        </div>
                        <div class="panel-body">
                           <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover">
                                 <thead>
                                    <tr>
                                       <th>Id</th>
                                       <th>Name</th>
                                       <th>Category</th>
                                       <th>Views</th>
                                       <th>Blog Path</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $counter = 0;
                                       while ($rowBlogs = mysqli_fetch_assoc($queryBlogs)) {
                                           $counter++;
                                           $id = $rowBlogs['n_blog_post_id'];
                                           $name = $rowBlogs['v_post_title'];
                                           $cId = $rowBlogs['n_category_id'];
                                           $views = $rowBlogs['n_blog_post_views'];
                                           $blogPath = $rowBlogs['v_post_path'];
                                       
                                           $sqlGetCategoryName = "SELECT v_category_title FROM blog_category WHERE n_category_id = $cId";
                                           $queryGetCategories = mysqli_query($conn, $sqlGetCategoryName);
                                       
                                           if ($rowGetCAtegory = mysqli_fetch_assoc($queryGetCategories)) {
                                               $categoryName = $rowGetCAtegory['v_category_title'];
                                           }
                                       
                                       ?>
                                    <tr>
                                       <td><?php echo $counter; ?></td>
                                       <td><?php echo $name; ?></td>
                                       <td><?php echo $categoryName; ?></td>
                                       <td><?php echo $views; ?></td>
                                       <td><?php echo $blogPath; ?></td>
                                       <td>
                                          <button class="popup-button"
                                             onclick="window.open('../single-blog.php?blog=<?php echo $blogPath; ?>','_blank')">View</button>
                                          <button class="popup-button"
                                             onclick="location.href='edit-blog.php?blogid=<?php echo $id; ?>'">Edit</button>
                                          <button class="popup-button" data-toggle="modal"
                                             data-target="#delete<?php echo $id; ?>">Delete</button>
                                       </td>
                                    </tr>
                                    <div class="modal fade" id="delete<?php echo $id; ?>" tabindex="-1"
                                       role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                       <div class="modal-dialog">
                                          <div class="modal-content">
                                             <form method="POST" action="includes/delete-blog-post.php">
                                                <div class="modal-header">
                                                   <button type="button" class="close" data-dismiss="modal"
                                                      aria-hidden="true">&times;</button>
                                                   <h4 class="modal-title" id="myModalLabel">Delete Blop
                                                      Post
                                                   </h4>
                                                </div>
                                                <div class="modal-body">
                                                   <input type="hidden" name="blog-post-id"
                                                      value="<?php echo $id; ?>">
                                                   <p>Are you sure that you want to delete this blog post?
                                                   </p>
                                                </div>
                                                <div class="modal-footer">
                                                   <button type="button" class="btn btn-default"
                                                      data-dismiss="modal">Close</button>
                                                   <button type="submit" name="delete-blog-post-btn"
                                                      class="btn btn-primary">Delete</button>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- /.col-lg-12 -->
               </div>
            </div>
            <!-- /. ROW  -->
         </div>
         <!-- /. PAGE INNER  -->
      </div>
      <!-- /. PAGE WRAPPER  -->
      </div>
      <!-- /. WRAPPER  -->
      <!-- JS Scripts-->
      <!-- jQuery Js -->
      <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
      <script src="assets/js/bootstrap.min.js"></script>
      <!-- Metis Menu Js -->
      <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
      <script src="assets/js/custom-scripts.js"></script>
   </body>
</html>