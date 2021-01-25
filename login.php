<?php
	session_start();

	$_SESSION["loggedin"] = false;

	$paginaHTML = file_get_contents('login.html');

	define("DB_SERVER", "localhost");
	define("DB_USERNAME", "root");
	define("DB_PASSWORD", "");
	define("DB_NAME", "gelateria");

	$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if ($con === false) {
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}

	$username = "";
	$password = "";
	$stringaErroreLogin = "";

	if (isset($_POST["submit"])) {
		$username = mysqli_real_escape_string($con, $_POST["username"]);
		$password = mysqli_real_escape_string($con, $_POST["password"]);

		$username_err=false;
		$password_err=false;

		if(!preg_match('/^[a-zA-Z0-9]{3,16}$/',$username))
		{
			$username_err=true;
		}

		if(strlen($password)<4)
		{
			$password_err=true;
		}


		$password = sha1($password);
		$result=0;

		if(!$username_err && !$password_err)
		{
		$login_check_query = "SELECT * FROM user WHERE username='$username' AND password='$password';";
		$result = mysqli_query($con, $login_check_query);
		}

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
		} else {
			$stringaErroreLogin = "<p class='errors'>Le credenziali inserite non risultano valide</p>";
		}
	}

	$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
	if ($pageWasRefreshed) {
		$erroreLogin = false;
		$username_err=false;
		$password_err=false;
	}

	mysqli_close($con);

	$stringaLogin = "";

	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		$stringaLogin .= "<p xml:lang='en'>LOGIN</p>\n";
	}
	else {
		$stringaLogin .= "<p class='det_log ciao'> CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<div class='barraVerticale det_log'></div>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php' xml:lang='en'>LOGOUT</a>\n";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);
	$paginaHTML = str_replace("<ErroreLogin />", $stringaErroreLogin, $paginaHTML);
	echo $paginaHTML;
?>
