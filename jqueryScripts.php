  <!-- <script src="js/jquery-1.12.4.min.js"></script> -->

<!-- JQuery libraries -->
<!-- <script src="js/jquery-1.11.1.min.js"></script> -->
<script src="js/jquery-1.12.4.min.js"></script>

<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<!-- Autocomplete -->
<!-- <script type="text/javascript" src="js/jquery.ui.autocomplete.html.js"></script>
<link rel="stylesheet" type="text/css" href="css/autocomplete.css"> -->


<!-- Tether for Bootstrap --> 
<!-- <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script> -->

<!-- Bootstrap libraries -->
<script src="js/bootstrap.min.js"></script>   

<!-- Bootstrap Validator -->
<link rel="stylesheet" href="css/bootstrapValidator.min.css"/>
<script type="text/javascript" src="js/bootstrapValidator.min.js"></script>

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
<script src="js/functionsJS.js"> </script>

<!-- Clipboard.js Libary -->
<script src="js/dist/clipboard.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){

      var webpage = "<?php echo _WEBPAGE_ ?>";
      if (webpage == "history"){
          commandsDatagrid = "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"> <p class=\"{{css.search}}\"></p></div></div></div>";
          var rowCountDatagrid = 50;
      }else{
          commandsDatagrid = "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"> <p class=\"{{css.search}}\"></p> <button type=\"button\" class=\"btn btn-default\" id=\"deleteAllBtn\"><span class=\"glyphicon glyphicon-trash\"></span> Delete all</button> </div></div></div>";
           
          var rowCountDatagrid = [10, 25, 50, -1];
      }


      //load gird on page\e load...
      var grid = $("#grid-data").bootgrid({
          ajax: true,
          search:  false,
          rowCount: rowCountDatagrid,
          post: function (){
              /* To accumulate custom parameter with the request object */
              return {
                  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
              };
          },
          templates: {
              header: commandsDatagrid
              // <p class=\"{{css.actions}}\"> To add Refresh, Pagination, and column selector buttons 
          },
          url: "includes/jsonDataGridRecordings.php?webpage="+webpage,
          
          formatters: {
              "link": function(column, row){
                  var copyTextString = updateTextForClipboard(row.format, row.source, row.location, row.title, row.subtitle, row.person, row.urn);
                  // All buttons commented, just temporally.
                  return "<button type=\"button\" class=\"btn btn-primary btn-sm command-edit\" data-row-id=\""  + row.id + "\"><span class=\"glyphicon glyphicon-pencil\"></span></button> " + "<button type=\"button\" class=\"btn btn-success btn-sm command-copy\" data-clipboard-text=\""+copyTextString+"\"><span class=\"glyphicon glyphicon-download-alt\"></span></button> "+ "<button type=\"button\" class=\"btn btn-danger btn-sm command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";
              }
          }

      }).on("loaded.rs.jquery.bootgrid", function(){
          /* Executes after data is loaded and rendered */
          grid.find(".command-edit").on("click", function(e){
          // alert("You pressed edit on row: " + $(this).data("row-id"));

              var idRecording = $(this).data("row-id");
              $.ajax({
                  url: "includes/dataRecordings.inc.php",
                  type: 'POST',
                  dataType: "json",
                  data:{ action: "getRecordingByID", idRecording : idRecording}, 
                  success: function(result) {
                      $("#savingMode").val("edit");
                      $("#idCB").val(idRecording);
                      $("#formatCB").val(result.format);
                      $("#sourceCB").val(result.source);
                      $("#locationCB").val(result.location);
                      $("#titleCB").val(result.title);
                      $("#subtitleCB").val(result.subtitle);
                      $("#personCB").val(result.person);
                      $("#urnCB").val(result.urn);
                      $("#savingMode").val("edit");
                      var returnCopy = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val());
                      $("#copytext").val(returnCopy);
                  }
              });
              // debugger;

          }).end().find(".command-delete").on("click", function(e){
              var idRecording = $(this).data("row-id"); 
              if (webpage == "history"){
                  //Used in History page where recording will be fully removed from DB
                  var actionDelete = "hardDeleteFromDB";
              }else{
                  var actionDelete = "deleteRecording";
              }

              $.ajax({
                  url: "includes/dataRecordings.inc.php",
                  type: 'POST',
                  dataType: "html",
                  data:{ action: actionDelete, idRecording : idRecording}, 
                  success: function(result) {
                      $("#grid-data").bootgrid('reload');
                      // console.log(result);
                  }
              });
          })
          .end().find(".command-copy").on("click", function(e){
              e.preventDefault();
          });

          var btn = document.querySelectorAll('button.command-copy');
          var clipboard = new Clipboard(btn);
          clipboard.on('success', function (e) {
              console.info('Copied to Clipboard: ', e.action);
          });
          if (webpage == "index"){
              $("#deleteAllBtn").on("click", function() {
                  $.ajax({
                          url: "includes/dataRecordings.inc.php",
                          type: 'POST',
                          dataType: "html",
                          data:{ action: "deleteAllRecordings"}, 
                          success: function(result) {
                              $("#grid-data").bootgrid('reload');
                              // console.log(result);
                          }
                  });
              });
          }
      });

      $("#sourceCB" ).autocomplete({
          minLength: 1,
          source: "includes/jsonObjetDataList.php?table=sourceList&field=source",

          select: function( event, ui ) {
              $("#sourceCB").val( ui.item.label );
              return false;
          }
      }).on('input', function() {
          var c = this.selectionStart,
              r = /[^ a-z_0-9-]/gi,
              v = $(this).val();
          if(r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
          }
          this.setSelectionRange(c, c);
      });

      $("#locationCB" ).autocomplete({
          minLength: 1,
          source: "includes/jsonObjetDataList.php?table=locationList&field=location",
          select: function( event, ui ) {
              $( "#locationCB" ).val( ui.item.label );
              return false;
          }
      }).on('input', function() {
          var c = this.selectionStart,
              r = /[^ a-z_0-9-]/gi,
              v = $(this).val();
          if(r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
          }
          this.setSelectionRange(c, c);
      });
      $("#titleCB" ).autocomplete({
          minLength: 1,
          source: "includes/jsonObjetDataList.php?table=titleList&field=title",
          select: function( event, ui ) {
              $( "#titleCB" ).val( ui.item.label );
              return false;
          }
      }).on('input', function() {
          var c = this.selectionStart,
              r = /[^ a-z_0-9-]/gi,
              v = $(this).val();
          if(r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
          }
          this.setSelectionRange(c, c);
      });
      $("#subtitleCB" ).autocomplete({
          minLength: 1,
          source: "includes/jsonObjetDataList.php?table=titleList&field=title",
          select: function( event, ui ) {
              $( "#subtitleCB" ).val( ui.item.label );
              return false;
          }
      }).on('input', function() {
          var c = this.selectionStart,
              r = /[^ a-z_0-9-]/gi,
              v = $(this).val();
          if(r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
          }
          this.setSelectionRange(c, c);
      });
      $("#personCB" ).autocomplete({
          minLength: 1,
          source: "includes/jsonObjetDataList.php?table=personList&field=lastname",
          select: function( event, ui ) {
              $( "#personCB" ).val( ui.item.label );
              return false;
          }
      }).on('input', function() {
          var c = this.selectionStart,
              r = /[^ a-z_0-9-]/gi,
              v = $(this).val();
          if(r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
          }
          this.setSelectionRange(c, c);
      });

      $("#formatCB").autocomplete({
          source:'includes/jsonObjetDataList.php?table=format&field=format'
      });
      
      $("#saveBtn").on("click", function() {
          // Validation of Source, Location and Person
          // OLD VALIDATION 
          // if ($("#sourceCB").val() == ''|| $("#locationCB").val() == ''|| $("#personCB").val() == '') {
          //     $('#recordingsForm').bootstrapValidator('validate');
          
          if($("#sourceCB").val() == ''&& $("#locationCB").val() == ''&& $("#titleCB").val() == ''&& $("#subtitleCB").val() == ''&& $("#personCB").val() == ''){
              $('#recordingsForm').bootstrapValidator('validate');
          }else if (!checkTotalFileLength()) {
              $('#recordingsForm').bootstrapValidator('validate');
          }else{
              //$("#sourceCB").val($("#sourceCB").value.toUpperCase());
              //$("#locationCB").val($("#locationCB").value.toUpperCase());

              $.ajax({
                  url: "includes/dataRecordings.inc.php",
                  type: 'POST',
                  datatype: "html",
                  data: $("#recordingsForm").serialize(),
                  success: function(result) {
                      if (result == "updated"){
                          console.log(result + " record.");
                      }else{
                          $("#urnCB").val(result);
                      }
                      var returnCopy = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val());
                      $("#copytext").val(returnCopy);
                      $("#grid-data").bootgrid('reload');
                      $("#resetBtn").trigger("click");
                      $("#recordingsForm").data('bootstrapValidator').resetForm();
                  }
              });
          }
      });

      $('#sourceCB').blur(function() {
          this.value = this.value.toUpperCase();
      });
      $('#locationCB').blur(function() {
          this.value = this.value.toUpperCase();
      });

      //when the user presses a key and the value of the `textarea` is changed, the new value will have all capitalized words
      $('#titleCB').blur(function() {
          $(this).capitalize();
      });
      $('#subtitleCB').blur(function() {
          $(this).capitalize();
      });
      $('#personCB').blur(function() {
          $(this).capitalize();
      });

      $('.form-control').keyup(function(){
          $("#copytext").val(updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val()));
      });

      $('#recordingsForm input').blur(function () {
          var textToClipboard = "";
          if ($("#urnCB").val() == ''){
              getURNVal();
          }
          textToClipboard = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val());
          $("#copytext").val(textToClipboard);
          //$(this).parents('p').addClass('warning');
      });
      $( "#formButtons").mouseenter(function() {
          var textToClipboard = "";
          if ($("#urnCB").val() == ''){
              getURNVal();
          }
          textToClipboard = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), $("#urnCB").val());
          $("#copytext").val(textToClipboard);
      });
      
      var clipboard = new Clipboard('.btn');
      clipboard.on('success', function(e) {
          e.clearSelection();
      });
      clipboard.on('error', function(e) {
          console.error('Error Action:', e.action);
          console.error('Error Trigger:', e.trigger);
      });
      
      var msgLargeFileError = "Please make a shorter Slug, Long slugs can cause some AVID functions to fail.";
      var msgValidationFields = "Slug name should not be empty.";
      $("#recordingsForm").bootstrapValidator({
          framework: 'bootstrap',
          // container: '.fileNameMessage',
          // err: {
          //     container: 'tooltip'
          // },
          fields:{
              sourceCB: {
                  container: '.fileNameMessage',
                  validators: {
                      callback: {
                          message: msgLargeFileError,
                          callback: function(value, validator) {
                              return checkTotalFileLength();
                          }
                      }
                  }
              },
              locationCB: {
                  container: '.fileNameMessage',
                  validators: {
                      callback: {
                          message: msgLargeFileError,
                          callback: function(value, validator) {
                              return checkTotalFileLength();
                          }
                      }
                  }
              },
              titleCB: {
                  container: '.fileNameMessage',
                  validators: {
                      callback: {
                          message: msgLargeFileError,
                          callback: function(value, validator) {
                              return checkTotalFileLength();
                          }
                      }
                  }
              },
              subtitleCB: {
                  container: '.fileNameMessage',
                  validators: {
                      callback: {
                          message: msgLargeFileError,
                          callback: function(value, validator) {
                              return checkTotalFileLength();
                          }
                      }
                  }
              },
              personCB: {
                  container: '.fileNameMessage',
                  validators: {
                      callback: {
                          message: msgLargeFileError,
                          callback: function(value, validator) {
                              return checkTotalFileLength();
                          }
                      }
                  }
              },
              copytext: {
                  container: '.fileNameMessage',
                  validators: {
                      callback: {
                          message: msgValidationFields,
                          callback: function(value, validator) {
                              return validateEmptyFields();
                          }
                      }
                  }
              }
          }
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
              url: "includes/dataRecordings.inc.php",
              type: 'POST',
              dataType: "html",
              data:{ action: "getURNValue"}, 
              success: function(result) {
                  $("#urnCB").val(result);
                  
              }
          });
      }

      function checkTotalFileLength() {
          var fileName = updateTextForClipboard($("#formatCB").val(), $("#sourceCB").val(), $("#locationCB").val(), $("#titleCB").val(), $("#subtitleCB").val(), $("#personCB").val(), "XXXXXX");
          if (fileName.length < 51){
              $("#recordingsForm").data('bootstrapValidator').resetForm();
              return true;  
          }else{
              console.log("Length: " + fileName + " (" + fileName.length + ")");
              $("#recordingsForm").data('bootstrapValidator').resetForm();
              return false;
          }
          return false;
      }

      function validateEmptyFields() {
          if($("#sourceCB").val() == ''&& $("#locationCB").val() == ''&& $("#titleCB").val() == ''&& $("#subtitleCB").val() == ''&& $("#personCB").val() == ''){
              return false;
          }else{
              return true;  
          }
          return false;
      }
  });
</script>