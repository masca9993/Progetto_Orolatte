<?php

	session_start();

	define("DB_SERVER", "localhost");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "");
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
	$stringaErroreEmail = "";
	$stringaErroreUsername = "";
	$stringaErrorePassword = "";
	$stringaSuccessoRegistrazione = "";

	if (isset($_POST["submit"])) {
		$username = mysqli_real_escape_string($con, $_POST["username"]);
		$email = mysqli_real_escape_string($con, $_POST["email"]);
		$password_1 = mysqli_real_escape_string($con, $_POST["password_1"]);
		$password_2 = mysqli_real_escape_string($con, $_POST["password_2"]);

		if ($password_1 != $password_2) {
			$different_passwords = true;
			$stringaErrorePassword = "<p class='errors'>Le password inserite non coincidono</p>";
		}

		$user_check_query = "SELECT email, username FROM user WHERE email='$email' OR username='$username' LIMIT 1;";
		$result = mysqli_query($con, $user_check_query);

		if ($result) {

			$row = mysqli_fetch_array($result);

			if ($row) {
				if ($row["email"] == $email) {
					$email_taken = true;
					$stringaErroreEmail = "<p class='errors'>Esiste gi&agrave; un utente con questo indirizzo email</p>";
				}
				if ($row["username"] == $username) {
					$username_taken = true;
					$stringaErroreUsername = "<p class='errors'>Esiste gi&agrave; un utente con questo username</p>";
				}
			}
		}

		if ($different_passwords == false && $email_taken == false && $username_taken == false) {
			$password = sha1($password_1);

			$query = "INSERT INTO user (email, username, password, admin) VALUES('$email', '$username', '$password', 0)";
			mysqli_query($con, $query);

			$signup_successful = true;
			$stringaSuccessoRegistrazione = "<p class='success-message'>La registrazione &egrave; andata a buon fine!</p>";
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

	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		$stringaLogin .= "<a href='login.php' xml:lang='en'>LOGIN</a>\n";
	}
	else {
		$stringaLogin .= "<p class='det_log ciao'> CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<div class='barraVerticale det_log' id='stile'></div>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php' role='button' xml:lang='en'>LOGOUT</a>\n";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);
	$paginaHTML = str_replace("<ErroreEmail />", $stringaErroreEmail, $paginaHTML);
	$paginaHTML = str_replace("<ErroreUsername />", $stringaErroreUsername, $paginaHTML);
	$paginaHTML = str_replace("<ErrorePassword />", $stringaErrorePassword, $paginaHTML);
	$paginaHTML = str_replace("<SuccessoRegistrazione />", $stringaSuccessoRegistrazione, $paginaHTML);
	echo $paginaHTML;
?>
