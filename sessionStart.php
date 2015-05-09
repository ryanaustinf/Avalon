<?php
	session_start();
	if( isset($_COOKIE['avalonuser']) ) {
		$_SESSION['avalonuser'] = $_COOKIE['avalonuser'];
	}
?>