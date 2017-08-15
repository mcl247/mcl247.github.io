<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
  	<!--Static head-->
	<?php require '../static/head.php';?>
  </head>

	<body>
		<div id ="container">
			<h1>Add Albums</h1>
		</div><!--end of container div--> 
		<!--Static navigation bar-->
		<?php require '../static/navigation.php';

		// Initialize database connection 
		require_once '../php/config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		// Check for error  
		if ($mysqli->errno) {
			echo $mysqli->error;
		}
		
		// If submit button is clicked 
		if(isset($_POST['submit'])){
			// Set variables
			$title = trim(htmlentities(strip_tags($_POST['addalbum'])));
			$description = trim(htmlentities(strip_tags($_POST['description'])));
			// Match and validate input 
			if(!preg_match("/^[A-Za-z0-9]{1,40}$/", $title)){
				print("<p>Album must only contain letters and numbers.</p>");
			}
			// If input matches, add entry into Albums database 
			else { 
				$query = "INSERT INTO Albums (title, description, date_created, date_modified) VALUES ('$title', '$description', now(), now())";
				$result= $mysqli->query($query);
				if($result){
				print("<p>The album was added successfully.</p>");
				}
				if(!$result){
				print("<p>There was an error processing your album request.</p>");
				}
			}		
		}
	// Only display add form if user is logged in 
	if (isset($_SESSION['logged_user'])) {
	?>
		<form action="add.php" method="post">
			<div class ="add_album">
				<h2>Add Album</h2> 
				<div class = "label">
					<label>Album Title:</label>
						<input type="text" name="addalbum" />
				</div><!-- end of label div -->
				<div class = "label">
					<label>Album Description:</label>
						<input type="text" name="description" />
				</div><!-- end of label div -->
				<div class = "submit">
					<input type="submit" name = "submit" value="Add" />
				</div><!-- end of submit div -->
			</div> <!-- end of add_album div -->
		</form><!-- End of form-->
	<?php 
	 }
	 // If no logged in user 
	 else {
	 	print "<p class='click_link'><a href='login.php'>Log in </a>to add an album.</p>";
	 }
 ?>
</body>
</html>
