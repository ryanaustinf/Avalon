<?php
	//start session
	session_start();
	
	//if logged in, set session variables
	if( isset($_COOKIE['avalonuser']) ) {
		$_SESSION['avalonuser'] = $_COOKIE['avalonuser'];
	}
	
	if( isset($_COOKIE['moder']) ) {
		$_SESSION['moder'] = $_COOKIE['moder'];
	} else {
		$_SESSION['moder'] = false;
	}
	
	if( isset($_COOKIE['admin']) ) {
		$_SESSION['admin'] = $_COOKIE['admin'];
	} else {
		$_SESSION['admin'] = false;
	}
	
?>