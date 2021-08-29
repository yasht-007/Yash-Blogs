<?php

require "connection.php";
session_start();

if (isset($_POST['submit-edit-blog'])) {

    $blogIdd = $_POST['blog-id'];
    $title = $_POST['blog-title'];
    $metaTitle = $_POST['blog-meta-title'];
    $blogCategoryId = $_POST['blog-category'];
    $blogSummary = $_POST['blog-summary'];
    $blogContent = $_POST['blog-content'];
    $blogTags = $_POST['blog-tags'];
    $blogPath = $_POST['blog-path'];
    $homepagePlacement = $_POST['blog-home-page-placement'];

    $date = date("Y-m-d");
    $time = date("H:i:s");

    if (empty($title)) {
        formError("emptytitle");
    } else if (empty($blogCategoryId)) {
        formError("emptycategory");
    } else if (empty($blogSummary)) {
        formError("emptysummary");
    } else if (empty($blogContent)) {
        formError("emptycontent");
    } else if (empty($blogTags)) {
        formError("emptytags");
    } else if (empty($blogPath)) {
        formError("emptypath");
    }

    if (strpos($blogPath, " ") != false) {
        formError("PathcontainsSpaces");
    }

    if (empty($homepagePlacement)) {
        $homepagePlacement = 0;
    }

    $sqlCheckBlogTitle = "SELECT v_post_title FROM blog_post WHERE v_post_title = '$title' AND v_post_title != '$title' AND f_post_status != '2' ";
    $queryCheckBlogTitle = mysqli_query($conn, $queryCheckBlogTitle);

    $sqlCheckBlogPath = "SELECT v_post_path FROM blog_post WHERE v_post_path = '$blogPath' AND v_post_title != '$title' AND f_post_status != '2' ";
    $queryCheckBlogPath = mysqli_query($conn, $queryCheckBlogPath);

    if (mysqli_num_rows($queryCheckBlogTitle) > 0) {
        formError("titlebeingused");
    } else if (mysqli_num_rows($queryCheckBlogPath) > 0) {
        formError("pathbeingused");
    }

    if ($homepagePlacement != 0) {

        $sqlCheckBlogHomepagePlacement = "SELECT * FROM blog_post WHERE n_home_page_placement='$homepagePlacement' AND f_post_status !='2'";
        $queryCheckBlogHomepagePlacement = mysqli_query($conn, $sqlCheckBlogHomepagePlacement);
        if (mysqli_num_rows($homepagePlacement)) {
            $sqlUpdateHomeBlogHomepagePlacement = "UPDATE blog_post SET n_home_page_placement = '0' WHERE n_home_page_placement= '$homepagePlacement' AND f_post_status !='2'";

            if (!mysqli_query($conn, $sqlUpdateHomeBlogHomepagePlacement)) {

                formError("homepageplacementerror");
            }
        }
    }
    $mainImgUrl = uploadImage($_FILES["main-blog-image"]["name"], "main-blog-image", "main", "v_main_image_url");
    $altImgUrl = uploadImage($_FILES["alt-blog-image"]["name"], "alt-blog-image", "alt", "v_alt_image_url");

    if ($mainImgUrl == "no update") {
        if ($altImgUrl == "no update") {
            $sqlUpdateBlog = "UPDATE blog_post SET n_category_id = '$blogCategoryId' , v_post_title = '$title', v_post_meta_title = '$metaTitle', v_post_path = '$blogPath', v_post_summary= '$blogSummary', v_post_content = '$blogContent', n_home_page_placement = '$homepagePlacement', d_date_updated = '$date', d_time_updated= '$time' WHERE n_blog_post_id = '$blogIdd'";
        } else {
            $sqlUpdateBlog = "UPDATE blog_post SET n_category_id = '$blogCategoryId' , v_post_title = '$title', v_post_meta_title = '$metaTitle', v_post_path = '$blogPath', v_post_summary= '$blogSummary', v_post_content = '$blogContent', v_alternate_image_url = '$altImgUrl', n_home_page_placement = '$homepagePlacement', d_date_updated = '$date', d_time_updated= '$time' WHERE n_blog_post_id = '$blogIdd'";
        }
    } else if ($altImgUrl == "no update") {
        if ($mainImgUrl == "no update") {
            $sqlUpdateBlog = "UPDATE blog_post SET n_category_id = '$blogCategoryId' , v_post_title = '$title', v_post_meta_title = '$metaTitle', v_post_path = '$blogPath', v_post_summary= '$blogSummary', v_post_content = '$blogContent', n_home_page_placement = '$homepagePlacement', d_date_updated = '$date', d_time_updated= '$time' WHERE n_blog_post_id = '$blogIdd'";
        }
    } else {
        $sqlUpdateBlog = "UPDATE blog_post SET n_category_id = '$blogCategoryId' , v_post_title = '$title', v_post_meta_title = '$metaTitle', v_post_path = '$blogPath', v_post_summary= '$blogSummary', v_post_content = '$blogContent', v_main_image_url = '$mainImgUrl', n_home_page_placement = '$homepagePlacement', d_date_updated = '$date', d_time_updated= '$time' WHERE n_blog_post_id = '$blogIdd'";
    }

    $sqlUpdateBlogTags = "UPDATE blog_tags SET v_tag='$blogTags' WHERE n_blog_post_id='$blogIdd'";

    if (mysqli_query($conn, $sqlUpdateBlog) && mysqli_query($conn, $sqlUpdateBlogTags)) {
        formSuccess();
    } else {
        formError("sqlerror");
    }
} else {
    header("Location: ../index.php");
    exit();
}

function formSuccess()
{
    require "connection.php";

    mysqli_close($conn);

    unset($_SESSION['editBlogId']);
    unset($_SESSION['editTitle']);
    unset($_SESSION['editMetaTitle']);
    unset($_SESSION['editCategoryId']);
    unset($_SESSION['editSummary']);
    unset($_SESSION['editContent']);
    unset($_SESSION['editPath']);
    unset($_SESSION['editTags']);
    unset($_SESSION['editHomePagePlacement']);

    header("Location: ../blogs.php?updateblog=success");
    exit();
}

function formError($errorCode)
{
    require "connection.php";

    $_SESSION['editTitle'] = $_POST['blog-title'];
    $_SESSION['editMetaTitle'] = $_POST['blog-meta-title'];
    $_SESSION['editCategoryId'] = $_POST['blog-category'];
    $_SESSION['editSummary'] = $_POST['blog-summary'];
    $_SESSION['editContent'] = $_POST['blog-content'];
    $_SESSION['editTags'] = $_POST['blog-tags'];
    $_SESSION['editPath'] = $_POST['blog-path'];
    $_SESSION['editHomePagePlacement'] = $_POST['blog-home-page-placement'];

    mysqli_close($conn);
    header("Location: ../edit-blog.php?updateblog=" . $errorCode);
    exit();
}

function uploadImage($img, $imgName, $imgType, $imgDbColoumn)
{

    require "connection.php";
    $imgUrl = "";
    $validExt = array("jpg", "jpeg", "png", "bmp", "gif");

    if ($img == "") {
        return "no update";
    } else {

        if ($_FILES[$imgName]["size"] <= 0) {
            formError($imgType . "image error");
        } else {
            $ext = strtolower(end(explode(".", $img)));
            if (!in_array($ext, $validExt)) {
                formError("invalidtype" . $imgType . "image");
            }

            $sqlGetOldImage = "SELECT " . $imgDbColoumn . " FROM blog_post WHERE n_blog_post_id = '$$blogIdd'";
            $queryGetOldImage = mysqli_query($conn, $sqlGetOldImage);

            if ($rowGetOldImage = mysqli_fetch_assoc($queryGetOldImage)) {
                $oldImageUrl = $rowGetOldImage[$imgDbColoumn];
            }

            if (!empty($oldImageUrl)) {
                $oldImageUrlArray = explode("/", $oldImageUrl);
                $oldImageName = end($oldImageUrlArray);
                $oldImagePath = "../images/blog-images/" . $oldImageName;
                unlink($oldImagePath);
            }

            $folder = "../images/blog-images/";
            $imgNewName = rand(10000, 990000) . '_' . time() . '.' . $ext;
            $imgPath = $folder . $imgNewName;

            if (move_uploaded_file($_FILES[$imgName]['tmp_name'], $imgPath)) {
                $imgUrl = "http://localhost/blog/admin/images/blog-images/" . $imgNewName;

            } else {
                formError("erroruploading" . $imgType . "image");
            }
        }

        return $imgUrl;
    }
}
