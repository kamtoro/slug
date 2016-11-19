<?php

    include_once 'config.php';

    $array_json = array();
    $array_json_row = array();
    $database = new Config();
    $db = $database->getConnection();
    //get table
    $tableList = $_GET['table'];
    //get search term
    $searchTerm = $_GET['term'];
    //get field to filter
    $field = $_GET['field'];


    $query = "SELECT * FROM " . $tableList . " WHERE ". $field . " LIKE '%" . $searchTerm . "%' ORDER BY ". $field;


    $stmt = $db->prepare($query);

    //$array_json_row["id"]       = $db ;
    // $array_json_row["value"]    = $query;
    // $array_json_row["label"]    = $query;
    // array_push($array_json, $array_json_row);

    //echo json_encode($array_json);

    if($stmt->execute()){
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $value = htmlentities(stripslashes($row[$field]));

            // $array_json_row["id"]       = htmlentities(stripslashes($row['source']));
            $array_json_row["value"]    = $value;
            $array_json_row["label"]    = $value;
            array_push($array_json, $array_json_row);
            //array_push($array_json, $value);
        }
    }else{
         //$array_json_row["id"]       = 'NoData';
         $array_json_row["value"]    = 'No data list, DB Connection error';
         $array_json_row["label"]    = 'No data list, DB Connection error';
         array_push($array_json, $array_json_row);
    }

    //return json data
    /* jQuery wants JSON data */
    echo json_encode($array_json);
    // echo $array_json;
    flush();

    //return json data
    /* jQuery wants JSON data */
    //flush();
    $db = $database->closeConnection();
    
?>