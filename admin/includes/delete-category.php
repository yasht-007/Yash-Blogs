<?php

require "connection.php";

if (isset($_POST['delete-category-btn'])) {

    $id = $_POST['category-id'];
    $sqlDeleteCategory = "DELETE FROM blog_category WHERE n_category_id='$id'";
    if (mysqli_query($conn, $sqlDeleteCategory)) {
        mysqli_close($conn);
        header("Location: ../blog-category.php?delete-category=success");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../blog-category.php?delete-category=error");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
