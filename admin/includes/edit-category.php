<?php

require "connection.php";

if (isset($_POST['edit-category-btn'])) {

    $id = $_POST['category-id'];
    $name = $_POST['edit-category-name'];
    $metatitle = $_POST['edit-category-meta-title'];
    $categorypath = $_POST['edit-category-path'];

    $sqlEditCategory = "UPDATE blog_category SET v_category_title = '$name', v_category_meta_title= '$metatitle',
     v_category_path='$categorypath' WHERE n_category_id = '$id'";
    if (mysqli_query($conn, $sqlEditCategory)) {
        mysqli_close($conn);
        header("Location: ../blog-category.php?edit-category=success");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../blog-category.php?edit-category=error");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
