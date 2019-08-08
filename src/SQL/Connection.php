<?php 

namespace App\SQL;

class Connection {

private $serv, $user, $pass, $mysql_path;

public function __construct($mysql_path) {
$this->mysql_path = $mysql_path;
$this->serv = "localhost";
$this->user = "user";
$this->pass = "pass";
}

/**
 * Returns open connection to SQL db ready for queries
 */
function connect() {
try {
$mysql = parse_ini_file($this->mysql_path);
} catch (Exception $e) {
  echo ($e);
}
$this->debug_log($mysql);
if(array_key_exists("username", $mysql) && array_key_exists("password", $mysql) && array_key_exists("server", $mysql)) {
$conn = mysqli_connect($this->serv, $this->user, $this->pass);
if(!$conn) {
    die("Connection to MySQL server failed: " + mysqli_connect_error());
}
echo ('<script>console.log("MySQL connected.")</script>');
return $conn;
} else die("MySQL credentials not found: make sure you have a username, password, and server keys inside mysql.ini");
}
function debug_log($object=null, $label=null, $priority=1) {
  $priority = $priority < 1 ? 1: $priority;
  $message = json_encode($object, JSON_PRETTY_PRINT);
  $label = "Debug" . ($label ? " ($label): " : ': ');
  echo "<script>console.log('" . str_repeat("-", $priority-1) . $label . "', " . $message . ");</script>";
}
}
?>