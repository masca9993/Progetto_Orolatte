<?php
	session_start();
	unset($_SESSION["loggedin"]);
	unset($_SESSION["username"]);
	unset($_SESSION["email"]);
	unset($_SESSION["admin"]);
	header("location: index.php");
?>
