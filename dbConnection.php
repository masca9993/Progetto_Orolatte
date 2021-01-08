<?php

namespace DB;

class DBAccess {
	private const HOST_DB = "localhost";	
	private const USERNAME = "root";
	private const PASSWORD = "root";
	private const DATABASE_NAME = "gelateria";
	
	private $connection;
	
	public function openDBConnection(){
		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);	//oggetto di tipo connessione se andato tutto ok, altrimenti contiene FALSE 
		
		if(mysqli_connect_errno($this->connection)) {
			return false;
		}
		else {
			return true;
		}
	}
	
	public function closeDBConnection() {
		mysqli_close($this->connection);
	}
	
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
}

?>
