<?php
include_once 'includes/config.php';

try {
  // $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //MYSQL database
//$conn = new PDO("sqlite:db/movies.db");  // SQLite Database
$database = new Config();
$conn = $database->getConnection();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// echo 'SQL PDO ERROR: 1';
$where =" status='unused' ";
$order_by="id";
$rows=25;
$current=1;
$limit_l=($current * $rows) - ($rows);
$limit_h=$limit_lower + $rows  ;


//Handles Sort querystring sent from Bootgrid
if (isset($_REQUEST['sort']) && is_array($_REQUEST['sort']) )
  {
    $order_by="";
    foreach($_REQUEST['sort'] as $key=> $value)
		$order_by.=" $key $value";
	}

//Handles search  querystring sent from Bootgrid 
if (isset($_REQUEST['searchPhrase']) )
  {
    $search=trim($_REQUEST['searchPhrase']);
    $where.= " AND (source LIKE '".$search."%' OR  title LIKE '".$search."%' OR  subtitle LIKE '".$search."%' OR  person LIKE '".$search."%' ) "; 
	}

//Handles determines where in the paging count this result set falls in
if (isset($_REQUEST['rowCount']) )  
  $rows=$_REQUEST['rowCount'];

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
  $sql="SELECT id, replace(source,'\"','' ) as source, location, format, title, subtitle, person, urn FROM recordings WHERE $where ORDER BY $order_by $limit";

  $stmt=$conn->prepare($sql);
  //$stmt->execute(); lunes 22:13
  //$results_array=$stmt->fetchAll(PDO::FETCH_ASSOC); lunes 22:13

  $array_json = array();
  $array_json_row = array();
  if($stmt->execute()){
      while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
          //$value = htmlentities(stripslashes($row[$field]));
          //$array_json_row [] = $row;
          //$array_json_row["id"]       = htmlentities(stripslashes($row['source']));
          // $array_json_row["value"]    = "$value";
          // $array_json_row["label"]    = "$value";
          // array_push($array_json, $array_json_row);
          $json [] = $row;
          //array_push($array_json, $value);
      }
  }else{
       //$array_json_row["id"]       = 'NoData';
       $array_json_row["value"]    = 'No data list, DB Connection error';
       $array_json_row["label"]    = 'No data list, DB Connection error';
       array_push($array_json, $array_json_row);
  }
  //echo(json_encode( $json));



  //$json=json_encode( $results_array );   //lunes 22:13

  $nRows=$conn->query("SELECT count(*) FROM recordings  WHERE $where")->fetchColumn();   /* specific search then how many match */

  //header('Content-Type: application/json'); //tell the broswer JSON is coming   lunes 22:13

  if (isset($_REQUEST['rowCount']) ){  //Means we're using bootgrid library
    //echo "{ \"current\":  $current, \"rowCount\":$rows,  \"rows\": ".$json.", \"total\": $nRows }";
    $json_data = array(
            "current"  => intval($current), 
            "rowCount" => $rows,            
            "total"    => intval($nRows),
            "rows"     => $json // total data array
            );
    echo json_encode($json_data);  // send data as json format

  }else{
    //echo $json;  //Just plain vanillat JSON output 
        $json_data = array(
            "current"  => intval($current), 
            "rowCount" => $rows,            
            "total"    => intval($nRows),
            "rows"     => $json   // total data array
            );
    echo json_encode($json_data);  // send data as json format
  }
  exit;
}
catch(PDOException $e) {
  echo 'SQL PDO ERROR: ' . $e->getMessage();
}
?>