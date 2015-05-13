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
									$query = "SELECT G.id, username, minPlaye"
												."rs, maxPlayers FROM game G, "
												."member M1 WHERE G.host = "
												."M1.id AND G.friendsOnly = "
												."FALSE AND cancelled = FALSE"
												." AND ongoing = FALSE AND "
												."ended IS NULL AND M1.id NOT"
												." IN (SELECT id FROM member "
												."M2, friends F WHERE M2.id = "
												."F.toMember AND F.fromMember " 
												."= (SELECT id FROM member WHE"
												."RE username = ?) AND approve"
												."d = 0 ) AND M1.id NOT IN (SE"
												."LECT id FROM member M2, "
												."friends F WHERE M2.id = F.fro"
												."mMember AND F.toMember = ("
												."SELECT id FROM member WHERE "
												."username = ?) AND approved "
												."= 0 )";
									$stmt = $conn->prepare($query);
									$stmt->bind_param("ss"
											,$_SESSION['avalonuser']
											,$_SESSION['avalonuser']);
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
									$query = "SELECT G.id, username, minPlaye"
												."rs, maxPlayers FROM game G, "
												."member M1 WHERE G.host = "
												."M1.id AND G.friendsOnly = "
												."TRUE AND cancelled = FALSE"
												." AND ongoing = FALSE AND "
												."ended IS NULL AND M1.id "
												." IN (SELECT id FROM member "
												."M2, friends F WHERE M2.id = "
												."F.toMember AND F.fromMember " 
												."= (SELECT id FROM member WHE"
												."RE username = ?) AND approve"
												."d = 1 )";
									$stmt = $conn->prepare($query);
									$stmt->bind_param("s"
											,$_SESSION['avalonuser']);
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