<?php
	require_once "../avalondb.php";
	
	function checkUsername($uname) {
		global $conn;
		
		//check if username is in the database
		$query = "SELECT username FROM member WHERE username = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s",$uname);
		$stmt->execute();
		
		//return if exists
		$ret = ( $stmt->fetch() ? "true" : "false" );
		$stmt->close(); //close statement
		return $ret;
	}
	
	function getId($uname) {
		global $conn;
		
		$query = "SELECT id FROM member WHERE username = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s",$uname);
		$stmt->bind_result($id);
		$stmt->execute();
		if( $stmt->fetch() ) {
			$stmt->close();
			return $id;
		} else {
			$stmt->close();
			return -1;
		}
	}
	
	function friendRequest($from,$to) {
		global $conn;
		
		$fromId = getId($from);
		$toId = getId($to);
		echo "$fromId friended $toId";
		
		$query = "INSERT INTO friends(fromMember,toMember) VALUES (?,?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ii",$fromId,$toId);
		$stmt->execute();
		$stmt->close();
	}
	
function acceptRequest($from,$to) {
		global $conn;
		
		$fromId = getId($from);
		$toId = getId($to);
		echo "$fromId accepted $toId's friend request.";
		
		$query = "UPDATE friends SET approved = TRUE WHERE fromMember = ? AND "
					."toMember = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ii",$toId,$fromId);
		$stmt->execute();
		$stmt->close();
		
		$query = "INSERT INTO friends VALUES (?,?,TRUE)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ii",$fromId,$toId);
		$stmt->execute();
		$stmt->close();
	}
	
	function blockMember($from,$to,$insert) {
		global $conn;
		
		$fromId = getId($from);
		$toId = getId($to);
		echo "$fromId blocked $toId";
		
		$query = $insert === 'true' ? "INSERT INTO friends VALUES (?,?,FALSE)" 
					: "UPDATE friends SET approved = FALSE WHERE fromMember = "
					."? AND toMember = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ii",$toId,$fromId);
		$stmt->execute();
		$stmt->close();
	}
	
	function getPlayers($gameId) {
		global $conn;
		
		$query = "SELECT username FROM member M, gameplayers GP"
					." WHERE GP.memberID = M.id AND GP.gameId = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("i",$gameId);
		$stmt->bind_result($uname);
		$stmt->execute();
		$players = array();
		while($stmt->fetch()) {
			$players[] = $uname;
		}
		$stmt->close();
		
		return json_encode($players);
	}
	
	function joinGame($gameId,$uname) {
		global $conn;
		
		$id = getId($uname); 
		$query = "INSERT INTO gameplayers(gameId, memberId) VALUES (?,?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ii",$gameId,$id);
		$stmt->execute();
		echo "$uname joined game $gameId";
	}
	
	function leaveGame($gameId,$uname) {
		global $conn;
		
		$id = getId($uname); 
		$query = "DELETE FROM gameplayers WHERE gameId = ? AND memberId = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ii",$gameId,$id);
		$stmt->execute();
		echo "$uname left game $gameId";
	}
	
	function maxReached($gameId) {
		global $conn;
		
		$query = "SELECT maxPlayers - COUNT(memberId) AS `Slots`"
					." FROM game G, gameplayers GP"
					." WHERE G.id = GP.gameId AND G.id = ?"
					." GROUP BY G.id";
 		$stmt = $conn->prepare($query);
		$stmt->bind_param("i",$gameId);
		$stmt->bind_result($slots);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();
		
		return $slots;
	}
	
	function minReached($gameId) {
		global $conn;
		
		$query = "SELECT minPlayers - COUNT(memberId) AS `Missing`"
					." FROM game G, gameplayers GP"
					." WHERE G.id = GP.gameId AND G.id = ?"
					." GROUP BY G.id";
 		$stmt = $conn->prepare($query);
 		$stmt->bind_param("i",$gameId);
 		$stmt->bind_result($missing);
 		$stmt->execute();
 		$stmt->fetch();
 		$stmt->close();
 			
		return $missing;
	}
	
	function getOngoing($gameId) {
		global $conn;
		
		$query = "SELECT ongoing FROM game WHERE id = ?";
 		$stmt = $conn->prepare($query);
 		$stmt->bind_param("i",$gameId);
 		$stmt->bind_result($ongoing);
 		$stmt->execute();
 		$stmt->fetch();
 		$stmt->close();
 		
 		return $ongoing;		
	}
	
	function assignChars($gameId) {
		global $conn;
		
		$query = "UPDATE game SET ongoing = TRUE WHERE id = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("i",$gameId);
		if( $stmt->execute() ) {
			echo "Success\n";
		} else {
			echo "Fail\n";
		}
		
		$stmt->close();
		$query = "SELECT memberId FROM gamePlayers WHERE gameId = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("i",$gameId);
		$stmt->bind_result($playerId);
		if( $stmt->execute() ) {
			echo "Success\n";
		} else {
			echo "Fail\n";
		}
		$players = array();
		
		while( $stmt->fetch() ) {
			$players[] = $playerId;
		}
		
		$stmt->close();
		
		$playerCount = count($players);
		$evilCtr = null;
		switch($playerCount) {
			case 5:
			case 6:
				$evilCtr = 2;
				break;
			case 7:
			case 8:
			case 9:
				$evilCtr = 3;
				break;
			case 10:
				$evilCtr = 4;
				break;
			default;	
		}
		$goodCtr = $playerCount - $evilCtr;
		
		$chars = array();
		for( $i = 1; $i <= $goodCtr; $i++ ) {
			$chars[] = "Servant of Arthur $i";
		}
		
		for( $i = 1; $i <= $evilCtr; $i++ ) {
			$chars[] = "Minion of Mordred $i";
		}
		
		$mapping = array();
		shuffle($chars);
		$i = 0;
		foreach( $players as $v ) {
			$mapping[$v] = $chars[$i];
			$i++;
		} 
		
		$query = "UPDATE gameplayers SET `character` = ? WHERE memberId = ? "
					."AND gameId = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("sii",$v,$k,$gameId);
		foreach( $mapping as $k=>$v) {
			if( $stmt->execute() ) {
				echo "Success\n";
			} else {
				echo "Fail\n";
			}
		} 
		$stmt->close();
	}
	
	switch( $_POST['request'] ) {
		case 'username':
			echo checkUsername($_POST['uname']);
			break;
		case 'friend':
			friendRequest($_POST['from'],$_POST['to']);
			break;
		case 'accept':
			acceptRequest($_POST['from'],$_POST['to']);
			break;
		case 'block':
			blockMember($_POST['from'],$_POST['to'],$_POST['insert']);
			break;
		case 'players':
			echo getPlayers($_POST['game']);
			break; 
		case 'join':
			joinGame($_POST['game'],$_POST['user']);
			break;
		case 'leave':
			leaveGame($_POST['game'],$_POST['user']);
			break;
		case 'max':
			echo maxReached($_POST['game']);
			break;
		case 'min':
			echo minReached($_POST['game']);
			break;
		case 'ongoing':
			echo getOngoing($_POST['game']);
			break;
		case 'begin':
			assignChars($_POST['game']);
			break; 
		default:
	}
	
	$conn->close();
?>