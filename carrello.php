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
	if (!isset($_SESSION['loggedin']) || $_SESSION["loggedin"] == false) {
		$dlProdotti = "<p>Non hai effettuato il login! Per aggiungere prodotti al carrello, <a href='login.php'>accedi</a>.</p>";
	}
	else {
		$totale=0;
		$listaProdotti = $dbAccess->getListaProdotti_Carrello($_SESSION["email"]);
		
		$dbAccess->closeDBConnection();
		
		$dlProdotti = "";
		
		if($listaProdotti != null) {
			
			//inserisco i prodotti nella zona carrello come lista di definizioni
			$dlProdotti = '<ul id="Prodotti">';
			$dlProdotti.= '<li class="grassetto maiuscolo rosso"><p>PRODOTTO</p>
							<p >QUANTITA</p>
							<p >PREZZO</p><p></p></li>';
			
			foreach ($listaProdotti as $prodotto) {
				$dlProdotti .= '<li><p class="pt_carr">'. $prodotto['nome_item'].'</p>
									<div class="qta_carr"> 
									<p>
									<form method="post" action="carrello.php" >
									<input type="text" id="nome" name="name" value="'.$prodotto['nome_item'].'"/>
									<input type="submit" name="meno" value="-" class="minus"/></form> 
									<p class="qt_carr">'.$prodotto['quantità'].'</p>
        							<form method="post" action="carrello.php">
        							<input type="text" id="nome" name="name" value="'.$prodotto['nome_item'].'"/>
        							<input type="submit" name="aggiungi" value="+"" class="plus"/></form></div></p>
									<p class="pz_carr">'. $prodotto['prezzo']*$prodotto['quantità'] .'&euro; </p>
					<p><form method="post" action="carrello.php"><fieldset class="no_colore">
					<input type="text" name="name" value="'.$prodotto['nome_item'].'" class="nascondi"/>
					<input type="submit" name="rimuovi" class="bottone_rosso" value="Rimuovi"/>
					</fieldset></form></p></li>';
					$totale=$totale+$prodotto['prezzo']*$prodotto['quantità'];	
			}
			$dlProdotti.="<li><p class='grassetto'>TOTALE: ".$totale." &euro;";
			$dlProdotti = $dlProdotti . "</ul>";
			$stringaPulsanteOrdine = "<form method='post' action='carrello.php'><fieldset class='no_colore'>
					<input type='submit' name='ordina' class='standard' value='Ordina subito'/>
					</fieldset></form>";
			$paginaHTML = str_replace("<ProcediAllordine />", $stringaPulsanteOrdine, $paginaHTML);
		}
		else {
			$dlProdotti = "<p>Nessun prodotto nel carrello</p>";
		}
	}
	
	$stringaLogin = "";
	$stringaPulsanteOrdine = "";

	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		$stringaLogin .= "<a href='login.php' tabindex='6'>LOGIN</a>\n";
	}
	else {
		$stringaLogin .= "<p class='det_log ciao' tabindex='11'> CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<div class='barraVerticale det_log' id='stile'></div>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php'>LOGOUT</a>\n";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);
	$paginaHTML = str_replace("<listaProdotti />", $dlProdotti, $paginaHTML);	//tag da aggiungere nella zona carrello
}

if (isset($_POST["rimuovi"])){
	$dbAccess->openDBConnection();
	$nome=$_POST['name'];
	$email=$_SESSION['email'];
	$queryResult=$dbAccess->diminuisci_tutto($nome,$email);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$strerrore="<p id='errore_aggiunta'>ERRORE DURANTE LA RIMOZIONE, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		$strerrore="<p id='successo_aggiunta'>PRODOTTO RIMOSSO CON SUCCESSO!</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
		header("Refresh:2");
	}
}
if (isset($_POST["ordina"])){
	$dbAccess->openDBConnection();
	$email=$_SESSION['email'];
	$queryResult=$dbAccess->ordina($email);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$strerrore="<p id='errore_aggiunta'>ERRORE, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		$strerrore="<p id='successo_aggiunta'>ORDINE AVVENUTO CON SUCCESSO!</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
		header("Refresh:2");
	}
}
if (isset($_POST["aggiungi"])){
		$dbAccess->openDBConnection();
		$nome=$_POST['name'];
		$queryResult=$dbAccess->aggiungi($nome,$_SESSION['email']);
		$dbAccess->closeDBConnection();
		if($queryResult==false){
		$strerrore="<p id='errore_aggiunta'>ERRORE DURANTE L'AGGIUNTA AL CARRELLO, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
		}
		else{
			header("Refresh:0");
		}
}

if (isset($_POST["meno"])){
	$dbAccess->openDBConnection();
	$nome=$_POST['name'];
	$email=$_SESSION['email'];
	$queryResult=$dbAccess->diminuisci($nome,$email);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$strerrore="<p id='errore_aggiunta'>RIMOZIONE NON RIUSCITA, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}
echo $paginaHTML;
?>
