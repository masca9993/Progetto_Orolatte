<?php
include "dbconnection.php";
use DB\dbAccess;

$dbAccess=new DBAccess();
$connessioneRiuscita= $dbAccess->openDBConnection();
$paginaHTML=file_get_contents('prodotti.html');
$nome="";
$immagine="";
$descrizione="";
$categoria="";
if (isset($_POST["modifica"])){
	$nome=$_POST["name"];
	$immagine=$_POST["immagine"];
	$descrizione=$_POST["descrizione"];
	$queryResult=$dbAccess->modifica($nome,$immagine,str_replace('"',"",$descrizione));
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		str_replace("</errelimina>", "<p id=elimina>modifica non riuscita</p></errelimina>", $paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}
if(isset($_POST['submit'])){
	$errori="";
	$mex="";
	$con=$dbAccess->getConnection();
		if (isset($_POST['item']) && isset($_POST['descrizione']) && isset($_POST['foto']) && isset($_POST['nome_category']))
		{
		$sql= "INSERT INTO item (nome, descrizione, foto, nome_category)
		VALUES ('".$_POST['item']."', '".$_POST['descrizione']."', '".$_POST['foto']."','".$_POST['nome_category']."')";

		if ($con->query($sql) === TRUE) {
			$mex= "<p> Inserimento avvenuto con successo</p>";
		} 
		else {
  		$errori= "<p> Error: " . $sql . "<br>" . $con->error. "</p>";
  		}
}
str_replace("<errori/>", $errori, $paginaHTML);
str_replace("<mex/>", $mex, $paginaHTML);
}
if (isset($_POST["rimuovi"])){
	$nome=$_POST['name'];
	$queryResult=$dbAccess->rimuovi($nome);
	$dbAccess->closeDBConnection();
	if($queryResult==false){
		str_replace("</errelimina>", "<p id=elimina>rimozione non riuscita</p>", $paginaHTML);
	}
	else{
		header("Refresh:0");
	}
}

if($connessioneRiuscita == false){
  die("Errore nell'apertura del DB");
}
else{
	$listaProdotti= $dbAccess->getListaProdotti();

	$dbAccess->closeDBConnection();
	
	if($listaProdotti != null){

		$definitionListProdotti='';
		foreach($listaProdotti as $prodotto){
			$definitionListProdotti.='<div class="flex"><dl id="prodotti"><dt>'.$prodotto['nome'];
			$definitionListProdotti.='</dt>';
			$definitionListProdotti.='<dd>';
			$definitionListProdotti.='<img src="'.$prodotto['immagine'].'"/>';
			//if($session['admin']==false)
			//$definitionListProdotti.='<p>'.$prodotto['descrizione'].'</p>';
			//if($prodotto['categoria']=="torta")
			//	$definitionListProdotti.='<button id="carrello">Aggiungi al carrello</button>';
			//else
				$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" id="nome" name="name" value="'.$prodotto['nome'].'" />';
				$definitionListProdotti.='<label for="Immagine"> Modifica Immagine: </label>
		<input type="text" id="immagine" name="immagine" value="'.$prodotto['immagine'].'/"></br>';
		$definitionListProdotti.='<label for="Descrizione"> Modifica Descrizione: </label>
		<textarea name="descrizione" rows="5" id="descrizione" >"'.$prodotto['descrizione'].'" </textarea></br>';
				$definitionListProdotti.='<input type="submit" name="modifica" value="Modifica" id="modifica"/></form>';
				$definitionListProdotti.='<form method="post" action="prodotti.php">';
				$definitionListProdotti.='<input type="text" id="nome" name="name" value="'.$prodotto['nome'].'" />';
				$definitionListProdotti.='<input type="submit" name="rimuovi" value="Rimuovi" id="rimuovi" /></form>';
				$definitionListProdotti.='</errelimina>';
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