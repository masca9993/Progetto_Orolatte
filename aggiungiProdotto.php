<?php

session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('delivery.html');	//delivery dovrebbe essere la pagina da cui prende le info

//inizializzazione campi

if(isset($_POST['inserisci'])) {	//dipende dal valore dato al pulsante nella form
	$email_user = $_POST[$_SESSION["email"]];	
	$nome_item = $_POST['nome_item'];
	$grandezza = $_POST['grandezza'];
	
	if(strlen($email_user) == 0) {
		//reindirizzamento alla pagina di login
		header("location: login.php");
	}
	else if(strlen($email_user) != 0 && strlen($nome_item) != 0 && strlen($grandezza) != 0)){
		//aggiungo alla tabella carrello
		
		$dbAccess = new DBAccess();
		$openDBConnection = $dbAccess->openDBConnection();
		
		if($openDBConnection == true) {
			$risultatoInserimento = $dbAccess->inserisciProdotto($email_user, $nome_item, $grandezza);
			
			if($risultatoInserimento == true) {
				$messaggioPerForm = '<div id="conferma"><p>Prodotto inserito correttamente</p></div>';
				$nome_item = '';
				$grandezza = '';
			}
			else {
				$messaggioPerForm = '<div id="errori"><p>Errore nell\'inserimento del prodotto. Riprovare</p></div>';
			}
		}
		
		$dbAccess->closeDBConnection();
	
	}
	else {
		//mostro all'utente gli errori commessi
		$messaggioPerForm = '<div id="errori"><ul>';
		
		
		if(strlen($nome_item) == 0) {
			$messaggioPerForm .= '<li>Scegliere il prodotto desiderato</li>';
		}
		if(strlen($grandezza) == 0) {
			$messaggioPerForm .= '<li>Scegliere la dimensione desiderata</li>';
		}
		$messaggioPerForm .= '</ul></div>';
	}
}

$paginaHTML = str_replace('<messaggioForm />', $messaggioPerForm, $paginaHTML);
$paginaHTML = str_replace('<item />', $nome_item, $paginaHTML);
$paginaHTML = str_replace('<dim />', $grandezza, $paginaHTML);

//tag da aggiungere alla pagina html

echo $paginaHTML;

?>
