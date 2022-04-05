<?php
// Script to conenct to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "iforum";
$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn){
    header("location: /forum/dberror.php");
    exit;
}
?>