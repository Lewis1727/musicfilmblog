<?php 
	session_start();
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	//$conn = mysqli_connect("localhost", "lewis", "!Monopolist1344", "PHP_BLOG");
	$conn = mysqli_connect("localhost", "root", "!Monopolist1344", "PHP_BLOG");

	if (!$conn) {
		die("Error connecting to database: " . mysqli_connect_error());
	}

	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://musicfilmblog.xyz/');
?>
