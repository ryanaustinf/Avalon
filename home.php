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
										echo "<tr><td><a href=\"game.php?gameid="
												."$id\">Game by $uname<br />"
												.($min != $max ? "$min - $max" 
													: $max)
												." players"
												."</a>"
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
										echo "<tr><td><a href=\"game.php?gameid="
												."$id\">Game by $uname<br />"
												.($min != $max ? "$min - $max" 
													: $max)
												." players"
												."</a>"
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