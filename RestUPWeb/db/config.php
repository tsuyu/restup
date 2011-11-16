<?php

# Name			: db.php
# Description	: Include file storing the database connection information.
# Author		: 
# Created		: 
# Updated		:
# MySQL Server Connection Constants. These can be changed here if the database is moved.

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "123456";
$dbName = "rssdb";  // Password

$db = mysql_connect("$dbHost", "$dbUser", "$dbPassword");

if (!$db) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db($databaseName, $db);
?>
