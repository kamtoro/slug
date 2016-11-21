<?php
class Datalist{
  
 // database connection and table name
 private $conn;
 private $table_name = "sourceList";

 // object properties
  public $source;
  public $id;
  
 public function __construct($db){
  $this->conn = $db;
 }
  
 // create product
 function create(){
   
  //write query
  $query = "INSERT INTO " . $this->table_name . " values(?,?,?,?,?,?,?,?,?,?)";
   
  $stmt = $this->conn->prepare($query);
 
  $stmt->bindParam(1, $this->id);
  $stmt->bindParam(2, $this->source);
   
  if($stmt->execute()){
   return true;
  }else{
   return false;
  }
   
 }
  
 // read products
 function readAll($page, $from_record_num, $records_per_page){
 
  $query = "SELECT 
     *
    FROM 
     " . $this->table_name . "
    ORDER BY 
     sourceList ASC 
    LIMIT 
     {$from_record_num}, {$records_per_page}";
  $stmt = $this->conn->prepare( $query );
  $stmt->execute();
   
  return $stmt;
 }


 function selectListArray($table, $field) {

  $query = "SELECT 
     " . $field . "
    FROM 
     " . $table . "
    ORDER BY  
     " . $field . " ASC";
  // echo "query " . $query;
  $stmt = $this->conn->prepare( $query );
  $stmt->execute();
   
  return $stmt;
}
  
 // used for paging products
 public function countAll(){
   
  $query = "SELECT urn FROM " . $this->table_name . "";
   
  $stmt = $this->conn->prepare( $query );
  $stmt->execute();
   
  $num = $stmt->rowCount();
   
  return $num;
 }

 public function getSerializedListForCombobox($table, $field) {
    $query = "SELECT 
       " . $field . "
      FROM 
       " . $table . "
      ORDER BY  
       " . $field . " ASC";
    // echo "query " . $query;
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $serializedList = "";
    //echo "query" . $query;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $local = $row[$field];
        $serializedList = $serializedList . "\" ".$row[$field] ."\", ";
    }
    //echo "string" . $serializedList;
    return $serializedList;
 }

  
 // used when filling up the update product form
 function readOne(){
   
  $query = "SELECT 
     *
    FROM 
     " . $this->table_name . "
    WHERE 
     id = ? 
    LIMIT 
     0,1";
 
  $stmt = $this->conn->prepare( $query );
  $stmt->bindParam(1, $this->id);
  $stmt->execute();
 
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
  // $this->nm = $row['nm_pdo']; EXAMPLE
  $this->id =   $row['id'];
  $this->source = $row['source'];

 }
  
 // update the product
 function update(){
 
  $query = "UPDATE 
     " . $this->table_name . "
    WHERE
     id = :id";
 
  $stmt = $this->conn->prepare($query);

  $stmt->bindParam(':id', $this->id);
  $stmt->bindParam(':source',   $this->source);

  // execute the query
  if($stmt->execute()){
   return true;
  }else{
   return false;
  }
 }
  
 // delete the product
 function delete(){
  
  $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
   
  $stmt = $this->conn->prepare($query);
  $stmt->bindParam(1, $this->id);
 
  if($result = $stmt->execute()){
   return true;
  }else{
   return false;
  }
 }
}
?> 