<?php
	session_start();
	require_once 'globals.php';
	require_once 'class.database.php';

	$db = new Database("mysql",DBHOST,DBNAME,DBUSER,DBPASS);
?>