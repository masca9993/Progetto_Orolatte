<?php
include "dbConnection.php";
use DB\DBAccess;
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




$tabindex=14;
if($connessioneRiuscita == false){
  die("Errore nell'apertura del DB");
}
else{
	$dbAccess->openDBConnection();
	$listaProdotti= $dbAccess->getListaItem();
	if(isset($_POST['tutti'])){
		$listaProdotti= $dbAccess->getListaItem();
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
	  <h2  tabindex="'.++$tabindex.'">Inserisci un Nuovo Prodotto</h2>
	    <fieldset>
	    <div class="row">
	     <label for="item"  tabindex="'.++$tabindex.'">Nome Prodotto:</label>
	     <input type="text" name="item" id="item"  tabindex="'.++$tabindex.'" required/>
	   </div>
	   <div class="row">
	   <label for="descrizione" tabindex="'.++$tabindex.'" >Descrizione:</label>
	   <textarea name="descrizione" rows="3" id="descrizione" tabindex="'.++$tabindex.'" required></textarea>
	  </div>
	   <div class="row">
	   <label for="foto" tabindex="'.++$tabindex.'" >Percorso Foto:</label>
	   <input type="text" name="foto" id="foto" tabindex="'.++$tabindex.'" required/>
	  </div>
	  <div class="row">
	   <label for="alt_foto" tabindex="'.++$tabindex.'" >Descrizione Immagine:</label>
	  <textarea name="alt_foto" rows="3" id="alt_foto"  tabindex="'.++$tabindex.'" required></textarea>
	  </div>
	  <div class="row">
	   <label for="prezzo" tabindex="'.++$tabindex.'" >Prezzo:</label>
	   <input type="text" name="prezzo" id="prezzo"  tabindex="'.++$tabindex.'" required/>
	  </div>
	   <div class="row">
	   <label for="nome_category" tabindex="'.++$tabindex.'" >Categoria:</label>
	   <select name="nome_category" id="nome_category"  tabindex="'.++$tabindex.'" >
	  <option value="gelato" tabindex="'.++$tabindex.'" >Gelato</option>
	  <option value="torta" tabindex="'.++$tabindex.'" >Torta</option>
	  </select>
	  </form> 
	</div>
	  <div id="mex">
	    <mex/>
	  </div>
	  <div id="errors">
	    <errori/>
	  </div>
	  <input id="submit" type="submit" name="submit"  tabindex="'.++$tabindex.'" value="Inserisci"/>
	  <input id="cancella" type="reset" name="submit"  tabindex="'.++$tabindex.'" value="Cancella"/>
	</fieldset>
	  </form> 
	</div>';
	 $paginaHTML=str_replace("<insert/>", $insert_form, $paginaHTML);
	}
	if(isset($_SESSION["admin"]) && $_SESSION["admin"]){
		$paginaHTML=str_replace("<titolo/>", "<h2 tabindex='".++$tabindex."' >Modifica Prodotti</h2>", $paginaHTML);
	}
	else{
		$intestazione="<h2 id='inizio'  tabindex='".++$tabindex."' >I Nostri Prodotti</h2>";
		$intestazione.='<div id="filtri">
		<form method="post" action="prodotti.php">
		<p  tabindex="'.++$tabindex.'" > Applica filtri:';
		if(isset($_POST['tutti'])){
			$intestazione.='<input type="submit"  name="tutti" value="Tutti" id="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Tutti", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit"  tabindex="'.++$tabindex.'"  name="tutti" value="Tutti"/>';
		}
		if(isset($_POST['gelati'])){
			$intestazione.='<input type="submit" name="gelati" value="Gelati" id="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Gelati", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit"  tabindex="'.++$tabindex.'"  name="gelati" value="Gelati"/>';
		}
		if(isset($_POST['torte'])){
			$intestazione.='<input type="submit" name="torte" value="Torte" id="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Torte", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit"  tabindex="'.++$tabindex.'"  name="torte" value="Torte"/>';
		}
		$intestazione.='</p>
		</form>
		</div>';
		$paginaHTML=str_replace("<titolo/>", $intestazione, $paginaHTML);
	}
	if($listaProdotti != null){

		$definitionListProdotti='';
		foreach($listaProdotti as $prodotto){
			$definitionListProdotti.='<div class="flex"><dl id="prodotti"><dt tabindex="'.++$tabindex.'">'.$prodotto['nome'];
			$definitionListProdotti.='</dt>';
			$definitionListProdotti.='<dd>';
			$definitionListProdotti.='<img tabindex="'.++$tabindex.'" src="'.$prodotto['immagine'].'"/>';
			if(isset($_SESSION["admin"]) && $_SESSION["admin"]){
				$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" id="nome" name="name" value="'.$prodotto['nome'].'" />';
				if($prodotto['categoria']=="gelato"){
					$definitionListProdotti.='<div id="nome">';
				}
					$definitionListProdotti.='<label for="prezzo" tabindex="'.++$tabindex.'" > Modifica Prezzo: </label>
					<input type="text" id="prezzo" name="prezzo" tabindex="'.++$tabindex.'"  value="'.$prodotto['prezzo'].'"/></br>';
				if($prodotto['categoria']=="gelato"){
					$definitionListProdotti.='</div>';	
				}
				$definitionListProdotti.='<label for="Immagine" tabindex="'.++$tabindex.'" > Modifica Immagine: </label>
		<input type="text" id="immagine" tabindex="'.++$tabindex.'"  name="immagine" value="'.$prodotto['immagine'].'"/></br>';
				$definitionListProdotti.='<label for="Descrizione immagine" tabindex="'.++$tabindex.'" > Modifica Descrizione immagine: </label>
				<textarea name="alt" rows="3" id="alt"  tabindex="'.++$tabindex.'" >'.$prodotto['alt'].' </textarea></br>';
				$definitionListProdotti.='<label for="Descrizione" tabindex="'.++$tabindex.'" > Modifica Descrizione: </label>
				<textarea name="descrizione" rows="5" id="descrizione"  tabindex="'.++$tabindex.'" >'.$prodotto['descrizione'].' </textarea></br>';
				$definitionListProdotti.='<input type="submit" name="modifica" value="Modifica" tabindex="'.++$tabindex.'"  id="modifica"/></form>';
				$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" id="nome" name="name" value="'.$prodotto['nome'].'" />';
				$definitionListProdotti.='<input type="submit" name="rimuovi" value="Rimuovi" id="rimuovi"  tabindex="'.++$tabindex.'"  /></form>';
				$definitionListProdotti.='</errelimina>';
			}
			else{
				$definitionListProdotti.='<p tabindex="'.++$tabindex.'">'.$prodotto['descrizione'].'</p>';
				if($prodotto['categoria']=="torta"){
					$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" id="nome" name="name" value="'.$prodotto['nome'].'" />';
				$tabindex=$tabindex+2;
				$definitionListProdotti.='<input type="submit" tabindex="'.$tabindex.'"name="aggiungi" value="Aggiungi al carrello" id="aggiungi" /></form>';
				$definitionListProdotti.='</errelimina>';
				$tabindex=$tabindex-1;
				$definitionListProdotti.='<div class="costo" ><p tabindex="'.$tabindex.'">'. $prodotto['prezzo'].'&euro;</p></div>';
				$tabindex++;
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

if (isset($_POST["modifica"])){
	$dbAccess->openDBConnection();
	$nome=$_POST["name"];
	$immagine=$_POST["immagine"];
	$descrizione=$_POST["descrizione"];
	$alt=$_POST["alt"];
	$prezzo=$_POST["prezzo"];
	//pulizia input
	$descrizione=str_replace("'", "`", $descrizione);
	$alt=str_replace("'", "`", $alt);
	$queryResult=$dbAccess->modifica($nome,$immagine,$alt,$descrizione, $prezzo);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$strerrore="<p id='errore_aggiunta'>MODIFICA NON RIUSCITA, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}


if(isset($_POST['submit'])){
	$errori="";
	$mex="";
	$dbAccess->openDBConnection();
		if (isset($_POST['item']) && isset($_POST['descrizione']) && isset($_POST['foto']) && isset($_POST['nome_category']) && isset($_POST['alt_foto']) && isset($_POST['prezzo']))
		{
        $result=$dbAccess->insert($_POST['item'], $_POST['descrizione'], $_POST['foto'], $_POST['alt_foto'], $_POST['nome_category'], $_POST['prezzo']);
        $dbAccess->closeDBConnection();
		if ($result === TRUE) {
		
			$mex.="<p> INSERIMENTO AVVENUTO CON SUCCESSO</p>";
			$paginaHTML=str_replace("<mex/>", $mex, $paginaHTML);
			header("Refresh:3");
		} 
		else {
  		$errori= "<p> ERRORE NELL'INSERIMENTO</p>";
  		$paginaHTML=str_replace("<errori/>", $errori, $paginaHTML);
  		header("Refresh:0");
  		}
}
}

if (isset($_POST["rimuovi"])){
	$dbAccess->openDBConnection();
	$nome=$_POST['name'];
	$queryResult=$dbAccess->rimuovi($nome);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$strerrore="<p id='errore_aggiunta'>RIMOZIONE NON RIUSCITA, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}

if (isset($_POST["aggiungi"])){
	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']==false){
		$strerrore="<p id='errore_aggiunta'>ACCEDI PER AGGIUNGERE PRODOTTI AL CARRELLO! <a href='login.php' role='button'>Accedi Qui</a></p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		$dbAccess->openDBConnection();
		$nome=$_POST['name'];
		$queryResult=$dbAccess->aggiungi($nome,$_SESSION['email']);
		$dbAccess->closeDBConnection();
		if($queryResult==false){
		$strerrore="<p id='errore_aggiunta'>ERRORE DURANTE L'AGGIUNTA AL CARRELLO, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
		}
		else{
		$strerrore="<p id='successo_aggiunta'>".$nome." AGGIUNTO AL CARRELLO CON SUCCESSO</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
		}
	}
}

if (isset($_POST["meno"])){
	$dbAccess->openDBConnection();
	$nome=$_POST['name'];
	$queryResult=$dbAccess->diminuisci($nome);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$strerrore="<p id='errore_aggiunta'>RIMOZIONE NON RIUSCITA, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}
	

		if (isset($_SESSION['admin']) && $_SESSION["admin"] == false){

		$dbAccess->openDBConnection();
		$listaProdotti = $dbAccess->getListaProdotti_Carrello($_SESSION["email"]);
		$shopping_cart = '<div id="carrello-prodotti">
  							<h2 tabindex="'.++$tabindex.'"> Il tuo Ordine </h2>';		
		$dbAccess->closeDBConnection();
		$totale=0;

		 if($listaProdotti != null) {
			
			//inserisco i prodotti nella zona carrello come lista di definizioni
			$shopping_cart .= '<ul id="cart">';
			foreach ($listaProdotti as $prodotto) {
				$shopping_cart .= '<li>  <p class="item" tabindex="'.++$tabindex.'">' . $prodotto['nome_item'] . '</p>
        <p class="prz" tabindex="'.++$tabindex.'">' . $prodotto['prezzo']*$prodotto['quantità'] . '&euro;</p>    
        <div class="qta">';

        $shopping_cart.='<form method="post" action="prodotti.php"><input type="text" id="nome" name="name" value="'.$prodotto['nome_item'].'" />';
		$shopping_cart.='<input type="submit" tabindex="'.++$tabindex.'" name="meno" value="-" class="minus"/></form> <p tabindex="'.++$tabindex.'">'. $prodotto['quantità'] . '</p>';
        $shopping_cart.='<form method="post" action="prodotti.php"><input type="text" id="nome" name="name" value="'.$prodotto['nome_item'].'" />';
		$shopping_cart.='<input type="submit" name="aggiungi" tabindex="'.++$tabindex.'" value="+" class="plus"/></form> </div></li>';
		$totale+=$prodotto['prezzo']*$prodotto['quantità'];
			}
			$shopping_cart.='</ul>
			<div id="riepilogo" >
			<p>Totale: ' .$totale.'&euro; </p>
  </div>
  <div id="concludi">
    <a>
    <p tabindex="'.++$tabindex.'">Vai al Carrello</p> </a>
  </div>
	';
		}
		else {
			$shopping_cart .= '<p "'.++$tabindex.'">Nessun prodotto nel carrello</p><div id="nascondi"></div>';
	   	}
		$shopping_cart.='</div>';
$paginaHTML = str_replace("<shopping_cart/>", $shopping_cart, $paginaHTML);
	}
	else if (!isset($_SESSION["admin"])) {

		$shopping_cart = '<div id="carrello-prodotti">
  							<h2 tabindex="'.++$tabindex.'"> Il tuo Ordine </h2>';
  		if (!isset($_SESSION['loggedin']) || $_SESSION["loggedin"] == false){
			$shopping_cart .= "<p tabindex='".++$tabindex."'>Non hai effettuato il login! Per aggiungere prodotti al carrello </br> <a href='login.php' tabindex='".++$tabindex."'>Accedi</a></p>";
  		} 
		$shopping_cart.='</div>';
		$paginaHTML = str_replace("<shopping_cart/>", $shopping_cart, $paginaHTML);
	}


	$stringaLogin = "";

	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		$stringaLogin .= "<a href='login.php' tabindex='11'>LOGIN</a>\n";
	}
	else {
		$stringaLogin .= "<p class='det_log' tabindex='11'> CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<div class='barraVerticale det_log' id='stile'></div>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php' role='button' tabindex='12'>LOGOUT</a>\n";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);

echo $paginaHTML;

?>
