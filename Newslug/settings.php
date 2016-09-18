<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
$records_per_page = 1000;
define("_WEBPAGE_", "settings");
 
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
                 src="/img/logo.png">
          </a>
    <!--       <a class="navbar-brand " href="index.html"><img class="img-responsive"       
           src="img/logo.png"></a> -->
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>  Home</a></li>
            <li class="active"><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
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
            <div class="form-group col-xs-2">
              <div class="">
                <label for="formatCB" class="sr-only control-label">Format</label>
                <input class="form-control" id="formatCB" name="formatCB" type="text" placeholder="Format...">
              </div>
            </div>

            <div class="form-group col-xs-2">
              <div class="">
                <label for="locationCB" class="sr-only control-label">Location</label>
                <input class="form-control" id="locationCB" name="locationCB" type="text" placeholder="Location...">
              </div>
            </div>

            <div class="form-group col-xs-2">
              <label for="sourceCB" class="sr-only control-label">Source</label>
              <input class="form-control" id="sourceCB" name="sourceCB" type="text" placeholder="Source..."/>
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
            <input id="urnCB" name="urnCB" type="text " class="sr-only" >
            <input id="savingMode" name="savingMode" type="text" value="insert" class="sr-only" >

            <!-- #messages is where the messages are placed inside -->
            <!--  <div class="form-group">
                <div class="col-md-9 col-md-offset-2">
                    <div id="messages"></div>
                </div>
            </div> -->
            <br>
            <br>
            <div class="form-group text-right" id = "formButtons">
              <input type="reset" value="  Clear" id = "resetBtn" class="sr-only">
              <input id="copytext"  type="text" value="to copy text" class="sr-only">
              <button type="button" class="btn btn-primary btn-md" id="saveBtn" data-clipboard-action="copy" data-clipboard-target="#copytext"> <!-- Use col-xs-offset-8 to put buttoms on the right -->
                <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"> </span> Save
              </button>
              <button type="button" class="btn btn-md btn-default" value = "Clear" id="clearBtn">
                <span class="glyphicon glyphicon-refresh" aria-hidden="true"> </span> Clear
              </button>
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
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#formatTab" data-toggle="tab">Format</a></li>
                    <li><a href="#locationTab" data-toggle="tab">Location</a></li>
                    <li><a href="#sourceTab" data-toggle="tab">Source</a></li>
                    <li><a href="#titleTab" data-toggle="tab">Title</a></li>
                    <li><a href="#subtitleTab" data-toggle="tab">Subtitle</a></li>
                    <li><a href="#personTab" data-toggle="tab">For</a></li>
                </ul>
            </div> 
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="formatTab">
                        Format
                    </div>
                    <div class="tab-pane fade" id="locationTab">
                        Location
                    </div>
                    <div class="tab-pane fade" id="sourceTab">
                        Source
                    </div>
                    <div class="tab-pane fade" id="titleTab">
                        Title
                    </div>
                    <div class="tab-pane fade" id="subtitleTab">
                        Subtitle
                    </div>
                    <div class="tab-pane fade" id="personTab">
                        For
                    </div>
                </div>
            </div>
        </div>
    </div>  <!-- /DATAGRID SETTINGS -->


    <?php include_once 'includes/jqueryScriptsSettingsPage.php'; ?> 
    <!-- 
    ======================================================================
                                  FOOTER
    ======================================================================
    -->

<!--   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

  </body>
</html>