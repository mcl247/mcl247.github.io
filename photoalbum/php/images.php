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

			// Get album ID 
			if (isset($_GET['albumID'])){
				// Filter sanitize 
				$albumID = filter_input(INPUT_GET, 'albumID', FILTER_SANITIZE_STRING);

				$album= $mysqli -> query( "SELECT * FROM Albums WHERE Albums.albumID= $albumID");

				$result= $mysqli->query("SELECT *
		    	FROM Images 
		    	INNER JOIN Album_to_Image 
		    	ON Album_to_Image.imageID = Images.imageID 
		    	INNER JOIN Albums 
		    	ON Albums.albumID= Album_to_Image.albumID
		    	WHERE Album_to_Image.albumID=$albumID");

				// Display images within album, show edit album/delete album options
			    echo "<div class='gallery'>";	   
				while ( $row = $result->fetch_assoc() ) {
					print ("<div class='entry'>");
					print ("<a href="."../php/individualpic.php?imageID=".$row['imageID'].">");
					print("<div class='thumb'><img src='../".$row['file_path']."'></div>");
					print ("<div class='info'>");
					print ("<h3>".$row['image_title']."</h3>");
					print ("<p>".$row['caption']."</p>");
					print ("<p>".$row['credit']."</p>");
					print ("</div></a></div>");
				}
				echo '</div>';
				print ("<p class='click_link'><a href="."../php/editalbum.php?albumID=".$albumID.">Edit an Album</a></p>");
				print ("<p class='click_link'><a href="."../php/deletealbum.php?albumID=".$albumID.">Delete this Album</a></p>");
			}
	    ?> 
	</body>
</html>