<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
  	<!--Static head-->
	<?php require '../static/head.php';?>
  </head>

	<body>
		<div id ="container">
			<h1>Add Images</h1>
		</div><!--end of container div--> 
		<!--Static navigation bar-->
		<?php require '../static/navigation.php';

		require_once 'config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// Only display add form if user is logged in 
	if (isset($_SESSION['logged_user'])) {
		?>

		<form method="post" enctype="multipart/form-data">
			<p>
				<label for="new-photos">Upload photo: </label><br><br>
				<input id="new-photos" type="file" name="newphoto"><br><br>
				<label for="photo-name-field">Title: </label>
				<input id="photo-name-field" type="text" name="photoName" maxlength="40" ><br><br>
				<label for="photo-name-field">Caption: </label>
				<input id="photo-name-field" type="text" name="photoCaption" maxlength="40" ><br><br>
				<label for="photo-name-field">Credit: </label>
				<input id="photo-name-field" type="text" name="photoCredit" maxlength="40" ><br><br>

			<?php 
							$albumQuery = "SELECT * FROM Albums";
							$albumResults = $mysqli -> query($albumQuery);	
						    echo "<label id='select-albums-title'><b>Add to album(s):</b> </label><br>";
						    while ($row = $albumResults -> fetch_assoc()) {
						      $albumId = $row['albumID'];
						      $albumTitle = $row['title'];
						        echo "<input type='checkbox' name='albums[]' value='$albumId'> $albumTitle";
						    }
						?>
						<br><br>
				<input type="submit" name="submit" value="Upload photo"><br>
			</p>
		</form>
		<br>

		<?php
		}
	 // If no logged in user 
	 else {
	 	print "<p class='click_link'><a href='login.php'>Log in </a>to add an image.</p>";
	 }

		//Check to see if files were uploaded using the "multiple file" form
		if (isset($_POST['submit'])){
			if (!empty($_FILES['newphoto'])){
				$newPhoto = $_FILES['newphoto'];
				$originalName = $newPhoto['name'];
				
					if ($newPhoto['error'] == 0 ) {
						$tempName = $newPhoto['tmp_name'];
						
						move_uploaded_file($tempName, "../images/$originalName");
						$_SESSION['photos'][] = $originalName;


						//Filter strings & get information  
						$image_title = filter_input(INPUT_POST, 'photoName', FILTER_SANITIZE_STRING);
						$caption = filter_input(INPUT_POST, 'photoCaption', FILTER_SANITIZE_STRING);
						$file_path = "images/$originalName";
						$credit = filter_input(INPUT_POST, 'photoCredit', FILTER_SANITIZE_STRING);
						

							//Insert new photos
							$query = "INSERT INTO Images (imageID, image_title, caption, file_path, credit, date_taken) VALUES (NULL, '$image_title', '$caption', '$file_path', '$credit', now())";
							$result= $mysqli->query($query);
					

						if (!empty($_POST['albums'])){
							$albums_selected = $_POST['albums'];

							$queryimage= $mysqli->query("SELECT * FROM Images WHERE caption='$caption' AND image_title='$image_title' AND file_path='$file_path' AND credit='$credit'");
				
							while($row = $queryimage->fetch_assoc()){
								$id = $row['imageID'];
							}
							foreach ($albums_selected as $album){
								$album1=(int)$album;
								$aiquery = "INSERT INTO Album_to_Image(connect, albumID, imageID) VALUES (NULL, '$album1', '$id')";
								$addresult=$mysqli ->query($aiquery);
								if($addresult){
								print("<p>The photo was added successfully to the album.</p>");
							}
							if(!$addresult){
								print("<p>There was an error processing your upload request.</p>");
							}
							}
						}
						else{
							print("<p>No photo was uploaded.</p>");
						}
						
					} 
					else {
						print("<p>The file $originalName was not uploaded.</p>");
					
				}
			}
		}
			
		?>
	</body>