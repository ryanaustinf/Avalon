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
					echo "<ul>";
					if( $_SESSION['moder'] ) {
						echo "<li><a href=\"moderator.php\">Moderator Panel"
								."</a></li>";
					}
					echo "<li><a href=\"friends.php\">Friends</a></li>\n"
							."<li><a href=\"community.php\">Community Statisti"
							."cs</a></li>\n"
							."<li><a href=\"hostGame.php\">Host Game</a></li>\n"
							."<li><a href=\"logout.php\">Logout</a></li>\n"
							."</ul>";
				}
			?>
		</header>