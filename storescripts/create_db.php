<?php

$sql = "CREATE DATABASE IF NOT EXISTS Movies";

if (!mysql_query($sql)){
    echo "CRITICAL ERROR: movies table has not been created.";
}

?>
