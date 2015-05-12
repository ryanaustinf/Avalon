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
			if( isset($_SESSION['avalonuser']) ) {
				echo "<ul>\n";
				if( $_SESSION['moder'] ) {
					echo "\t\t\t\t<li><a href=\"moderator.php\">Moderator"
							." Panel</a></li>\n";
				}
				echo "\t\t\t\t<li><a href=\"friends.php\">Friends</a>"
						."</li>\n"
						."\t\t\t\t<li><a href=\"community.php\">Community"
						." Statistics</a></li>\n";
				
				if( $_SERVER['PHP_SELF'] != '/Avalon/hostGame.php' ) {
					echo "\t\t\t\t<li><a href=\"hostGame.php\">Host Game"
							."</a></li>\n";
				}
						
				echo "\t\t\t\t<li><a href=\"logout.php\">Logout"
						."</a></li>\n"
						."\t\t\t</ul>\n";
			}
		?>
</header>
