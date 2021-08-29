<?php
         session_start();
        // unset($_SESSION['adminname']);
        //session_start();
        session_unset();
        session_destroy();
        header("Location: ../index.php");  
        exit();
?>