<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Contatti - Gelateria Orolatte</title>
<meta name="title" content="Orolatte"/>
<meta name="description" content="sito realizzato per il corso di TecWeb"/>
<meta name="keywords" content=""/>
<meta name="author" content="TecWeb class"/>
<meta name="language" content="italian it"/>

<link rel=“icon” href=“img/icona_logo.png” type="image/png"/>
<link rel=“shortcut icon” href=“img/icona_logo.png”   type="image/png" />
<!--Responsive design: vengono definiti dei punti di rottura e viene creato un layout per ogni livello, ogni layaut deve essere acessibile e tenere conto della variabilità -->
<link rel="stylesheet" type ="text/css" href="style/contatti_desktop.css" media="screen" />
<link rel="stylesheet" type="text/css" href="style/contatti_mobile.css" media="handheld , screen and (max-width:640px), only screen and (max-device-width:640px)" />
<link rel="stylesheet" type ="text/css" href="style/contatti_stampa.css" media="print" />

</head>
<body id="pagina">
<div id="container">
<div id="header">
	<ul>
		<li class="aiutiNascosti"><a href="#menu_1">vai al menù</a></li>
		<li class="aiutiNascosti"><a href="contenutoPagina">Vai al contenuto</a></li>
	</ul>
	<div  class="menu" id="icona_mobile">
		<a  href="#menu_mobile">
			<img onclick="menu()" id="stile" src="img/menu.png" alt="menù"/>
		</a>
	</div>
	<div class="menu" id="menu_1">
		<ul>
			<li>
				<a href="index.php" >HOME</a>
				<img id="stile" src="img/barra_verticale.png" alt=""/> 
			</li>
			<li>
				<a href="prodotti.php">GELATI</a>
				<img id="stile" src="img/barra_verticale.png" alt=""/> 
			</li>
			<li>
				<a href="gallery.php">GALLERY</a>
				<img id="stile" src="img/barra_verticale.png" alt=""/> 
			</li>
			<li>
				CONTATTI
			</li>
		</ul>
	</div>
	<div class="menu" id="menu_2">
		<ul>
			<li>
				<img id="stile" src="img/login.png" alt=""/>
				<?php if ($_SESSION["loggedin"] == false) : ?>
					<a href="login.php">LOGIN</a>
				<?php endif; ?>
				<?php if ($_SESSION["loggedin"] == true) : ?>
					<p> CIAO <?php echo $_SESSION["username"] ?> </p>
				<?php endif; ?>
				<img id="stile" src="img/barra_verticale.png" alt=""/>
			</li>
			<li>
				<img id="stile" src="img/carrello.png" alt=""/>
				<a href="carrello.php">CARRELLO</a>
			</li>
		</ul>
	</div>
	<div id="titolo">
		<img id="logo" src="img/logo_1.png" alt="Logo"/>
		<h1> Gelateria Orolatte </h1>
	</div>
	<div class="menu" id="titolo_mobile">
		<img id="logo_mobile" src="img/scritta_logo.png" alt="Logo"/>
		<h1> Gelateria Orolatte </h1>
	</div>
</div>
<div id="percorso">
	<p>Ti trovi in: Contatti</p>
</div>
<div id="contenutoPagina" class="contenutogenerale">
	<div class="flex" id="box">
		<iframe id="mappa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22443.421582594376!2d10.572727529212067!3d45.31998517325374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4781c722eea8dd5d%3A0xc384123efe3a9f44!2sOrolatte%20Pasticceria%20Gelateria%20Caff%C3%A8!5e0!3m2!1sit!2sit!4v1608072328104!5m2!1sit!2sit" ></iframe>
	</div>
	<div class="flex" id="contatti">
		<h2>Contatti</h2>	
		<ul>
			<li><span class="grassetto maiuscolo"> Tel:</span> 347 792 6494</li>
			<li><span class="grassetto maiuscolo">Indicazioni:</span> Via Matteotti 7, Guidizzolo (92,83 km) 46040 Guidizzolo, Lombardia</li>
			<li><span class="grassetto maiuscolo">Facebook:</span><a href="https://it-it.facebook.com/OrolatteGelateriaCafe/"> OrolatteGelateriaCaffè </a></li>
		</ul>
	</div>
</div>
<div id="push">
</div>
</div>
<div id="footer">
	<img id="imgvalidcode" src="img/valid-xhtml10.png" alt="" />
  	<img id="imgvalidcss" src="img/vcss-blue.gif" alt="" />
  	<p>Il sito e' stato creato come progetto del corso di Tecnologie Web dell' Università di Padova</p>
</div>
<script type="text/javascript">
 function menu() {
   var x=document.getElementById("menu_1");
   if(x.style.display=="none"){
      x.style.display="block";
   }
  else{
      x.style.display="none";
    }
 }
</script>
</body>
</html>
