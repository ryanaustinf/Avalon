<?php
	require_once "commons/header.php"
?>
		<script src="assets/js/register.js"></script>
		<div id="prompt">
			<div id="promptContent"></div><br />
			<button id="ok" class="goldButton">Ok</button>
		</div>
		<div id="mainContent" class="mainRegister">
			<div id="register">
				<form action="includes/controller.php" method="post">
					<input type="hidden" name="request" value="register" />
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
				<form action="includes/controller.php" method="post">
					<input type="hidden" name="request" value="login"/>
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