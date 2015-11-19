
<?php
// Start session first thing in script
session_start();

// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Connect to the MySQL database
// Define BASE_URL
if (dirname(dirname($_SERVER['SCRIPT_NAME']))!=='/') {
  require_once("../storescripts/connect_to_mysql.php");
  define('BASE_URL',dirname(dirname($_SERVER['SCRIPT_NAME'])));
  $file = explode('/', $_SERVER['SCRIPT_NAME'])[3];
}else{
  require_once("storescripts/connect_to_mysql.php");
  define('BASE_URL',dirname($_SERVER['SCRIPT_NAME']));
  $file = explode('/', $_SERVER['SCRIPT_NAME'])[2];
}


?>
