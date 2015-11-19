<?php

// Connect to the MySQL database  
require "connect_to_mysql.php";

$sqlCommand = "CREATE TABLE IF NOT EXISTS movies (
		 		 id int(11) NOT NULL auto_increment,
				 movie_name varchar(255) NOT NULL,
		 		 price varchar(16) NOT NULL,
				 details text NOT NULL,
				 category varchar(16) NOT NULL,
		 		 date_added timestamp NOT NULL,
		 		 PRIMARY KEY (id),
		 		 UNIQUE KEY product_name (movie_name)
		 		 )";
if (!mysql_query($sqlCommand)){ 
    echo "CRITICAL ERROR: movies table has not been created.";
}
?>
