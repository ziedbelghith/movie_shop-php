<?php  

$db_host = "localhost"; 
// Place the username for the MySQL database here
$db_username = "root";  
// Place the password for the MySQL database here
$db_pass = "AEI123pass";  
// Place the name for the MySQL database here
$db_name = "Movies";

// Run the actual connection here
$mysql = mysql_connect("$db_host","$db_username","$db_pass") or die(mysql_error());

mysql_select_db("$db_name") or die ("no database");

require_once 'create_db.php';
require_once 'create_movies_table.php';
require_once 'create_users_table.php';
require_once 'create_transactions_table.php';

?>
