"use strict";

//Variables
var i = 0;
var pix = ["banquet1.jpg", "banquet2.jpg", "banquet3.jpg", "banquet4.jpg"];
var first_image = document.getElementById('banquet');
console.log(first_image);

//Function
function showDiv(n) {

 i += n;  
    if (i<0){ // if i<0, i= number of pictures/picture length -1 
        i = pix.length-1; 
        document.getElementById('banquet').src = 'images/' + pix[i];
    }

    else if (i <= pix.length-1 && i>=0) { // else if i>0, i = number of pictures/picture length -1 
        document.getElementById('banquet').src = 'images/' + pix[i];
    } 
    
    else {
        i=0; // else i=0, retrieve the first image
        document.getElementById('banquet').src = 'images/' + pix[i];   
    } 
}