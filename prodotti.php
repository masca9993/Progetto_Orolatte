<?php
include "dbconnection.php";
use DB\dbAccess;
session_start();

ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);

$dbAccess=new DBAccess();
$connessioneRiuscita= $dbAccess->openDBConnection();
$paginaHTML=file_get_contents('prodotti.html');
$nome="";
$immagine="";
$alt_foto="";
$prezzo="";
$descrizione="";
$categoria="";
if (isset($_POST["modifica"])){
	$nome=$_POST["name"];
	$immagine=$_POST["immagine"];
	$descrizione=$_POST["descrizione"];
	$alt=$_POST["alt"];
	$prezzo=$_POST["prezzo"];
	$queryResult=$dbAccess->modifica($nome,$immagine,str_replace('"',"",$descrizione),str_replace('"',"",$alt), $prezzo);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$paginaHTML=str_replace("</errelimina>", "<p id=elimina>modifica non riuscita</p></errelimina>", $paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}
if (isset($_POST["meno"])){
	$nome=$_POST['name'];
	$queryResult=$dbAccess->diminuisci($nome);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		//$paginaHTML=str_replace("</errelimina>", "<p id=elimina>rimozione non riuscita</p>", $paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}
if (isset($_POST["piu"])){
	$nome=$_POST['name'];
	$utente=$_SESSION['email'];
	$queryResult=$dbAccess->aggiungi($nome, $utente);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		//$paginaHTML=str_replace("</errelimina>", "<p id=elimina>rimozione non riuscita</p>", $paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}
if(isset($_POST['submit'])){
	$errori="";
	$con=$dbAccess->getConnection();
		if (isset($_POST['item']) && isset($_POST['descrizione']) && isset($_POST['foto']) && isset($_POST['nome_category']) && isset($_POST['alt_foto']) && isset($_POST['prezzo']))
		{
        $result=$dbAccess->insert($_POST['item'], $_POST['descrizione'], $_POST['foto'], $_POST['alt_foto'], $_POST['nome_category'], $_POST['prezzo']);
		if ($result === TRUE) {
			header("Refresh:0");
		} 
		else {
  		$errori= "<p> Errore nell'inserimento</p>";
  		}
}
$paginaHTML=str_replace("<errori/>", $errori, $paginaHTML);

}
if (isset($_POST["rimuovi"])){
	$nome=$_POST['name'];
	$queryResult=$dbAccess->rimuovi($nome);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$paginaHTML=str_replace("</errelimina>", "<p id=elimina>rimozione non riuscita</p>", $paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}
if (isset($_POST["aggiungi"])){
	$nome=$_POST['name'];
	$queryResult=$dbAccess->aggiungi($nome,$_SESSION['email']);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$paginaHTML=str_replace("</errelimina>", "<p id=elimina>operazione non riuscita</p>", $paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}

if($connessioneRiuscita == false){
  die("Errore nell'apertura del DB");
}
else{
	$dbAccess->openDBConnection();
	$listaProdotti= $dbAccess->getListaProdotti();
	if(isset($_POST['tutti'])){
		$listaProdotti= $dbAccess->getListaProdotti();
	}
	else if(isset($_POST['gelati'])){
		$listaProdotti= $dbAccess->getListaGelati();
	}
	else if(isset($_POST['torte'])){
		$listaProdotti= $dbAccess->getListaTorte();
	}
	$dbAccess->closeDBConnection();
	
	if(isset($_SESSION["admin"]) && $_SESSION["admin"])
	{
			$insert_form='<div id="admin">
	  <form action="prodotti.php" method="POST" id="admin_form">
	  <h2>Inserisci un Nuovo Prodotto</h2>
	    <fieldset>
	    <div class="row">
	     <label for="item">Nome Prodotto:</label>
	     <input type="text" name="item" id="item" required/>
	   </div>
	   <div class="row">
	   <label for="descrizione">Descrizione:</label>
	   <input type="text" name="descrizione" id="descrizione" required/>
	  </div>
	   <div class="row">
	   <label for="foto">Percorso Foto:</label>
	   <input type="text" name="foto" id="foto" required/>
	  </div>
	  <div class="row">
	   <label for="alt_foto">Descrizione Immagine:</label>
	   <input type="text" name="alt_foto" id="alt_foto" required/>
	  </div>
	  <div class="row">
	   <label for="prezzo">Prezzo:</label>
	   <input type="text" name="prezzo" id="prezzo" required/>
	  </div>
	   <div class="row">
	   <label for="nome_category">Categoria:</label>
	   <select name="nome_category" id="nome_category">
	  <option value="gelato">Gelato</option>
	  <option value="torta">Torta</option>
	  </select>
	  </form> 
	</div>
	  <div id="mex">
	    <mex/>
	  </div>
	  <div id="errors">
	    <errori/>
	  </div>
	  <input id="submit" type="submit" name="submit" value="Inserisci"/>
	  <input id="cancella" type="reset" name="submit" value="Cancella"/>
	</fieldset>
	  </form> 
	</div>';
	 $paginaHTML=str_replace("<insert/>", $insert_form, $paginaHTML);
	}
	if(isset($_SESSION["admin"]) && $_SESSION["admin"]){
		$paginaHTML=str_replace("<titolo/>", "<h2>Modifica Prodotti</h2>", $paginaHTML);
	}
	else{
		$intestazione="<h2>I Nostri Prodotti</h2>";
		$intestazione.='<div id="filtri">
		<form method="post" action="prodotti.php">
		<p> Applica filtri:';
		if(isset($_POST['tutti'])){
			$intestazione.='<input type="submit" name="tutti" value="Tutti" id="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Tutti", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit" name="tutti" value="Tutti"/>';
		}
		if(isset($_POST['gelati'])){
			$intestazione.='<input type="submit" name="gelati" value="Gelati" id="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Gelati", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit" name="gelati" value="Gelati"/>';
		}
		if(isset($_POST['torte'])){
			$intestazione.='<input type="submit" name="torte" value="Torte" id="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Torte", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit" name="torte" value="Torte"/>';
		}
		$intestazione.='</p>
		</form>
		</div>';
		$paginaHTML=str_replace("<titolo/>", $intestazione, $paginaHTML);
	}
	if($listaProdotti != null){

		$definitionListProdotti='';
		foreach($listaProdotti as $prodotto){
			$definitionListProdotti.='<div class="flex"><dl id="prodotti"><dt>'.$prodotto['nome'];
			$definitionListProdotti.='</dt>';
			$definitionListProdotti.='<dd>';
			$definitionListProdotti.='<img src="'.$prodotto['immagine'].'"/>';
			if(isset($_SESSION["admin"]) && $_SESSION["admin"]){
				$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" id="nome" name="name" value="'.$prodotto['nome'].'" />';
				$definitionListProdotti.='<label for="prezzo"> Modifica Prezzo: </label>
		<input type="text" id="prezzo" name="prezzo" value="'.$prodotto['prezzo'].'"/></br>';
				$definitionListProdotti.='<label for="Immagine"> Modifica Immagine: </label>
		<input type="text" id="immagine" name="immagine" value="'.$prodotto['immagine'].'"/></br>';
		$definitionListProdotti.='<label for="Descrizione immagine"> Modifica Descrizione immagine: </label>
		<textarea name="alt" rows="3" id="alt" >"'.$prodotto['alt'].'" </textarea></br>';
		$definitionListProdotti.='<label for="Descrizione"> Modifica Descrizione: </label>
		<textarea name="descrizione" rows="5" id="descrizione" >"'.$prodotto['descrizione'].'" </textarea></br>';
				$definitionListProdotti.='<input type="submit" name="modifica" value="Modifica" id="modifica"/></form>';
				$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" id="nome" name="name" value="'.$prodotto['nome'].'" />';
				$definitionListProdotti.='<input type="submit" name="rimuovi" value="Rimuovi" id="rimuovi" /></form>';
				$definitionListProdotti.='</errelimina>';
			}
			else{
				$definitionListProdotti.='<p>'.$prodotto['descrizione'].'</p>';
				if($prodotto['categoria']=="torta"){
					$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" id="nome" name="name" value="'.$prodotto['nome'].'" />';
				$definitionListProdotti.='<input type="submit" name="aggiungi" value="Aggiungi al carrello" id="aggiungi" /></form>';
				$definitionListProdotti.='</errelimina>';
				}
			}
			$definitionListProdotti.='</dd> </dl> </div>';
		}
	}
	else{

		// messaggi che non son presenti prodotti
		$definitionListProdotti='<p>Nessun prodotto presente</p>';
	}
	 $paginaHTML=str_replace("<prodotti/>", $definitionListProdotti, $paginaHTML);
}
if (!isset($_SESSION['loggedin']) || $_SESSION["loggedin"] == false) {
		$dlProdotti = "<p>Non hai effettuato il login! Per aggiungere prodotti al carrello, <a href='login.php'>accedi</a>.</p>";
	}
	else if (isset($_SESSION['admin']) && $_SESSION["admin"] == false){

		$dbAccess->openDBConnection();
		$listaProdotti = $dbAccess->getListaProdotti_Carrello($_SESSION["email"]);
		
		$dbAccess->closeDBConnection();
		
		$shopping_cart = '<div id="carrello">
  							<h2> Il tuo Ordine </h2>';
		
		if($listaProdotti != null) {
			
			//inserisco i prodotti nella zona carrello come lista di definizioni
			$shopping_cart .= '<ul id="cart">';
			foreach ($listaProdotti as $prodotto) {
				$shopping_cart .= '<li>  <p class="item">' . $prodotto['nome_item'] . '</p>
        <p class="prz">' . $prodotto['prezzo'] . '&euro;</p>    
        <div class="qta">';

        $shopping_cart.='<form method="post" action="prodotti.php"><input type="text" id="nome" name="name" value="'.$prodotto['nome_item'].'" />';
		$shopping_cart.='<input type="submit" name="meno" value="-" class="minus"/></form> <p>'. $prodotto['quantità'] . '</p>';
        $shopping_cart.='<form method="post" action="prodotti.php"><input type="text" id="nome" name="name" value="'.$prodotto['nome_item'].'" />';
		$shopping_cart.='<input type="submit" name="piu" value="+" class="plus"/></form> </div></li>';	
			}
			$shopping_cart.='</ul>
			<div id="riepilogo" >
    <p>Totale:<span>tot</span></p>
  </div>
  <div id="concludi">
    <a href="carrello.php">
    <p>Vai al Carrello</p> </a>
  </div></div>';
		}
		else {
			$shopping_cart .= '<p>Nessun prodotto nel carrello</p></div>';
		}
		$paginaHTML = str_replace("<shopping_cart/>", $shopping_cart, $paginaHTML);
}
echo $paginaHTML;

?>
