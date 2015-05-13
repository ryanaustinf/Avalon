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
		default;
	}
	
	$conn->close();
?>