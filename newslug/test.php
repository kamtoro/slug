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
?>

<!-- <div class="container text-left" style="padding-top: 20px; margin-bottom: 10px;">  -->
<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div class="panel-title">New Recording</div>
    </div>

    <div class="panel-body">
      <!-- <form role="form" action="/includes/dataRecordings.inc.php" method="post" id="recordingsForm" > -->
      <form role="form-inline" id="recordingsForm" >

        <div class="form-group col-xs-2">
            <select class="form-control" id="formatCB" name="formatCB" >
              <option>HD</option>
              <option>SD</option>
            </select>
        </div>

        <div class="form-group col-xs-2">
          <label for="sourceCB" class="sr-only control-label">Source</label>
          <input class="form-control" id="sourceCB" name="sourceCB" type="text" placeholder="Source..."/>
        </div>

        <div class="form-group col-xs-2">
          <div class="">
            <label for="locationCB" class="sr-only control-label">Location</label>
            <input class="form-control" id="locationCB" name="locationCB" type="text" placeholder="Location...">
          </div>
        </div>

        <div class="form-group col-xs-2">          
          <div class="">
            <label for="titleCB" class="sr-only control-label">Title</label>
            <input class="form-control" type="text" id="titleCB" name="titleCB" placeholder="Title...">
          </div>
        </div>

        <div class="form-group has-feedback col-xs-2">
          <div class="">
            <label for="subtitleCB" class="sr-only control-label">Subtitle</label>
            <input class="form-control" id="subtitleCB" name="subtitleCB" type="text" id="subtitle" placeholder="Subtitle...">
          </div>
        </div>

        <div class="form-group has-feedback col-xs-2">          
          <div class="">
            <label for="personCB" class="sr-only control-label">For</label>
            <input class="form-control" type="text" id="personCB" name="personCB" placeholder="For...">
          </div>
        </div>
        <br>
        
        <!-- HIDDEN URN AND ID FIELDS -->
        <input id="idCB" name="idCB" type="text" class="sr-only" >
        <input id="urnCB" name="urnCB" type="text" class="sr-only" >
        <!-- #messages is where the messages are placed inside -->
       <!--  <div class="form-group">
            <div class="col-md-9 col-md-offset-2">
                <div id="messages"></div>
            </div>
        </div> -->
        <br>
        <br>
        <div class="form-group text-right" id = "formButtons">
          <input type="reset" value="  Clear" id = "resetBtn" style="display: none;">
          <input id="copytext" class="sr-only" type="text" value="to copy text">
          <button type="button" class="btn btn-primary btn-md " id="saveBtn" data-clipboard-action="copy" data-clipboard-target="#copytext"> <!-- Use col-xs-offset-8 to put buttoms on the right -->
            <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"> </span> Save
          </button>
          <button type="button" class="btn btn-md btn-default" value = "Clear" id="clearBtn">
            <span class="glyphicon glyphicon-refresh" aria-hidden="true"> </span> Clear
          </button>
        </div>
      </form>
    </div>
    <!-- </div> -->
  </div>
</div>

<div class="container">
  <div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Recordings</div>
    <div class="panel-body">
      
        <!--define the table using the proper table tags, leaving the tbody tag empty -->
        <table id="grid-data" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true" data-url="includes/jsonDataGridRecordings.php">
          <thead>
            <tr>
              <th data-column-id="id" data-type="numeric" data-identifier="true">id</th>
              <th data-column-id="format" data-sortable="false">Format</th>
              <th data-column-id="source">Source</th>
              <th data-column-id="location" data-order="desc">Location</th>
              <th data-column-id="title">Title</th>
              <th data-column-id="subtitle">Subtitle</th>
              <th data-column-id="person">Person</th>
              <th data-column-id="urn" data-sortable="false">URN</th>
              <th data-column-id="commands" data-formatter="commands" data-sortable="false"></th>
            </tr>
          </thead>  
        </table>
      <!-- <button onClick="getServerData()">Refresh Data</button> 
      <button onClick="clearGrid()">Clear table</button>  -->
    </div>

  </div>
</div>
<?php include_once 'jqueryScripts.php'; ?>
<?php include_once 'footer.php'; ?>

