		<div id="mainContent">
			<table id="gameDetails">
				<tr><th colspan='2' id="head">Game Details</th></tr>
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
						echo "<tr><th colspan = '2'>";
						echo $ongoing == 0 ? "Not yet started" 
									: "Ongoing: ";
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
					<?php 
						$query = "SELECT username FROM gamePlayers GP, "
									."member M WHERE GP.gameId = ? "
									."AND M.id = GP.memberId";
						$stmt = $conn->prepare($query);
						$stmt->bind_param("i",$_GET['gameid']);
						$stmt->bind_result($uname);
						$stmt->execute();
						$stmt->fetch();
						echo "<td><a href=\"user.php?uname=$uname\">$uname"
								."</a></td>\n</tr>";
						
						while( $stmt->fetch() ) {
							echo "<tr><th></th><td><a href=\"user.php?uname="
									."$uname\">$uname</a></td></tr>";
						}
					?>
			</table>
		</div>
<?php
?>