<!DOCTYPE html>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <title>Art Blog</title>
	    <link rel="stylesheet" href="css/style.css">
	    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	    <script type="text/javascript" src="js/main.js"></script>
	    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
	    <link href='https://fonts.googleapis.com/css?family=Khand' rel='stylesheet' type='text/css'>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 	</head>

	<body>
		
		<div class = "data">
			<div id ="container">
				<h1>My Collection of Favorite Artworks</h1>
		      	<div class="nav">
		      		<span class="nav_span"><a class="link" href="index.php">Home</a></span>
		            <span class="nav_span"><a class="link">Full Collection</a></span>
		            <span class="nav_span"><a class="link" href="search.php">Search My Collection</a></span>
		        </div> <!-- end of nav div -->	
		    </div> <!-- end of container div -->	

    	<?php

					//Check if data.txt file loads
					if(!isset($arts)){
						$arts = file("data.txt");
						//Count number of elements in $arts
						$artcount = count($arts); 
						//If file does not load, display error message and exit
						if (!$arts){
							print("Could not load data.txt file.\n");
							exit;
						}
					}

					//If add button is pressed but no updates
					if (isset($_POST["add"])) {

						//Sanitize to prevent malicious codes
						$title = filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING );
				        $artist = filter_input( INPUT_POST, 'artist', FILTER_SANITIZE_STRING );
				        $keywords = filter_input( INPUT_POST, 'keywords', FILTER_SANITIZE_STRING );
				        $year = filter_input( INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT );
				        $category = ucfirst($_POST['category']);

				    } 

				        $update=false; 

				    //If add button is pressed and check all passes 
				    if (isset($_POST["add"])){
				        if(validateAll()){
				        	//Convert to tab-delimited string 
				        	$art = "$title\t$artist\t$keywords\t$year\t$category\n";
				        	//Add this line to the array of lines to be written 
				        	$arts []=$art;
				        	//New artwork is added, so data file will need to be updated
				        	$update=true;
				        }
				    }

				    //If the data file needs updating, write the content
				    if ($update){
				    	//Open data file for write and store returned pointer variable 
						$fp=fopen("data.txt","w");
						//Exit and display error message if file cannot be opened
						if(!$fp){
							print("Can't open data.txt file.\n");
							exit;
						}
						//Loop through array of artworks and build up array of lines to be written
						foreach ($arts as $catalog){
							//Writes $catalog to the data file
							fputs($fp, $catalog);
						}
					}

					//Check Functions
					function validateAll() {
						
						//Sanitize to prevent malicious codes
						$title = filter_input( INPUT_POST, 'title', FILTER_SANITIZE_STRING );
				        $artist = filter_input( INPUT_POST, 'artist', FILTER_SANITIZE_STRING );
				        $keywords = filter_input( INPUT_POST, 'keywords', FILTER_SANITIZE_STRING );
				        $year = filter_input( INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT );
				        $category = ($_POST['category']);
						
						//Check if title is entered correctly 
						if ((!validateTitle($title))||(!isset($title))){
							$error_message = "You did not enter the title correctly.";
							print("<p>$error_message</p>");
							return false;
						}
						//Check if artist name is entered correctly 
						if (!validateArtist($artist)){
							$error_message = "You did not enter the artist name correctly.";
							print("<p>$error_message</p>");
							return false;
						}
						//Check if keyword is entered correctly 
						if (!validateKeywords($keywords)){
							$error_message = "You did not enter the keyword correctly.";
							print("<p>$error_message</p>");
							return false;
						}
						//Check if artwork year is entered correctly 
						if (!validateYear($year)){
							$error_message = "You did not enter the year correctly.";
							print("<p>$error_message</p>");
							return false;
						}
						//Check for duplicate entries
						if (checkDouble($title)){ 
							$error_message = "This artwork is a duplicate.";
							print("<p>$error_message</p>");
							return false;
						}
						return true;
					}

					//Title validation function 
					function validateTitle($t) {
						//Regex to filter entries 
						$check = '/^[a-zA-Z0-9 .\-]+$/i';
						$pattern = preg_match($check,$t);
						//Make sure pattern matches given subject and is less than 80 characters
						if(($pattern!=0) && (strlen($t)<80)){
							return true;
						} 
						else {
							return false;
						}
					}
					
					//Artist validation function 
					function validateArtist($a) {
						//Regex to filter entries 
						$check = '/^[a-zA-Z0-9 .\-]+$/i';
						$pattern = preg_match($check,$a);
						//Make sure pattern matches given subject and is less than 80 characters
						if(($pattern!=0) && (strlen($a)<80)){
							return true;
						} 
						else {
							return false;
						}
					}

					//Keyword validation function 
					function validateKeywords($k) {
						//Regex to filter entries 
						$check = '/^[a-zA-Z0-9@!&#" "-]+$/';
						$pattern = preg_match($check,$k);
						//Make sure pattern matches given subject and is less than 80 characters
						if(($pattern!=0) && (strlen($k)<80)){
							return true;
						} 
						else {
							return false;
						}
					}
					
					//Year validation function 
					function validateYear($y) {
						//Regex to make sure entry is a number thats 4 digits
						$check = '/^\d{4}$/';
						$pattern = preg_match($check,$y);
						//Make sure pattern matches given subject
						if($pattern!=0){
							return true;
						} 
						else {
							return false;
						}
					}

					//Check for duplicate entries
					function checkDouble($input){
						//Array in which each entry is a line of data.txt
						$arts = file('data.txt');
						//Count elements in $arts array
						$artscount = count($arts);
						//Convert input to upper case
						$input = strtoupper($input);
						//Breaks input string into an array 
						$entry = explode(' ', $input);
						//Count the input array
						$wordcount = count($entry);
									
						//Loop through list to check for duplicates
						for($i=0; $i<$artscount; $i++){
							$match = true;
							//Loop through input words
							for($w = 0; $w<$wordcount; $w++){
								//If word is not a match, return false
								if(!preg_match("/$entry[$w]/", strtoupper($arts[$i]))){
									$match= false;
								}
							}
							//If word is a match, return true 
							if($match==true){
								return true;
							}
						}
					}

		?>
				
					<form method="post" action="catalog.php">
						<table class = "catalog">
							<thead>
								<tr class="list">
								<th>Title</th>
								<th>Artist</th>
								<th>Keyword</th>
								<th>Year</th>
								<th>Category</th>
								</tr>
							</thead>
						
		<?php
					
				//Write catalog by looping through $arts array and storing keys with values 
				foreach($arts as $artindex => $catalog) {
					print("<tr>\n");
						//Explode row separated by tab-delimiter 
						$row = explode("\t", $catalog);
						//Write row elements
						foreach ($row as $fieldindex => $field) {
							//Print out each input field
							print("<td>$field</td>\n");
						} 
						print("</tr>\n");
				}

		?>

							<tr>
								<td><input type="text" name="title"/></td>
								<td><input type="text" name="artist"/></td>
								<td><input type="text" name="keywords"/></td>
								<td><input type="number" name="year" max="2017"/></td>
								<td><select name="category" id="category"/>
				                  <option value=""selected>Any Medium</option>
				                  <option value="painting">Painting</option>
				                  <option value="multimedia">Multimedia</option>
				                  <option value="architecture">Architecture</option>
				                  <option value="photography">Photography</option> 
				                  <option value="furniture">Furniture</option> 
				                  <option value="installation">Installation</option></select>
				              	</td>
								<td><input type="submit" name="add" value="Add New"/></td>
							</tr>
						</table> <!--end of table-->
					</form>  <!--end of form-->
				
				</div><!--end of data div-->


		    <div class="gallery">

		    	<div class="entry">
		      		<div class="thumb">
		        		<img src="images/ddp.jpg">
		        			<!--ddp.jpg by Zaha Hadid on archdaily
	        		 		http://www.archdaily.com/489604/dongdaemun-design-plaza-zaha-hadid-architects
	        				-->
		      		</div><!-- end of thumb div --> 
					<div class="info">
		        		<h3>Dongdaemun Design Plaza</h3>
		        		<h4>by Zaha Hadid</h4>
		        	</div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 

		      	<div class="entry">
		        	<div class="thumb">
		        		<img src="images/jungle.jpg">
		        		<!--jungle.jpg by Team Lab on Design Boom
	        			http://www.designboom.com/art/teamlab-jungle-festival-light-installation-02-14-2017/
	        			-->
		        	</div><!-- end of thumb div --> 
					<div class="info">
		          		<h3>Jungle</h3>
		          		<h4>by Team Lab</h4>
		          	</div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 

		        <div class="entry">
		        	<div class="thumb">
		            	<img src="images/coconutchair.jpg">
		            	<!--coconut.jpg by George Nelson on Herman Miller
		            	http://www.hermanmiller.com/products/seating/lounge-seating/nelson-coconut-lounge-chair.html
		            	--> 
		         	</div><!-- end of thumb div --> 
					<div class="info">
						<h3>Coconut Chair</h3>
			            <h4>by George Nelson</h4>
			        </div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 

		      	<div class="entry">
		        	<div class="thumb">
		            	<img src="images/thekiss.png">
		            	<!--thekiss.png by Gustav Klimt on Klimt 
	            		http://www.klimt.com/en/gallery/women.html
	            		-->
		         	</div><!-- end of thumb div --> 
					<div class="info">
						<h3>The Kiss</h3>
			            <h4>by Gustav Klimt</h4>
			        </div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 

		      	<div class="entry">
		        	<div class="thumb">
		            	<img src="images/yosemite.jpg">
		            	<!--yosemite.jpg by Ansel Adams on Time
		            	http://content.time.com/time/photogallery/0,29307,1932762,00.html
		            	-->
		         	</div><!-- end of thumb div --> 
					<div class="info">
						<h3>Yosemite Falls</h3>
			            <h4>by Ansel Adams</h4>
			        </div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 

		      	<div class="entry">
		        	<div class="thumb">
		            	<img src="images/nativity.jpg">
		            	<!--nativity.jpg by Maria Berrio on artnet
	            		http://www.artnet.com/artists/maria-berrio/nativity-a-Yyq9LOk5Xh0K0LMn-F4Nlw2
	            		--> 
		         	</div><!-- end of thumb div --> 
					<div class="info">
						<h3>Nativity</h3>
			            <h4>by Maria Berrio</h4>
			        </div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 
		   
		      	<div class="entry">
		        	<div class="thumb">
		            	<img src="images/housena.jpg">
		            	<!--housena.jpg by Sou Fujimoto on archdaily
		            	http://www.archdaily.com/230533/house-na-sou-fujimoto-architects
		            	-->
		         	</div><!-- end of thumb div --> 
					<div class="info">
						<h3>House NA</h3>
			            <h4>by Sou Fujimoto Architecture</h4>
			        </div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 

		        <div class="entry">
		        	<div class="thumb">
		            	<img src="images/poetrylines.jpg">
		            	<!--poetrylines.jpg by Jo Fairfax on designboom 
		            	http://www.designboom.com/art/jo-fairfax-line-of-light-nottingham-02-20-2017/
		            	--> 
		         	</div><!-- end of thumb div --> 
					<div class="info">
						<h3>Poetry Lines</h3>
			            <h4>by Jo Fairfax</h4>
			        </div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 

		      	<div class="entry">
		        	<div class="thumb">
		            	<img src="images/broadway-boogie-woogie.jpg">
		            	<!--broadway-boogie-woogie.jpg by Piet Mondrian on MoMA
		            	https://www.moma.org/collection/works/78682
		            	-->
		         	</div><!-- end of thumb div --> 
					<div class="info">
						<h3>Broadway Boogie Woogie</h3>
			            <h4>by Piet Mondrian</h4>
			        </div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 

		        <div class="entry">
		        	<div class="thumb">
		            	<img src="images/marshmallow.jpg">
		            	<!--marshmallow.jpg by George Nelson on herman miller
						http://store.hermanmiller.com/Products/Nelson-Marshmallow-Sofa
						-->
		         	</div><!-- end of thumb div --> 
					<div class="info">
						<h3>Marshmallow Chair</h3>
			            <h4>by George Nelson</h4>
			        </div><!-- end of info div --> 
		      	</div><!-- end of entry div --> 
		      	<div class="artcredits">
		      		<a href ="artwork.html">Credits</a>
		      	</div><!--end of artcredits div-->
		    </div><!-- end of gallery div --> 
	</body>
</html>