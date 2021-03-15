<?php
	require_once('connect.php');
	if(IsLoggedIn())
	{
		exit("already logged in.");
	}
	if(!isset($_SESSION['username']) && strlen($_POST['name']) > 32)
	{
		exit("username is too long.");
	}
	if(!strlen($_POST['name']))
	{
		exit("username is empty.");
	}
	if(!IsLoggedIn() && strlen($_POST['name']))
	{
		$query = "SELECT * FROM users WHERE username = ? LIMIT 1";
		if($stmt = $mysqli->prepare($query))
		{
			$stmt->bind_param("s", $_POST['name']);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();
				$_SESSION['ID'] = $row['ID'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['perm'] = $row['perm'];
				$stmt->close();
				$mysqli->close();
				exit("success.");
			}
			else
			{
				$stmt->close();
				$mysqli->close();
				exit("user not found.");
			}
			$stmt->close();
		}
		$mysqli->close();
	}
?>