<?php

// Connect to the MySQL database  
require "connect_to_mysql.php";  

$sqlCommand = "CREATE TABLE IF NOT EXISTS users (
		 		 id int(11) NOT NULL auto_increment,
				 username varchar(24) NOT NULL,
		 		 password varchar(50) NOT NULL,
		 		 email varchar(50) NOT NULL,
		 		 status varchar(24) NOT NULL,
		 		 active boolean NOT NULL,
		 		 last_log_date timestamp NOT NULL,
		 		 sign_in_date timestamp NOT NULL,
		 		 PRIMARY KEY (id),
		 		 UNIQUE KEY username (username)
		 		 ) ";
if (!mysql_query($sqlCommand)){ 
    echo "CRITICAL ERROR: users table has not been created.";
}
?>