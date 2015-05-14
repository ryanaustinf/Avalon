<?php
	session_start();
	require_once 'header.php';
	require_once "../avalondb.php";
	
	$query = "SELECT G.id, M2.username FROM game G, gameplayers GP, member M, "
				."member M2 WHERE M2.id = G.host AND G.id = GP.gameId AND M.id"
				." = GP.memberID AND G.cancelled = FALSE AND G.ended IS NULL "
				."AND M.username = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i",$_SESSION['avalonuser']);
	$stmt->bind_result($game,$host);
	$stmt->execute();
	$pending = null;
	$hosting=  null;
	
	if($stmt->fetch()) {
		$pending = true;
		if( $host == $_SESSION['avalonuser'] ) {
			$hosting = true;
		}
	} else {
		$pending = false;
	}
	$hosting = $hosting === null ? false : true;
	
	$stmt->close();
	$conn->close();
?>
		<script>	
			function updateToggleButtons() {
				if( $("#minPlayers").text() == 5 ) {
					$("#fewerMin").prop('disabled',true);
				} else {
					$("#fewerMin").prop('disabled',false);
				}

				if( $("#minPlayers").text() == $("#maxPlayers").text() ) {
					$("#moreMin").prop('disabled',true);
					$("#fewerMax").prop('disabled',true);
				} else {
					$("#moreMin").prop('disabled',false);
					$("#fewerMax").prop('disabled',false);
				}
				
				if( $("#maxPlayers").text() == 10 ) {
					$("#moreMax").prop('disabled',true);
				} else {
					$("#moreMax").prop('disabled',false);
				}							
			}
			
			$(document).ready(function() {
				<?php 
					if( $pending ) {
						$htmlStr = "";
						if( $hosting ) {
							$htmlStr .= "You are hosting a game<br />";
						} else {
							$htmlStr .= "You are part of a game<br />";
						}
						$htmlStr .= "<a href=\\\"game.php?gameid=$game\\\">"
										."Click here to go to its page</a>";
						echo "$(\"#promptContent\").html(\"$htmlStr\");";
						echo '$("input#host").hide();';
						echo '$("#ok").click(function() {'
								.'location = "/Avalon";'
								.'});';
					} else {
						echo '$("#prompt").hide();'; 
						echo '$("#ok").click(function() {'
								.'$("#prompt").hide(500);'
							.'});';
					}
				?>
				
				updateToggleButtons();
				
				$("#fewerMax").click(function() {
					$("span#maxPlayers").text($("#maxPlayers").text() * 1 - 1);
					updateToggleButtons();
					return false;
				});

				$("#moreMax").click(function() {
					$("span#maxPlayers").text($("#maxPlayers").text() * 1 + 1);
					updateToggleButtons();
					return false;
				});

				$("#fewerMin").click(function() {
					$("span#minPlayers").text($("#minPlayers").text() * 1 - 1);
					updateToggleButtons();
					return false;
				});

				$("#moreMin").click(function() {
					$("span#minPlayers").text($("#minPlayers").text() * 1 + 1);
					updateToggleButtons();
					return false;
				});

				$("form#hostGame").submit(function() {
					<?php 
						if( $pending ) {
							echo "return false;";
						}
					?>
					$("input#maxPlayers").val($("span#maxPlayers").text());
					$("input#minPlayers").val($("span#minPlayers").text());
				});
			});
		</script>
		<div id="prompt">
			<div id="promptContent"></div>
			<br />
			<button id="ok" class="goldButton">Ok</button>
		</div>
		<div id="mainContent">
			<form id="hostGame" action="game.php" method="post">
				<table id="hostTable">
					<tr><th colspan="2">
						Host Game
					</th></tr>
					<tr>
						<td class="hostLabel">
							<input type="radio" id="community" name="fo" value="false" required/>
							<label for="community">Community Game</label>
						</td>
						<td class="hostLeft">
							<input type="radio" id="friends" name="fo" value="true" required/>
							<label for="friends">Friends-Only Game</label>
						</td>
					</tr>
					<tr>
						<td class="hostLabel">Minimum Players:</td>
						<td class="hostLeft">
							<button id="fewerMin" class="goldButton">&lt;</button>
							<span id='minPlayers'>5</span>
							<button id="moreMin" class="goldButton">&gt;</button>
							<input type="hidden" name="min" id="minPlayers" />
						</td>
					</tr>
					<tr>
						<td class="hostLabel">Maximum Players:</td>
						<td class="hostLeft">
							<button id="fewerMax" class="goldButton">&lt;</button>
							<span id='maxPlayers'>10</span>
							<button id="moreMax" class="goldButton">&gt;</button>
							<input type="hidden" name="max" id="maxPlayers" />
						</td>
					</tr>
					<tr><td colspan="2">
						<input type="submit" id="host" class="goldButton" value="Host Game" /> 
					</td></tr>
				</table>
			</form>
		</div>
	</body>
</html>