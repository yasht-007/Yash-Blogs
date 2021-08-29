<?php

    require "connection.php";

if(isset($_POST['add-category-btn'])){
    
    $name= $_POST['category-name'];
    $metatitle= $_POST['category-meta-title'];
    $path= $_POST['category-path'];

    $date= date("Y-m-d");
    $time= date("H:i:s");

    $sqlCategory= "INSERT INTO blog_category(v_category_title,v_category_meta_title,v_category_path,d_date_created,d_time_created) VALUES('$name','$metatitle','$path','$date','$time')";
    if(mysqli_query($conn,$sqlCategory)){
        mysqli_close($conn);
        header("Location: ../blog-category.php?addcategory=success");
        exit();
    }

    else{
        mysqli_close($conn);
        header("Location: ../blog-category.php?addcategory=error");
        exit();
    }

}
else{
    header("Location: ../index.php");
}
?>