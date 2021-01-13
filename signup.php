<?php

	session_start();

	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);

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

	$paginaHTML = file_get_contents('signup.html');

	$stringaLogin = "";
	$stringaErroreEmail = "";
	$stringaErroreUsername = "";
	$stringaErrorePassword = "";
	$stringaSuccessoRegistrazione = "";

	if ($_SESSION['loggedin'] == false) {
		$stringaLogin .= "<a href='login.php'>LOGIN</a>\n";
	}
	else {
		$stringaLogin .= "<p> CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<img id='stile' src='img/barra_verticale.png' alt=''/>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php'>LOGOUT</a>\n";
	}

	if ($email_taken == true) {
		$stringaErroreEmail = "<p class='errors'>Esiste gi&agrave; un utente con questo indirizzo email</p>";
	}
	if ($username_taken == true) {
		$stringaErroreUsername = "<p class='errors'>Esiste gi&agrave; un utente con questo username</p>";
	}
	if ($different_passwords == true) {
		$stringaErrorePassword = "<p class='errors'>Le password inserite non coincidono</p>";
	}
	if ($signup_successful == true) {
		$stringaSuccessoRegistrazione = "<p class='success-message'>La registrazione &egrave; andata a buon fine!</p>";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);
	$paginaHTML = str_replace("<ErroreEmail />", $stringaErroreEmail, $paginaHTML);
	$paginaHTML = str_replace("<ErroreUsername />", $stringaErroreUsername, $paginaHTML);
	$paginaHTML = str_replace("<ErrorePassword />", $stringaErrorePassword, $paginaHTML);
	$paginaHTML = str_replace("<SuccessoRegistrazione />", $stringaSuccessoRegistrazione, $paginaHTML);
	echo $paginaHTML;
?>