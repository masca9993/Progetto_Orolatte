<?php

session_start();

	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openDBConnection();
$paginaHTML = file_get_contents('prodotti.html');

if($connessioneRiuscita == false){
  die("Errore nell'apertura del DB");
}
else{
	$listaProdotti= $dbAccess->getListaProdotti($_SESSION["email"]);

	$dbAccess->closeDBConnection();
	
	if($listaProdotti != null){

		$definitionListProdotti='';
		foreach($listaProdotti as $prodotto){
			$definitionListProdotti.='<div class="flex"><dl id="prodotti"><dt>'.$prodotto['nome'].'</dt>';
			$definitionListProdotti.='<dd>';
			$definitionListProdotti.='<img src="'.$prodotto['immagine'].'"/>';
			$definitionListProdotti.='<p>'.$prodotto['descrizione'].'</p>';
			if($prodotto['categoria']=="torta")
				$definitionListProdotti.='<button id="carrello">Aggiungi al carrello</button>';
			$definitionListProdotti.='</dd> </dl> </div>';
		}
		
	}
	else{

		// messaggi che non son presenti prodotti
		$definitionListProdotti='<p>Nessun prodotto presente</p>';
	}
	echo str_replace("<prodotti/>", $definitionListProdotti, $paginaHTML);
}

?>
