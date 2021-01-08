<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);

	session_start();

	$_SESSION["loggedin"] = false;

	define("DB_SERVER", "localhost");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "root");
	define("DB_NAME", "gelateria");

	$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if ($con === false) {
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}

	$username = "";
	$password = "";

	if (isset($_POST["submit"])) {
		$username = mysqli_real_escape_string($con, $_POST["username"]);
		$password = mysqli_real_escape_string($con, $_POST["password"]);

		$password = sha1($password);

		$login_check_query = "SELECT * FROM user WHERE username='$username' AND password='$password';";
		$result = mysqli_query($con, $login_check_query);

		if ($result && mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result);
			if ($row) {

				$_SESSION["loggedin"] = true;
				$_SESSION["username"] = $row["username"];
				$_SESSION["email"] = $row["email"];
				$_SESSION["admin"] = false;

				if ($row["admin"] == true) {
					$_SESSION["admin"] = true;
				}
			}

			header("location: index.php");
		}
	}

	$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
	if ($pageWasRefreshed) {
	}

	mysqli_close($con);
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

	<link rel="stylesheet" type="text/css" href="style/login_desktop.css" media="screen"/>

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
				<a href="contatti.php">CONTATTI</a>
			</li>
		</ul>
	</em>
	<em class="menu" id="menu_2">
		<ul>
			<li>
				<img id="stile" src="img/login.png" alt=""/>
				<?php if ($_SESSION["loggedin"] == false) : ?>
					LOGIN
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
	<p> Ti trovi in: Accesso</p>
</div>

<h1> LOGIN </h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="form-group">
		<label for="username"> Inserire il proprio username: </label>
		<input type="text" id="username" name="username" placeholder="Username" autofocus required>
	</div>
	<div class="form-group">
		<label for="password"> Inserire la propria password: </label>
		<input type="password" id="password" name="password" placeholder="Password" required>
	</div>
	<div class="form-group">
		<input type="submit" name="submit" value="Accedi">
		<input type="reset" name="reset" value="Cancella">
	</div>
</form>

<div id="signup-link">
	<p>Non hai ancora un account? <a href="signup.php">Registrati</a></p>
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
