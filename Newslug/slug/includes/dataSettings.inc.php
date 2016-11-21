<?php
include_once 'config.php';

//get form field values


if (!empty($_POST)) {
    $action = "";
    $idSetting = "";

    if(isset($_POST['action'])){
        $action = $_POST['action'];
    }
    if(isset($_POST['idSetting'])){
        $idSetting = $_POST['idSetting'];
    }
    if(isset($_POST['savingMode'])){
        $savingMode= $_POST['savingMode'];
    }
    if($action =="deleteSetting"){
        // echo json_encode(getRecordingByID(20017));
        
        $returnStatus = "";
        if(isset($_POST['tableToDelete'])){
            $returnStatus = deleteSetting($_POST['tableToDelete'], $_POST['idSetting']);
        }
        echo $returnStatus;
    }elseif($savingMode =="insertSettings"){
        $format   = $_POST['formatCB'];
        $source   = $_POST['sourceCB'];
        $location = $_POST['locationCB'];
        $title    = $_POST['titleCB'];
        $person   = $_POST['personCB'];
        insertSettings($format, $source, $location, $title,  $person);
    }
}

function insertSettings($format, $source, $location, $title, $person){
    
    if ($format != "") {
        $format = $format;
        if (checkList("format", "format", $format)) {
            $query = insertSQLSetting("INSERT INTO Format(format) VALUES('{$format}')");
            echo "Added $format to format list.<br>";
        } else {
            echo "Value $format is already in format list.<br>";
        }
    }
    if ($location != "") {
        $location = ucwords(strtolower($location));
        if (checkList("locationList", "location", $location)) {
            $query = insertSQLSetting("INSERT INTO locationList(location) VALUES ('{$location}')");
            echo "Added $location to location list.<br>";
        } else {
            echo "Value $location is already in location list.<br>";
        }
    }
    if ($source != "") {
        $source = ucwords(strtolower($source));
        if (checkList("sourceList", "source", $source)) {
            $query = insertSQLSetting("INSERT INTO sourceList(source) VALUES('{$source}')");
            echo "Added $source to source list. " .$query. "<br>";
        } else {
            echo "Value $source is already in source list.<br>";
        }
    }
    if ($title != "") {
        $title = ucwords(strtolower($title));
        if (checkList("titleList", "title", $title)) {
            $query = insertSQLSetting("INSERT INTO titleList(title) VALUES('{$title}')");
            echo "Added $title to title list. ". $query . "<br>";
        } else {
            echo "Value $title is already in title list.<br>";
        }
    }
    if ($person != "") {
        $person = ucwords(strtolower($person));
        if (checkList("personList", "lastname", $person)) {
            $query = insertSQLSetting("INSERT INTO personList(lastname) VALUES('{$person}')");
            echo "Added $person to person list. ". $query ."<br>";
        } else {
            echo "Value $person is already in person list.<br>";
        }
    }
}

function checkList($table, $value, $listValue) {
    try {
        $sql = "SELECT * FROM " . $table . " WHERE " . $value . "='" . $listValue . "'";
        $database = new Config();
        $db = $database->getConnection();
        $stmt = $db->prepare($sql);
        $stmt -> execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); // Same here
        if($rows){
            $db = $database->closeConnection();
            return false;
        } else {
            $db = $database->closeConnection();
            return true;
        }
    }catch (PDOException $e) {
          return false;
    }
}

function deleteSetting($tableToDelete, $idSetting){
    $sql = "DELETE FROM $tableToDelete WHERE id = :id";
    try{
        $database = new Config();
        $db = $database->getConnection();
        $stmt = $db->prepare($sql);
        $stmt -> bindParam(':id', $idSetting);
        $stmt -> execute();
        $db = $database->closeConnection();
        //Just plain message when record has been deleted
        return "Record from table $tableToDelete with ID $idSetting deleted";  

    }catch (PDOException $e) {
        return "Error Deleting setting";  //Just plain vanillat JSON out
    }
}

function getDataSettings($sql){
    try {
        $database = new Config();
        $db = $database->getConnection();
        $stmt=$db->prepare($sql);
        $stmt->execute();
        $results_array=$stmt->fetchAll(PDO::FETCH_ASSOC);

        $json=json_encode( $results_array );
        header('Content-Type: application/json'); //tell the broswer JSON is coming
        return $json;  //Just plain vanillat JSON out
    }catch (PDOException $e) {
        return false;
        echo $json;  //Just plain vanillat JSON out
    }
}

function insertSQLSetting($sql){
    try {
        $database = new Config();
        $db = $database->getConnection();
        $stmt = $db->prepare($sql);
        $stmt -> execute();
        echo "Value received ".$sql;
        return true;
    } catch (PDOException $e) {
        return false;
    }
    return $urn;
}

function deleteRecordingFromDB($id) {
    try {
    $sql = "DELETE FROM recordings WHERE id = :id";

    $database = new Config();
    $db = $database->getConnection();
    $stmt = $db->prepare($sql);

    $stmt -> bindParam(':id', $id);
    $stmt -> execute();

    $db = $database->closeConnection();
    return "Recording deleted FROM DB => ".$id;
    } catch (PDOException $e) {
        // echo 'Connection failed: ' . $e->getMessage();
        return 'Connection failed: '. $e->getMessage();
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


?> 