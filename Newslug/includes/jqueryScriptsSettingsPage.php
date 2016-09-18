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
<!-- <script src="../js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.js"></script>
<link href="../js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.css" rel="stylesheet"> -->



<!-- Local js Library -->
<script src="../js/functionsJS.js"> </script>

<script type="text/javascript">
  $(document).ready(function(){

      var webpage = "<?php echo _WEBPAGE_ ?>";
      if (webpage == "history"){
          var rowCountDatagrid = 50;
      }else{
          var rowCountDatagrid = [10, 25, 50, -1];
      }

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

      $('#recordingsForm input').blur(function () {
          var textToClipboard = "";
          if ($("#urnCB").val() == ''){
              getURNVal();
          }
      });
      $( "#formButtons").mouseenter(function() {
          var textToClipboard = "";
          if ($("#urnCB").val() == ''){
              getURNVal();
          }
      });
      
      // $(document).ready(function() {
      $('#recordingsForm').bootstrapValidator({
          framework: 'bootstrap',
          // container: '#messages',
          err: {
              container: 'tooltip'
          },
          // feedbackIcons: {
          //     valid: 'glyphicon glyphicon-ok',
          //     invalid: 'glyphicon glyphicon-remove',
          //     validating: 'glyphicon glyphicon-refresh'
          // },
          fields: {
              sourceCB: {
                  row: '.col-xs-3',
                  validators: {
                      notEmpty: {
                          message: 'Source is required and can not be empty'
                      }
                  }
              },
              locationCB: {
                  row: '.col-xs-3',
                  validators: {
                      notEmpty: {
                          message: 'Location is required and cannot be empty'
                      }
                  }
              },
              personCB: {
                  row: '.col-xs-3',
                  validators: {
                      notEmpty: {
                          message: 'For is required and cannot be empty'
                      }
                  }
              }
          }
      })
      .on('err.field.fv', function(e, data) {
          // Get the tooltip
          var $icon = data.element.data('fv.icon'),
          title = $icon.data('bs.tooltip').getTitle();
          
          // Destroy the old tooltip and create a new one positioned to the right
          $icon.tooltip('destroy').tooltip({
              html: true,
              placement: 'right',
              title: title,
              container: 'body'
          });
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
      function getURNVal(){
          $.ajax({
              url: "../includes/dataRecordings.inc.php",
              type: 'POST',
              dataType: "html",
              data:{ action: "getURNValue"}, 
              success: function(result) {
                  $("#urnCB").val(result);
                  console.log("Entro al getURNVal");
              }
          });
      }
  });
</script>


