<?php
	require_once "../avalondb.php";
?>
		<div id="mainContent">
			<div id="games">
				<div id="ongoing">Ongoing Games</div>
				<table>
					<tr>
						<th>Community Games</th>
						<th>Friends' Games</th>
					</tr>
					<tr>
						<td>
							<ul id="community">
								<?php 
									$query = "SELECT G.id, username, "
												."minPlayers,"
												." maxPlayers FROM game G,"
												." member M WHERE G.host ="
												." M.id AND G.friendsOnly"
												." = FALSE";
									$stmt = $conn->prepare($query);
									$stmt->bind_result($id,$uname,$min
														,$max);
									$stmt->execute();
									while( $stmt->fetch() ) {
										echo "<li><a href=\"game.php?gameid="
												."$id\">Game by $uname<br />"
												."$min - $max players"
												."</a>"
												."</li>";
									} 
									$stmt->close();
								?>
							</ul>
						</td>
						<td>
							<ul id="friends">
								<?php 
									$query = "SELECT G.id, username, "
												."minPlayers,"
												." maxPlayers FROM game G,"
												." member M WHERE G.host ="
												." M.id AND G.friendsOnly"
												." = TRUE";
									$stmt = $conn->prepare($query);
									$stmt->bind_result($id,$uname,$min
														,$max);
									$stmt->execute();
									while( $stmt->fetch() ) {
										echo "<li><a href=\"game.php?gameid="
												."$id\">Game by $uname<br />"
												."$min - $max players"
												."</a>"
												."</li>";
									} 
									$stmt->close();
									$conn->close();
								?>
							</ul>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>