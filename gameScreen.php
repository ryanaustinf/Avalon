<?php require_once "sendHome.php"; ?>
		<script> 
			var game = <?php echo $_GET['gameid']; ?>;
			var user = "<?php echo $_SESSION['avalonuser']; ?>";
			var watchMin = false;
			var watchMax = false;
			var watchOngoing = false;
			var join;
			var begin;
			
			function updatePlayers() {
				$.ajax({
					url : "controller.php",
					method : "POST",
					data : {
						"request" : "players",
						"game" : game
					},
					dataType : "json",
					success : function(a) {
						var htmlStr = "";
						for( var player in a ) {
							player = a[player];
							htmlStr += "<li><a href=\"user.php?uname=" + player
										+ "\">" + player + "</a></li>\n";
						}
						$("#playerList").html(htmlStr);
					}
				});
			}

			function checkMax() {
				if( watchMax ) {
					$.ajax({
						url : "controller.php",
						method : "POST",
						data : {
							"request" : "max",
							"game" : game
						},
						success : function( a ) {
							if( a == 0 ) {
								$("#notif").text("Max Reached");
								$("#join").hide();
							} else {
								if(join) {
									$("#notif").text(a + " slot"  
														+ (a != 1 ? "s" : "" ) 
														+ " remaining");
									$("#join").show();
									$("#leave").hide();
								} else {
									$("#notif").text("");
									$("#join").hide();
									$("#leave").show();
								}
							}
						}
					});
				}
			}
		
			function checkMin() {
				if( watchMin ) {
					$.ajax({
						url : "controller.php",
						method : "POST",
						data : {
							"request" : "min",
							"game" : game
						},
						success : function( a ) {
							if( a <= 0 ) {
								$("#notif").html("");
								$("#begin").show();
							} else {
								$("#notif").text("Missing " + a + " player"
												+ ( a > 1 ? "s" : "" ) );
								$("#begin").hide();
							}
						}
					});
				}
			}
		
			function checkOngoing() {
				if( watchOngoing ) {
					$.ajax({
						url : "controller.php",
						method : "POST",
						data : {
							"request" : "ongoing",
							"game" : game
						},
						success : function( a ) {
							a = a == '1';
							if( a ) {
								watchMax = false;
								watchMin = false;
								$("#notif").html("");
								$("#join").hide();
								$("#leave").hide();
								$("#begin").hide();
								$("#ongoing").text("Ongoing");
							} else {
								$("#ongoing").text("Not yet started");
								if( $("#join").length > 0) {
									watchMax = true;
									checkMax();
								} 
								if( $("#begin").length > 0 ) {
									watchMin = true;
									checkMin();
								}
							}
						}
					});
				}
			}
		
			$(document).ready(function() {
				$("#prompt").hide();
				
				updatePlayers();
				var update = setInterval(updatePlayers,1000);
				var minInterval = setInterval(checkMin,1000);
				var maxInterval = setInterval(checkMax,1000);
				var ongoingInterval = setInterval(checkOngoing,1000);
				
				$("#join").click(function() {
					$.ajax({
						url : "controller.php",
						method : "POST",
						data : {
							"request" : "join",
							"game" : game,
							"user" : user
						},
						success : function(a) {
							console.log(a);
							$("#promptContent")
								.text("You have joined the game!");
							$("#prompt").show();
							$("#join").hide();
							$("#leave").show();
							join = false;
						}
					});
				});
				
				$("#leave").click(function() {
					$.ajax({
						url : "controller.php",
						method : "POST",
						data : {
							"request" : "leave",
							"game" : game,
							"user" : user
						},
						success : function(a) {
							console.log(a);
							$("#promptContent")
								.text("You have left the game!");
							$("#prompt").show();
							$("#leave").hide();
							$("#join").show();
							join = true;
						}
					});
				});
				
				$("#begin").click(function() {
					$.ajax({
						url : "controller.php",
						method : "POST",
						data : {
							"request" : "begin",
							"game" : game
						},
						success : function(a) {
							console.log(a);
							$("#begin").hide();
						}
					});
				});
				
				$("#ok").click(function() {
					$("#prompt").hide(500);
				});
			});
		</script>
		<div id="prompt">
			<div id="promptContent"></div><br />
			<button id="ok" class="goldButton">Ok</button>
		</div>
		<div id="mainContent">
			<table id="gameDetails">
				<tr><th colspan='2' id="head">Game Details</th></tr>
				<tr><th colspan='2' id="gameOptions">
					<div id="notif"></div>
					<?php 
						$query = "SELECT G.id, M2.username FROM game G, "
									."gameplayers GP, member M, member M2 "
									."WHERE M2.id = G.host AND G.id = "
									."GP.gameId AND M.id = GP.memberID AND "
									."G.cancelled = FALSE AND G.ended IS "
									."NULL "
									."AND M.username = ?";
						$stmt = $conn->prepare($query);
						$stmt->bind_param("s",$_SESSION['avalonuser']);
						$stmt->bind_result($gameId, $gameHost);
						$stmt->execute();
						if( $stmt->fetch() ) {
							$stmt->close();
							if($gameId == $_GET['gameid']) {
								if( $gameHost == $_SESSION['avalonuser']) {
									echo "<button id=\"begin\" "
											."class=\"goldButton\">Begin "
											."Game</button>";
									echo "<script>watchMin = true;"
											."watchOngoing = true;"
											."checkMin(); checkOngoing();"
											."</script>";
								} else {
									echo "<button id=\"leave\" "
											."class=\"goldButton\">Leave "
											."Game</button>";
									echo "<button id=\"join\" "
											."class=\"goldButton\">Join "
											."Game</button>";
									echo "<script>$(\"#join\").hide();"
											."watchMax = true;join = false;"
											."watchOngoing = true;"
											."checkMax();checkOngoing();"
											."</script>";
								}
							} else {
								echo "<script>$(\"#notif\").html('You are "
										."already part of a game.<br />"
										."<a href=\"game.php?gameid=$gameId"
										."\">Click here to go to its page"
										."</a>');</script>";
							}
						} else {
							$stmt->close();
							echo "<button id=\"leave\" "
									."class=\"goldButton\">Leave Game"
									."</button>";
							echo "<button id=\"join\" class=\"goldButton\">"
									."Join Game</button>";
							echo "<script>$(\"#leave\").hide(); "
									."join = true; watchMax = true; "
									."watchOngoing = true;"
									."checkMax(); checkOngoing();</script>";
						}
						$conn->close();
					?>
				</th></tr>
				<tr>
					<th>Host:</th>
					<td><?php echo $host;?></td>
				</tr>
				<tr>
					<th>Hosted on:</th>
					<td><?php echo $hosted; ?></td>
				</tr>
				<?php
					if( $cancel ) { 
						echo "<tr>"
								."<th colspan = '2'>";
						echo $cancel == 0 ? "" 
										: "Cancelled";
						echo "</th>";
						echo "</tr>";
					} else {
						echo "<tr><th colspan = '2' id=\"ongoing\">";
						echo $ongoing == 0 ? "Not yet started" 
									: "Ongoing";
						echo "</th></tr>";
						echo "<tr><th "; 
						echo $ended == 0 ? "colspan = '2'>Not yet ended" 
								: ">Ended: ";
						echo "</th>";
						echo $ended == 0 ? "" : "<td>$ended</td>";
						echo "</tr>";
					}
				?>
				<tr><th colspan='2'><?php echo $fo ? "Friends-only" : "Community"; ?></th></tr>
				<tr><th colspan='2'>
					<?php echo ($min != $max ? "$min - $max": $max)
								." players"; ?>
				</th></tr>
				<tr>
					<th colspan='2'>Targeting <?php echo $target ? "enabled" : "disabled"; ?></th>
				</tr>
				<tr>
					<th colspan='2'>Lady of the Lake <?php echo $lady ? "enabled" : "disabled"; ?></th>
				</tr>
				<tr id="playerRow">
					<th>Players:</th>
					<td>
						<ul id="playerList"></ul>
					</td>
				</tr>
			</table>
		</div>
<?php
?>