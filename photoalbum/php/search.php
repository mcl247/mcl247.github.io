<!DOCTYPE html>
<html>
  <head>
  	<!--Static head-->
	<?php require '../static/head.php';?>
  </head>

	<body>
		<div id ="container">
			<h1>Search</h1>
		</div><!--end of container div--> 
		<!--Static navigation bar-->   
		<?php require '../static/navigation.php';  ?>

		    <!-- Search Form -->
			<form action="search.php" method="get">
				<div class ="search">
					<h2>Search Albums and Images</h2>
					<div class ="label">
						<label>Album Name:</label>
							<input type="text" name="searchAlbumTitle"><br><br>
					</div><!-- end of label div -->
					<div class ="label">
						<label>Image Name:</label>
							<input type="text" name="searchImageTitle"><br><br>
					</div><!-- end of label div -->
					<div class ="label">
						<label>Image Caption:</label>
							<input type="text" name="searchImageCaption"><br><br>
					</div><!-- end of label div -->
					<div class ="submit">
						<input type="submit" name="search" value="search">
					</div> <!-- end of submit div --> 
				</div><!-- end of search div -->
			</form><!-- end of form--> 

		<?php

			//Search variables
			$filteredPhotos = array();
			$searchmatch = "";
			
			//If search form was submitted 
			if (isset($_GET['search'])) { 
				//If fields are empty
				if (empty($_GET['searchAlbumTitle']) && empty($_GET['searchImageTitle']) && empty($_GET['searchImageCaption'])) {
					// Display message for no fields filled out
                	$searchmatch = "Please fill in at least one field.";
        		} 
        		else {
        			// Get and filter user input 	
        			$searchAlbumTitle = trim(htmlentities(strip_tags($_GET['searchAlbumTitle'])));
					$searchImageTitle = trim(htmlentities(strip_tags($_GET['searchImageTitle'])));
					$searchImageCaption = trim(htmlentities(strip_tags($_GET['searchImageCaption'])));

					// Initialize database connection
					require_once 'config.php';
					$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

					// Regex match album title, image title, and image caption 
					if((!preg_match("/^[a-zA-Z0-9]+$/i", $searchAlbumTitle)) && (!empty($searchAlbumTitle))){
						print("<p>Album title must only contain letters and numbers.</p>");
					}
					elseif((!preg_match("/^[A-Za-z0-9]+$/i", $searchImageTitle)) && (!empty($searchImageTitle))){
						print("<p>Image title must only contain letters and numbers.</p>");
					}
					elseif((!preg_match("/^[A-Za-z0-9#]+$/i", $searchImageCaption)) && (!empty($searchImageCaption))){
						print("<p>Image caption must only contain letters, numbers, and hashtags.</p>");
					}
					else {
					// Find search matches by search terms 
					$result = $mysqli->query(
						"SELECT * FROM (SELECT * FROM Images 
						WHERE Images.image_title LIKE '%$searchImageTitle%' 
						AND Images.caption LIKE '%$searchImageCaption%') as FilteredPhotos
						INNER JOIN Album_to_Image
						ON FilteredPhotos.imageID = Album_to_Image.imageID
						INNER JOIN Albums
						ON Album_to_Image.albumID = Albums.albumID
						WHERE Albums.title LIKE '%$searchAlbumTitle%'
						GROUP BY FilteredPhotos.imageID"
					);
						// Populate filteredPhotos array with database results
						while ($row = $result->fetch_assoc()) {
							array_push($filteredPhotos, $row);
						}

						// Display matches message
						if (count($filteredPhotos) == 0) { 
							// No matches found
							$searchmatch = "No matches found.";
						} 
						elseif (count($filteredPhotos) == 1) { 
							// 1 match found
							$searchmatch = "1 match found.";
						} 
						else { 
							// More than one matches found
							$searchmatch = (count($filteredPhotos) . " matches found.");
						}
        			}
				}
			}
		?>

		<h2><?php echo $searchmatch?></h2>

		<?php 
			// If more than 0 filtered photos
			if (count($filteredPhotos) > 0) { 
				echo "<div class='gallery'>";
				// Loop through filteredPhotos and display fields
				foreach ($filteredPhotos as $catalog){
					$imageID = $catalog['imageID'];
					$albumID = $catalog['albumID'];
					$image_title = $catalog['image_title'];
					$caption = $catalog['caption'];
					$file_path = $catalog['file_path'];
					$credit = $catalog['credit'];
					$title = $catalog['title'];

					print ("<div class='entry'>");
					print ("<a href="."../php/images.php?albumID=".$albumID.">");
					print ("<div class='thumb'><img src='../".$file_path."'></div>");
					print ("<div class='info'>");
					print ("<h3>".$image_title."</h3>");
					print ("<h4>".$caption."</h4>");
					print ("<h4>In album: ".$title."</h4>");
					print ("</div></a></div>");
				}
				echo '</div>';	
			}
		?>
	</body>
</html>