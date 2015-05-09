<?php
	require_once "sessionStart.php";
	session_destroy();
	if( isset($_SESSION['avalonuser']) ) {
		require_once "header.php";
	} else {
		require_once "register.php";
	}
?>
	</body>
</html>