<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Cathy Liu</title>
		<link rel="stylesheet" href="css/stylesheet.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
		<link href="https://fonts.googleapis.com/css?family=Lobster+Two" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Khand' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div id ="container">
			<h1>Photo Gallery</h1>
		</div>
		<div id="container">
		  	<div class="nav">
		  		<span class="nav_span"><a class="link" href="">Albums</a></span>
		        <span class="nav_span"><a class="link" href="php/allimages.php">Images</a></span>
		        <span class="nav_span"><a class="link" href="php/add.php">Add Album</a></span>
		        <span class="nav_span"><a class="link" href="php/addimage.php">Add Image</a></span>
		        <span class="nav_span"><a class="link" href="php/search.php">Search</a></span>
		        <span class="nav_span"><a class="link" href="php/login.php">Login</a></span>
		    </div> <!-- end of nav div -->
		</div><!--end of container div--> 

		<?php 

		// Initialize database connection
 		require_once 'php/config.php';
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		//Get all from table "Albums"
	    $result= $mysqli->query("SELECT * FROM Albums");

	    echo "<div class='gallery'>";

	    //Print rows 
		while ( $row = $result->fetch_assoc() ) {
			
			print ("<div class='entry'>");
			print ("<a href="."php/images.php?albumID=".$row['albumID'].">");
			print("<div class='thumb'><img src= '".$row['file_name']."'></div>");
			print ("<div class='info'>");
			print ("<h3>".$row['title']."</h3>");
			print ("<h4>".$row['description']."</h4>");
			print ("</div></a></div>");
		}
		echo '</div>';
	  ?>
	</body>
</html>
	