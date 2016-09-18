<?php
include_once 'config.php';
//get form field values
if (!empty($_POST)) {
  $action = "";
  if(isset($_POST['action'])){
      $action = $_POST['action'];
  }
  if(isset($_POST['idRecording'])){
      $idRecording = $_POST['idRecording'];
  }
  if($action =="getRecordingByID"){
    // echo json_encode(getRecordingByID(20017));
    echo json_encode(getRecordingByID($idRecording));
  }elseif($action =="deleteRecording"){
    echo deleteRecording($idRecording);
  }elseif($action =="deleteAllRecordings"){
    echo deleteAllRecordings();
  }elseif($action =="getURNValue"){
    // echo "cagada";
    echo getURNValue();
  }else{
    $format   = $_POST['formatCB'];
    $source   = $_POST['sourceCB'];
    $location = $_POST['locationCB'];
    $title    = $_POST['titleCB'];
    $subtitle = $_POST['subtitleCB'];
    $person   = $_POST['personCB'];
    $urn      = $_POST['urnCB'];
    $id       = $_POST['idCB'];
    $savingMode= $_POST['savingMode'];
    $tdate    = date("Y-m-d", time());
    $status   = "unused";
    if($savingMode=="insert"){
        $newURN = insertNewRecording($format, $source, $location, $title, $subtitle, $person, $urn);
        echo $newURN;
    }elseif($savingMode == "edit") {
        $return= "update";
        $return = updateRecording($id, $format, $source, $location, $title, $subtitle, $person, $urn);
        echo $return;
    }elseif($savingMode == "delete") {
        $return= "delete";
        $return = deleteRecording($idRecording);
        echo $return;
    }
  }
}

function deleteRecording($id) {
  $tdate = date("Y-m-d H:i:s", time());
  try {
    // $sql = "SELECT format, source, location, title, subtitle, person, urn FROM recordings WHERE id = :id";

    $sql = "UPDATE recordings SET status = \"deleted\", time = :tdate WHERE id = :id";
    // $sql = "UPDATE recordings SET status = \"deleted\" WHERE id = :id";

    $database = new Config();
    $db = $database->getConnection();
    $stmt = $db->prepare($sql);

    $stmt -> bindParam(':id',       $id);
    $stmt -> bindParam(':tdate',    $tdate);
    $stmt -> execute();

    $db = $database->closeConnection();
    return "Recording deleted => ".$id;
  } catch (PDOException $e) {
      // echo 'Connection failed: ' . $e->getMessage();
      return 'Connection failed: '. $e->getMessage();
  }
}

function deleteAllRecordings() {
    $tdate = date("Y-m-d H:i:s", time());
    try {
      // $sql = "UPDATE recordings SET status = \"deleted\" WHERE status = \"unused\"";

      $sql = "UPDATE recordings SET status = \"deleted\", time = :tdate WHERE status = \"unused\"";

      $database = new Config();
      $db = $database->getConnection();
      $stmt = $db->prepare($sql);

      $stmt -> bindParam(':tdate',    $tdate);
      $stmt -> execute();

      $db = $database->closeConnection();
      return "Delete all Recordings ";
    } catch (PDOException $e) {
        // echo 'Connection failed: ' . $e->getMessage();
        return 'Connection failed: '. $e->getMessage();
    }
}

function getRecordingByID($id){  
  try {
    $sql = "SELECT format, source, location, title, subtitle, person, urn FROM recordings WHERE id = :id";    
    $database = new Config();
    $db = $database->getConnection();
    $stmt = $db->prepare($sql);
    $stmt -> bindParam(':id', $id);
    $stmt -> execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $db = $database->closeConnection();
    return $row;
  } catch (PDOException $e) {
      // echo 'Connection failed: ' . $e->getMessage();
      return 'Connection failed: '. $e->getMessage();
  }
}

function updateRecording($id, $format, $source, $location, $title, $subtitle, $person, $urn){
  $tdate = date("Y-m-d H:i:s", time());
  // $timedate = date("Y-m-d 23:59:59", time());
  // $status   = "unused";

  //GET URN
  if($urn==""){
    $urn = getURNValue();
  }
  try {
    $sql = "UPDATE recordings SET format = :format, source = :source, location = :location, title = :title, subtitle = :subtitle, person = :person, time = :tdate WHERE id = :id";
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

    // $sql = "format ".$format." - ".$source." - ".$location." - ".$title." - ".$subtitle." - ".$person." - ".$id;
    return "updated";
  
  } catch (PDOException $e) {
      //echo 'Connection failed: ' . $e->getMessage();
      return 'Connection failed: ' . $e->getMessage();

  }
  $db = $database->closeConnection();
}

function insertNewRecording($format, $source, $location, $title, $subtitle, $person, $urn){
  $tdate = date("Y-m-d H:i:s", time());
  $timedate = date("Y-m-d H:i:s", time());
  $status   = "unused";
  //GET URN
  if($urn==""){
    $urn = getURNValue();
  }
  try {
    $sql = "INSERT INTO recordings(format, source, location, title, subtitle, person, urn, time, status, timeEntered)".
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
  } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
  }
  return $urn;
}

function cleanString($string){
  $unwantedCharacters = array("/", ",", "*", ";");
  $res = str_replace($unwantedCharacters, "-", $string);
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
?> 