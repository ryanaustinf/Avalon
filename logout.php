<?php
	//start session
	session_start();
	
	//deletes cookies
	setcookie("avalonuser","",time() - 86400,"/Avalon");
	setcookie("moder","", time() - 86400, "/Avalon" );
	setcookie("admin","", time() - 86400, "/Avalon" );
	
	//destroys session
	session_unset();
	session_destroy();
	
	//goes to homepage
	echo "<script>location = '/Avalon'</script>";
?>