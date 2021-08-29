<?php 

$conn = "";
   
try {
    
$servername= "localhost";
$dbusername = "admin";
$dbpassword="admin";
$dbname= "blogs";

$conn = new PDO(
    "mysql:host=$servername; dbname=$dbname",
    $dbusername, $dbpassword
);
  
$conn->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
echo "Connection failed: " . $e->getMessage();
}