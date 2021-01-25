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


function checkEmail_signup(){
	 var email = document.getElementById("email").value;

	 var email_valid=/^([\w\-\+\.]+)\@([\w\-\+\.]+)\.([\w\-\+\.]+)$/;
   var err=document.getElementById("email_err");
    
  if (!email_valid.test(email) || (email == "") || (email == "undefined")) 
   {
      err.style.display="block";
      return false;
   }
   else
   {
   	err.style.display="none";
   	return true;
   }
}

function checkUsername_signup(){
	var username = document.getElementById("username").value;

	var username_valid=/^[a-zA-Z0-9]{3,16}$/;
   err=document.getElementById("username_err");
   if (!username_valid.test(username)) 
   {
      err.style.display="block";
      return false;
   }
   else
   {
   	err.style.display="none";
   	return true;
   }
}

function checkPassword_signup(){
	var password_1= document.getElementById("password_1").value;

	err=document.getElementById("password_err");
    
   if (password_1.length<4) 
   {
   	 
      err.style.display="block";
      
      return false;
   }
   else
   {
   		err.style.display="none";
   		return true;
   }
  
}


function checkUsername_login(){
 
 var username = document.getElementById("username").value;

  var username_valid=/^[a-zA-Z0-9]{3,16}$/;
   err=document.getElementById("username_err");
    err.style.display="none";
   if (!username_valid.test(username)) 
   {
      err.style.display="block";
      
      return false;
   }
   else
   {
     err.style.display="none";
     return true;
   }
}

function checkPassword_login(){
  
  var password = document.getElementById("password").value;

 err=document.getElementById("password_err");
    err.style.display="none";
   if (password.length<4) 
   {
      err.style.display="block";
      return false;
   }
   else
   {
     err.style.display="none";
     return true;
   }

}

