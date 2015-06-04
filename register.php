<?php
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bio']) ) {
		$_SESSION['faillogin'] = false;
		require_once "../avalondb.php";
		$query = "INSERT INTO member(firstName,lastName,username,password,bio) "
					."VALUES(?,?,?,?,?)";
		$stmt = $conn->prepare($query);
		$bio = "";
		for( $i = 0; $i < strlen($_POST['bio']); $i++ ) {
			$c = substr($_POST['bio'],$i,1);
			$bio .= ( $c === "\n" ? "<br />" : $c );
		}
		$stmt->bind_param("sssss",$_POST['fname'],$_POST['lname']
							,$_POST['uname'],$pass,$bio);
		$pass = hash("md5","Arthur".$_POST['pass']."Guinevere");
		$stmt->execute();
		$stmt->close();
		$conn->close();
	}
	require_once "header.php"
?>
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
					if( $("#uname").val().length > 0 ) {
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
					} else {
						$("#taken").text("");
					}
				});
				
				$("#luname").on('input',function() {
					if( $("#luname").val().length > 0 ) {
						$.ajax({
							url : "controller.php",
							method : "POST",
							data : {
								'request' : 'username',
								'uname' : $("#luname").val()
							},
							success : function(a) {
								a = a != 'true';
								$("#exists").text( a ? "Username is not regis" 
													+ "tered" : "" );
							} 
						});
					} else {
						$("#exists").text("");
					}
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

				$("form#login").submit(function() {
					var errors = $("#exists").text();

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
		<div id="prompt">
			<div id="promptContent"></div><br />
			<button id="ok" class="goldButton">Ok</button>
		</div>
		<div id="mainContent" class="mainRegister">
			<div id="register">
				<form action="register.php" method="post">
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
								<input type="submit" value="Register" id="register" class="goldButton" />
						</td></tr>
					</table>
				</form>
			</div>
			<div id="login">
				<form action="/Avalon/" method="post">
					<table>
						<tr><h1>Login</h1></tr>
						<tr><td>
							<?php
								$value = "";
								if( $_SESSION['faillogin'] ) {
									$value = 'value="'.$_POST['uname'].'"';
								}
								echo '<input type="text" class="input" placeholder="Username" name="uname" id="luname" '.$value.' required />';
							?>
						</td></tr>
						<tr><td>
							<span id="exists"></span>
						</td></tr>
						<tr><td>
							<input type="password" class="input" placeholder="Password" name="pass" id="lpass" required />
						</td></tr>
						<tr><td>
							<span id="invalid">
								<?php echo ($_SESSION['faillogin'] ? "Incorrect Password" : ""); ?>
							</span>
						</td></tr>
						<tr><td>
							<input type="submit" value="Login" id="login" class="goldButton" />
						</td></tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>