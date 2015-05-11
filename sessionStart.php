<?php
	session_start();
	if( isset($_COOKIE['avalonuser']) ) {
		$_SESSION['avalonuser'] = $_COOKIE['avalonuser'];
	}
	if( isset($_COOKIE['moder']) ) {
		$_SESSION['moder'] = $_COOKIE['moder'];
	}
	if( isset($_COOKIE['admin']) ) {
		$_SESSION['admin'] = $_COOKIE['admin'];
	}
	
?>