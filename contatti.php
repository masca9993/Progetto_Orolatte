<?php

	session_start();

	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);

	$paginaHTML = file_get_contents('contatti.html');

	$stringaLogin = "";

	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		$stringaLogin .= "<a href='login.php'  tabindex='11' >LOGIN</a>\n";
	}
	else {
		$stringaLogin .= "<p class='det_log ciao'  tabindex='11' > CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<img class='det_log' id='stile' src='img/barra_verticale.png' alt=''/>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php'  tabindex='12' >LOGOUT</a>\n";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);
	echo $paginaHTML;
?>
