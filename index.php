<?php
	require_once "sessionStart.php";
	$_SESSION['faillogin'] = false;
	if( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
		if( isset($_SESSION['avalonuser']) ) {
			require_once "header.php";
			require_once "home.php";
		} else {
			require_once "register.php";
		}
	} else {
		require_once "../avalondb.php";
		$query = "SELECT password FROM member WHERE username = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s",$_POST['uname']);
		$pass = hash("md5","Arthur".$_POST['pass']."Guinevere");
		$stmt->bind_result($hash_pass);
		$stmt->execute();
		$stmt->fetch();
		if( $pass === $hash_pass ) {
			$_SESSION['faillogin'] = false;
			$_SESSION['avalonuser'] = $_POST['uname'];
			$query = "SELECT MO.id FROM moderator MO, member ME WHERE MO.id = "
						."ME.id AND username = ?";
			$stmt->close();
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s",$_POST['uname']);
			$stmt->execute();
			$moder = null;
			if($stmt->fetch()) {
				$moder = 1;
			} else {
				$moder = 0;
			}
			$query = "SELECT A.id FROM admin A, member M WHERE A.id = M.id AND "
						."username = ?";
			$stmt->close();
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s",$_POST['uname']);
			$stmt->execute();
			$admin = null;
			if($stmt->fetch()) {
				$admin = 1;
			} else {
				$admin = 0;
			}
			$stmt->close();
			
			setcookie("avalonuser",$_POST['uname'], time() + 86400 * 14,
					"/Avalon" );
			setcookie("moder",$moder, time() + 86400 * 14, "/Avalon" );
			setcookie("admin",$admin, time() + 86400 * 14, "/Avalon" );
			$_SESSION['moder'] = $moder;
			$_SESSION['admin'] = $admin;
			
			require_once "header.php";
			require_once "home.php";
		} else {
			$_SESSION['faillogin'] = true;
			require_once "register.php";
		}
	}
?>