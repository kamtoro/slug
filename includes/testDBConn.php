<?php
include_once 'config.php';
# Fill our vars and run on cli
# $ php -f db-connect-test.php
$dbname = 'slug';
$dbuser = 'slugadmin';
$dbpass = '8cRBpGUEFqtRTaKx';
$dbhost = 'localhost';


$link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
mysqli_select_db($link, $dbname) or die("Could not open the db '$dbname'");
$test_query = "SHOW TABLES FROM $dbname";
$result = mysqli_query($link, $test_query);
$tblCnt = 0;
while($tbl = mysqli_fetch_array($result)) {
    $tblCnt++;
    echo $tbl[0]."<br />\n";
}
if (!$tblCnt) {
    echo "There are no tables<br />\n";
} else {
    echo "There are $tblCnt tables<br />\n";
    echo "<br/>\n";
    echo "<br/>\n";
    echo "<br/>\n";

    try{
        $sql = "SELECT format, source, location, title, subtitle, person, urn FROM recordings WHERE location LIKE '%LONDON BU%'"; 
        
        $database = new Config();
        $db = $database->getConnection();
        $stmt = $db->prepare($sql);
        $stmt -> execute();


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo $row['source'] . " " . $row['location'] ;
            echo "<br />";
        }

    }catch (PDOException $e) {
        return "Error Deleting setting";  //Just plain vanillat JSON out
    }

}

?>