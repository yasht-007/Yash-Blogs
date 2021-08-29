<?php

    session_start();
    if(!isset($_SESSION['adminname'])){
        header("Location: ./index.php");
    }
?>