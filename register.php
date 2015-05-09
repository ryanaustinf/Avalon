<!DOCTYPE PHP>
<html>
	<head>
		<title>Avalon Online</title>
		<link rel="stylesheet" href="external.css" />
		<script src="jquery-2.1.1.js"></script>
		<script>
			$(document).ready(function() {
				$("#prompt").hide();
				
				$("form#register").submit(function() {
					var errors = "";
					var p1 = $("#pass").val();
					var p2 = $("#cpass").val();
					if( p1 != p2 ) {
						errors += "Passwords don't match.";
					} 

					if( errors.length != 0 ) {
						$("#promptContent").text(errors);
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
		<div id="mainContent">
			<h1>Welcome to Avalon Online</h1>
			<form id="register" action="controller.php" method="post">
				<table>
					<tr><h1>Register</h1></tr>
					<tr>
						<td>
							<input type="text" class="input" placeholder="First Name" name="fname" required />
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" class="input" placeholder="Last Name" name="lname" required />
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" class="input" placeholder="Username" name="uname" required />
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" class="input" placeholder="Password" name="pass" id="pass" required />
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" class="input" placeholder="Confirm Password" id="cpass" required />
						</td>
					</tr>
					<tr><td id="biolabel">Bio:</td></tr>
					<tr>
						<td>
							<textarea id="textarea"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" value="Register" id="register" />
						</td>
					</tr>
				</table>
			</form>
		</div>