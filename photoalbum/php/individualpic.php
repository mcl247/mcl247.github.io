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

		// Get image by image ID
		if (isset($_GET['imageID'])){
			// Filter sanitize 
			$imageID = filter_input(INPUT_GET, 'imageID', FILTER_SANITIZE_STRING);
			$albumID = filter_input(INPUT_GET, 'albumID', FILTER_SANITIZE_STRING);

			$image= $mysqli -> query( "SELECT * FROM Images WHERE Images.imageID= $imageID");

			// Display full-sized individual image
		    echo "<div class='gallery'>";
			while ( $row = $image->fetch_assoc() ) {
				print ("<div class='imagecenter'>");
				print ("<div class='individualpic'><img src='../".$row['file_path']."'></div>");
				print ("<div class='info'>");
				print ("<h2>".$row['image_title']."</h2>");
				print ("<p>".$row['caption']."</p>");
				print ("<p>".$row['credit']."</p>");		
			}
		}

		// Get image by image ID
		if (isset($_GET['imageID'])){
			// Filter sanitize 
			$imageID = filter_input(INPUT_GET, 'imageID', FILTER_SANITIZE_STRING);
			$title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING);

			$result= $mysqli->query("SELECT DISTINCT Images.imageID, Albums.albumID, Albums.title, Images.file_path, Images.image_title, Images.caption, Images.credit
	    	FROM Albums
	    	INNER JOIN Album_to_Image 
	    	ON Album_to_Image.albumID = Albums.albumID 
	    	INNER JOIN Images
	    	ON Images.imageID= Album_to_Image.imageID
	    	WHERE Album_to_Image.imageID=$imageID");

			// Show which album the image is a part of
		    print ("<h3>This image is part of album: </h3>");
			while ( $row = $result->fetch_assoc() ) {	
				print ("<a href="."../php/images.php?albumID=".$row['albumID'].">");		
				print ("<p>".$row['title']."</p>");
				
			}
		}

		// Get image by image ID
		if (isset($_GET['imageID'])){
			// Filter sanitize 
			$imageID = filter_input(INPUT_GET, 'imageID', FILTER_SANITIZE_STRING);
			$albumID = filter_input(INPUT_GET, 'albumID', FILTER_SANITIZE_STRING);

			$image= $mysqli -> query( "SELECT * FROM Images WHERE Images.imageID= $imageID");

			// Show edit/delete options 
			while ( $row = $image->fetch_assoc() ) {
				print ("<p class='click_link'><a href="."../php/editimage.php?imageID=".$row['imageID'].">Edit This Image</a></p>");
				print ("<p class='click_link'><a href="."../php/deleteimage.php?imageID=".$imageID.">Delete This Image</a></p>");	
			}
		print ("</div></div>");
		echo '</div>';
		}
			
	    ?> 