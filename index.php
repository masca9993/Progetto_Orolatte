<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>Gelateria Orolatte</title>
	<meta name="title" content="Gelateria Orolatte" />
	<meta name="description" content="Sito internet della gelateria orolatte" />
	<meta name="keywords" content="gelateria, gelato, orolatte" />
	<meta name="author" content="Luca Biasotto, Nicla Faccioli" />
	<meta name="language" content="italian it" />

	<link rel="stylesheet" type="text/css" href="style/index_desktop.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="style/index_mobile.css" media="handheld, screen and (max-width:640px), only screen and (max-device-width:640px)"/>
	<link rel="stylesheet" type="text/css" href="style/index_stampa.css" media="print"/>

</head>


<body>

<div id="header">
	<ul>
		<li class="aiutiNascosti"><a href="#menu_1">vai al menù</a></li>
		<li class="aiutiNascosti"><a href="contenutoPagina">Vai al contenuto</a></li>
	</ul>
	<em class="menu" id="icona_mobile">
		<a onclick="myFunction()" href="#menu_mobile">
			<img id="stile" src="img/menu.png" alt="menù"/>
		</a>
	</em>
	<em class="menu" id="menu_1">
		<ul>
			<li>
				HOME
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
				<a href="contatti.php">CONTATTI</a>
			</li>
		</ul>
	</em>
	<em class="menu" id="menu_2">
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
	</em>
	<em id="titolo">
		<img id="logo" src="img/logo_1.png" alt="Logo"/>
		<h1> Gelateria Orolatte </h1>
	</em>
	<em class="menu" id="titolo_mobile">
		<img id="logo_mobile" src="img/scritta_logo.png" alt="Logo"/>
		<h1> Gelateria Orolatte </h1>
	</em>
</div>

<div id="percorso">
	<p> Ti trovi in: Home</p>
</div>

<div id="content" class="wrapper">
	<div id="top">
		<!-- <img id="imgHomePage1" src="img/gelatoHomePage.jpg" alt="immagine di un gelato"/> -->
		<div class="image-container">
			<img class="imgHomePage" src="img/cassetta_frutta.jpeg" alt="immagine di un gelato"/>
		</div>
		<div class="text-container">
			<h1>La gelateria Orolatte</h1>
			<p> 
				La nostra gelateria esiste dal 1947 nella citt&agrave; di Guidizzolo (MN).
				Da sempre vendiamo ogni giorno gelato di ottima qualit&agrave;, artigianale e preparato con la massima cura ed esperienza.
				Il nostro gelato racchiude in sè tradizione, ricerca, innovazione, emozione.
				Abbiamo ereditato la professione e fatto di questa la nostra passione e ci ispiriamo quotidianamente a voi per continuare a nutrirvi, coccolarvi e sorprendervi.
				Orolatte &egrave; un’esperienza, un incontro, uno scambio. Artigiani per tradizione e passione dal 1947 in continuo movimento e ricerca.
			</p>
		</div>
	</div>

	<div id="mid">
		<div class="text-container">
			<h2>I nostri ingredienti</h2>
			<p> 
				Per preparare i nostri gelati artigianali ci basiamo esclusivamente su ingredienti di prima qualit&agrave;, freschi e bilogici.
				Si tratta delle eccellenze del nostro territorio lavorate con un metodo esclusivo per offrirvi sempre la freschezza dei prodotti della terra.
			</p>
		</div>
	</div>

	<div id="bottom">
		<div class="text-container">
			<h2>Il nuovo gelato</h2>
			<p>
				Il nostro nuovo gelato si chiama ??? ed &egrave; preparato con ???. Il gusto &egrave; ??? e vi lascer&agrave; stupiti! Venite a provarlo <a href="">in gelateria!</a>
			</p>
			<a href=""><button>Ordinalo subito!</button></a>
		</div>
		<!-- <img id="imgHomePage2" src="img/gelatoHomePage.jpg" alt="immagine di un gelato"/> -->
		<div class="image-container">
			<img class="imgHomePage" src="img/tokyo.jpeg" alt="immagine di un gelato"/>
		</div>
	</div>
</div>

<div id="footer">
	<img id="imgvalidcode" src="img/valid-xhtml10.png" alt="timbro w3c standart XHTML"/>
	<img id="imgvalidcss" src="img/vcss-blue.gif" alt="timbro w3c standart CSS3"/>
	<p> Il sito &egrave; stato realizzato nell'ambito del corso <a href="http://informatica.math.unipd.it/laurea/tecnologieweb.html">Tecnologie Web</a> come progetto </p>
</div>

<script type="text/javascript">
	function myFunction() {
		var x=document.getElementById("footer");
		x.style.height="55%";
	}
	function myFunction1(){
		var x=document.getElementById("footer");
		x.style.height="50px";
	}
</script>

</body>

</html>
