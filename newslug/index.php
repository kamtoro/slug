<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
$records_per_page = 1000;
 
$from_record_num = ($records_per_page * $page) - $records_per_page;
$table_source = "sourceList";

include_once 'header.php';
include_once 'includes/config.php';
include_once 'includes/datalist.inc.php';



// $source = new Datalist($db);
// // $stmt_source = $source->selectListArray($table_source, "id");
// $stmt_source = $source->getSerializedListForCombobox($table_source, "source");

// // <!-- $num = $stmt->rowCount(); -->
// echo "Source Count: " . $stmt_source; 
?>

<!-- <div class="container text-left" style="padding-top: 20px; margin-bottom: 10px;">  -->
<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div class="panel-title">Add/Edit Recordings</div>
    </div>

    <div class="panel-body">
      <form role="form" action="/includes/dataRecordings.inc.php" method="post" id="recordingsForm" >
        <div class="form-group">
          <div class="col-xs-2">
            <select class="form-control" id="formatCB" name="formatCB" >
              <option>HD</option>
              <option>SD</option>
            </select>
          </div>

          <div class="col-xs-2">
              <label for="sourceCB" class="sr-only">Source</label>
              <input class="form-control ui-autocomplete-input" id="sourceCB" name="sourceCB" type="text" placeholder="Source...">
              <input id="idCB" name="idCB" type="text" style="display: none;">
              <input id="urnCB" name="urnCB" type="text" style="display: none;">
          </div>
          <div class="col-xs-2">
            <label for="locationCB" class="sr-only">Location</label>
            <input class="form-control" id="locationCB" name="locationCB" type="text" placeholder="Location...">
          </div>
          
          <div class="col-xs-2">
            <label for="titleCB" class="sr-only">Title</label>
            <input class="form-control" type="text" id="titleCB" name="titleCB" placeholder="Title...">
          </div>
          
          <div class="col-xs-2">
            <label for="subtitleCB" class="sr-only">Subtitle</label>
            <input class="form-control" id="subtitleCB" name="subtitleCB" type="text" id="subtitle" placeholder="Subtitle...">
          </div>
          <div class="col-xs-2">
            <label for="personCB" class="sr-only">For</label>
            <input class="form-control" type="text" id="personCB" name="personCB" placeholder="For...">
          </div>
        </div>
        <br>
        <br>
        <hr style="margin-top:5px">
        <div class="form-group">
          <input type="reset" value="Clear" id = "resetBtn" style="display: none;">
          <button type="submit" class="btn btn-primary btn-md " id="saveBtm"><!-- Use col-xs-offset-8 to put buttoms on the right -->
            <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"> </span> Submit 
          </button>
          <button type="button" class="btn btn-md btn-default" value = "Clear" id="clearBtm">
            <span class="glyphicon glyphicon-refresh" aria-hidden="true"> </span> Clear
          </button>
        </div>
      </form>
    </div>
    <!-- </div> -->
  </div>
</div>

<?php include_once 'jqueryScripts.php'; ?>
<?php include_once 'footer.php'; ?>

