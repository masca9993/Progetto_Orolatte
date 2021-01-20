<?php

namespace DB;

class DBAccess {
	private const HOST_DB = "localhost";	
	private const USERNAME = "root";
	private const PASSWORD = "";
	private const DATABASE_NAME = "gelateria";
	
	private $connection;
	
	public function openDBConnection(){
		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);	//oggetto di tipo connessione se andato tutto ok, altrimenti contiene FALSE 
		
		if(!$this->connection) {
			return false;
		}
		else {
			return true;
		}
	}
	
	public function closeDBConnection() {
		mysqli_close($this->connection);
	}
	
public function getListaProdotti_Carrello($email) {

  $escape_dots='carrello.nome_item=item.nome';
    $querySelect = "SELECT nome_item, prezzo, COUNT(*) as quantità FROM carrello, item WHERE email_user='$email' AND $escape_dots GROUP BY nome_item;"; 
    $queryResult = mysqli_query($this->connection, $querySelect);
    
    if(!$queryResult) {
      return null;
    }
    else {
      $listaProdotti = array();
      while($riga = mysqli_fetch_assoc($queryResult)) {
        $prodotto = array(
          "nome_item" => $riga['nome_item'],
          "quantità" =>  $riga['quantità'],
          "prezzo" =>  $riga['prezzo'],
        );
        
        array_push($listaProdotti, $prodotto);
      }
      
      return $listaProdotti;
    }
  }

	// per popolare la pagina carrello
	public function getListaProdotti($email) {
		$querySelect = "SELECT * FROM carrello WHERE email_user='$email';";	
		$queryResult = mysqli_query($this->connection, $querySelect);
		
		if(mysqli_num_rows($queryResult) == 0) {
			return null;
		}
		else {
			$listaProdotti = array();
			while($riga = mysqli_fetch_assoc($queryResult)) {
				$prodotto = array(
					"nome_item" => $riga['nome_item'],
					"grandezza" =>  $riga['grandezza'],
				);
				
				array_push($listaProdotti, $prodotto);
			}
			
			return $listaProdotti;
		}
	}
	
	public function getListaGelati(){
    $querySelect="SELECT * FROM item WHERE nome_category='gelato' ORDER BY nome ASC";
    $queryResult=mysqli_query($this->connection, $querySelect);

    if(mysqli_num_rows($queryResult)==0) {
      return null;
    }
    else{
      $listaProdotti= array();
      while($riga = mysqli_fetch_assoc($queryResult)){
        $singoloProdotto=array(
          "nome" => $riga['nome'],
          "descrizione" => $riga['descrizione'],
          "immagine" => $riga['foto'],
          "prezzo" => $riga['prezzo'],
           "alt" => $riga['alt_foto'],
          "categoria" => $riga['nome_category']
        );

        array_push($listaProdotti,$singoloProdotto);
      }
      return $listaProdotti;
    }
  }

	//
	public function getListaTorte(){
    $querySelect="SELECT * FROM item WHERE nome_category='torta' ORDER BY nome ASC";
    $queryResult=mysqli_query($this->connection, $querySelect);

    if(mysqli_num_rows($queryResult)==0) {
      return null;
    }
    else{
      $listaProdotti= array();
      while($riga = mysqli_fetch_assoc($queryResult)){
        $singoloProdotto=array(
          "nome" => $riga['nome'],
          "descrizione" => $riga['descrizione'],
          "immagine" => $riga['foto'],
          "alt" => $riga['alt_foto'],
          "prezzo" => $riga['prezzo'],
          "categoria" => $riga['nome_category']
        );

        array_push($listaProdotti,$singoloProdotto);
      }
      return $listaProdotti;
    }
  }

	//
	public function insert($item, $descrizione, $foto, $alt_foto, $nome_category, $prezzo){
    $query="INSERT INTO item (nome, descrizione, foto, alt_foto, nome_category, prezzo)
    VALUES ('".$item."', '".$descrizione."', '".$foto."','".$alt_foto."','".$nome_category."','".$prezzo."')";
    
    $queryResult=mysqli_query($this->connection, $query);
   /* if ($queryResult==false)
    {
      $queryResult=mysqli_error($this->connection);
    }*/
    return $queryResult;
  }

	//
	public function rimuovi($nome){
		$query="DELETE FROM item WHERE item.nome ='".$nome."'";
		$queryResult=mysqli_query($this->connection, $query);
		return $queryResult;
	}

	//
	public function modifica($nome,$immagine,$alt,$descrizione,$prezzo){
    $query="UPDATE item SET descrizione ='".$descrizione."', foto = '".$immagine."', alt_foto='".$alt."', prezzo='".$prezzo."' WHERE item.nome ='".$nome."';";
    $queryResult=mysqli_query($this->connection, $query);
    return $queryResult;
  }

	//
	public function aggiungi($nome,$utente){
    $query="INSERT INTO carrello (email_user,nome_item) 
    VALUES ('".$utente."','".$nome."')";
    $queryResult=mysqli_query($this->connection, $query);
    return $queryResult;
  }

	public function diminuisci($nome){
    $escape_dots='carrello.nome_item';
    $query="DELETE FROM carrello WHERE $escape_dots='".$nome."'LIMIT 1";
    $queryResult=mysqli_query($this->connection, $query);
    return $queryResult;
  }

	// inserisce un prodotto nel carrello
	public function inserisciProdotto($email_user, $nome_item, $grandezza) {
		$queryInserimento= "INSERT INTO carrello(email_user, nome_item, grandezza) VALUES (\"$email_user\", \"$nome_item\", \"$grandezza\")";
		$queryResult = mysqli_query($this->connection, $queryInserimento);
		
		if(mysqli_affected_rows($this->connection) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	// svuota il carrello quando viene premuto il pulsante per effettuare l'ordine
	public function svuotaCarrello($email) {
		$querySvuotamento= "DELETE FROM carrello WHERE email_user='$email';";
		$queryResult = mysqli_query($this->connection, $querySvuotamento);
		
		if(mysqli_affected_rows($this->connection) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	// permette all'utente di eliminare un singolo prodotto dal proprio carrello
	public function eliminaProdotto($email_user, $nome_item) {	//i prodotti nel carrello hanno come chiave primaria questi due campi
		$queryRimozione= "DELETE FROM carrello WHERE email_user='$email_user' AND $nome_item='nome_item';";
		$queryResult = mysqli_query($this->connection, $queryRimozione);
		
		if(mysqli_affected_rows($this->connection) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	//funzione per popolare la pagina prodotti
	/*
	public function getListaItem() {
		$querySelect = "SELECT * FROM item";	
		$queryResult = mysqli_query($this->connection, $querySelect);
		
		if(mysqli_num_rows($queryResult) == 0) {
			return null;
		}
		else {
			$listaItem = array();
			while($riga = mysqli_fetch_assoc($queryResult)) {
				$item = array(
					"nome" => $riga['nome'],
					"descrizione" => $riga['descrizione'],
					"foto" => $riga['foto'],
					"nome_category" =>  $riga['nome_category']
				);
				
				array_push($listaItem, $item);
			}
			
			return $listaItem;
		}
	}
	*/

  public function getListaItem(){
    $querySelect="SELECT * FROM item ORDER BY nome ASC";
    $queryResult=mysqli_query($this->connection, $querySelect);

    if(mysqli_num_rows($queryResult)==0) {
      return null;
    }
    else{
      $listaProdotti = array();
      while($riga = mysqli_fetch_assoc($queryResult)){
        $singoloProdotto=array(
          "nome" => $riga['nome'],
          "descrizione" => $riga['descrizione'],
          "immagine" => $riga['foto'],
          "prezzo" => $riga['prezzo'],
          "alt" => $riga['alt_foto'],
          "categoria" => $riga['nome_category']
        );

        array_push($listaProdotti,$singoloProdotto);
      }
      return $listaProdotti;
    }
  }

}

?>
