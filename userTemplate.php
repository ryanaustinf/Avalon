<script>
	var from = <?php echo '"'.$_SESSION['avalonuser'].'"';?>;
	var to = <?php echo '"'.$uname.'"'; ?>;
	var insert = null;
	
	$(document).ready(function() {
		$("#friend").click(function() {
			$.ajax({
				url : "controller.php",
				method : "POST",
				data : {
					"request" : "friend",
					"from" : from,
					"to" : to
				},
				success : function(a) {
					console.log(a);
					$("#friend").text("Friend Request Sent")
						.prop('disabled',true);
				}
			});
		});

		$("#accept").click(function() {
			$.ajax({
				url : "controller.php",
				method : "POST",
				data : {
					"request" : "accept",
					"from" : from,
					"to" : to
				},
				success : function(a) {
					console.log(a);
					$("#accept").text("Friend Request Accepted")
						.prop('disabled',true);
				}
			});
		});

		$("#block").click(function() {
			$.ajax({
				url : "controller.php",
				method : "POST",
				data : {
					"request" : "block",
					"from" : from,
					"to" : to,
					"insert" : insert
				},
				success : function(a) {
					console.log(a);
					$("#block").text("Member Blocked")
						.prop('disabled',true);
				}
			});
		});
	});
</script>
<div id="mainContent">
	<table id="userInfo">
		<tr>
			<th colspan="2"><?php echo "$uname's User Profile"; ?></th>
		</tr>
		<tr>
			<td id="userActions" colspan="2">
				<ul id="userActions">
					<?php
						if( $uname != $_SESSION['avalonuser'] ) {
							$query = "SELECT M1.username AS `fromMember`, "
										."M2.username AS `toMember`, approved "
										."FROM friends F, member M1, member M2 " 
										."WHERE fromMember = M1.id AND toMember"
										." = M2.id AND M1.username = ? AND "
										."M2.username = ?";
							$stmt = $conn->prepare($query);
							$stmt->bind_param("ss",$_SESSION['avalonuser']
												,$uname);
							$stmt->bind_result($from,$to,$status);
							$stmt->execute();
							if( $stmt->fetch() ) {
								if ($status === null) {
									echo "Friend request pending";
								} elseif( $status === 1 ) {
									echo "Friended";
								} elseif ($status === 0 ) {
									echo "This member has blocked you";
								}
							} else {
								$stmt->bind_param("ss",$uname
													,$_SESSION['avalonuser'] );
								$stmt->execute();
								if( $stmt->fetch() ) {
									if( $status === 0 ) {
										echo "You have blocked this member";
									} elseif( $status === null ) {
										echo "<li><button id=\"accept\" class="
												."\"goldButton\">Accept Friend"
												." Request</button></li>";
										echo "<script>insert = false</script>";
									} elseif($status === 1 ) {
										echo "Friended";
									}
								} else {
									$status = null;
									echo "<li><button id=\"friend\" class=\"go"
											."ldButton\">Friend Member</button"
											."></li>";
									echo "<script>insert = true</script>";
								}
								
								if( $status === null ) {
									echo "<li><button id=\"block\" class=\"go"
											."ldButton\">Block &nbsp;Member</b"
											."utton></li>";
								}
							}
						}
					?>
					<!-- <li><button id="friend">Flag User</button></li> -->
				</ul>
			</td>
		<tr>
			<th>Name:</th>
			<td><?php echo "$fname $lname"; ?></td>
		</tr>
		<tr>
			<th>Bio:</th>
			<td><?php echo $bio; ?>
		</tr>
		<tr>
			<th>Games Played:</th>
			<td><?php echo $gameCtr; ?>
		</tr>
		<tr>
			<th>Player Level:</th>
			<td><?php echo ($gameCtr >=250 ? "Gold" : ( $gameCtr >= 125 
								? "Silver" : ( $gameCtr >= 50 ? "Bronze" 
								: "Normal" ) ) ); ?></td>
		</tr>
		<tr>
			<th>User Level:</th>
			<td>
				<?php 
					echo ($admin !== null ? "Admin" : ( $moder != null 
							? "Moderator" : "Regular Member") );
					$conn->close();
				?>
		</tr>
	</table>
</div>