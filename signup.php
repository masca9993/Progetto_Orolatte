<?php
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);

	session_start();

	define("DB_SERVER", "localhost");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "root");
	define("DB_NAME", "gelateria");

	$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if ($con === false) {
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}

	$username = "";
	$email = "";
	$password = "";
	$different_passwords = false;
	$email_taken = false;
	$username_taken = false;
	$signup_successful = false;

	if (isset($_POST["submit"])) {
		$username = mysqli_real_escape_string($con, $_POST["username"]);
		$email = mysqli_real_escape_string($con, $_POST["email"]);
		$password_1 = mysqli_real_escape_string($con, $_POST["password_1"]);
		$password_2 = mysqli_real_escape_string($con, $_POST["password_2"]);

		if ($password_1 != $password_2) {
			$different_passwords = true;
		}

		$user_check_query = "SELECT email, username FROM user WHERE email='$email' OR username='$username' LIMIT 1;";
		$result = mysqli_query($con, $user_check_query);

		if ($result) {

			$row = mysqli_fetch_array($result);

			if ($row) {
				if ($row["email"] == $email) {
					$email_taken = true;
				}
				if ($row["username"] == $username) {
					$username_taken = true;
				}
			}
		}

		if ($different_passwords == false && $email_taken == false && $username_taken == false) {
			$password = sha1($password_1);

			$query = "INSERT INTO user (email, username, password, admin) VALUES('$email', '$username', '$password', 0)";
			mysqli_query($con, $query);

			$signup_successful = true;
		}
	}

	$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
	if ($pageWasRefreshed) {
		$email_taken = false;
		$username_taken = false;
		$different_passwords = false;
		$signup_successful = false;
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

	<link rel="stylesheet" type="text/css" href="style/signup_desktop.css" media="screen"/>

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
	<p> Ti trovi in: Registrazione</p>
</div>

<h1>SING UP</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="form-group">
		<label for="emal"> Inserire il proprio indirizzo email: </label>
		<input type="email" id="email" name="email" placeholder="nome.cognome@esempio.com" autofocus required>
		<?php if ($email_taken == true) : ?>
			<p class="errors">Esiste gi&agrave; un utente con questo indirizzo email</p>
		<?php endif; ?>
	</div>
	<div class="form-group">
		<label for="username"> Inserire il proprio username: </label>
		<input type="text" id="username" name="username" placeholder="Username" required>
		<?php if ($username_taken == true) : ?>
			<p class="errors">Esiste gi&agrave; un utente con questo username</p>
		<?php endif; ?>
	</div>
	<div class="form-group">
		<label for="password"> Inserire la propria password: </label>
		<input type="password" id="password_1" name="password_1" placeholder="Password" required>
	</div>
	<div class="form-group">
		<label for="password"> Confermare la propria password: </label>
		<input type="password" id="password_2" name="password_2" placeholder="Password" required>
		<?php if ($different_passwords == true) : ?>
			<p class="errors">Le password inserite non coincidono</p>
		<?php endif; ?>
	</div>
	<div class="form-group">
		<input type="submit" name="submit" value="Registrati">
		<input type="reset" name="reset" value="Cancella">
	</div>
</form>

<div>
	<?php if ($signup_successful == true) : ?>
		<p class="success-message">La registrazione &egrave; andata a buon fine!</p>
	<?php endif; ?>
</div>

<div id="login-link">
	<p>Hai gi&agrave; un account? <a href="login.php">Accedi</a></p>
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
