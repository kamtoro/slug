<!-- <script src="/js/jquery-1.12.4.min.js"></script> -->

<!-- JQuery libraries -->
<!-- <script src="/js/jquery-1.11.1.min.js"></script> -->
<script src="/js/jquery-1.12.4.min.js"></script>

<script src="/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<!-- Autocomplete -->
<!-- <script type="text/javascript" src="/js/jquery.ui.autocomplete.html.js"></script>
<link rel="stylesheet" type="text/css" href="/css/autocomplete.css"> -->


<!-- Tether for Bootstrap --> 
<!-- <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script> -->

<!-- Bootstrap libraries -->
<script src="/js/bootstrap.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">   

<!-- Bootstrap Validator -->
<!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/> -->
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>

<!-- Include bootgrid plugin (below), -->
<script src="js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.js"></script>
<link href="js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.css" rel="stylesheet">

<style type="text/css">
/* Custom the feedback icon styles */
/*#recordingsForm .form-horizontal .has-feedback .form-control-feedback {
    top: 100;
    right: 105px;
}

#recordingsForm .has-error .form-control {
    border-color: #555599;
    top: 100;
    right: 100px;
}
#recordingsForm .has-feedback .form-control {
    padding-right: 100.5px;
    top: 100;
    right: 100px;
}*/

</style>


<!-- Local js Library -->
<script src="/js/functionsJS.js"> </script>

<!-- Clipboard.js Libary -->
<script src="/js/dist/clipboard.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){

    
      //load gird on page\e load...
      var grid = $("#grid-data").bootgrid({
          ajax: true,
          post: function ()
          {
              /* To accumulate custom parameter with the request object */
              return {
                  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
              };
          },
          url: "/includes/jsonDataGridRecordings.php",
          formatters: {
              // "link": function(column, row)
              // {
              //     return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
              // }
              "link": function(column, row){
                  return "<button type=\"button\" class=\"btn btn-primary btn-sm command-edit\" data-row-id=\""  + row.id + "\"><span class=\"glyphicon glyphicon-pencil\"></span></button> " + 
                      "<button type=\"button\" class=\"btn btn-success btn-sm command-copy\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-download-alt\"></span></button> "+ 
                      "<button type=\"button\" class=\"btn btn-danger btn-sm command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";
              }
          }
      }).on("loaded.rs.jquery.bootgrid", function(){
          /* Executes after data is loaded and rendered */
          grid.find(".command-edit").on("click", function(e){
              //alert("You pressed edit on row: " + $(this).data("row-id"));
              // debugger;



              // jQuery.ajax({
              //     type: "POST",
              //     url: '/includes/dataRecordings.inc.php',
              //     dataType: 'html',
              //     data: {functionname: 'getURNValue'},
              //     success: function (result) {
              //         //$("#urnCB").val(result);
              //         alert(result);
              //         //$("#copytext").val(textToClipboard);
              //     }
              // });




              $.ajax({
                  url: "/includes/dataRecordings.inc.php",
                  type: 'POST',
                  dataType: "json",
                  data:{ action: "getRecordingByID", idRecording : $(this).data("row-id")}, 
                  success: function(result) {
                      $("#savingMode").val("edit");
                      console.log(recordingRow.format);

                      //var recordingRow = $.parseJSON(result);
                      alert("You pressed edit on row: ".recordingRow.format);
                      // $("#idCB").val($(this).data("row-id"));
                      // $("#formatCB").val(recordingRow.format);
                      // $("#sourceCB").val(recordingRow.source);
                      // $("#locationCB").val(recordingRow.location);
                      // $("#titleCB").val(recordingRow.title);
                      // $("#subtitleCB").val(recordingRow.subtitle);
                      // $("#personCB").val(recordingRow.person);
                      // $("#urnCB").val(recordingRow.urn);
                      // $("#savingMode").val("edit");
                      // var returnCopy = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val());
                      // $("#copytext").val(returnCopy);
                  }
              });
              // debugger;

          }).end().find(".command-delete").on("click", function(e){
              alert("You pressed delete on row: " + $(this).data("row-id"));
          });
      });
      $("#sourceCB" ).autocomplete({
          minLength: 1,
          source: "/includes/jsonObjetDataList.php?table=sourceList&field=source",
          // focus: function( event, ui ) {
          //   $( "#sourceCB" ).val( ui.item.label );
          //   return false;
          // },
          select: function( event, ui ) {
              $("#sourceCB").val( ui.item.label );
              return false;
          }
      });
      $("#locationCB" ).autocomplete({
          minLength: 1,
          source: "/includes/jsonObjetDataList.php?table=locationList&field=location",
          select: function( event, ui ) {
              $( "#locationCB" ).val( ui.item.label );
              return false;
          }
      });
      $("#titleCB" ).autocomplete({
          minLength: 1,
          source: "/includes/jsonObjetDataList.php?table=titleList&field=title",
          select: function( event, ui ) {
              $( "#titleCB" ).val( ui.item.label );
              return false;
          }
      });
      $("#subtitleCB" ).autocomplete({
          minLength: 1,
          source: "/includes/jsonObjetDataList.php?table=titleList&field=title",
          select: function( event, ui ) {
              $( "#subtitleCB" ).val( ui.item.label );
              return false;
          }
      });
      $("#personCB" ).autocomplete({
          minLength: 1,
          source: "/includes/jsonObjetDataList.php?table=personList&field=lastname",
          select: function( event, ui ) {
              $( "#personCB" ).val( ui.item.label );
              return false;
          }
      });
      
      $("#saveBtn").on("click", function() {

          if ($("#sourceCB").val() == ''|| $("#locationCB").val() == ''|| $("#personCB").val() == '') {
              $('#recordingsForm').bootstrapValidator('validate');
              // alert();
          }else{
              $.ajax({
                  url: "/includes/dataRecordings.inc.php",
                  type: 'POST',
                  datatype: "html",
                  data: $("#recordingsForm").serialize(),
                  success: function(result) {
                      $("#urnCB").val(result);
                      var returnCopy = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val());
                      $("#copytext").val(returnCopy);
                      $("#resetBtn").trigger("click");
                      $("#recordingsForm").data('bootstrapValidator').resetForm();
                  }
              });
          }
      });
      $( "#formButtons" ).mouseenter(function() {
          if (!$("#urnCB").val()){
              jQuery.ajax({
                  type: "POST",
                  url: '/includes/dataRecordings.inc.php',
                  dataType: 'html',
                  data: {functionname: 'getURNValue'},
                  success: function (result) {
                      $("#urnCB").val(result);
                      var textToClipboard = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val());
                      $("#copytext").val(textToClipboard);
                  }
              });
          }else{
              var textToClipboard = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val());
              $("#copytext").val(textToClipboard);
          }
      });
      
      var clipboard = new Clipboard('.btn');
      clipboard.on('success', function(e) {
          // console.info('Action:', e.action);
          // console.info('Text:', e.text);
          // console.info('Trigger:', e.trigger);
          e.clearSelection();
      });
      
      clipboard.on('error', function(e) {
          console.error('Error Action:', e.action);
          console.error('Error Trigger:', e.trigger);
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
          console.log("getServerData");
          $("#grid-data").bootgrid({ caseSensitive:false});
      }
      
      function clearGrid(){
          console.log("clearGrid");
          $("#grid-data").bootgrid().clear();
      }

  });
</script>


