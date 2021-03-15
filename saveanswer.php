<?php
	require_once("connect.php");
	if(!isset($_POST['sessionid']) || !isset($_POST['testid']) || !isset($_POST['questionid']))
	{
		$mysqli->close();
		exit("no data.");
	}
	if(!isset($_POST['optionid']))
	{
		$mysqli->close();
		exit("success.");
	}
	$sessionid = intval($_POST['sessionid']);
	$testid = intval($_POST['testid']);
	$questionid = intval($_POST['questionid']);
	$optionid = intval($_POST['optionid']);
	if(!IsLoggedIn())
	{
		$mysqli->close();
		exit("not logged in.");
	}
	$userid = intval($_SESSION['ID']);
	$query = "SELECT ID, untilTime, isActive FROM sessions WHERE ID = ? LIMIT 1";
	if($stmt = $mysqli->prepare($query))
	{
		$stmt->bind_param("i", $sessionid);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			if(!$row['isActive'])
			{
				$stmt->close();
				$mysqli->close();
				exit("session is inactive.");
			}
			if($row['untilTime'] <= time())
			{
				$stmt->close();
				$mysqli->close();
				exit("session is finished.");
			}
		}
		else
		{
			$stmt->close();
			$mysqli->close();
			exit("session not found.");
		}
	}
	$query = "SELECT ID FROM answers WHERE sessionID = ? AND userID = ? AND questionID = ?";
	if($stmt = $mysqli->prepare($query))
	{
		$stmt->bind_param("iii", $sessionid, $userid, $questionid);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0)
		{
			$answerinfo = $result->fetch_assoc();
			$answerid = $answerinfo['ID'];
			$stmt->close();
			$query = "UPDATE answers SET time = UNIX_TIMESTAMP(), answer = ? WHERE ID = ?";
			if($stmt = $mysqli->prepare($query))
			{
				$stmt->bind_param("ii", $optionid, $answerid);
				if($stmt->execute())
				{
					$stmt->close();
					$mysqli->close();
					exit("success.");
				}
				else
				{
					$stmt->close();
					$mysqli->close();
					exit("failure.");
				}
			}
			else
			{
				//echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
				exit("mysql error.");
				$stmt->close();
			}
		}
		$query = "INSERT INTO answers (questionID, userID, testID, sessionID, time, answer) VALUES (?, ?, ?, ?, UNIX_TIMESTAMP(), ?)";
		if($stmt = $mysqli->prepare($query))
		{
			$stmt->bind_param("iiiii", $questionid, $userid, $testid, $sessionid, $optionid);
			if($stmt->execute())
			{
				$stmt->close();
				$mysqli->close();
				exit("success.");
			}
			else
			{
				$mysqli->close();
				$stmt->close();
				exit("saving error.");
			}
		}
	}
	/*
	$query = "SELECT correctOption FROM questions WHERE ID = ? LIMIT 1";
	if($stmt = $mysqli->prepare($query))
	{
		$stmt->bind_param("i", $questionid);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			if($optionid == $row['correctOption'])
			{
				$stmt->close();
				$mysqli->close();
				exit("correct answer.");
			}
			else
			{
				$stmt->close();
				$mysqli->close();
				switch($row['correctOption'])
				{
					case 1:
					{
						exit("it is A.");
					}
					case 2:
					{
						exit("it is B.");
					}
					case 3:
					{
						exit("it is C.");
					}
					case 4:
					{
						exit("it is D.");
					}
				}
				
			}
		}
	}
	*/
	$mysqli->close();
?>
	