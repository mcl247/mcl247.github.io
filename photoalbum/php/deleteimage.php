<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
  	<!--Static head-->
	<?php require '../static/head.php';?>
  </head>

	<body>
		<div id ="container">
			<h1>Photo Gallery</h1>
		</div><!--end of container div--> 
		<!--Static navigation bar-->   
		<?php require '../static/navigation.php'; 

		// Initialize database connection 
		require_once 'config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		// Set variable
		$deleteImageID=$_GET['imageID'];

		// Get image ID 
		if (isset($_GET['imageID'])){
			// Filter sanitize 
			$imageID = filter_input(INPUT_GET, 'imageID', FILTER_SANITIZE_STRING);

			$image= $mysqli -> query( "SELECT * FROM Images WHERE Images.imageID= $imageID");

			$result= $mysqli->query("SELECT *
	    	FROM Albums
	    	INNER JOIN Album_to_Image 
	    	ON Album_to_Image.albumID = Albums.albumID 
	    	INNER JOIN Images
	    	ON Images.imageID= Album_to_Image.imageID
	    	WHERE Album_to_Image.imageID=$imageID");
		}
		
		// Only allow deletion if user is logged-in, confirmation of deletion 
		if (isset($_SESSION['logged_user'])) {
			print "<h2>Confirm Deletion of Image:</h2>";
			print "<form method='post' action=''>
			<p>
				<input type='submit' name='deleteImage' value='Delete'><br>
			</p>
		</form>";
		// If user is not logged in 
		}  
		else { 
			print "<p class='click_link'><a href='login.php' class='click_link'>Log in </a>to delete this album.</p>";
		}

		// If delete image button is clicked 
		if (isset($_POST['deleteImage'])) {
			$deleted_image_title = $mysqli->query("SELECT Images.image_title FROM Images WHERE Images.imageID = $deleteImageID");
			$deleted_image = $mysqli->query("DELETE FROM Images WHERE Images.imageID = $deleteImageID");
			$deleted_connection = $mysqli->query("DELETE FROM Album_to_Image WHERE Album_to_Image.imageID = $deleteImageID");
			// Message for successful deletion 
			if($deleted_connection){
			print("<p>The image was successfully deleted!</p>");
			}
			// Error message for failed deletion 
			if(!$deleted_connection){
			print("<p>The image failed to be deleted.</p>");
			}
		}

	?>
	</body>
</html> 