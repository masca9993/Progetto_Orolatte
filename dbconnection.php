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

  public function getListaCarrello($email) {
    $querySelect = "SELECT * FROM carrello WHERE email_user='$email' GROUP BY nome_item;"; 
    $queryResult = mysqli_query($this->connection, $querySelect);
    
    if(mysqli_num_rows($queryResult) == 0) {
      return null;
    }
    else {
      $listaProdotti = array();
      while($riga = mysqli_fetch_assoc($queryResult)) {
        $prodotto = array(
          "nome_item" => $riga['nome_item'],
          "quantità" =>  $riga['grandezza'],
        );
        
        array_push($listaProdotti, $prodotto);
      }
      
      return $listaProdotti;
    }
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
          "alt" => $riga['alt_foto'],
          "categoria" => $riga['nome_category']
        );

        array_push($listaProdotti,$singoloProdotto);
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
           "alt" => $riga['alt_foto'],
          "categoria" => $riga['nome_category']
        );

        array_push($listaProdotti,$singoloProdotto);
      }
      return $listaProdotti;
    }
  }
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
          "categoria" => $riga['nome_category']
        );

        array_push($listaProdotti,$singoloProdotto);
      }
      return $listaProdotti;
    }
  }
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
  public function rimuovi($nome){
    $query="DELETE FROM item WHERE item.nome ='".$nome."'";
    
    $queryResult=mysqli_query($this->connection, $query);
    return $queryResult;
  }
  public function modifica($nome,$immagine,$alt,$descrizione){
    $query="UPDATE item SET descrizione ='".$descrizione."', foto = '".$immagine."', alt_foto='".$alt."' WHERE item.nome ='".$nome."';";
    $queryResult=mysqli_query($this->connection, $query);
    return $queryResult;
  }
  public function aggiungi($nome,$utente){
    $query="INSERT INTO carrello (email_user,nome_item) 
    VALUES ('".$utente."','".$nome."')";
    $queryResult=mysqli_query($this->connection, $query);
    return $queryResult;
  }
}
?>