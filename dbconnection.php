<?php
namespace DB;

class DBAccess {
  private const HOST_DB="localhost";
  private const USERNAME="root";
  private const PASSWORD="";
  private const DATABASE_NAME="gelateria";
  
  private $connection;
  
  public function openDBConnection() {
    $this->connection = mysqli_connect(DBAccess::HOST_DB,DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
    if(!$this->connection){
      return false;
    }
    else{
      return true;
    }
  }
  public function getConnection(){
    return $this->connection;
  }
  public function closeDBConnection() {
  	mysqli_close($this->connection);
  }
  public function getListaProdotti(){
  	$querySelect="SELECT * FROM item ORDER BY nome ASC";
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
          "categoria" => $riga['nome_category']
        );

        array_push($listaProdotti,$singoloProdotto);
      }
      return $listaProdotti;
    }
  }
  public function rimuovi($nome){
    $query="DELETE FROM item WHERE item.nome ='".$nome."'";
    
    $queryResult=mysqli_query($this->connection, $query);
    return $queryResult;
  }
  public function modifica($nome,$immagine,$descrizione){
    $query="UPDATE item SET descrizione ='".$descrizione."', foto = '".$immagine."' WHERE item.nome ='".$nome."';";
    $queryResult=mysqli_query($this->connection, $query);
    return $queryResult;
  }
}
?>