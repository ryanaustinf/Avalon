<!DOCTYPE PHP>
<html>
	<head>
		<title>Avalon Online</title>
		<link rel="stylesheet" href="external.css" />
		<script src="jquery-2.1.1.js"></script>
	</head>
	<body>
		<header>
			<div id="title">
				<h1>
					<a href="/Avalon"><img src="Assets/AVALON.png"> Online</a>
				</h1>
			</div>
		<?php
			if( isset($_SESSION['avalonuser'] ) ) { 
				echo "<div id=\"username\">\n<a href=\"user.php?uname="
						.$_SESSION['avalonuser']."\">Welcome, "
						.$_SESSION['avalonuser']."</h5><br/>\n"
						."<a href=\"logout.php\">Logout"
						."</a></div>";
			}
		 
			if( isset($_SESSION['avalonuser']) ) {
				echo "<ul>\n";
				if( $_SESSION['moder'] ) {
					echo "\t\t\t\t<li><a href=\"moderator.php\">Moderator"
							." Panel</a></li>\n";
				}
				
				echo "\t\t\t\t<li><a href=\"friends.php\">Friends</a>"
						."</li>\n";
				
				require_once "../avalondb.php";
				
				
				$query = "SELECT COUNT(fromMember) FROM friends F, member M "
						 	."WHERE F.toMember = M.id AND M.username = ? AND "
						 	."approved IS NULL";
				$stmt2 = $conn->prepare($query);
				$stmt2->bind_param("s",$_SESSION['avalonuser'] );
				$stmt2->bind_result($ctr);
				$stmt2->execute();
				$stmt2->fetch();
				$stmt2->close();
				
				echo "\t\t\t\t<li><a href=\"requests.php\">Friend Requests"
						."($ctr)</a></li>\n";
				
				echo "\t\t\t\t<li><a href=\"community.php\">Community"
						." Statistics</a></li>\n";
				
				if( $_SERVER['PHP_SELF'] != '/Avalon/hostGame.php' ) {
					echo "\t\t\t\t<li><a href=\"hostGame.php\">Host Game"
							."</a></li>\n";
				}
			}
		?>
</header>
