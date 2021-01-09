<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta charset="utf-8">

<title> Gallery | Orolatte </title>

<meta name="title" content="Gallery | Orolatte" />
<meta name="keywords" content="gallery" />

<meta name="language" content="italian it" />

<link rel="stylesheet" type="text/css" href="style/gallery_desktop.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="style/gallery_mobile.css" media="handheld, screen and (max-width:640px), only screen and (max-device-width:640px)"/>
<link rel="stylesheet" type="text/css" href="style/gallery_stampa.css" media="print"/>

</head>

<body>
	<!-- HEADER -->
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
					<a href="index.php" >HOME</a>
					<img id="stile" src="img/barra_verticale.png" alt=""/> 
				</li>
				<li>
					<a href="gelati.php">GELATI</a>
					<img id="stile" src="img/barra_verticale.png" alt=""/> 
				</li>
				<li>
					GALLERY
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
	
	<!-- PERCORSO -->
	<div id="percorso">
		<p>Ti trovi in: Gallery</p>
	</div>
	
	<!-- CONTENUTO PAGINA -->
	<div id="contenutoPagina" class="contenutogenerale">
		<h2> GALLERY </h2>
		<div id="flex-gallery">
			<div class="galleryItem">
				<a onclick="openModal('cuore_frutta')">
			    		<img src="img/cuore_frutta.jpeg" alt="torta a forma di cuore con sopra frutti rossi">
			    	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('monica')">
			    		<img src="img/monica.jpeg" alt="donna sorridente con in mano un cono gelato">
			    	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('cassetta_frutta')">	
			    		<img src="img/cassetta_frutta.jpeg" alt="torta a forma di cassetta di frutta">
			    	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('anelliMonaco')">
			    		<img src="img/anelliMonaco.jpeg" alt="Anelli di Monoaco artigianali">
			    	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('cannoli')">
			    		<img src="img/cannoli.jpeg" alt="cannoli siciliani">
			  	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('fruttiRossi')">
			    		<img src="img/fruttiRossi.jpeg" alt="frutti rossi: lamponi, mirtilli e more">
			  	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('tortaOceano')">
			    		<img src="img/tortaOceano.jpeg" alt="torta che rappresenta un fondale di un oceano">
			  	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('torte_rosa')">
			    		<img src="img/torte_rosa.jpeg" alt="torte alla fragola eleganti">
			  	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('gelato_amarena')">
			    		<img src="img/gelato_amarena.jpeg" alt="gelato gusto variegato amarena">
			  	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('panettone')">
			    		<img src="img/panettone.jpeg" alt="Panettone artigianale con confezione natalizia">
			  	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('tokyo')">
			    		<img src="img/tokyo.jpeg" alt="Tronchetto Tokyo">
			  	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('danese')">
			    		<img src="img/danese.jpeg" alt="brioche danese con fragole e crema">
			  	</a>
			</div>
			
			<div class="galleryItem">
				<a onclick="openModal('brioches')">
			    		<img src="img/brioches.jpeg" alt="brioche varie">
			  	</a>
			</div>
		</div>
		
		
		<!--modal-->
		<div id="myModal" class="modal">
			<button class="close" onclick="closeModal()">&times;</button>
			<div class="modal-content">
				<div class="slide" id="cuore_frutta">
					<img src="img/cuore_frutta.jpeg" alt="torta a forma di cuore con sopra frutti rossi">
				</div>
				
				<div class="slide" id="monica">
					<img src="img/monica.jpeg" alt="donna sorridente con in mano un cono gelato">
				</div>
				
				<div class="slide" id="cassetta_frutta">
					<img src="img/cassetta_frutta.jpeg" alt="torta a forma di cassetta di frutta">
				</div>
				
				<div class="slide" id="anelliMonaco">
					<img src="img/anelliMonaco.jpeg" alt="Anelli di Monoaco artigianali">
				</div>
				
				<div class="slide" id="cannoli">
					<img src="img/cannoli.jpeg" alt="cannoli siciliani">
				</div>
				
				<div class="slide" id="fruttiRossi">
					<img src="img/fruttiRossi.jpeg" alt="frutti rossi: lamponi, mirtilli e more">
				</div>
				
				<div class="slide" id="tortaOceano">
					<img src="img/tortaOceano.jpeg" alt="torta che rappresenta un fondale di un oceano">
				</div>
				
				<div class="slide" id="torte_rosa">
					<img src="img/torte_rosa.jpeg" alt="torte alla fragola eleganti">
				</div>
				
				<div class="slide" id="gelato_amarena">
					<img src="img/gelato_amarena.jpeg" alt="gelato gusto variegato amarena">
				</div>
				
				<div class="slide" id="panettone">
					<img src="img/panettone.jpeg" alt="Panettone artigianale con confezione natalizia">
				</div>
				
				<div class="slide" id="tokyo">
					<img src="img/tokyo.jpeg" alt="Tronchetto Tokyo">
				</div>
				
				<div class="slide" id="danese">
					<img src="img/danese.jpeg" alt="brioche danese con fragole e crema">
				</div>
				
				<div class="slide" id="brioches">
					<img src="img/brioches.jpeg" alt="brioche varie">
				</div>
			</div>
			
			
		</div>
	</div>
	
	<div id="footer">
		<img id="imgvalidcode" src="img/valid-xhtml10.png" alt="" />
	  	<img id="imgvalidcss" src="img/vcss-blue.gif" alt="" />
	  	<p>Il sito e' stato creato come progetto del corso di Tecnologie Web dell' Università di Padova</p>
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
	
	<script>
		//
		function myFunction() {
			var x = document.getElementById("Links");
			if (x.style.display === "block") {
				x.style.display = "none";
			}
			else {
			   	x.style.display = "block";
			}
		}
		
		
		//apre ingrandimento immagine
		function openModal(id){
			document.getElementById("myModal").style.display="block";
			document.getElementById(id).style.display="block";
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
		}
	</script>
	
</body>
</html>
