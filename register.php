<?php
	if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		require_once "../avalondb.php";
		$query = "INSERT INTO member(firstName,lastName,username,password,bio) "
					."VALUES(?,?,?,?,?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("sssss",$_POST['fname'],$_POST['lname']
							,$_POST['uname'],$pass,$_POST['bio']);
		$pass = hash("md5","Arthur".$_POST['pass']."Guinevere");
		$stmt->execute();
	}
?>
<!DOCTYPE PHP>
<html>
	<head>
		<title>Avalon Online</title>
		<link rel="stylesheet" href="external.css" />
		<script src="jquery-2.1.1.js"></script>
		<script>
			function checkPass() {
				var p1 = $("#pass").val();
				var p2 = $("#cpass").val();
				if( p1.length > 0 && p2.length > 0 ) {
					$("#match").text( p1 != p2 ? "Passwords don't match." : "");
				} 
				return (p1 != p2 ? "Passwords don't match." : "");
			}
			$(document).ready(function() {
				$("#prompt").hide();
				$("#pass").on('input',checkPass);
				$("#cpass").on('input',checkPass);
				
				$("#uname").on('input',function() {
					$.ajax({
						url : "controller.php",
						method : "POST",
						data : {
							'request' : 'username',
							'uname' : $("#uname").val()
						},
						success : function(a) {
							a = a == 'true';
							$("#taken").text( a ? "Username is taken" : "" );
						} 
					});
				});
				
				$("form#register").submit(function() {
					var errors = $("#taken").text();
					errors += (errors.length == 0 ? "" : "<br />") 
								+ $("#match").text();

					if( errors.length != 0 ) {
						$("#promptContent").html(errors);
						$("#prompt").show(500);
						return false;
					} else {
						return true;
					}
				});

				$("#ok").click(function() {
					$("#prompt").hide(500);
				});
			});
		</script>
	</head>
	<body>
		<div id="prompt">
			<div id="promptContent"></div>
			<button id="ok">Ok</button>
		</div>
		<div id="mainContent" class="mainRegister">
			<h1>Welcome to Avalon Online</h1>
			<form id="register" action="register.php" method="post">
				<table>
					<tr><h1>Register</h1></tr>
					<tr><td>
							<input type="text" class="input" placeholder="First Name" name="fname" required />
					</td></tr>
					<tr><td>
							<input type="text" class="input" placeholder="Last Name" name="lname" required />
					</td></tr>
					<tr><td>
							<input type="text" class="input" placeholder="Username" name="uname" id="uname" required />
					</td></tr>
					<tr><td>
							<span id="taken"></span>
					</td></tr>
					<tr><td>
							<input type="password" class="input" placeholder="Password" name="pass" id="pass" required />
					</td></tr>
					<tr><td>
							<input type="password" class="input" placeholder="Confirm Password" id="cpass" required />
					</td></tr>
					<tr><td>
							<span id="match"></span>
					</td></tr>
					<tr><td id="biolabel">Bio:</td></tr>
					<tr><td>
							<textarea id="textarea" name="bio"></textarea>
					</td></tr>
					<tr><td>
							<input type="submit" value="Register" id="register" />
					</td></tr>
				</table>
			</form>
		</div>
	</body>
</html>