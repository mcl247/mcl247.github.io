<!DOCTYPE html>
<html>
  <head>
  	<!--Static head-->
	<?php require '../static/head.php';?>
  </head>

	<body>
		<div id ="container">
			<h1>Images</h1>
		</div><!--end of container div--> 
		<!--Static navigation bar-->
		<?php require '../static/navigation.php';?>
		<?php 

		//Initialize database connection 
 		require_once '../php/config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		//Get all from table "Albums"
	    $result= $mysqli->query("SELECT * FROM Images");

	    // Display all images 
	    echo "<div class='gallery'>";
		while ( $row = $result->fetch_assoc() ) {
			print ("<div class='entry'>");
			print ("<a href="."../php/individualpic.php?imageID=".$row['imageID'].">");
			print("<div class='thumb'><img src='../".$row['file_path']."'></div>");
			print ("<div class='info'>");
			print ("<h3>".$row['image_title']."</h3>");
			print ("<p>".$row['caption']."</p>");
			print ("<p>".$row['credit']."</p>");
			print ("</div></div>");
		}
		echo '</div>';
	
	    ?>
	</body>
</html>