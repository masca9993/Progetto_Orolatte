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
				<?php if (session_status() == "PHP_SESSION_NULL" or $_SESSION["loggedin"] == false) : ?>
					<a href="login.php">LOGIN</a>
				<?php endif; ?>
				<?php if (session_status() == "PHP_SESSION_ACTIVE" and $_SESSION["loggedin"] == true) : ?>
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
