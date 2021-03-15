<?php
	session_start();
	date_default_timezone_set('Europe/Istanbul');
	$server = "localhost";
	$username = "";
	$password = "";
	$dbname = "";

	// Create connection
	$mysqli = new mysqli($server, $username, $password, $dbname);

	// Check connection
	if ($mysqli->connect_errno) {
		die( "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
	}
	/* change character set to utf8 */
	if (!$mysqli->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $mysqli->error);
		exit();
	}
	function IsLoggedIn()
	{
		if(strlen($_SESSION['username'])) return 1;
		return 0;
	}
	if(isset($_SESSION['perm']))
	{
		$perm = $_SESSION['perm'];
	}
	?>