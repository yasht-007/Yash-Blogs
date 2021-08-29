<?php

session_start();
require "includes/connection.php";
include "includes/auth-login.php";
include "includes/unset-sessions.php";

$sqlCategories = "SELECT * FROM blog_category";
$queryCategories = mysqli_query($conn, $sqlCategories);
$numCategories = mysqli_num_rows($queryCategories);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel : Blog Category</title>
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
                            Blog Categories
                        </h1>
                    </div>
                </div>
                <?php

                if (isset($_REQUEST['addcategory'])) {

                    if ($_REQUEST['addcategory'] == "success") {
                        echo "<div class='alert alert-success'>
                        <strong>Success!</strong> Category added.
                        </div>";
                    } else if ($_REQUEST['addcategory'] == "error") {
                        echo "<div class='alert alert-danger'>
                        <strong>Error!</strong> Category was not added, there was an unexpected error.
                        </div>";
                    }
                } else if (isset($_REQUEST['edit-category'])) {

                    if ($_REQUEST['edit-category'] == "success") {
                        echo "<div class='alert alert-success'>
                        <strong>Success!</strong> Changes to Category were saved.
                        </div>";
                    } else if ($_REQUEST['edit-category'] == "error") {
                        echo "<div class='alert alert-danger'>
                        <strong>Error!</strong> Changes to Category were not saved.
                        </div>";
                    }
                } else if (isset($_REQUEST['delete-category'])) {

                    if ($_REQUEST['delete-category'] == "success") {
                        echo "<div class='alert alert-success'>
                        <strong>Success!</strong>Category deleted sucesfully.
                        </div>";
                    } else if ($_REQUEST['delete-category'] == "error") {
                        echo "<div class='alert alert-danger'>
                        <strong>Error!</strong> Error Category not deleted.
                        </div>";
                    }
                }


                ?>
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add A Category
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="includes/add-category.php">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input class="form-control" name="category-name">
                                            </div>

                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input class="form-control" name="category-meta-title">
                                            </div>

                                            <div class="form-group">
                                                <label>Category Path (lower case, no spaces)</label>
                                                <input class="form-control" name="category-path">
                                            </div>
                                            <button type="submit" name="add-category-btn" class="btn btn-default">Add Category</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                All Categories
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Meta Title</th>
                                                <th>Category Path</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $counter = 0;
                                            while ($rowCategories = mysqli_fetch_assoc($queryCategories)) {
                                                $counter++;
                                                $id = $rowCategories['n_category_id'];
                                                $name = $rowCategories['v_category_title'];
                                                $metaTitle = $rowCategories['v_category_meta_title'];
                                                $categoryPath = $rowCategories['v_category_path'];

                                            ?>
                                                <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td><?php echo $name; ?></td>
                                                    <td><?php echo $metaTitle; ?></td>
                                                    <td><?php echo $categoryPath; ?></td>
                                                    <td>
                                                        <button class="popup-button" onclick="window.open('../categories.php?group=<?php echo $categoryPath; ?>','_blank')">View</button>
                                                        <button data-toggle="modal" data-target="#edit<?php echo $id; ?>" class="popup-button">Edit</button>
                                                        <button data-toggle="modal" data-target="#delete<?php echo $id; ?>" class="popup-button">Delete</button>
                                                    </td>

                                                    <div class="modal fade" id="edit<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="POST" action="includes/edit-category.php">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="category-id" value="<?php echo $id; ?>">
                                                                        <div class="form-group">
                                                                            <label>Name</label>
                                                                            <input class="form-control" name="edit-category-name" value="<?php echo $name; ?>">

                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Meta Title</label>
                                                                            <input class="form-control" name="edit-category-meta-title" value="<?php echo $metaTitle; ?>">

                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>Category Path</label>
                                                                            <input class="form-control" name="edit-category-path" value="<?php echo $categoryPath; ?>">

                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="edit-category-btn" class="btn btn-primary">Save changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="delete<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="POST" action="includes/delete-category.php">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="category-id" value="<?php echo $id; ?>">
                                                                        <p>Are you sure that you want to delete this category?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="delete-category-btn" class="btn btn-primary">Delete</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </tr>
                                            <?php

                                            }
                                            ?>
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