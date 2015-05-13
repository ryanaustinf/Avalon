<?php
	session_start();
	require_once "../avalondb.php";
	$query = "SELECT firstName, lastName, username, bio, gamesPlayed, MO.id AS"
				." `moder`, A.id AS `admin` FROM member M LEFT JOIN moderator "
				."MO ON M.id = MO.id LEFT JOIN admin A ON MO.id = A.id WHERE "
				."username = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("s",$_GET['uname']);
	$stmt->bind_result($fname,$lname,$uname,$bio,$gameCtr,$moder,$admin);
	$stmt->execute();
	require_once "header.php";
	if($stmt->fetch()) {
		$stmt->close();
		require_once "userTemplate.php";
	} else {
		echo "<div id=\"mainContent\">User does not exist</div>";
	}
?>
			