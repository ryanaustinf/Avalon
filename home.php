<?php
	require_once "../avalondb.php";
?>
		<div id="mainContent">
			<div id="games">
				<div id="pending">Pending Games</div>
				<table id="gameContainer">
					<tr>
						<th>Community Games</th>
						<th>Friends' Games</th>
					</tr>
					<tr>
						<td>
							<table id="community" class="gameList">
								<?php 
									$query = "SELECT G.id, username, "
												."minPlayers,"
												." maxPlayers FROM game G,"
												." member M WHERE G.host ="
												." M.id AND G.friendsOnly"
												." = FALSE AND cancelled = "
												."FALSE AND ongoing = FALSE"
												." AND ended IS NULL";
									$stmt = $conn->prepare($query);
									$stmt->bind_result($id,$uname,$min
														,$max);
									$stmt->execute();
									while( $stmt->fetch() ) {
										echo "<tr><td>Game by <a href=\"user"
												.".php?uname=$uname\">$uname"
												."</a><br />"
												.($min != $max ? "$min - $max" 
													: $max)
												." players<br />"
												."<a href=\"game.php?gameid="
												."$id\" class=\"goldButton\">"
												."View Game</a>"
												."</td></tr>";
									} 
									$stmt->close();
								?>
							</table>
						</td>
						<td>
							<table id="friends" class="gameList">
								<?php 
									$query = "SELECT G.id, username, "
												."minPlayers,"
												." maxPlayers FROM game G,"
												." member M WHERE G.host ="
												." M.id AND G.friendsOnly"
												." = TRUE AND cancelled = "
												."FALSE AND ongoing = FALSE"
												." AND ended IS NULL";
									$stmt = $conn->prepare($query);
									$stmt->bind_result($id,$uname,$min
														,$max);
									$stmt->execute();
									while( $stmt->fetch() ) {
										echo "<tr><td>Game by <a href=\"user"
												.".php?uname=$uname\">$uname"
												."</a><br />"
												.($min != $max ? "$min - $max" 
													: $max)
												." players<br />"
												."<a href=\"game.php?gameid="
												."$id\" class=\"goldButton\">"
												."View Game</a>"
												."</td></tr>";
									} 
									$stmt->close();
									$conn->close();
								?>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>