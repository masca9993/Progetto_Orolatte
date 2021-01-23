<?php
include "dbConnection.php";
use DB\DBAccess;
session_start();

$dbAccess=new DBAccess();
$connessioneRiuscita= $dbAccess->openDBConnection();
$paginaHTML=file_get_contents('prodotti.html');
$nome="";
$immagine="";
$alt_foto="";
$prezzo="";
$descrizione="";
$categoria="";




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
	  <h2 >Inserisci un Nuovo Prodotto</h2>
	    <fieldset>
	    <div class="row">
	     <label for="item"  >Nome Prodotto:</label>
	     <input type="text" name="item" id="item"   required/>
	   </div>
	   <div class="row">
	   <label for="descrizione" >Descrizione:</label>
	   <textarea name="descrizione" rows="3" class="descrizione" required></textarea>
	  </div>
	   <div class="row">
	   <label for="foto" >Percorso Foto:</label>
	   <input type="text" name="foto" id="foto"  required/>
	  </div>
	  <div class="row">
	   <label for="alt_foto" >Descrizione Immagine:</label>
	  <textarea name="alt_foto" rows="3" id="alt_foto"  required></textarea>
	  </div>
	  <div class="row">
	   <label for="prezzo" >Prezzo:</label>
	   <input type="number" name="prezzo" class="prezzo"  required/>
	  </div>
	   <div class="row">
	   <label for="nome_category"  >Categoria:</label>
	   <select name="nome_category" id="nome_category"   >
	  <option value="gelato"  >Gelato</option>
	  <option value="torta"  >Torta</option>
	  </select>
	</div>
	  <div id="mex">
	    <mex/>
	  </div>
	  <div id="errors">
	    <errori/>
	  </div>
	  <input id="submit" type="submit" name="submit"   value="Inserisci"/>
	  <input id="cancella" type="reset" name="submit"   value="Cancella"/>
	</fieldset>
	  </form> 
	</div>';
	 $paginaHTML=str_replace("<insert/>", $insert_form, $paginaHTML);
	}
	if(isset($_SESSION["admin"]) && $_SESSION["admin"]){
		$paginaHTML=str_replace("<titolo/>", "<h2 >Modifica Prodotti</h2>", $paginaHTML);
	}
	else{
		$intestazione="<h2 id='inizio' accesskey='c'  >I Nostri Prodotti</h2>";
		$intestazione.='<div id="filtri">
		<form method="post" action="prodotti.php">
		<fieldset class="no_colore">
		<p  > Applica filtri:';
		if(isset($_POST['tutti'])){
			$intestazione.='<input type="submit"  name="tutti" value="Tutti" class="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Tutti", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit"    name="tutti" value="Tutti"/>';
		}
		if(isset($_POST['gelati'])){
			$intestazione.='<input type="submit" name="gelati" value="Gelati" class="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Gelati", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit"   name="gelati" value="Gelati"/>';
		}
		if(isset($_POST['torte'])){
			$intestazione.='<input type="submit" name="torte" value="Torte" class="selezionato"/>';
			$paginaHTML=str_replace("<categoria/>", ">> Torte", $paginaHTML);
		}
		else{
			$intestazione.='<input type="submit"    name="torte" value="Torte"/>';
		}
		$intestazione.='</p>
		</fieldset>
		</form>
		</div>';
		$paginaHTML=str_replace("<titolo/>", $intestazione, $paginaHTML);
	}
	if($listaProdotti != null){

		$definitionListProdotti='';
		foreach($listaProdotti as $prodotto){
			$definitionListProdotti.='<div class="flex"><dl id="prodotti"><dt >'.$prodotto['nome'];
			$definitionListProdotti.='</dt>';
			$definitionListProdotti.='<dd>';
			$definitionListProdotti.='<img  src="'.$prodotto['immagine'].'" alt="'.$prodotto['alt'].'"/>';
			if(isset($_SESSION["admin"]) && $_SESSION["admin"]){
				$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" class="nome" name="name" value="'.$prodotto['nome'].'" />';
				if($prodotto['categoria']=="gelato"){
					$definitionListProdotti.='<div class="nome">';
				}
					$definitionListProdotti.='<label for="prezzo"  > Modifica Prezzo: </label>
					<input type="text" class="prezzo" name="prezzo"   value="'.$prodotto['prezzo'].'"/></br>';
				if($prodotto['categoria']=="gelato"){
					$definitionListProdotti.='</div>';	
				}
				$definitionListProdotti.='<label for="Immagine" > Modifica Immagine: </label>
		<input type="text" class="immagine"   name="immagine" value="'.$prodotto['immagine'].'"/></br>';
				$definitionListProdotti.='<label for="Descrizione immagine"  > Modifica Descrizione immagine: </label>
				<textarea name="alt" rows="3" class="alt"   >'.$prodotto['alt'].' </textarea></br>';
				$definitionListProdotti.='<label for="Descrizione"  > Modifica Descrizione: </label>
				<textarea name="descrizione" rows="5" class="descrizione"   >'.$prodotto['descrizione'].' </textarea></br>';
				$definitionListProdotti.='<input type="submit" name="modifica" value="Modifica"  class="modifica"/></form>';
				$definitionListProdotti.='<form method="post" action="prodotti.php"><fieldset class="no_colore">';
				$definitionListProdotti.='<input type="text" class="nome" name="name" value="'.$prodotto['nome'].'" />';
				$definitionListProdotti.='<input type="submit" name="rimuovi" value="Rimuovi" class="rimuovi"    /></fieldset></form>';
				$definitionListProdotti.='</errelimina>';
			}
			else{
				$definitionListProdotti.='<p >'.$prodotto['descrizione'].'</p>';
				if($prodotto['categoria']=="torta"){
					$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" class="nome" name="name" value="'.$prodotto['nome'].'" />';
				$definitionListProdotti.='<input type="submit"  name="aggiungi" value="Aggiungi al carrello" class="aggiungi" /></form>';
				$definitionListProdotti.='</errelimina>';
				$definitionListProdotti.='<div class="costo" ><p >'. $prodotto['prezzo'].'&euro;</p></div>';
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
		$strerrore="<p class='errore_aggiunta'>MODIFICA NON RIUSCITA, RIPROVA PIÙ TARDI</p>";
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
		$strerrore="<p class='errore_aggiunta'>RIMOZIONE NON RIUSCITA, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}

if (isset($_POST["aggiungi"])){
	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']==false){
		$strerrore="<p class='errore_aggiunta'>ACCEDI PER AGGIUNGERE PRODOTTI AL CARRELLO! <a href='login.php' role='button'>accedi qui</a></p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		$dbAccess->openDBConnection();
		$nome=$_POST['name'];
		$queryResult=$dbAccess->aggiungi($nome,$_SESSION['email']);
		$dbAccess->closeDBConnection();
		if($queryResult==false){
		$strerrore="<p class='errore_aggiunta'>ERRORE DURANTE L'AGGIUNTA AL CARRELLO, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
		}
		else{
		$strerrore="<p id='successo_aggiunta'>".$nome." AGGIUNTO AL CARRELLO CON SUCCESSO</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
		header("Refresh:5");
		}
	}
}

if (isset($_POST["meno"])){
	$dbAccess->openDBConnection();
	$nome=$_POST['name'];
	$email=$_SESSION['email'];
	$queryResult=$dbAccess->diminuisci($nome,$email);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		$strerrore="<p class='errore_aggiunta'>RIMOZIONE NON RIUSCITA, RIPROVA PIÙ TARDI</p>";
		$paginaHTML=str_replace("<err/>",$strerrore,$paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}
	

		if (isset($_SESSION['admin']) && $_SESSION["admin"] == false){

		$dbAccess->openDBConnection();
		$listaProdotti = $dbAccess->getListaProdotti_Carrello($_SESSION["email"]);
		$shopping_cart = '<div class="carrello-prodotti" >
  							<h2 accesskey="s" > Il tuo Ordine </h2>';		
		$dbAccess->closeDBConnection();
		$totale=0;

		 if($listaProdotti != null) {
			
			//inserisco i prodotti nella zona carrello come lista di definizioni
			$shopping_cart .= '<ul id="cart">';
			foreach ($listaProdotti as $prodotto) {
				$shopping_cart .= '<li>  <p class="item" >' . $prodotto['nome_item'] . '</p>
        <p class="prz" >' . $prodotto['prezzo']*$prodotto['quantità'] . '&euro;</p>    
        <div class="qta">';

        $shopping_cart.='<form method="post" action="prodotti.php"><fieldset class="no_colore"><input type="text" class="nome" name="name" value="'.$prodotto['nome_item'].'" />';
		$shopping_cart.='<input type="submit"  name="meno" value="-" class="minus"/></fieldset></form> <p >'. $prodotto['quantità'] . '</p>';
        $shopping_cart.='<form method="post" action="prodotti.php"><fieldset class="no_colore"><input type="text" class="nome" name="name" value="'.$prodotto['nome_item'].'" />';
		$shopping_cart.='<input type="submit" name="aggiungi"  value="+" class="plus"/></fieldset></form> </div></li>';
		$totale+=$prodotto['prezzo']*$prodotto['quantità'];
			}
			$shopping_cart.='</ul>
			<div id="riepilogo" >
			<p>Totale: ' .$totale.' </p>
  </div>
  <div id="concludi">
    <a href="carrello.php" role="button">
    <p >Vai al Carrello</p> </a>
  </div>
	';
		}
		else {
			$shopping_cart .= '<p>Nessun prodotto nel carrello</p><div id="nascondi"></div>';
	   	}
		$shopping_cart.='</div>';
$paginaHTML = str_replace("<shopping_cart/>", $shopping_cart, $paginaHTML);
	}
	else if (!isset($_SESSION["admin"])) {

		$shopping_cart = '<div class="carrello-prodotti">
  							<h2 accesskey="s" > Il tuo Ordine </h2>';
  		if (!isset($_SESSION['loggedin']) || $_SESSION["loggedin"] == false){
			$shopping_cart .= "<p>Non hai effettuato il login! Per aggiungere prodotti al carrello, <a href='login.php'>accedi</a>.</p>";
  		}
		$shopping_cart.='</div>';
		$paginaHTML = str_replace("<shopping_cart/>", $shopping_cart, $paginaHTML);
	}


	$stringaLogin = "";

	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		$stringaLogin .= "<a href='login.php'  xml:lang='en'>LOGIN</a>\n";
	}
	else {
		$stringaLogin .= "<p class='det_log ciao' > CIAO " . $_SESSION['username'] . "</p>" . "\n";
		$stringaLogin .= "<div class='barraVerticale det_log' ></div>" . "\n";
		$stringaLogin .= "\t</li>\n";
		$stringaLogin .= "\t<li>\n";
		$stringaLogin .= "\t\t<a href='logout.php' role='button'  xml:lang='en'>LOGOUT</a>\n";
	}

	$paginaHTML = str_replace("<ControlloLogin />", $stringaLogin, $paginaHTML);

echo $paginaHTML;

?>
