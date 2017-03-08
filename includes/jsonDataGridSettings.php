<?php
include_once 'config.php';

try {
  // $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //MYSQL database
//$conn = new PDO("sqlite:db/movies.db");  // SQLite Database
$database = new Config();
$conn = $database->getConnection();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// echo 'SQL PDO ERROR: 1';
$id            = "id";
$field         = "format";
$tableSettings = "format";

$where = " 1 = 1 ";

if (isset($_GET["settings"])){
    if ($_GET["settings"] == "format"){
        $field = "format";
        $tableSettings = "format";
    }
    if ($_GET["settings"] == "location"){
        $field = "location";
        $tableSettings = "locationList";
    }
    if ($_GET["settings"] == "source"){
        $field = "source";
        $tableSettings = "sourceList";
    }
    if ($_GET["settings"] == "title"){
        $field = "title";
        $tableSettings = "titleList";
    }
    if ($_GET["settings"] == "person"){
        $field = "lastname";
        $tableSettings = "personList";
    }
}


$order_by=$field;
$rows=50;
$current=1;
$limit_l = ($current * $rows) - ($rows);
$limit_h = $limit_l + $rows;

//Handles Sort querystring sent from Bootgrid
if (isset($_REQUEST['sort']) && is_array($_REQUEST['sort']) ){
    $order_by="";
    foreach($_REQUEST['sort'] as $key=> $value)
        $order_by.=" $key $value";
    }

  //Handles search  querystring sent from Bootgrid 
  if (isset($_REQUEST['searchPhrase']) ){
      $search=trim($_REQUEST['searchPhrase']);
      $where.= " AND (".$field." LIKE '%".$search."%') "; 
  }

  //Handles determines where in the paging count this result set falls in
  if (isset($_REQUEST['rowCount']) ){  
      $rows=$_REQUEST['rowCount'];
  }

 //calculate the low and high limits for the SQL LIMIT x,y clause
  if (isset($_REQUEST['current'])){
      $current=$_REQUEST['current'];
      $limit_l=($current * $rows) - ($rows);
      $limit_h=$rows ;
  }

  if ($rows==-1){
      $limit="";  //no limit
  }else{
      $limit=" LIMIT $limit_l,$limit_h  ";
  }
  //NOTE: No security here please beef this up using a prepared statement - as is this is prone to SQL injection.
  //$sql="SELECT ".$id .", ".$field." FROM ". $tableSettings ."";
  $sql="SELECT $id, $field FROM $tableSettings WHERE $where ORDER BY $order_by $limit";
  //echo $sql;
  $stmt=$conn->prepare($sql);
  $stmt->execute();
  $results_array=$stmt->fetchAll(PDO::FETCH_ASSOC);

  $json=json_encode($results_array);

  $nRows=$conn->query("SELECT count(*) FROM $tableSettings WHERE $where")->fetchColumn();   /* specific search then how many match */

  header('Content-Type: application/json'); //tell the broswer JSON is coming

  if (isset($_REQUEST['rowCount']) ){  //Means we're using bootgrid library
      echo "{ \"current\":  $current, \"rowCount\":$rows,  \"rows\": ".$json.", \"total\": $nRows }";
  }
  else{
      echo $json;  //Just plain vanillat JSON output 
  }
  exit;
  }
  catch(PDOException $e) {
      echo 'SQL PDO ERROR: ' . $e->getMessage();
  }
?>