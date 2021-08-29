<?php 

$servername= "localhost";
$dbusername = "admin";
$dbpassword="admin";
$dbname= "blogs";

$conn = mysqli_connect($servername,$dbusername,$dbpassword,$dbname);

if(!$conn){
    die("Connection Failed: ".mysqli_connect_error());
}