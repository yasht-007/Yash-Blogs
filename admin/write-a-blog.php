<?php

session_start();
require "includes/connection.php";
include "includes/auth-login.php";

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
                            Write A Blog
                        </h1>
                    </div>
                </div>

                <?php

                if (isset($_REQUEST['addblog'])) {
                    if ($_REQUEST['addblog'] == "emptytitle") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog title.</div>";
                    } elseif ($_REQUEST['addblog'] == "emptycategory") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog category.</div>";
                    } elseif ($_REQUEST['addblog'] == "emptysummary") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog summary.</div>";
                    } elseif ($_REQUEST['addblog'] == "emptycontent") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog content.</div>";
                    } elseif ($_REQUEST['addblog'] == "emptytags") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog tags.</div>";
                    } elseif ($_REQUEST['addblog'] == "emptypath") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please add a blog path.</div>";
                    } elseif ($_REQUEST['addblog'] == "sqlerror") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please try again.</div>";
                    } elseif ($_REQUEST['addblog'] == "pathcontainsspaces") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please do not add any spaces in a blog.</div>";
                    } elseif ($_REQUEST['addblog'] == "emptymainimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please Upload a main image.</div>";
                    } elseif ($_REQUEST['addblog'] == "emptyaltimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please Upload alternate image.</div>";
                    } elseif ($_REQUEST['addblog'] == "mainimageerror") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please Upload another main image.</div>";
                    } elseif ($_REQUEST['addblog'] == "altimageerror") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Please Upload another alternate image.</div>";
                    } elseif ($_REQUEST['addblog'] == "invalidtypemainimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Main image upload only -> jpg,jpeg,bmp,gif,png images only.</div>";
                    } elseif ($_REQUEST['addblog'] == "invalidtypealtimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Alternate image upload only -> jpg,jpeg,bmp,gif,png images only.</div>";
                    } elseif ($_REQUEST['addblog'] == "erroruploadingmainimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> There was an error while uploading. Please try again later. </div>";
                    } elseif ($_REQUEST['addblog'] == "erroruploadingaltimage") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> There was an error while uploading. Please try again later. </div>";
                    } elseif ($_REQUEST['addblog'] == "titlebeingused") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> Title is being used in another title. Please try another title.</div>";
                    } elseif ($_REQUEST['addblog'] == "pathbeingused") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> This Blog Path is being used in another path. Please try another blog path.</div>";
                    } elseif ($_REQUEST['addblog'] == "homepageplacementerror") {
                        echo "<div class='alert alert-danger'><strong>Error! </strong> An unexpected error occured while trying to set the home page placement. Please try agian.</div>";
                    }
                }
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Write A Blog
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="includes/add-blog.php" enctype="multipart/form-data" onsubmit="return validateImage();">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="blog-title" value="<?php
                                                                                                        if (isset($_SESSION['blogTitle'])) {
                                                                                                            echo $_SESSION['blogTitle'];
                                                                                                        }
                                                                                                        ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input class="form-control" name="blog-meta-title" value="<?php
                                                                                                            if (isset($_SESSION['blogMetaTitle'])) {
                                                                                                                echo $_SESSION['blogMetaTitle'];
                                                                                                            }
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

                                                        if (isset($_SESSION['blogpCategoryId'])) {
                                                            if (S_SESSION['blogCategoryId'] == $cId) {
                                                                echo "<option value='" . $cId . "' selected=''>" . $cName . "</option>";
                                                            } else {
                                                                echo "<option value='" . $cId . "'>" . $cName . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='" . $cId . "'>" . $cName . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Main Image</label>
                                                <input type="file" name="main-blog-image" id="main-blog-image">
                                            </div>
                                            <div class="form-group">
                                                <label>Alternate Image</label>
                                                <input type="file" id="alt-blog-image" name="alt-blog-image">
                                            </div>
                                            <div class="form-group">
                                                <label>Summary</label>
                                                <textarea name="blog-summary" class="form-control" rows="3"><?php
                                                                                                            if (isset($_SESSION['blogSummary'])) {
                                                                                                                echo $_SESSION['blogSummary'];
                                                                                                            }
                                                                                                            ?></textarea>
                                            </div>
                                            <div class="form-gsroup">
                                                <label>Blog Content</label>
                                                <textarea class="form-control" rows="3" id="summernote" name="blog-content"><?php
                                                                                                            if (isset($_SESSION['blogContent'])) {
                                                                                                                echo $_SESSION['blogContent'];
                                                                                                            }
                                                                                                            ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Tags(Speperated by comma)</label>
                                                <input class="form-control value=" <?php
                                                                                    if (isset($_SESSION['blogTags'])) {
                                                                                        echo $_SESSION['blogTags'];
                                                                                    }
                                                                                    ?>" name="blog-tags">
                                            </div>
                                            <div class="form-group input-group">
                                                <label>Blog Path</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">www.yashtiwari.com</span>
                                                    <input type="text" class="form-control" name="blog-path" value="<?php
                                                                                                                    if (isset($_SESSION['blogPath'])) {
                                                                                                                        echo $_SESSION['blogPath'];
                                                                                                                    }
                                                                                                                    ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Home Page Placement: </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline1" value="1" <?php if (isset($_SESSION['blog-home-page-placement'])) {
                                                                                                                        if ($_SESSION['blog-home-page-placement'] == 1) {
                                                                                                                            echo "checked=''";
                                                                                                                        }
                                                                                                                    }
                                                                                                                                            ?>>1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline2" value="2" <?php if (isset($_SESSION['blog-home-page-placement'])) {
                                                                                                                                                if ($_SESSION['blog-home-page-placement'] == 2) {
                                                                                                                                                    echo "checked=''";
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            ?>>2
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="blog-home-page-placement" id="optionsRadiosInline3" value="3" <?php if (isset($_SESSION['blog-home-page-placement'])) {
                                                                                                                                                if ($_SESSION['blog-home-page-placement'] == 3) {
                                                                                                                                                    echo "checked=''";
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            ?>>3
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-default" name="submit-blog">Add Blog</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
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
            $('#summernote').summernote(
                { height: 300, minHeight:null,maxHeight:null,focus:false}
            );
        });
    </script>
    <script>
        function validateImage() {

            var main_img = $("#main-blog-image").val();
            var alt_img = $("#alt-blog-image").val();

            var exts = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

            var get_ext_main_img = main_img.split('.');
            var get_ext_alt_img = alt_img.split('.');

            get_ext_main_img = get_ext_main_img.reverse();
            get_ext_alt_img = get_ext_alt_img.reverse();

            main_image_check = false;
            alt_image_check = false;

            if (main_img.length > 0) {
                if ($.inArray(get_ext_main_img[0].toLowerCase(), exts) >= -1) {
                    main_image_check = true;
                } else {
                    alert("Error -> Main Image, Upload only jpg, jpeg, png, gif, bmp images");
                    main_image_check = false;
                }
            } else {
                alert("Please upload a main Image.");
                main_image_check = false;
            }

            if (alt_img.length > 0) {
                if ($.inArray(get_ext_alt_img[0].toLowerCase(), exts) >= -1) {
                    alt_image_check = true;
                } else {
                    alert("Error -> Alternate Image, Upload only jpg, jpeg, png, gif, bmp images");
                    alt_image_check = false;
                }
            } else {
                alert("Please upload a Alternate Image.");
                alt_image_check = false;
            }

            if (main_image_check == true && alt_image_check == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>

</body>

</html>