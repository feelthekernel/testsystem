<?php
	require_once('connect.php');
	if(!IsLoggedIn())
	{
		exit("not logged in.");
	}
	$query = "SELECT ID, untilTime, isActive FROM sessions WHERE ID = ? LIMIT 1";
	if($stmt = $mysqli->prepare($query))
	{
		$stmt->bind_param("i", $_GET['sessionid']);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			if(!$row['isActive'])
			{
				print("session is inactive.");
			}
			else if($row['untilTime'] <= time())
			{
				print("session is finished.");
			}
			else if($row['startTime'] >= time())
			{
				print("session is not started.");
			}
			else print("success");
		}
		else
		{
			print("session not found.");
		}
		$stmt->close();
		$mysqli->close();
	}
?>