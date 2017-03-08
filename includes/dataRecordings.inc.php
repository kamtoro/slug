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
    }elseif($action =="hardDeleteFromDB"){
        echo deleteRecordingFromDB($idRecording);
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


        if($savingMode=="insertSettings"){
            $newURN = insertSettings($format, $source, $location, $title, $subtitle, $person, $urn);
            echo $newURN;
        }elseif($savingMode=="insert"){
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

function insertSettings($format, $source, $location, $title, $subtitle, $person, $urn){
    if ($format != "") {
        $format = $format;
        if (checkList("format", "format", $format)) {
            $query = insertSQLSetting("INSERT INTO Format(format) VALUES('{$format}')");
            echo "Added $format to format list.";
        } else {
            echo "Value $format is already in format list." . "<br>";
        }
    }
    if ($location != "") {
        $location = ucwords(strtolower($location));
        if (checkList("locationList", "location", $location)) {
            $query = insertSQLSetting("INSERT INTO locationList(location) VALUES ('{$location}')");
            MySQL_SubmitQuery($sql, $link) or die('Error, Query failed');
            echo "added $location to location list. ".$query . "<br>";
        } else {
            echo "Value $location is already in location list." . "<br>";
        }
    }
    if ($source != "") {
        $source = ucwords(strtolower($source));
        if (checkList("sourceList", "source", $source)) {
            $query = insertSQLSetting("INSERT INTO sourceList(source) VALUES('{$source}')");
            echo "added $source to source list. " .$query. "<br>";
        } else {
            echo "Value $source is already in source list." . "<br>";
        }
    }
    if ($title != "") {
        $title = ucwords(strtolower($title));
        if (checkList("titleList", "title", $title)) {
            $query = insertSQLSetting("INSERT INTO titleList(title) VALUES('{$title}')");
            MySQL_SubmitQuery($sql, $link) or die('Error, Query failed');
            echo "added $title to title list. ". $query . "<br>";
        } else {
            echo "Value $title is already in title list." . "<br>";
        }
    }
    if ($personList != "") {
        $person = ucwords(strtolower($person));
        if (checkList("personList", "lastname", $person)) {
            $query = insertSQLSetting("INSERT INTO personList(lastname) VALUES('{$person}')");
            MySQL_SubmitQuery($sql, $link) or die('Error, Query failed');
            echo "added $person to person list. ". $query ."<br>";
        } else {
            echo "Value $person is already in person list." . "<br>";
        }
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

function checkList($table, $value, $listValue) {
    try {
        $sql = "SELECT * FROM " . $table . " WHERE " . $value . "='" . $listValue . "'";
        $database = new Config();
        $db = $database->getConnection();
        $stmt = $db->prepare($sql);
        $stmt -> execute();

        echo "Value received ".$sql;
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
    $title = cleanString($title);
    $subtitle = cleanString($subtitle);
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
        $stmt -> bindParam(':title',    $title);
        $stmt -> bindParam(':subtitle', $subtitle);
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
    $title = cleanString($title);
    $subtitle = cleanString($subtitle);

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
        $stmt -> bindParam(':title',    $title);
        $stmt -> bindParam(':subtitle', $subtitle);
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
    /*CTORO: Year 2000 is gone, no need of having the above code 
    $cdate = mktime(0, 0, 0, 1, 1, 2000, 0);
    $today = time();
    $difference =  $today - $cdate;
    if ($difference < 0) { $difference = 0; }*/
    $difference = 0;
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