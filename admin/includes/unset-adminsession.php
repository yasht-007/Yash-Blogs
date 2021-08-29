<?php
        session_start();
        unset($_SESSION['adminname']);
        header("Location: ../index.php");
        exit();
?>