<?php
	require_once "sessionStart.php";
	if( isset($_SESSION['avalonuser']) ) {
		require_once "commons/header.php";
		require_once "home.php";
	} else {
		require_once "register.php";
	}
?>