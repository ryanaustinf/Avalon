<?php
	session_start();
	require_once "header.php";
	require_once "sendHome.php"; 
?>
		<script> 
			var game = <?php echo $_GET['gameid']; ?>;
			var user = "<?php echo $_SESSION['avalonuser']; ?>";
			
		
			$(document).ready(function() {
				
				
				
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
		</div>
	</body>
</html>