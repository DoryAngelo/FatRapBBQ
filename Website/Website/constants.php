<?php

	session_start();

	define('SITEURL', 'http://fatrapsbbq.online/Website/');
	define('LOCALHOST', 'fatrapsbbq.online');
	define('DB_USERNAME', 'fbquser');
	define('DB_PASSWORD', 'j}wdrF!k+ED)');
	define('DB_NAME', 'bbq');

	$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
	$db_select = mysqli_select_db($conn, DB_NAME) or die (mysqli_error());
	
    mysqli_query($conn, "SET time_zone = '+08:00';");
	date_default_timezone_set('Asia/Manila');
    

?>