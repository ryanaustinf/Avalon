<?php
	session_start();
	require_once "header.php";
?>
<script>
	var from = "<?php echo $_SESSION['avalonuser']; ?>";

	$(document).ready(function() {
		$("[id^='accept']").click(function() {
			var to = $(this).attr("id");
			to = to.substring(6);
			$.ajax({
				url : "controller.php",
				method : "POST",
				data : {
					"request" : "accept",
					"from" : from,
					"to" : to
				},
				success : function(a) {
					$("#friend" + to).html(to + "'s Friend Request Accepted");
				}
			});
		});

		$("[id^='block']").click(function() {
			var to = $(this).attr("id");
			to = to.substring(5);
			$.ajax({
				url : "controller.php",
				method : "POST",
				data : {
					"request" : "block",
					"from" : from,
					"to" : to,
					"insert" : "false"
				},
				success : function(a) {
					$("#friend" + to).html(to + " Blocked");
				}
			});
		});
	});
</script>
<div id="mainContent" class="friendRequests">
	<?php 
		$query = "SELECT M.username FROM friends F, member M WHERE "
					."F.fromMember = M.id AND F.toMember = (SELECT "
					."id FROM member WHERE username = ?) AND approved IS NULL";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s",$_SESSION['avalonuser']);
		$stmt->bind_result($friend);
		$stmt->execute();
		$requests = 0;
		while( $stmt->fetch() ) {
			echo "<div id=\"friend$friend\">\n"
					."Request by: $friend<br />"
					."<button id=\"accept$friend\" class=\"goldButton\">Accept"
					."</button>"
					."<button id=\"block$friend\" class=\"goldButton\">Block"
					."</button>\n"
					."</div>";
			$requests++;
		}
		
		if( $requests === 0 ) {
			echo "<div id=\"friend\">No Friend Requests</div>";
		}
	?>
</div>
