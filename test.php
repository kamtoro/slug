<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
$records_per_page = 1000;

define("_WEBPAGE_", "index");

$from_record_num = ($records_per_page * $page) - $records_per_page;
$table_source = "sourceList";

include_once 'includes/config.php';
include_once 'includes/datalist.inc.php';
?>


<!-- 
======================================================================
                              HEADER
======================================================================
 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SLUG - Recordings</title>
    <meta charset="utf-8">
    <!-- Customised CSS -->
    <link rel="stylesheet" type="text/css" href="css/custom.css"> 
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>

<!-- 
======================================================================
                              BODY
======================================================================
-->
  <body>
    <!-- 
    ======================================================================
                                  NAVBAR
    ======================================================================
    -->
    <nav class="navbar navbar-inverse navbar-light" style = "background-color: #006699;">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" rel="home" href="#" title="Slug - CBS News">
            <img style="max-width:290px; margin-top: -7px;"
                 src="img/logo.png">
          </a>
    <!--       <a class="navbar-brand " href="index.html"><img class="img-responsive"       
           src="img/logo.png"></a> -->
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span>  Home</a></li>
            <li><a href="settings.php"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
            <li><a href="history.php"><span class="glyphicon glyphicon-list"></span>  History</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><!-- <a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a> --></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- /Navbar-->

    <!-- 
    ======================================================================
                            NEW RECORDING PANEL
    ======================================================================
    -->
    <!-- <div class="container text-left" style="padding-top: 20px; margin-bottom: 10px;">  -->
    <div class="container">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <div class="panel-title">New Recording</div>
        </div>

        <div class="panel-body">
          <form role="form-inline" id="recordingsForm" >

            <div class="form-group col-md-2">
              <label for="sourceCB" class="sr-only control-label">Source</label>
              <input class="form-control input-uppercase" id="sourceCB" name="sourceCB" type="text" placeholder="Source...">
              <span class="help-block with-errors"></span>
            </div>

            <div class="form-group col-md-2">
                <label for="locationCB" class="sr-only control-label">Location</label>
                <input class="form-control input-uppercase" id="locationCB" name="locationCB" type="text" placeholder="Location...">
            </div>

            <div class="form-group col-md-2">          
              <div class="">
                <label for="titleCB" class="sr-only control-label">Title</label>
                <input class="form-control input-capitalize" type="text" id="titleCB" name="titleCB" placeholder="Title...">
              </div>
            </div>

            <div class="form-group has-feedback col-md-2">
              <div class="">
                <label for="subtitleCB" class="sr-only control-label">Subtitle</label>
                <input class="form-control input-capitalize" id="subtitleCB" name="subtitleCB" type="text" id="subtitle" placeholder="Subtitle...">
              </div>
            </div>

            <div class="form-group has-feedback col-md-2">          
              <div class="">
                <label for="personCB" class="sr-only control-label">For</label>
                <input class="form-control input-capitalize" type="text" id="personCB" name="personCB" placeholder="For...">
              </div>
            </div>

            <div class="form-group col-sm-2">
                <select class="form-control" id="formatCB" name="formatCB" >
                  <option>HD</option>
                  <option>SD</option>
                </select>
            </div>
            <div class="col-sm-12">
                <span class="help-block text-left fileNameMessage" ></span>
            </div>
            <div class="form-group text-right col-sm-12" id = "formButtons">
              <input type="reset" value="  Clear" id = "resetBtn" class="sr-only ">
              <input id="copytext"  name="copytext" type="text" value="to copy text" class="sr-only form-control">
              <button type="button" class="btn btn-primary btn-md" id="saveBtn" data-clipboard-action="copy" data-clipboard-target="#copytext"> <!-- Use col-md-offset-8 to put buttoms on the right -->
                <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"> </span> Save
              </button>
              <button type="button" class="btn btn-md btn-default" value = "Clear" id="clearBtn">
                <span class="glyphicon glyphicon-refresh" aria-hidden="true"> </span> Clear
              </button>
            </div>
            <div>
              <!-- HIDDEN URN AND ID FIELDS -->
              <input id="idCB" name="idCB" type="text" class="sr-only" >
              <input id="urnCB" name="urnCB" type="text " class="sr-only" >
              <input id="savingMode" name="savingMode" type="text" value="insert" class="sr-only" >

              <!-- #messages is where the messages are placed inside -->
             <!--  <div class="form-group">
                  <div class="col-md-9 col-md-offset-2">
                      <div id="messages"></div>
                  </div>
              </div> -->
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /NEW RECORDING PANEL-->

    <!-- 
    ======================================================================
                        DATAGRID RECORDING PANEL
    ======================================================================
    -->

    <div class="container">
      <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading">Recording</div>
        <div class="panel-body">
          
            <!--define the table using the proper table tags, leaving the tbody tag empty -->
            <table id="grid-data" class="table table-condensed table-hover table-striped">
              <thead>
                <tr>
                  <th data-column-id="id" data-type="numeric" data-identifier="true" data-visible="false">id</th>
                  <th data-column-id="urn" data-order="desc" data-sortable="true" data-align="left" data-width="65">URN</th>
                  <th data-column-id="source" data-width="100">Source</th>
                  <th data-column-id="location" data-width="110px">Location</th>
                  <th data-column-id="title" data-sortable="false">Title</th>
                  <th data-column-id="subtitle" data-sortable="false">Subtitle</th>
                  <th data-column-id="time" data-visible="false">time</th>
                  
                  <th data-column-id="person" data-width="130px">Person</th>
                  <th data-column-id="format" data-visible="true" data-width="74px">Format</th>
                  <!-- <th data-column-id="copyTextRow" data-formatter="copyTextRow" data-sortable="false">Copy</th> -->
                  <th data-column-id="link" data-formatter="link" data-sortable="false" data-align="right" data-width="120px"></th>
                </tr>
              </thead>  
            </table>
          <!-- <button onClick="getServerData()">Refresh Data</button> 
          <button onClick="clearGrid()">Clear table</button>  -->
        </div>

      </div>
    </div> <!-- /DATAGRID RECORDING -->

    <?php include_once 'jqueryScripts.php'; ?>
    <!-- 
    ======================================================================
                                  FOOTER
    ======================================================================
     -->
  </body>
</html>