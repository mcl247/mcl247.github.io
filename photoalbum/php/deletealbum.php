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

		// Initialize database connecition
		require_once 'config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		// Set variable
		$deleteAlbumID=$_GET['albumID'];

		// Get album by album ID
		if (isset($_GET['albumID'])){
			$albumID = filter_input(INPUT_GET, 'albumID', FILTER_SANITIZE_STRING);

			$album= $mysqli -> query( "SELECT * FROM Albums WHERE Albums.albumID= $albumID");

			$result= $mysqli->query("SELECT *
	    	FROM Images 
	    	INNER JOIN Album_to_Image 
	    	ON Album_to_Image.imageID = Images.imageID 
	    	INNER JOIN Albums 
	    	ON Albums.albumID= Album_to_Image.albumID
	    	WHERE Album_to_Image.albumID=$albumID");		    
		}
		
		// Allow deletion only when user is logged in, deletion confirmation 
		if (isset($_SESSION['logged_user'])) {
			print "<h2>Confirm Deletion of Album:</h2>";
			print "<form method='post' action=''>
					<p>
						<input type='submit' name='deleteAlbum' value='Delete'><br>
					</p>
				  </form>";
		} 
		// If no user is logged in 
		else { 
			print "<p class='click_link'><a href='login.php' class='click_link'>Log in </a>to delete this album.</p>";
		}

		// If delete button is clicked
		if (isset($_POST['deleteAlbum'])) {
			$deleted_album_title = $mysqli->query("SELECT Albums.title FROM Albums WHERE Albums.albumID = $deleteAlbumID");
			$deleted_album = $mysqli->query("DELETE FROM Albums WHERE Albums.albumID = $deleteAlbumID");
			$deleted_connection = $mysqli->query("DELETE FROM Album_to_Image WHERE Album_to_Image.albumID = $deleteAlbumID");
			// Successful deletion
			if($deleted_connection){
			print("<p>The album was successfully deleted!</p>");
			}
			// Failed deletion 
			if(!$deleted_connection){
			print("<p>The album failed to be deleted.</p>");
			}				
		}
	?>
	</body>
</html> 