<?php

	session_start();

	$paginaHTML = file_get_contents('contatti.html');

	$stringaLogin = "";

	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		$stringaLogin .= "<a href='login.php' tabindex='11' xml:lang='en'>LOGIN</a>\n";
	}
	else {
		$stringaLogin .= "<p class='det_log ciao'  tabindex='11' > CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<img class='det_log' id='stile' src='img/barra_verticale.png' alt=''/>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php'  tabindex='12' xml:lang='en'>LOGOUT</a>\n";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);
	echo $paginaHTML;
?>
