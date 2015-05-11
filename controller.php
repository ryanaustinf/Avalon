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
	
	switch( $_POST['request'] ) {
		case 'username':
			echo checkUsername($_POST['uname']);
			break;
		default;
	}
	
	$conn->close();
?>