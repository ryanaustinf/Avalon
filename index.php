<?php
	require_once "sessionStart.php";
	if( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
		if( isset($_SESSION['avalonuser']) ) {
			require_once "header.php";
			require_once "home.php";
		} else {
			require_once "register.php";
		}
	} else {
		
	}
?>