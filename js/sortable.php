 <?php session_start(); ?>
<!DOCTYPE html>
<html>
  <?php require('../static/header.php') ?>
<head>
  <title>jQuery UI Sortable - Display as grid</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li {
    margin: 3px 3px 3px 0; padding: 1px; float: left; width: 350px; height: 450px; font-size: 4em; text-align: center; }
  </style>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
</head>

<body>

  <?php require('../static/navbar.php');?>

  <div class="containercustom">
    <div class="lined-header">
        <h2 class="texts">GALLERY</h2>
      </div>

  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
      <div id ="imggallery" class="gallerycontainer">
        <img src="../assets/b1.jpg" alt="food" class="img-responsive"/>
        <img src="../assets/b2.jpg" alt="food" class="img-responsive"/>
        <img src="../assets/b3.jpg" alt="food" class="img-responsive"/>
        <img src="../assets/b4.jpg" alt="food" class="img-responsive"/>
        <img src="../assets/b5.jpg" alt="food" class="img-responsive"/>
        <img src="../assets/b6.jpg" alt="food" class="img-responsive"/>
        <img src="../assets/b7.jpg" alt="food" class="img-responsive"/>
        <img src="../assets/b8.jpg" alt="food" class="img-responsive"/>
    </div>
      </div>
    </div>

   <script>
   (function(){
        var imgLen = document.getElementById('imggallery');
        var images = imgLen.getElementsByTagName('img');
        var counter = 1;

        if(counter <= images.length){
            setInterval(function(){
                images[0].src = images[counter].src;
                console.log(images[counter].src);
                counter++;

                if(counter === images.length){
                    counter = 1;
                }
            },3000);
        }

    })();
  </script>
    <!-- <div class="row header text-center"> -->
      <?php require_once '../config.php';
      
      if (isset($_SESSION['logged_user_by_sql'])) {?>


<!--            <div class="row">-->
      <ul id="sortable">
      <?php 
      $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
      $result = $mysqli->query('SELECT * FROM Images');

      $x = 0;

      while ($row = $result->fetch_assoc()) {
      $file_name =$row[ 'file_path' ];
      $image_caption = $row['caption'];
      ?>
      <div class="col-sm-4 col-md-4 col-lg-3">
        <img src="../assets/<?php echo $file_name?>"alt="food" class="img-responsive"/>
      </div>
      <?php
          $x++;
          if($x % 4 == 0){
          } //end if
        } //end while
       ?>
        </ul>

        <?php } //end if 
      else{
          $mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
          $result = $mysqli->query('SELECT * FROM Images');

          $x = 0;
         ?><div class="row"><?php
          while ($row = $result->fetch_assoc()) {
              $file_name =$row[ 'file_path' ];
              $image_caption = $row['caption'];
              ?>
              <div class="col-sm-4 col-md-4 col-lg-3">
                <img src="../assets/<?php echo $file_name?>"alt="food" class="img-responsive"/>
              </div>
              <?php
                  $x++;
                  if($x % 4 == 0){
                      ?>
                      </div>
                      <div class="row">
                      <?php
                  } //end if
            } //end while
          
            }//end else
            
      
      ?>

<!-- Close Header  -->
        </div>  <!-- end of custom container   -->
      </div>
    </div>
    <!--Static footer-->
  <?php require '../static/footer.php';?>
  </body>
</html>