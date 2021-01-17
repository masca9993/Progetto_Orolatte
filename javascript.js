function menu() {
	var x=document.getElementById("menu_mobile");
	if(x.style.display!="block"){
		x.style.display="block";
	}
	else{
		x.style.display="none";
	}
}

function totale(){
	var v=document.forms["dati"];
	document.getElementById("riepilogo").innerHTML="<p>Totale: " +v.elements[0].value +" </p>";
}
