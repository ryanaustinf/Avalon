<?php
	if( empty($_POST) && !isset($_SERVER['HTTP_REFERER'] ) ) {
		header("Location: .././");
		die();
	}
	
	require_once "user-functions.php";
		
	function friendRequest($from,$to) {
		global $db;
		
		$fromId = getId($from);
		$toId = getId($to);
		echo "$fromId friended $toId";
		
		$query = "INSERT INTO friends(fromMember,toMember) VALUES (?,?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii",$fromId,$toId);
		$stmt->execute();
		$stmt->close();
	}
	
function acceptRequest($from,$to) {
		global $db;
		
		$fromId = getId($from);
		$toId = getId($to);
		echo "$fromId accepted $toId's friend request.";
		
		$query = "UPDATE friends SET approved = TRUE WHERE fromMember = ? AND "
					."toMember = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii",$toId,$fromId);
		$stmt->execute();
		$stmt->close();
		
		$query = "INSERT INTO friends VALUES (?,?,TRUE)";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii",$fromId,$toId);
		$stmt->execute();
		$stmt->close();
	}
	
	function blockMember($from,$to,$insert) {
		global $db;
		
		$fromId = getId($from);
		$toId = getId($to);
		echo "$fromId blocked $toId";
		
		$query = $insert === 'true' ? "INSERT INTO friends VALUES (?,?,FALSE)" 
					: "UPDATE friends SET approved = FALSE WHERE fromMember = "
					."? AND toMember = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii",$toId,$fromId);
		$stmt->execute();
		$stmt->close();
	}
	
	function getPlayers($gameId) {
		global $db;
		
		$query = "SELECT username FROM member M, gameplayers GP"
					." WHERE GP.memberID = M.id AND GP.gameId = ?";
		$stmt = $db->prepare($query);
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
		global $db;
		
		$id = getId($uname); 
		$query = "INSERT INTO gameplayers(gameId, memberId) VALUES (?,?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii",$gameId,$id);
		$stmt->execute();
		echo "$uname joined game $gameId";
	}
	
	function leaveGame($gameId,$uname) {
		global $db;
		
		$id = getId($uname); 
		$query = "DELETE FROM gameplayers WHERE gameId = ? AND memberId = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("ii",$gameId,$id);
		$stmt->execute();
		echo "$uname left game $gameId";
	}
	
	function maxReached($gameId) {
		global $db;
		
		$query = "SELECT maxPlayers - COUNT(memberId) AS `Slots`"
					." FROM game G, gameplayers GP"
					." WHERE G.id = GP.gameId AND G.id = ?"
					." GROUP BY G.id";
 		$stmt = $db->prepare($query);
		$stmt->bind_param("i",$gameId);
		$stmt->bind_result($slots);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();
		
		return $slots;
	}
	
	function minReached($gameId) {
		global $db;
		
		$query = "SELECT minPlayers - COUNT(memberId) AS `Missing`"
					." FROM game G, gameplayers GP"
					." WHERE G.id = GP.gameId AND G.id = ?"
					." GROUP BY G.id";
 		$stmt = $db->prepare($query);
 		$stmt->bind_param("i",$gameId);
 		$stmt->bind_result($missing);
 		$stmt->execute();
 		$stmt->fetch();
 		$stmt->close();
 			
		return $missing;
	}
	
	function getOngoing($gameId) {
		global $db;
		
		$query = "SELECT ongoing FROM game WHERE id = ?";
 		$stmt = $db->prepare($query);
 		$stmt->bind_param("i",$gameId);
 		$stmt->bind_result($ongoing);
 		$stmt->execute();
 		$stmt->fetch();
 		$stmt->close();
 		
 		return $ongoing;		
	}
	
	function assignChars($gameId) {
		global $db;
		
		$query = "UPDATE game SET ongoing = TRUE WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i",$gameId);
		if( $stmt->execute() ) {
			echo "Success\n";
		} else {
			echo "Fail\n";
		}
		
		$stmt->close();
		$query = "SELECT memberId FROM gamePlayers WHERE gameId = ?";
		$stmt = $db->prepare($query);
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
		$stmt = $db->prepare($query);
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
		case 'accept':
			acceptRequest($_POST['from'],$_POST['to']);
			break;
		case 'begin':
			assignChars($_POST['game']);
			break; 
		case 'block':
			blockMember($_POST['from'],$_POST['to'],$_POST['insert']);
			break;
		case 'friend':
			friendRequest($_POST['from'],$_POST['to']);
			break;
		case 'join':
			joinGame($_POST['game'],$_POST['user']);
			break;
		case 'leave':
			leaveGame($_POST['game'],$_POST['user']);
			break;
		case 'login':
			$data = usrGetData($_POST['uname']);

			$pass = hash("md5","Arthur".$_POST['pass']."Guinevere");
			$hash_pass = $data['password'];
			
			if( $pass === $hash_pass ) {
				$_SESSION['faillogin'] = false;
				$_SESSION['avalonuser'] = $_POST['uname'];
				$moder = $data['moder'] !== null;
				$admin = $data['moder'] !== null;	
				setcookie("avalonuser",$_POST['uname'], time() + 86400 * 14,
						"/Avalon" );
				setcookie("moder",$moder, time() + 86400 * 14, "/Avalon" );
				setcookie("admin",$admin, time() + 86400 * 14, "/Avalon" );
				$_SESSION['moder'] = $moder;
				$_SESSION['admin'] = $admin;
				header("Location: .././");
			} else {
				$_SESSION['faillogin'] = true;
				header("Location: .././");
			}
			die();
			break;
		case 'logout':
			//deletes cookies
			setcookie("avalonuser","",time() - 86400,"/Avalon");
			setcookie("moder","", time() - 86400, "/Avalon" );
			setcookie("admin","", time() - 86400, "/Avalon" );
			
			//destroys session
			session_unset();
			session_destroy();
			header("Location: .././");
			die();
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
		case 'players':
			echo getPlayers($_POST['game']);
			break; 
		case 'register':
			$_SESSION['faillogin'] = false;
			$res = usr_register($_POST['fname'], $_POST['lname']
									, $_POST['uname'], $_POST['pass']
									, $_POST['bio']);
			if( $res ) {
				header("Location: .././?result=success");
			} else {
				header("Location: .././?result=failure");
			}	
			die();
			break;
		case 'username':
			echo usrCheckUsername($_POST['uname']);
			break;
		default:
	}
?>