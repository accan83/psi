<?php
$server = "localhost"; 
$username = "itcc";
$password = "itcc2015";
$database = "psi";


$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>