<?php

session_start();
include "includes/auth-login.php";
require "includes/connection.php";

session_start();
if (isset($_REQUEST['blogid'])) {
    $blogid = $_REQUEST['blogid'];
    if (empty($blogid)) {
        header("Location: blogs.php");
        exit();
    }

    $_SESSION['editBlogId'] = $_REQUEST['blogid'];
    $sqlGetBlogDetails = "SELECT * FROM blog_post WHERE n_blog_post_id = '$blogid'";
    $queryGetBlogDetails = mysqli_query($conn, $sqlGetBlogDetails);

    if ($rowGetBlogDetails = mysqli_fetch_assoc($queryGetBlogDetails)) {
        $_SESSION['editTitle'] = $rowGetBlogDetails['v_post_title'];
        $_SESSION['editMetaTitle'] = $rowGetBlogDetails['v_post_meta_title'];
        $_SESSION['editCategoryId'] = $rowGetBlogDetails['n_category_id'];
        $_SESSION['editSummary'] = $rowGetBlogDetails['v_post_summary'];
        $_SESSION['editContent'] = $rowGetBlogDetails['v_post_content'];
        $_SESSION['editPath'] = $rowGetBlogDetails['v_post_path'];
        $_SESSION['editHomePagePlacement'] = $rowGetBlogDetails['n_home_page_placement'];
    } else {
        header("Location: blogs.php");
        exit();
    }

    $sqlGetBlogTags = "SELECT * FROM blog_tags WHERE n_blog_post_id = $blogid";
    $queryGetBLogTags = mysqli_query($conn, $sqlGetBlogTags);
    if ($rowGetBlogTags = mysqli_fetch_assoc($queryGetBLogTags)) {
        $_SESSION['editTags'] = $rowGetBlogTags['v_tag'];
    }
} else if ($_SESSION['editBlogId']) {
} else {
    header("Location: blogs.php");
    exit();
}

$sqlGetImages = "SELECT * FROM blog_post WHERE n_blog_post_id = '" . $_SESSION['editBlogId'] . "'";
$queryGetImages = mysqli_query($conn, $sqlGetImages);
if ($rowGetImages = mysqli_fetch_assoc($queryGetImages)) {
    $mainImageUrl = $rowGetImages['v_main_image_url'];
    $altImageUrl = $rowGetImages['v_alternate_image_url'];
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel : Write A Blog</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- summernote  -->
    <link href='summernote/summernote.min.css' rel='stylesheet' type='text/css' />

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
                            Edit Blog Post
                        </h1>
                    </div>
                </div>

                <?php

                if (isset($_REQUEST['updateblog'])) {
                    if ($_REQUEST['updateblog'] == "emptytitle") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog title.</div>";
                    } else if ($_REQUEST['updateblog'] == "emptycategory") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog category.</div>";
                    } else if ($_REQUEST['updateblog'] == "emptysummary") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog summary.</div>";
                    } else if ($_REQUEST['updateblog'] == "emptycontent") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog content.</div>";
                    } else if ($_REQUEST['updateblog'] == "emptytags") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog tags.</div>";
                    } else if ($_REQUEST['updateblog'] == "emptypath") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog path.</div>";
                    } else if ($_REQUEST['updateblog'] == "sqlerror") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please try again.</div>";
                    } else if ($_REQUEST['updateblog'] == "pathcontainsspaces") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please do not add any spaces in a blog.</div>";
                    } else if ($_REQUEST['updateblog'] == "emptymainimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please Upload a main image.</div>";
                    } else if ($_REQUEST['updateblog'] == "emptyaltimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please Upload alternate image.</div>";
                    } else if ($_REQUEST['updateblog'] == "mainimageerror") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please Upload another main image.</div>";
                    } else if ($_REQUEST['updateblog'] == "altimageerror") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please Upload another alternate image.</div>";
                    } else if ($_REQUEST['updateblog'] == "invalidtypemainimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Main image upload only -> jpg,jpeg,bmp,gif,png images only.</div>";
                    } else if ($_REQUEST['updateblog'] == "invalidtypealtimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Alternate image upload only -> jpg,jpeg,bmp,gif,png images only.</div>";
                    } else if ($_REQUEST['updateblog'] == "erroruploadingmainimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> There was an error while uploading. Please try again later. </div>";
                    } else if ($_REQUEST['updateblog'] == "erroruploadingaltimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> There was an error while uploading. Please try again later. </div>";
                    } else if ($_REQUEST['updateblog'] == "titlebeingused") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Title is being used in another title. Please try another title.</div>";
                    } else if ($_REQUEST['updateblog'] == "pathbeingused") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> This Blog Path is being used in another path. Please try another blog path.</div>";
                    } else if ($_REQUEST['updateblog'] == "homepageplacementerror") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> An unexpected error occured while trying to set the home page placement. Please try agian.</div>";
                    }
                }
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Edit: <?php echo $_SESSION['editTitle']; ?>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="includes/update-blog.php" enctype="multipart/form-data">
                                            <input type="hidden" name="blog-id" value="<?php echo $blogid; ?>">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="blog-title" value="<?php
                                                                                                        echo $_SESSION['editTitle'];
                                                                                                        ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input class="form-control" name="blog-meta-title" value="<?php
                                                                                                            echo $_SESSION['editMetaTitle'];
                                                                                                            ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Category</label>
                                                <select class="form-control" name="blog-category">
                                                    <option value="">Select a Category</option>
                                                    <?php

                                                    $sqlCategories = "SELECT * FROM blog_category;";
                                                    $queryCategories = mysqli_query($conn, $sqlCategories);

                                                    while ($rowCategories = mysqli_fetch_assoc($queryCategories)) {

                                                        $cId = $rowCategories['n_category_id'];
                                                        $cName = $rowCategories['v_category_title'];


                                                        if (S_SESSION['editCategoryId'] == $cId) {
                                                            echo "<option value='" . $cId . "' selected=''>" . $cName . "</option>";
                                                        } else {
                                                            echo "<option value='" . $cId . "'>" . $cName . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Update Main Image</label>
                                                <input type="file" name="main-blog-image" id="main-blog-image">
                                                <?php
                                                if (!empty($mainImageUrl)) {
                                                    echo "<p style='font-size:inherit;'><a href='' data-toggle='modal' data-target='#main-image' class='popup-button' style='margin-top:10px;'>View Existing Image</a></p>";
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Update Alternate Image</label>
                                                <input type="file" id="alt-blog-image" name="alt-blog-image">
                                                <?php
                                                if (!empty($altImageUrl)) {
                                                    echo "<p style='font-size:inherit;'><a href='' data-toggle='modal' data-target='#alt-image' class='popup-button' style='margin-top:10px;'>View Existing Image</a></p>";
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Summary</label>
                                                <textarea name="blog-summary" class="form-control" rows="3"><?php
                                                                                                            echo $_SESSION['editSummary'];
                                                                                                            ?>
                                                                                                            </textarea>
                                            </div>
                                            <div class="form-gsroup">
                                                <label>Blog Content</label>
                                                <textarea class="form-control" id="summernote" rows="4" name="blog-content"><?php
                                                                                                                            echo $_SESSION['editContent'];
                                                                                                                            ?>
                                                                                                            </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Tags(Speperated by comma)</label>
                                                <input class="form-control" name="blog-tags" value="<?php
                                                                                                    echo $_SESSION['editTags'];
                                                                                                    ?>">
                                            </div>
                                            <div class="form-group input-group">
                                                <label>Blog Path</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">www.yashtiwari.com</span>
                                                    <input type="text" class="form-control" name="blog-path" value="<?php
                                                                                                                    echo $_SESSION['editPath'];
                                                                                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Home Page Placement: </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline1" value="1" <?php if (isset($_SESSION['editHomePagePlacement'])) {
                                                                                                                                                if ($_SESSION['editHomePagePlacement'] == 1) {
                                                                                                                                                    echo "checked=''";
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            ?>>1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline2" value="2" <?php if (isset($_SESSION['editHomePagePlacement'])) {
                                                                                                                                                if ($_SESSION['editHomePagePlacement'] == 2) {
                                                                                                                                                    echo "checked=''";
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            ?>>2
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline3" value="3" <?php if (isset($_SESSION['editHomePagePlacement'])) {
                                                                                                                                                if ($_SESSION['editHomePagePlacement'] == 3) {
                                                                                                                                                    echo "checked=''";
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            ?>>3
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-default" name="submit-edit-blog">Save Changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->

                            <?php
                            if (!empty($mainImageUrl)) {

                            ?>
                                <div class="modal fade" id="main-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Main Image</h4>
                                            </div>
                                            <div class="modal-body">
                                                <img src="<?php echo $mainImageUrl; ?>" style="max-width:100%; height:auto;" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <?php
                            if (!empty($altImageUrl)) {

                            ?>
                                <div class="modal fade" id="alt-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Alt Image</h4>
                                            </div>
                                            <div class="modal-body">
                                                <img src="<?php echo $altImageUrl; ?>" style="max-width:100%; height:auto;" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    <!-- Summernote Js -->
    <script src="summernote/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                minHeight: null,
                maxHeight: null,
                focus: false
            });
        });
    </script>

</body>

</html>