<!DOCTYPE html>

<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>Cornell Kappa Phi Lambda Sorority</title>
    <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Dosis">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Pacifico">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Lily+Script+One">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Yellowtail">
    <style type="text/css"
    media:"screen">
    	.error {color:red;}
    </style>
</head>

<body>

	<div id="top">
	    
	    <div id="banner">

	        <div class="image2">
	            <img src="images/crest.png" alt="rush">
	            <!-- image by https://umichkappaphilambda.wordpress.com/ -->
	        </div><!-- end of image2 div -->

	        <div id="titles">
	            <h1>Kappa Phi Lambda Sorority</h1>
	            <h2>Iota Chapter at Cornell University</h2>
	        </div><!-- end of titles div -->

	    </div><!-- end of banner div -->
	  
	    <div id="global_nav">
	        <span class="nav_span"><a class="link" href="index.html">Home</a></span>
	        <span class="nav_span"><a class="link" href="index_2.html">Sisters</a></span>
	        <span class="nav_span"><a class="link" href="index_3.html">Gallery</a></span>
	        <span class="nav_span"><a class="link" href="index_4.html">Rush</a></span>
	        <span class="nav_span"><a class="link">Contact Us</a></span>
	    </div> <!-- end of global_nav div -->
	    
	</div> <!-- end of top div -->

	<div id="top2">

	    <div class="image">
	        <p class="caption">Contact Form</p>
	    </div><!-- end of image div -->

	</div><!--end of top2 div --> 

</html> 

<?php
/* This page receives data from index_5.html: 
name, year, grade, email, comments, and submit */

//Show all possible problems
error_reporting(E_ALL);

//Defined variables
$name=$_POST['name'];
$year=$_POST['year'];
$grade=$_POST['grade'];
$email=$_POST['email'];
$comments=$_POST['comments'];

//Define function 
function validate (){

	//Variable in order to track successful submit
	$okay=TRUE;

//Validate the name:
if (empty($_POST['name'])){
	print '<p class ="error">Please enter your name.</p>';
	$okay=FALSE;
}

//Validate the year: 
if (is_numeric($_POST['year']) AND (strlen($_POST['year'])==4)){

	//Check that the user was born before 2017
	if ($_POST['year'] <2017 ){
		$age=2017 - $_POST['year'];
	} else {
		print '<p class="error">You entered your birth year wrong!</p>';
		$okay=FALSE;
	}
 } else {
 	print '<p class="error">Please enter the year you were born as four digits.</p>';
 	$okay=FALSE;
 }

//Validate the grade: 
switch ($_POST['grade']) {
	case 'Freshmen':
		$grade_type = 'Freshmen';
		break;
	case 'Sophomore':
		$grade_type = 'Sophomore';
		break;
	case 'Junior':
		$grade_type = 'Junior';
		break;
	case 'Senior':
		$grade_type = 'Senior';
		break;
	default: 
		print '<p class="error">Please select your grade.</p>';
		$okay=FALSE;
		break;
}

//Validate the email: 
if (empty($_POST['email'])){
	print '<p class="error">Please enter your email.</p>';
	$okay=FALSE;
}

//Validate the comments:
if (empty($_POST['comments'])){
	print '<p class="error">Your comments area is blank.</p>';
	$okay=FALSE;
}

//If no errors, print success message:
if ($okay==TRUE) {
	print "<p>Thank you, $name for your comments.</p>
	<p>We will email you back at $email as soon as possible!</p>"; 

}
}

$okay = validate (); 


?> 