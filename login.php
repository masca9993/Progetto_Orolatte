<?php
	session_start();

	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);


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

	$paginaHTML = file_get_contents('login.html');

	$stringaLogin = "";

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

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);
	echo $paginaHTML;
?>