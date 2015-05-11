<?php
	require_once "../avalondb.php";
	
	function checkUsername($uname) {
		global $conn;
		
		$query = "SELECT username FROM member WHERE username = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s",$uname);
		$stmt->execute();
		$ret = ( $stmt->fetch() ? "true" : "false" );
		$stmt->close();
		return $ret;
	}
	
	switch( $_POST['request'] ) {
		case 'username':
			echo checkUsername($_POST['uname']);
			break;
		default;
	}
	
	$conn->close();
?>