 <!DOCTYPE html>
<html>
  	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <title>Art Blog</title>
	    <link rel="stylesheet" href="css/style.css">
	    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700' rel='stylesheet' type='text/css'>
	    <link href='https://fonts.googleapis.com/css?family=Khand' rel='stylesheet' type='text/css'>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
  	<body>

	  
	    	<div id ="container">
	      		<h1>My Collection of Favorite Artworks</h1>
	          	<div class="nav">
	            	<span class="nav_span"><a class="link" href="index.php">Home</a></span>
	              	<span class="nav_span"><a class="link" href="catalog.php">Full Collection</a></span>
	              	<span class="nav_span"><a class="link">Search My Collection</a></span>
	          	</div> <!-- end of nav div -->   
	      	</div> <!-- end of container div -->

	    <!-- Single-Field Search Form --> 
		<form action="search.php" method="get">
	   		<div class="left">
	      		<h2>Single-Field Search</h2>
	         	<div class="label"> 
	            	<label>Search:</label>
	            		<input type="text" name="input"/>
	            </div><!-- end of label div -->
	            <div class="submit">
	            	<input type="submit" name="search" value="Search"/>
	            </div><!-- end of submit div -->
	        </div><!-- End of left div-->
	    </form><!-- End of form-->

	    <!-- Multiple-Field Search Form -->
	    <form action="search.php" method="get">
	        <div class="right">
	            <h2>Multiple-Field Search</h2>
		        <div class="label">
		            <label>Title</label>
		                <input id="title" type="text" name="title" maxlength="45" placeholder="Title" value=""/>
		            </div><!--end of label div--> 
		            <div class="label">
		                <label>Artist</label>
		                <input type="text" name="artist" placeholder="Artist" value=""/> 
		            </div><!--end of label div--> 
		            <div class="label">
		                <label>Keyword</label>       
		                <input type="text" name="keywords" placeholder="Keyword" value=""/>
		            </div><!--end of label div--> 
		            <div class="label">
		                <label>Year</label>       
		                <input type="number" name="year" max="2017"/>
		            </div><!--end of label div--> 
		            <div class="label">
		                <label>Category</label>   
		                  	<select name="category">
		                      <option value=""selected>Any Medium</option>
		                      <option value="painting">Painting</option>
		                      <option value="multimedia">Multimedia</option>
		                      <option value="architecture">Architecture</option>
		                      <option value="photography">Photography</option> 
		                      <option value="furniture">Furniture</option> 
		                      <option value="installation">Installation</option>
		                    </select>
		            <div class="submit">
	              		<input type="submit" name="search2" value="Search">           
	          		</div><!--end of submit div--> 
	        </div><!--end of right div--> 
	    </form><!--end of form-->

	<?php

			////Check if data.txt file loads
			if(!isset($arts)){
				$arts = file("data.txt");
				//If file does not load, display error and exit
				if (!$arts){
					print("Could not load data.txt file\n");
					exit;
				}
			}
			//If search exists, perform single-field search
			if(isset($_GET["search"])){
				$noResults = false;
				//Set single-field user input to variable
				$input = $_GET['input'];
				//Filter and match input
				$check = '/^[a-zA-Z0-9@!&#" "]+$/';
				if(preg_match($check, $input)){
					$rowCount = count($arts);
					$searchResults = array();
					$input = strtoupper($input);
					$entry = explode(' ', $input);
					$wordCount = count($entry);
					
					//Loop through input rows
					for($i=0; $i<$rowCount; $i++){
						$match = true;
						//Loop through input words
						for($j = 0; $j<$wordCount; $j++){
							//If input word matches word in collection
							if(!preg_match("/$entry[$j]/", strtoupper($arts[$i]))){
								$match = false;
							}
						}
						if($match==true){
							$searchResults[] = $arts[$i];
						}
					}
					//Count all elements and assign to variable 
					$size = count($searchResults);
					if($size==0){
						print("</br>");
						$noResults = true;
					}
				} //Preg_match ends 
				else {
					$noResults = true;
				}
			
			//Print the single-field search results
			if(isset($noResults)){
				if($noResults==true){
					print("No Results Were Found.");
				}
				else{
					print("<h5>Search Results For My Song Catalog:</h5>");
			
		?>
				<table class ="catalog" id = "search2">
					<thead>
						<tr>
							<th>Title</th>
							<th>Artist</th>
							<th>Keywords</th>
							<th>Year</th>
							<th>Category</th>
						</tr>	
					</thead>
				
		<?php
							//Loop for cycling results 
							for($k = 0; $k<$size; $k++){
								$printResults = explode("\t", $searchResults[$k]);
								$count = count($printResults);				
								print("<tr>");
								//Loop for printing table
								for($l = 0; $l<$count; $l++){
									print("<td>$printResults[$l]</td>");
								}
									print("</tr>");
							}//End for cycle results
						}//End else print results
					}//End isset results
				}

			//If search2 exists, perform multiple-field search
			elseif(isset($_GET["search2"])) {
				//Filter sanitize
				$title = filter_input( INPUT_GET, 'title', FILTER_SANITIZE_STRING );
				$artist = filter_input( INPUT_GET, 'artist', FILTER_SANITIZE_STRING );
				$keywords = filter_input( INPUT_GET, 'keywords', FILTER_SANITIZE_STRING );
				$year = filter_input( INPUT_GET, 'year', FILTER_SANITIZE_NUMBER_INT );
				$category = ucfirst(($_GET['category']));

				$results = array();

				//User is searching for entry with specified title, artist, keywords, year, and category
				if((!empty($title)) && (!empty($artist)) && (!empty($keywords)) && (!empty($year)) && (!empty($category))){	
					$entries = file('data.txt');		
					foreach($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[1]) == $artist && trim($exploded[2]) ==$keywords && trim($exploded[3])==$year && trim($exploded[4])==$category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title, artist, keywords, and year
				elseif((!empty($title)) && (!empty($artist)) && (!empty($keywords)) && (!empty($year))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);			
						if (trim($exploded[0]) == $title && trim($exploded[1]) == $artist && trim($exploded[2]) ==$keywords && trim($exploded[3])==$year){
							array_push($results,$exploded);
						}
					}
				}
				//User is searching for entry with specified title, artist, keywords, and category
				elseif((!empty($title)) && (!empty($artist)) && (!empty($keywords)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[1]) == $artist && trim($exploded[2]) ==$keywords && trim($exploded[4])==$category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title, artist, year, and category
				elseif((!empty($title)) && (!empty($artist)) && (!empty($year)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if ($entry[0] == $title && $entry[1] == $artist && $entry[3] ==$year && $entry[4]==$category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title, keywords, year, and category
				elseif((!empty($title)) && (!empty($keywords)) && (!empty($year)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[2]) == $keywords && trim($exploded[3]) ==$year && trim($exploded[4])==$category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified artist, keywords, year, and category
				elseif((!empty($artist)) && (!empty($keywords)) && (!empty($year)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[1]) == $artist && trim($exploded[2]) == $keywords && trim($exploded[3]) ==$year && trim($exploded[4])==$category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title, artist, and keywords
				elseif((!empty($title)) && (!empty($artist)) && (!empty($keywords))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[1])==$artist && trim($exploded[2]) == $keywords){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title, artist, and year
				elseif((!empty($title)) && (!empty($artist)) && (!empty($year))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[1])==$artist && trim($exploded[3]) == $year){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title, artist, and category
				elseif((!empty($title)) && (!empty($artist)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[1])==$artist && trim($exploded[4]) == $category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title, keywords, and year
				elseif((!empty($title)) && (!empty($keywords)) && (!empty($year))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[2])==$keywords && trim($exploded[3]) == $year){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title, keywords, and category
				elseif((!empty($title)) && (!empty($keywords)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[2])==$keywords && trim($exploded[4]) == $category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified keywords, artist, and year
				elseif((!empty($keywords)) && (!empty($artist)) && (!empty($year))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[2]) == $keywords && trim($exploded[1])==$artist && trim($exploded[3]) == $year){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified keywords, artist, and category
				elseif((!empty($keywords)) && (!empty($artist)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[2]) == $keywords && trim($exploded[1])==$artist && trim($exploded[4]) == $category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified year, artist, and category
				elseif((!empty($year)) && (!empty($artist)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[3]) == $year && trim($exploded[1])==$artist && trim($exploded[4]) == $category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title and artist
				elseif((!empty($title)) && (!empty($artist))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[1])==$artist){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title and keywords
				elseif((!empty($title)) && (!empty($keywords))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[2]) == $keywords){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title and year
				elseif((!empty($title)) && (!empty($year))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[3]) == $year){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified title and category
				elseif((!empty($title)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[0]) == $title && trim($exploded[4]) == $category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified artist and keywords
				elseif((!empty($artist)) && (!empty($keywords))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[1]) == $artist && trim($exploded[2]) == $keywords){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified artist and year
				elseif((!empty($artist)) && (!empty($year))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[1]) == $artist && trim($exploded[3]) == $year){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified artist and category
				elseif((!empty($artist)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[1]) == $artist && trim($exploded[4]) == $category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified keywords and year
				elseif((!empty($keywords)) && (!empty($year))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[2]) == $keywords && trim($exploded[3]) == $year){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified keywords and category
				elseif((!empty($keywords)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[2]) == $keywords && trim($exploded[4]) == $category){
							array_push($results, $exploded);
						}
					}
				}
				//User is searching for entry with specified year and category
				elseif((!empty($year)) && (!empty($category))){
					$entries = file('data.txt');
					foreach ($entries as $entry){
						$exploded= explode("\t", $entry);
						if (trim($exploded[3]) == $year && trim($exploded[4]) == $category){
							array_push($results, $exploded);
						}
					}
				}
				//If results are empty, display message; else print message showing results
					if(empty($results)){
					 	print ("No results were found.");
					 	exit;
					}
					else {
						print ("<h2>Search Results For My Song Catalog:</h2>");
					}
		?>
				<table class ="catalog" id = "search2">
					<thead>
						<tr>
							<th>Title</th>
							<th>Artist</th>
							<th>Keywords</th>
							<th>Year</th>
							<th>Category</th>
						</tr>	
					</thead>
					
		<?php	
					//If results is not empty, print results results
						foreach ($results as $catalog){
							echo "<tr>";
							echo "<td>".$catalog[0]."</td>";
							echo "<td>".$catalog[1]."</td>";
							echo "<td>".$catalog[2]."</td>";
							echo "<td>".$catalog[3]."</td>";
							echo "<td>".$catalog[4]."</td>";
							echo "</tr>";
						}
					
			}//End of multiple fields search 

		?>
				</table><!--End of table-->
  	</body>
</html>
