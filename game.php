<?php
	session_start();
	if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		require_once '../avalondb.php';
	 	
		$query = "SELECT id FROM member WHERE username = ?";
	 	$stmt = $conn->prepare($query);
	 	$stmt->bind_param("s",$_SESSION['avalonuser']);
	 	$stmt->bind_result($id);
	 	$stmt->execute();
	 	$stmt->fetch();
	 	$stmt->close();
	 	
	 	$query = "INSERT INTO game (friendsOnly, minPlayers, maxPlayers, host) VALUES(?,?,?,?)";
	 	$stmt = $conn->prepare($query);
	 	$fo = $_POST['fo'] == 'true' ? 1: 0;
	 	$stmt->bind_param("iiii",$fo,$_POST['min'],$_POST['max'],$id);
	 	$stmt->execute();
	 	$stmt->close();
	 	
	 	$query = "SELECT G.id FROM game G, member M WHERE G.host = M.id "
					."AND M.id = ? ORDER BY hosted DESC LIMIT 1";
	 	$stmt = $conn->prepare($query);
	 	$stmt->bind_param("i",$id);
	 	$stmt->bind_result($game);
	 	$stmt->execute();
	 	$stmt->fetch();
	 	$stmt->close();
	 	
	 	$query = "INSERT INTO gamePlayers(gameId, memberId) VALUES(?,?)";
	 	$stmt = $conn->prepare($query);
	 	$stmt->bind_param("ii",$game,$id);
	 	$stmt->execute();
	 	
	 	$stmt->close();
	 	$conn->close();
	 	echo "<script>location = '/Avalon/game.php?gameid=$game';</script>";
 	} else {
 		require_once "header.php";
 		require_once "../avalondb.php";
 		
 		$query = "SELECT hosted, ended, ongoing, cancelled, friendsOnly, "
 					."minPlayers, maxPlayers, targeting, ladyOfTheLake, "
 					."username As host FROM game G INNER JOIN member M "
 					."ON G.host = M.id WHERE G.id = ?";
 		$stmt = $conn->prepare($query);
 		$stmt->bind_param("i",$_GET['gameid']);
 		$stmt->bind_result($hosted,$ended,$ongoing,$cancel,$fo,$min,$max,$target
 							,$lady,$host);
 		$stmt->execute();
 		$stmt->fetch();
 		$stmt->close();
 		
 		require_once "gameScreen.php";
 	} 	 	
?>
