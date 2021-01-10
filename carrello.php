<?php

session_start();

	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);

//aggiorna la zona carrello nella pagina

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('carrello.html');

$dbAccess = new DBAccess();	
$connessioneRiuscita = $dbAccess->openDBConnection();

if ($connessioneRiuscita == false) {
	die ("Errore nell'apertura del DB");	
}
else {
	if ($_SESSION["loggedin"] == false) {
		$dlProdotti = "<p>Non hai effettuato il login! Per aggiungere prodotti al carrello, <a href='login.php'>accedi</a>.</p>";
	}
	else {
		$listaProdotti = $dbAccess->getListaProdotti($_SESSION["email"]);
		
		$dbAccess->closeDBConnection();
		
		$dlProdotti = "";
		
		if($listaProdotti != null) {
			
			//inserisco i prodotti nella zona carrello come lista di definizioni
			$dlProdotti = '<ul id="Prodotti">';
			
			foreach ($listaProdotti as $prodotto) {
				$dlProdotti .= '<li><p>' . $prodotto['nome_item'] . " " . $prodotto['grandezza'] . "<a href=''><button class='delete'>Rimuovi</button></a></p></li>";	
			}
			
			$dlProdotti = $dlProdotti . "</ul>";
			
		}
		else {
			$dlProdotti = "<p>Nessun prodotto nel carrello</p>";
		}
	}
	
	$paginaHTML = str_replace("<listaProdotti />", $dlProdotti, $paginaHTML);	//tag da aggiungere nella zona carrello
	echo $paginaHTML;
}


?>
