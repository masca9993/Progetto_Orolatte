<?php

	session_start();

	$paginaHTML = file_get_contents('gallery.html');

	$stringaLogin = "";

	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		$stringaLogin .= "<a href='login.php'>LOGIN</a>\n";
	}
	else {
		$stringaLogin .= "<p class='det_log ciao'> CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<div class='barraVerticale det_log' id='stile'></div>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php' role='button' xml:lang='en'>LOGOUT</a>\n";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);
	echo $paginaHTML;
?>
