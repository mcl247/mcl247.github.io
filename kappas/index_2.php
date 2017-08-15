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
            <span class="nav_span"><a class="link">Sisters</a></span>
            <span class="nav_span"><a class="link" href="index_3.html">Gallery</a></span>
            <span class="nav_span"><a class="link" href="index_4.html">Rush</a></span>
            <span class="nav_span"><a class="link" href="index_5.html">Contact Us</a></span>
        </div> <!-- end of global_nav div -->

    </div><!-- end of top div -->


    <div id="top2">

        <div class="image">
            <p class="caption">Executive Board Positions</p>
        </div><!-- end of image div -->

        <?php 
        //This script creates and prints out an array 

        //Show all possible problems
        error_reporting(E_ALL);

        //Define a function
        function create_executive_board() {

        //Create an array
        $positions= array(
            'President'=> 'Cathleen Lyu *Regent*',
            'Vice President' => 'Jinnie Kim *oceanic*',
            'Warden' => 'Priscilla Wong *Evangeline*',
            'Liasion' => 'Grace Yoon *Chambord*',
            'Secretary' => 'Lynn Xu *Merceles*',
            'Treasurer' => 'Samantha Wong *VESPERIA*'
            ); 

        //Loop for printing out keys and values
        foreach ($positions as $key => $value) {
            print "<p>$key: $value</p>\n";
        }
    }

        create_executive_board (); //call the function

        ?>  

        <p class="caption">Active Sisters</p>

    </div><!-- end of top2 div -->

    <div id="content">

        <div id="left">
            <h2>Eugenia Xiao *LifeLine*</h2>
                <p>iota Phi, Spring 2015<br/>
                Big: Crystal Lee *Citra*<br/>
                Littles: Tracy Lam *Bailey*, Tenzin Dolma *Raumne*</p> 
                <img src="images/eugenia.jpg" alt="rush">
            <h2>Priscilla Wong *Evangeline*</h2>
                <p>iota Phi, Spring 2015<br/>
                Big: Shelley Poon *aloha*<br/>
                Little: Teresa Huang *ashe*</p>
                <img src="images/pris.jpg" alt="rush">
            <h2>Jing Huang *Reserve*</h2>
                <p>iota Phi, Spring 2015<br/>
                Big: Crystal Lee *Citra*<br/>
                Littles: Lynn Xu *Merceles*, Grace Yoon *Chambord*</p>
                <img src="images/biggles.jpg" alt="rush">
            <h2>Cathleen Lyu *Regent*</h2>
                <p>iota Phi, Spring 2015<br/>
                Big: Mimi Lee *McQueen*<br/>
                Little: Cathy Liu *Glasswing*</p>
                <img src="images/cathleen.jpg" alt="rush">
            <h2>Jenny Yang *Mauna Kea*</h2>
                <p>iota Phi, Spring 2015<br/>
                Big: Mimi Lee *McQueen*<br/>
                Little: n/a</p>
                <img src="images/yang.jpg" alt="rush">
            <h2>Kiana Leung *unforgettable*</h2>
                <p>iota Chi, Fall 2015<br/>
                Big: Sara Kim *morelle*<br/>
                Littles: Erika Kim *luciole*, Julie Lim *libellule*</p>
                <img src="images/kiana.jpg" alt="rush">
            <h2>Shanelle Quizon *unstoppable*</h2>
                <p>iota Chi, Fall 2015<br/>
                Big: Sara Kim *morelle*<br/>
                Little: n/a</p>
                <img src="images/shanelle.jpg" alt="rush">
            <h2>Cathy Liu *Glasswing*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Cathleen Lyu *Regent*<br/>
                Little: n/a</p> 
                <img src="images/cathy1.jpg" alt="rush">
            <h2>Samantha Wong *VESPERIA*</h2>
                <p>iota Psi, Spring, 2016<br/>
                Big: Christie Wang *Clair de Lune*<br/>
                Little: n/a</p>
                <img src="images/sam.jpg" alt="rush">
            <h2>Nuri Kim *eevee*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Selena Kim *Picturesque*<br/>
                Little: n/a</p>
                <img src="images/nuri.jpg" alt="rush">
            <h2>Lynn Xu *Merceles*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Jing Huang *Reserve*<br/>
                Little: n/a</p>
                <img src="images/twin.jpg" alt="rush">

                <!-- all images by Clarie Ng-->
        </div><!-- end of left div -->

        <div id="right">
            <h2>Grace Yoon *Chambord*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Jing Huang *Reserve*<br/>
                Little: n/a</p> 
                <img src="images/grace.jpg" alt="rush">
            <h2>Peiyao Chen *voce*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Cinthia Kim *Marigold*<br/>
                Little: n/a</p>
                <img src="images/pei.jpg" alt="rush">
            <h2>Nina Lin *Belle Ame*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Jenny Zou *Bvlgari*<br/>
                Little: n/a</p>
                <img src="images/nina.jpg" alt="rush">
            <h2>Jinnie Kim *oceanic*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Soon-Mi Sugihara *thermic*<br/>
                Little: n/a</p>
                <img src="images/jinnie.jpg" alt="rush">
            <h2>Clarie Ng *Triple 7*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Michelle Zhang *Jackpot*<br/>
                Little: n/a</p>
                <img src="images/clarie.jpg" alt="rush">
            <h2>Yiwen Huang *Acrylic*</h2>
                <p>iota Psi, Spring 2016<br/>
                Big: Soon-Mi Sugihara *thermic*<br/>
                Little: n/a</p>
                <img src="images/yiwen.jpg" alt="rush">
            <h2>Nicole Kim *panacea*</h2>
                <p>iota Omega, Fall 2016<br/>
                Big: Helen Huang *Ixchel*<br/>
                Little: n/a</p>
                <img src="images/nicole1.jpg" alt="rush">
            <h2>Tracy Lam *Bailey*</h2>
                <p>iota Omega, Fall 2016<br/>
                Big: Eugenia Xiao *LifeLine*<br/>
                Little: n/a</p>
                <img src="images/tracy.jpg" alt="rush">
            <h2>Tenzin Dolma *Ramune*</h2>
                <p>iota Omega, Fall 2016<br/>
                Big: Eugenia Xiao *LifeLine*<br/>
                Little: n/a</p>
                <img src="images/tenzin.jpg" alt="rush">
            <h2>Erika Kim *luciole*</h2>
                <p>iota Omega, Fall 2016<br/>
                Big: Kiana Leung *unforgettable*<br/>
                Little: n/a</p>
                <img src="images/erika.jpg" alt="rush">
            <h2>Julie Lim *libellule*</h2>
                <p>iota Omega, Fall 2016<br/>
                Big: Kiana Leung *unforgettable*<br/>
                Little: n/a</p>
                <img src="images/julie.jpg" alt="rush">

                <!-- all images by Clarie Ng-->
        </div><!-- end of right div -->
        
    </div> <!-- end of content div -->   

</body>

</html>
