<?php 
//fetch mysql data from cfg
$server = "localhost";
$user = "user";
$pass = "pass";

/**
 * Returns open connection to SQL db ready for queries
 */
function connect() {
$conn = mysqli_connect($server, $user, $pass);
if(!$conn) {
    die("Connection to MySQL server failed: " + mysqli_connect_error());
}
echo ("MySQL connected.");
return $conn;
}
?>