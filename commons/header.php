<!DOCTYPE PHP>
<html>
	<head>
		<title>Avalon Online</title>
		<link rel="stylesheet" href="assets/css/external.css" />
		<script src="assets/js/jquery-2.1.1.js"></script>
	</head>
	<body>
		<header>
			<div id="title">
				<h1>
					<a href="/Avalon"><img src="assets/images/AVALON.png"> Online</a>
				</h1>
			</div>
		<?php if( isset($_SESSION['avalonuser'] ) ) { ?> 
				<div id="username">
					<a href="user.php?uname=<?php echo $_SESSION['avalonuser']; ?>">Welcome, <?php echo $_SESSION['avalonuser']; ?><br/>
					<a data-path='logout' onCLick="document.logout.submit();">Logout</a>
				</div>
		<?php }
		 
			  if( isset($_SESSION['avalonuser']) ) {
		?>
				<ul>
	    <?php	if( $_SESSION['moder'] ) { ?>
					<li><a href="moderator.php">Moderator Panel</a></li>
		<?php 	} ?>
				
				<li><a href="friends.php">Friends</a></li>
		<?php 		
				require_once "../avalondb.php";
				
				if( $_SERVER['PHP_SELF'] != '/Avalon/requests.php' ) {
					$query = "SELECT COUNT(fromMember) FROM friends F, member "
								."M WHERE F.toMember = M.id AND M.username = ?"
								." AND approved IS NULL";
					$stmt2 = $conn->prepare($query);
					$stmt2->bind_param("s",$_SESSION['avalonuser'] );
					$stmt2->bind_result($ctr);
					$stmt2->execute();
					$stmt2->fetch();
					$stmt2->close();
		?>	
					<li><a href="requests.php">Friend Requests(<?php echo $ctr;?>)</a></li>
		<?php 	} ?>
				
				<li><a href=\"community.php\">Community Statistics</a></li>
		<?php 	if( $_SERVER['PHP_SELF'] != '/Avalon/hostGame.php' ) { ?>
					<li><a href=\"hostGame.php\">Host Game</a></li>
		<?php 	}
			}
		?>
		<form action="includes/controller.php" method="post" name="logout">
			<input type="hidden" name="request" value="logout" />
		</form>
</header>
