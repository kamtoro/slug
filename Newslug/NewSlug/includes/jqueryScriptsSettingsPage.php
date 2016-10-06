<!-- JQuery libraries -->
<script src="../js/jquery-1.12.4.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="../css/jquery-ui.css">

<!-- Autocomplete --><!-- 
<script type="text/javascript" src="../js/jquery.ui.autocomplete.html.js"></script>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"> -->

<!-- Bootstrap libraries -->
<script src="../js/bootstrap.min.js"></script>   

<!-- Bootstrap Validator -->
<!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/> -->
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>

<!-- Include bootgrid plugin (below), -->
<script src="../js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.js"></script>
<link href="../js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.css" rel="stylesheet">



<!-- Local js Library -->
<script src="../js/functionsJS.js"> </script>

<script type="text/javascript">
  $(document).ready(function(){
      var rowCountDatagrid = 50;
      var grid = $("#grid-data-format").bootgrid({
          ajax: true,
          search:  false,
          rowCount: rowCountDatagrid,
          post: function (){
              /* To accumulate custom parameter with the request object */
              return {
                  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
              };
          },
          url: "/includes/jsonDataGridSettings.php?settings=format",
          data:{ id: "id", field: "format", table: "format"}, 
          formatters: {
              "link": function(column, row){
                  return "<button type=\"button\" class=\"btn btn-danger btn-sm command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";
              }
          }
      }).on("loaded.rs.jquery.bootgrid", function(){
          /* Executes after data is loaded and rendered */
          grid.find(".command-delete").on("click", function(e){
              var idFormat = $(this).data("row-id");
              $.ajax({
                  url: "/includes/dataSettings.inc.php",
                  type: 'POST',
                  dataType: "json",
                  data:{ action: "formatGrid", id: idFormat}, 
                  success: function(result) {
                      $("#grid-data-format").bootgrid('reload');
                  }
              });
          });
      });
      $("#saveBtn").on("click", function() {
          console.log("Entro al click");
          $.ajax({
              url: "/includes/dataSettings.inc.php",
              type: "POST",
              datatype: "html",
              data: $("#settingsForm").serialize(),
              data:{ action: "getRecordingByID", idRecording : idRecording},
              success: function(result){
                  console.log(result);
                  if (result == "updated"){
                      console.log(result + " record.");
                  }else{
                      $("#urnCB").val(result);
                  }
                  // $("#grid-data").bootgrid("reload");
                  $("#resetBtn").trigger("click");
              }
          });
      });
      $("#sourceCB" ).autocomplete({
          minLength: 1,
          source: "../includes/jsonObjetDataList.php?table=sourceList&field=source",
          select: function( event, ui ) {
              $("#sourceCB").val( ui.item.label );
              return false;
          }
      });
      $("#locationCB" ).autocomplete({
          minLength: 1,
          source: "../includes/jsonObjetDataList.php?table=locationList&field=location",
          select: function( event, ui ) {
              $( "#locationCB" ).val( ui.item.label );
              return false;
          }
      });
      $("#titleCB" ).autocomplete({
          minLength: 1,
          source: "../includes/jsonObjetDataList.php?table=titleList&field=title",
          select: function( event, ui ) {
              $( "#titleCB" ).val( ui.item.label );
              return false;
          }
      });
      $("#subtitleCB" ).autocomplete({
          minLength: 1,
          source: "../includes/jsonObjetDataList.php?table=titleList&field=title",
          select: function( event, ui ) {
              $( "#subtitleCB" ).val( ui.item.label );
              return false;
          }
      });
      $("#personCB" ).autocomplete({
          minLength: 1,
          source: "../includes/jsonObjetDataList.php?table=personList&field=lastname",
          select: function( event, ui ) {
              $( "#personCB" ).val( ui.item.label );
              return false;
          }
      });

      $('.form-control').keyup(function(){
          $("#copytext").val(updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val()));
      });

      $('#clearBtn').on('click', function(e) {
          $("#recordingsForm").data('bootstrapValidator').resetForm();
          $("#resetBtn").trigger( "click" );
      });

      function getServerData(){
          //console.log("getServerData");
          $("#grid-data").bootgrid({ caseSensitive:false});
      }
      function clearGrid(){
          //console.log("clearGrid");
          $("#grid-data").bootgrid().clear();
      }
  });
</script>


