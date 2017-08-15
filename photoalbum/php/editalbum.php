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
		$editAlbumID=$_GET['albumID'];

		// If edit album button is clicked 
		if (isset($_POST['editAlbum'])) {
				// Filter input 
				$edited_album_title = trim(strip_tags(htmlentities($_POST['editedtitle'])));
				$edited_album_description= trim(strip_tags(htmlentities($_POST['editeddescription'])));
			if((!empty($edited_album_title)) && (!empty($edited_album_description))){
				// Match and validate input
				if(!preg_match("/^[A-Za-z0-9 ]{1,40}$/", $edited_album_title)){
				print("<p>Album title must only contain letters and numbers.</p>");
				}	
				elseif (!preg_match("/^[A-Za-z0-9 ]{1,100}$/", $edited_album_description)){
					print("<p>Album description must only contain letters and numbers.</p>");
				}
				// If input matches, update album 
				else { 
					$edited_album = $mysqli->query("UPDATE Albums SET Albums.title = '$edited_album_title', Albums.description = '$edited_album_description' WHERE Albums.albumID = $editAlbumID");
					// If successfully edited
					if($edited_album){
					print("<p>The album was successfully edited</p>");
					}
					// If not successfully edited 
					if(!$edited_album){
					print("<p>The album failed to be edited.</p>");
					}
					// If images checkbox is checked 
					if (!empty($_POST['images'])){
						$images_selected = $_POST['images'];
						
						$queryalbum= $mysqli->query("SELECT * FROM Albums WHERE albumID=$editAlbumID");
						// Loop through images selected and delete chosen image from album 
						foreach ($images_selected as $image){
							$image1=(int)$image;
							$iquery = "DELETE FROM Album_to_Image WHERE Album_to_Image.albumID =$editAlbumID AND Album_to_Image.imageID =$image1";
							$deleteresult=$mysqli ->query($iquery);
							// If deleted successuly
							if($deleteresult){
							print("<p>and the image chosen was successfully deleted from the album.</p>");
							}
						}
					}
				// If images checkbox is checked 
				if (!empty($_POST['addimage'])){
					$images_selected = $_POST['addimage'];
					
					$queryalbum= $mysqli->query("SELECT * FROM Albums WHERE albumID=$editAlbumID");
					// Loop through images selected and delete chosen image from album 
					foreach ($images_selected as $image){
						$image1=(int)$image;
						$iquery = "INSERT INTO Album_to_Image (connect, albumID, imageID) VALUES (NULL, '$editAlbumID', '$image1')";
						$addresult=$mysqli ->query($iquery);
						// If deleted successuly
						if($addresult){
						print("<p>and the image chosen was successfully added to the album.</p>");
						}
					}
				}
				}	
				
			}
			// If not all fields are filled 
			else {
				print ("<p>Please fill in both fields");
			}	
		}
		// Get album by album ID
		if (isset($_GET['albumID'])){
			// Filter sanitize
			$albumID = filter_input(INPUT_GET, 'albumID', FILTER_SANITIZE_STRING);

			$result= $mysqli->query("SELECT *
	    	FROM Images 
	    	INNER JOIN Album_to_Image 
	    	ON Album_to_Image.imageID = Images.imageID 
	    	INNER JOIN Albums 
	    	ON Albums.albumID= Album_to_Image.albumID
	    	WHERE Album_to_Image.albumID=$albumID");

			// Display images in album 
		    echo "<div class='gallery'>";
		    // Display album images 
			while ( $row = $result->fetch_assoc() ) {
				print ("<div class='entry'>");
				print ("<a href="."../php/individualpic.php?imageID=".$row['imageID'].">");
				print ("<div class='thumb'><img src='../".$row['file_path']."'></div>");
				print ("<div class='info'>");
				print ("<h3>".$row['image_title']."</h3>");
				print ("<p>".$row['caption']."</p>");
				print ("<p>".$row['credit']."</p>");
				print ("</div></a></div>");
			}
		echo '</div>';
		}
		
		// Only allow editing if user is logged in 
		if (isset($_SESSION['logged_user'])) {
			// Edit album form 
		?>
			<form method='post' action=''>
				<p>
					<label for='edit-album-field'>New Title: </label>
					<input id='edit-album-field' type='text' name='editedtitle' maxlength='40' ><br><br>
					<label for='edit-album-field'>New Description: </label>
					<input id='photo-name-field' type='text' name='editeddescription' maxlength='40'><br><br>
					<?php 

						// Get albumID by connection database tables 
						if (isset($_GET['albumID'])){
							$albumID = filter_input(INPUT_GET, 'albumID', FILTER_SANITIZE_STRING);

							$imageQuery = "SELECT * 
							FROM Images 
							INNER JOIN Album_to_Image 
							ON Album_to_Image.imageID = Images.imageID
							INNER JOIN Albums
							ON Albums.albumID = Album_to_Image.albumID
							WHERE Album_to_Image.albumID = $albumID";

							// Show images checkboxes 
							$imageResults = $mysqli -> query($imageQuery);	
						    echo "<label id='select-albums-title'><b>Delete image(s) from this album:</b> </label><br><br>";
						    while ($row = $imageResults -> fetch_assoc()) {
						      	$imageId = $row['imageID'];
						      	$imageTitle = $row['image_title'];
						        echo "<input type='checkbox' name='images[]' value='$imageId'> $imageTitle";
						    }
						    echo "<br><br>";

						}

						$addimageQuery = "SELECT * 
							FROM Images";
						// Show images checkboxes 
							$addimageResults = $mysqli -> query($addimageQuery);	
						    echo "<label id='select-albums-title'><b>Add image(s) to this album:</b> </label><br><br>";
						    // echo "<select>";
						    while ($row = $addimageResults -> fetch_assoc()) {
						      	$imageId = $row['imageID'];
						      	$imageTitle = $row['image_title'];
						      	echo "<input type='checkbox' name='addimage[]' value='$imageId'> $imageTitle";
						    }
					?>
					<br><br>
					<input type='submit' name='editAlbum' value='Edit Album'><br>
				</p>
			</form>
		<?php
		} 
		// If no user is logged in 
		else { 
			print "<p class='click_link'><a href='login.php' class='click_link'>Log in </a>to edit this album.</p>";
		}
	?>
	</body>
</html> 