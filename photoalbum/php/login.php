<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
  	<!--Static head-->
	<?php require '../static/head.php';?>
  </head>

	<body>
		<div id ="container">
			<h1>Login Form</h1>
		</div><!--end of container div--> 
		<!--Static navigation bar-->
		<?php require '../static/navigation.php';

			//If "log out" button is pressed, log out and destroy session 
			if (isset($_POST['logout']) && isset($_SESSION['logged_user'])) { 
				$olduser = $_SESSION['logged_user'];
				//Log the user out
				unset($_SESSION['logged_user']); 
				unset($_SESSION);
				$_SESSION=array();
				session_destroy();
				print("<p>You are now logged out, $olduser.</p>");
				//Officially logged out, link to login form 
				print("<p class ='click_link'>Return to the <a href='login.php'>login form.</a></p>");
			} 
			else {
				// Sanitize input for username and password 
				$username = trim(strip_tags(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING))); 
				$password = trim(strip_tags(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));

				// User is not logged in, display login form 
				if (!isset($_SESSION['logged_user']) && (empty($username) || empty($password))) { 
			?>
					<form action='login.php' method='post'>
						<div class ='login'>
							<h2>Admin Login</h2>
							<div class ='label'>
								<label>Username:</label>
									<input type='text' name='username'><br><br>
							</div>
							<div class ='label'>
								<label>Password:</label>
									<input type='password' name='password'><br><br>
							</div>
							<div class ='submit'>
								<input type='submit' value='login'>
							</div>
						</div>
					</form>
			<?php
				} 
				else {
					// Initialize database connection
					require_once 'config.php';
					$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

					// Check database connection
					if($mysqli->connect_errno) {
						echo "Failed to connect to database";
					}
					// Query from User database 
					$query = "SELECT * FROM User WHERE User.username = ? AND User.password = ?";
					// Prepare statements to prevent SQL injections 
					$stmt = $mysqli->stmt_init();
					if ($stmt->prepare($query)){
						$stmt->bind_param('ss', $username, $password);
						$stmt->execute ();
						$result=$stmt-> get_result();
					}
					// Check if only one username =$username
					if ($result && $result->num_rows == 1) {
						$row = $result->fetch_assoc();
						//Hash the password
						$hashed_password = password_hash("$password", PASSWORD_DEFAULT);
						// Verify database password = hashed password
						if (password_verify($password, $hashed_password)) {
							$_SESSION['logged_user'] = $row['username'];
						}
					}
					// Close database connection
					$mysqli->close(); 

					// If user is successfully logged in 
					if (isset($_SESSION['logged_user'])) { 
						$logged_user = $_SESSION['logged_user']; 
						print "<p>Welcome, $logged_user!</p>";
						//Show log out form 
						?> 
						<form name='logoutForm' action='login.php' method='post'>
							<div class ='submit'>
							    <input type='submit' name='logout' value='logout'>
							</div>
						</form>
					<?php
					// If login information is incorrect 
					} 
					else { 
						print "<p>Incorrect username or password.</p>";
						print "<p class='click_link'>Please <a href='login.php'>try again</a>.</p>";
					}
				} 
			}
		?>
	</body>
</html>