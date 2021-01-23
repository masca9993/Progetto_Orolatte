function menu() {
	var x=document.getElementById("menu_mobile");
	if(x.style.display!="block"){
		x.style.display="block";
	}
	else{
		x.style.display="none";
	}
}

//specifiche di gallery
var focused;

//apre ingrandimento immagine
function openModal(id){
	focused = document.activeElement;
	document.getElementById("myModal").style.display="block";
	document.getElementById(id).style.display="block";
	document.getElementById("close").focus();
}
				
//chiude ingrandimento immagine
function closeModal() {
	var slides=document.getElementsByClassName("slide");
	document.getElementById("myModal").style.display = "none";
	for(var i=0; i < slides.length; i++) {
		if(slides[i].style.display === "block") {
			slides[i].style.display = "none";
		}
	}
	focused.focus();
}
