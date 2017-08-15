var accumulator = 0;

function showmenu(){
	document.getElementById("menu1").className = "animated fadeIn";
	document.getElementById("menu1").style.visibility = "visible";
}
function hidemenu(){
	document.getElementById("menu1").className = "animated fadeOut";
}

//nav is a string that specifies the name of the div
function createmenu(nav){
	var navbarcats = ["HOME","ABOUT","PROJECTS", "ART","CONTACT"];
	var navbarlinks = ["#homepage","#aboutpage", "#portfoliopage","#artpage","#contactpage"];
	var menu = [];
	for (i = 0;i<navbarcats.length;i++){
		if (navbarlinks[i] == "documents/Resume1.pdf"){
			menu.push("<li class='hvr-underline-from-center'><a href="+navbarlinks[i]+" target='_blank' class='smoothScroll'>"+navbarcats[i]+"</a></li>");
		}
		else{
			menu.push("<li class='hvr-underline-from-center'><a href="+navbarlinks[i]+" class='smoothScroll'>"+navbarcats[i]+"</a></li>");
		}
	}
	document.getElementById(nav).innerHTML = menu.join("");
}



function showtext(textcaption, diffalbs){
	var createtext = document.getElementById(textcaption);
	if (textcaption.indexOf("mobile") == -1){
		createtext.innerHTML = "<div id='albumscaption' class='animated fadeIn'>"+diffalbs+"</div>";
	}
	else{
		createtext.innerHTML = "<div class='albumscaptionmobile animated fadeIn'>"+diffalbs+"</div>";
	}
}


function hidetext2(name){
	document.getElementById(name).innerHTML = "";
}


