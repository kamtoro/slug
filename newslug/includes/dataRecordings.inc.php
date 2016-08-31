<?php
include_once 'config.php';
//get form field values
if (!empty($_POST)) {

  $format   = $_POST['formatCB'];
  $source   = $_POST['sourceCB'];
  $location = $_POST['locationCB'];
  $title    = $_POST['titleCB'];
  $subtitle = $_POST['subtitleCB'];
  $person   = $_POST['personCB'];
  $urn      = $_POST['urnCB'];
  $id       = $_POST['idCB'];
  $tdate    = date("Y-m-d", time());
  $status   = "unused";
  if($id==""){
    $newURN = insertNewRecording($format, $source, $location, $title, $subtitle, $person, $urn);
    echo $newURN;
    //return $urn;
  }else {
    $urn = insertNewRecording($id, $format, $source, $location, $title, $subtitle, $person, $urn);
    //return $urn;
  }
}

function updateRecording($id, $format, $source, $location, $title, $subtitle, $person, $urn){  
  $tdate = date("Y-m-d", time());
  $timedate = date("Y-m-d 23:59:59", time());
  $status   = "unused";

  //GET URN
  if($urn==""){
    $urn = getURNValue();
  }
  try {
    $sql = "UPDATE recordings SET format = :format, source = :source, location = :location, title = :title, subtitle = :subtitle, person = :person, timeEntered = :tdate WHERE id = :id";
    echo "<script>alert('".$sql."'); </script>";

    $database = new Config();
    $db = $database->getConnection();
    $stmt = $db->prepare($sql);

    $stmt -> bindParam(':format',   $format);
    $stmt -> bindParam(':source',   $source);
    $stmt -> bindParam(':location', $location);
    $stmt -> bindParam(':title',    cleanString($title));
    $stmt -> bindParam(':subtitle', cleanString($subtitle));
    $stmt -> bindParam(':person',   $person);
    $stmt -> bindParam(':id',       $id);
    $stmt -> bindParam(':tdate',    $tdate);
    $stmt -> execute();
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
  }

  $db = $database->closeConnection();
  return $urn;
}

function insertNewRecording($format, $source, $location, $title, $subtitle, $person, $urn){
  $tdate = date("Y-m-d", time());
  $timedate = date("Y-m-d 23:59:59", time());
  $status   = "unused";
  //GET URN
  if($urn==""){
    $urn = getURNValue();
  }
  /*
  echo "<script>alert('".$sql."'); </script>";
  */
  try {
    $sql = "INSERT INTO recordings(format, source, location, title, subtitle, person, urn, time, status,timeEntered)".
             " VALUES (:format, :source, :location, :title, :subtitle, :person, :urn, :time, :status, :tdate)";
    $database = new Config();
    $db = $database->getConnection();
    $stmt = $db->prepare($sql);
    $stmt -> bindParam(':format',   $format);
    $stmt -> bindParam(':source',   $source);
    $stmt -> bindParam(':location', $location);
    $stmt -> bindParam(':title',    cleanString($title));
    $stmt -> bindParam(':subtitle', cleanString($subtitle));
    $stmt -> bindParam(':person',   $person);
    $stmt -> bindParam(':urn',      $urn);
    $stmt -> bindParam(':time',     $timedate);
    $stmt -> bindParam(':status',   $status);
    $stmt -> bindParam(':tdate',    $tdate);
    $stmt -> execute();


    // echo "<br>for ".$format;
    // echo "<br>sou ".$source;
    // echo "<br>loc ".$location;
    // echo "<br>tit ".$title;
    // echo "<br>sub ".$subtitle;
    // echo "<br>per ".$person;
    // echo "<br>urn ".$urn;
    // echo "<br>sta ".$status;
    // echo "<br>tda ".$tdate;

    // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "<br><br><br>aca entro 1 sql ".$sql." ".$urn;
    // $stmt = $db->prepare($sql);

    // $vals = array(
    //     ':format'=>$format,
    //     ':source'=>$source,
    //     ':location'=>$location,
    //     ':title'=>cleanString($title),
    //     ':subtitle'=>cleanString($subtitle),
    //     ':person'=>$person, 
    //     ':urn'=>$urn,
    //     ':status'=>$status,
    //     ':tdate'=>$tdate));
    // echo ($vals);

    // echo "<br><br><br>aca entro 1 sql ".$sql." ".$urn;

    // $stmt->execute(array(
    //     ':format'=>$format,
    //     ':source'=>$source,
    //     ':location'=>$location,
    //     ':title'=>cleanString($title),
    //     ':subtitle'=>cleanString($subtitle),
    //     ':person'=>$person, 
    //     ':urn'=>$urn,
    //     ':status'=>$status,
    //     ':tdate'=>$tdate));

    // echo "<br><br><br>aca entro 1 sql ".$sql." ".$urn;
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
  }

  //$db = $database->closeConnection();
  return $urn;

  //$array_json_row["id"]       = $db ;
  // $array_json_row["value"]    = $query;
  // $array_json_row["label"]    = $query;
  // array_push($array_json, $array_json_row);

  //echo json_encode($array_json);

    // if($stmt->execute()){
    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //     }
    // }else{
    // } 
    
    //return json data
    /* jQuery wants JSON data */
    // echo json_encode($array_json);
    // echo $array_json;
    // flush();

    //return json data
    /* jQuery wants JSON data */
    //flush();
}

function cleanString($string){
  // allow only letters
  //$res = preg_replace("/[^a-zA-Z0-9\s](tilde|quot)?#+;/i", '-', $string);
  
  $unwantedCharacters = array("/", ",", "*", ";");
  $res = str_replace($unwantedCharacters, "-", $string);
  // trim what's left to 8 chars
  return $res;
}

function getURNValue() {
  $cdate = mktime(0, 0, 0, 1, 1, 2000, 0);
  $today = time();
  $difference =  $today - $cdate;
  if ($difference < 0) { $difference = 0; }
  $days = floor($difference/60/60/24);
  $letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
  $urn = "";
  $number = intval($days / 676);
  $remainder = $days - ($number*676);
  $A =  $letter[$number];
  $number = intval($remainder / 26);
  $remainder = $remainder - ($number*26);
  $B = $letter[$number];
  $C = $letter[$remainder];
  $urn = $A . $B . $C;
  $num = 0;

    

  try {

    $tdate = date("Y-m-d", time());
    $sql = "SELECT id FROM recordings WHERE timeEntered >= '$tdate'";
    // $sql = "INSERT INTO recordings(format, source,location,title,subtitle,person,urn,time,status,timeEntered) VALUES ('HD', 'camilo', 'toro','Lick it up','Kiss','person','urn','2016-08-31 23:59:59','status','2016-08-31')";
    $database = new Config();
    $db = $database->getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $num = $stmt->rowCount();
    $db = $database->closeConnection();
  } catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
  }
  if (strlen($num)=="1") {
    $num = "00" . $num;
  }
  else if(strlen($num)=="2") {
    $num = "0" . $num;
  }

  $urn = $urn . $num;
  return $urn;
}
// class DataRecordings{
  
//  // database connection and table name
//  private $conn;
//  private $table_name = "recordings";
  

  
//  // read products
//  function readAll($page, $from_record_num, $records_per_page){
 
//   $query = "SELECT 
//      *
//     FROM 
//      " . $this->table_name . "
//     ORDER BY 
//      timeEntered DESC 
//     LIMIT 
//      {$from_record_num}, {$records_per_page}";
   
//   $stmt = $this->conn->prepare( $query );
//   $stmt->execute();
   
//   return $stmt;
//  }
  
//  // used for paging products
//  public function countAll(){
   
//   $query = "SELECT urn FROM " . $this->table_name . "";
   
//   $stmt = $this->conn->prepare( $query );
//   $stmt->execute();
   
//   $num = $stmt->rowCount();
   
//   return $num;
//  }
  
//  // used when filling up the update product form
//  function readOne(){
   
//   $query = "SELECT 
//      *
//     FROM 
//      " . $this->table_name . "
//     WHERE 
//      urn = ? 
//     LIMIT 
//      0,1";
 
//   $stmt = $this->conn->prepare( $query );
//   $stmt->bindParam(1, $this->id);
//   $stmt->execute();
 
//   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
//   // $this->nm = $row['nm_pdo']; EXAMPLE
//   $this->source =   $row['source'];
//   $this->location = $row['location'];
//   $this->title =    $row['title'];
//   $this->subtitle = $row['subtitle'];
//   $this->person =   $row['person'];
//   $this->urn =      $row['urn'];
//   $this->time =     $row['time'];
//   $this->status =   $row['status'];
//   $this->timeEntered = $row['timeEntered'];
//   $this->format =   $row['format'];

//  }
  
//  // update the product
//  function update(){
 
//   $query = "UPDATE 
//      " . $this->table_name . "
//     WHERE
//      urn = :urn";
 
//   $stmt = $this->conn->prepare($query);

//   $stmt->bindParam(':source',   $this->source);
//   $stmt->bindParam(':location', $this->location);
//   $stmt->bindParam(':title',    $this->title);
//   $stmt->bindParam(':subtitle', $this->subtitle);
//   $stmt->bindParam(':person',   $this->person);
//   $stmt->bindParam(':urn',      $this->urn);
//   $stmt->bindParam(':time',     $this->time);
//   $stmt->bindParam(':status',   $this->status);
//   $stmt->bindParam(':timeEntered',$this->timeEntered);
//   $stmt->bindParam(':format',   $this->format); 

//   // execute the query
//   if($stmt->execute()){
//    return true;
//   }else{
//    return false;
//   }
//  }
  
//  // delete the product
//  function delete(){
  
//   $query = "DELETE FROM " . $this->table_name . " WHERE urn = ?";
   
//   $stmt = $this->conn->prepare($query);
//   $stmt->bindParam(1, $this->urn);
 
//   if($result = $stmt->execute()){
//    return true;
//   }else{
//    return false;
//   }
//  }
// }
?> 