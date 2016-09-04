<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootgrid Sample Template</title>
    <!-- Bootstrap CSS-->

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.css" rel="stylesheet">

  </head>
  <body>

<h2> My Bootgrid Implementation </h2>
        for more info about <A href="http://www.jquery-bootgrid.com/">bootgrid</a>
    
    <!--define the table using the proper table tags, leaving the tbody tag empty -->
        <table id="grid-data" class="table table-condensed table-hover table-striped" data-toggle="bootgrid" data-ajax="true" data-url="/includes/jsonObjetDataList.php">
        <thead>
            <tr>
                <th data-column-id="id" data-type="numeric" data-identifier="true">id</th>
                <th data-column-id="format">Format</th>
                <th data-column-id="source">Source</th>
                <th data-column-id="title">Title</th>
                <th data-column-id="subtitle">Subtitle</th>
            </tr>
        </thead>    
</table>
    
    
    <button onClick="getServerData()">Refresh Data</button> 
    <button onClick="clearGrid()">Clear table</button> 

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery-1.12.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Include bootgrid plugin (below), -->
    <script src="/js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.js"></script>


    <!-- now write the script specific for this grid -->
    <script langauge="javascript">
    //Refer to http://jquery-bootgrid.com/Documentation for methods, events and settings

    //load gird on page\e load...
    $("#grid-data").bootgrid(
     {
     caseSensitive:false
     
     });
    
    function getServerData()
    {
     console.log("getServerData");
     $("#grid-data").bootgrid({ caseSensitive:false});
    }
    
    function clearGrid()
    {
    console.log("clearGrid");
    $("#grid-data").bootgrid().clear();
    }
    
    </script>

    </body>
</html>