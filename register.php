<?php
	require_once('connect.php');
	if(!isset($_SESSION['username']) && strlen($_POST['name']) > 32)
	{
		exit("username is too long.");
	}
	if(!strlen($_POST['name']))
	{
		exit("username is empty.");
	}
	if(!strlen($_POST['mail']))
	{
		exit("email address is empty.");
	}
	if(strlen($_POST['mail']) > 320)
	{
		exit("email address is too long.");
	}
	if(!IsLoggedIn() && strlen($_POST['name']) && strlen($_POST['mail']))
	{
		if($stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ?"))
		{
			$stmt->bind_param("s", $_POST['name']);
			$stmt->execute();
			$result = $stmt->get_result();
			if($result->num_rows > 0)
			{
				$stmt->close();
				$mysqli->close();

				exit("username already taken.");
			}
		}
		else
		{
			print("contact with the admin.");
			//printf("Error: %s.\n", $stmt->error);
			$stmt->close();
			$mysqli->close();
		}
		$query = "INSERT INTO users (username, email, regtime, lastlogin, IP, perm) VALUES (?, ?, UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), ?, 0)";
		if($stmt = $mysqli->prepare($query))
		{
			$stmt->bind_param("sss", $_POST['name'], $_POST['mail'], $_SERVER['REMOTE_ADDR']);
			if($stmt->execute())
			{
				$_SESSION['ID'] = $stmt->insert_id;
				$_SESSION['username'] = $_POST['name'];

				$stmt->close();
				$mysqli->close();

				exit("success.");
			}
			else
			{
				print("contact with the admin.");
				//printf("Error: %s.\n", $stmt->error);
				$stmt->close();
				$mysqli->close();
			}
		}
	}
	else if(IsLoggedIn())
	{
		exit("already logged in.");
	}
?>