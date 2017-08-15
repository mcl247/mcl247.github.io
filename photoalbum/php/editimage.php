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
		$editImageID=$_GET['imageID'];

		// If edit image button is clicked 
		if (isset($_POST['editImage'])) {
				// Filter input 
				$edited_image_title = trim(strip_tags(htmlentities($_POST['editedtitle'])));
				$edited_image_caption = trim(strip_tags(htmlentities($_POST['editedcaption'])));
			// If both fields are not empty 
			if((!empty($edited_image_title)) && (!empty($edited_image_caption))){
				// Match/validate fields and display error messages if violated 
				if(!preg_match("/^[A-Za-z0-9 ]{1,40}$/", $edited_image_title)){
				print("<p>Image title must only contain letters and numbers.</p>");
				}
				elseif (!preg_match("/^[A-Za-z0-9# ]{1,40}$/", $edited_image_caption)){
					print("<p>Image caption must only contain letters, numbers, and hashtags.</p>");
				}
				else {
					//Update images database 
					$edited_image = $mysqli->query("UPDATE Images SET Images.image_title = '$edited_image_title', Images.caption ='$edited_image_caption' WHERE Images.imageID = $editImageID");
					// If successfully edited
					if($edited_image){
					print("<p>The image was successfully edited</p>");
					}
					// If not successfully edited
					if(!$edited_image){
					print("<p>The image failed to be edited.</p>");
					}
					// If albums checkbox is checked 
					if (!empty($_POST['albums'])){
						$albums_selected = $_POST['albums'];

						$queryimage= $mysqli->query("SELECT * FROM Images WHERE imageID=$editImageID");
						//Loop through albums selected and add image into chosen album(s)
						foreach ($albums_selected as $album){
							$album1=(int)$album;
							$aiquery = "INSERT INTO Album_to_Image(connect, albumID, imageID) VALUES (NULL, '$album1', '$editImageID')";
							$addresult=$mysqli ->query($aiquery);
							
						}
						// If added successfuly 
						if($addresult){
							print("<p>and added successfully to the chosen album.</p>");
						}
					}
				}
			}
			// If not all fields are filled 
			else {
				print ("<p>Please fill in both fields");
			}
		}
		// Get image by image ID
		if (isset($_GET['imageID'])){
			// Filter input 
			$imageID = filter_input(INPUT_GET, 'imageID', FILTER_SANITIZE_STRING);
			// Select all from images table 
			$image= $mysqli -> query( "SELECT * FROM Images WHERE Images.imageID= $imageID");

			//Display full-size image 
		    echo "<div class='gallery'>";
			while ( $row = $image->fetch_assoc() ) {
				print ("<div class='imagecenter'>");
				print("<div class='individualpic'><img src='../".$row['file_path']."'></div>");
				print ("<div class='info'>");
				print ("<h3>".$row['image_title']."</h3>");
				print ("<p>".$row['caption']."</p>");
				print ("<p>".$row['credit']."</p>");
				print ("</div></div>");

			}
			echo '</div>';
		}

		// Edit is only allowed if user is logged in 
		if (isset($_SESSION['logged_user'])) {
			// Edit image form 
		?>
			<form method='post' action=''>
				<p>
					<label for='edit-image-field'>New Title: </label>
					<input id='edit-image-field' type='text' name='editedtitle' maxlength='40' ><br><br>
					<label for='edit-album-field'>New Caption: </label>
					<input id='photo-name-field' type='text' name='editedcaption' maxlength='40'><br><br>

					<?php 
						// Display albums checkboxes 
						$albumQuery = "SELECT * FROM Albums";
						$albumResults = $mysqli -> query($albumQuery);	
					    echo "<label id='select-albums-title'><b>Add to album(s):</b> </label><br><br>";
					    while ($row = $albumResults -> fetch_assoc()) {
					      	$albumId = $row['albumID'];
					      	$albumTitle = $row['title'];
					        echo "<input type='checkbox' name='albums[]' value='$albumId'> $albumTitle";
					    }
					?>
					<br><br>
					<input type='submit' name='editImage' value='Edit Image'><br>
				</p>
			</form>
	   <?php 
	   // If not logged in 
		} 
		else {
			print "<p class='click_link'><a href='login.php'>Log in </a>to edit this image.</p>";
		}

		?>
	</body>
</html> 