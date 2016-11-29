<!-- JQuery libraries -->
<script src="js/jquery-1.12.4.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<!-- Autocomplete --><!-- 
<script type="text/javascript" src="../js/jquery.ui.autocomplete.html.js"></script>
<link rel="stylesheet" type="text/css" href="../css/autocomplete.css"> -->

<!-- Bootstrap libraries -->
<script src="js/bootstrap.min.js"></script>   

<!-- Bootstrap Validator -->
<!-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/> -->
<script type="text/javascript" src="js/bootstrapValidator.min.js"></script>

<!-- Include bootgrid plugin (below), -->
<script src="js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.js"></script>
<link href="js/jquery.bootgrid-1.3.1/jquery.bootgrid.min.css" rel="stylesheet">



<!-- Local js Library -->
<script src="js/functionsJS.js"> </script>

<script type="text/javascript">
  $(document).ready(function(){
      var rowCountDatagrid = 50;

      var commandsDatagrid = "<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-12 actionBar\"> <p class=\"{{css.search}}\"></p></div></div></div>";
           

      //  *****  Format  *****  //
      var gridFormat = $("#grid-data-format").bootgrid({
          ajax: true,
          search:  false,
          rowCount: rowCountDatagrid,
          post: function (){
              /* To accumulate custom parameter with the request object */
              return {
                  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
              };
          },
          url: "includes/jsonDataGridSettings.php?settings=format",
          data:{ id: "id", field: "format", table: "format"}, 
          templates: {
              header: commandsDatagrid
          },
          formatters: {
              "link": function(column, row){
                  return "<button type=\"button\" class=\"btn btn-danger btn-sm command-delete-format\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";
              }
          }
      }).on("loaded.rs.jquery.bootgrid", function(){
          /* Executes after data is loaded and rendered */
          gridFormat.find(".command-delete-format").on("click", function(e){
              var idSetting = $(this).data("row-id");
              var actionDelete = "deleteSetting";
              var tableToDelete = "format";

              $.ajax({
                  url: "includes/dataSettings.inc.php",
                  type: 'POST',
                  dataType: "html",
                  data:{ action: actionDelete, idSetting : idSetting, tableToDelete: tableToDelete}, 
                  success: function(result) {
                      $("#grid-data-format").bootgrid('reload');
                      console.log(result);
                  }
              });
          });
      });


      // //  *****  Location  *****  //    
      var gridLocation = $("#grid-data-location").bootgrid({
          ajax: true,
          search:  false,
          rowCount: rowCountDatagrid,
          post: function (){
              /* To accumulate custom parameter with the request object */
              return {
                  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
              };
          },
          url: "includes/jsonDataGridSettings.php?settings=location",
          data:{ id: "id", field: "location", table: "locationList"}, 
          templates: {
              header: commandsDatagrid
          },
          formatters: {
              "link": function(column, row){
                  return "<button type=\"button\" class=\"btn btn-danger btn-sm command-delete-location\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";
              }
          }
      }).on("loaded.rs.jquery.bootgrid", function(){
          /* Executes after data is loaded and rendered */
          gridLocation.find(".command-delete-location").on("click", function(e){
              var idSetting = $(this).data("row-id");
              var actionDelete = "deleteSetting";
              var tableToDelete = "locationList";

              $.ajax({
                  url: "includes/dataSettings.inc.php",
                  type: 'POST',
                  dataType: "html",
                  data:{ action: actionDelete, idSetting : idSetting, tableToDelete: tableToDelete}, 
                  success: function(result) {
                      $("#grid-data-location").bootgrid('reload');
                      console.log(result);
                  }
              });
          });
      });



      // //  *****  Source  *****  //    
      var gridSource = $("#grid-data-source").bootgrid({
          ajax: true,
          search:  false,
          rowCount: rowCountDatagrid,
          post: function (){
              /* To accumulate custom parameter with the request object */
              return {
                  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
              };
          },
          url: "includes/jsonDataGridSettings.php?settings=source",
          data:{ id: "id", field: "source", table: "sourceList"}, 
          templates: {
              header: commandsDatagrid
          },
          formatters: {
              "link": function(column, row){
                  return "<button type=\"button\" class=\"btn btn-danger btn-sm command-delete-source\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";
              }
          }
      }).on("loaded.rs.jquery.bootgrid", function(){
          /* Executes after data is loaded and rendered */
          gridSource.find(".command-delete-source").on("click", function(e){
              var idSetting = $(this).data("row-id");
              var actionDelete = "deleteSetting";
              var tableToDelete = "sourceList";

              $.ajax({
                  url: "includes/dataSettings.inc.php",
                  type: 'POST',
                  dataType: "html",
                  data:{ action: actionDelete, idSetting : idSetting, tableToDelete: tableToDelete}, 
                  success: function(result) {
                      $("#grid-data-source").bootgrid('reload');
                      console.log(result);
                  }
              });
          });
      });

      // //  *****  Title  *****  //    
      var gridTitle = $("#grid-data-title").bootgrid({
          ajax: true,
          search:  false,
          rowCount: rowCountDatagrid,
          post: function (){
              /* To accumulate custom parameter with the request object */
              return {
                  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
              };
          },
          url: "includes/jsonDataGridSettings.php?settings=title",
          data:{ id: "id", field: "title", table: "titleList"}, 
          templates: {
              header: commandsDatagrid
          },
          formatters: {
              "link": function(column, row){
                  return "<button type=\"button\" class=\"btn btn-danger btn-sm command-delete-title\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";
              }
          }
      }).on("loaded.rs.jquery.bootgrid", function(){
          /* Executes after data is loaded and rendered */
          gridTitle.find(".command-delete-title").on("click", function(e){
              var idSetting = $(this).data("row-id");
              var actionDelete = "deleteSetting";
              var tableToDelete = "titleList";

              $.ajax({
                  url: "includes/dataSettings.inc.php",
                  type: 'POST',
                  dataType: "html",
                  data:{ action: actionDelete, idSetting : idSetting, tableToDelete: tableToDelete}, 
                  success: function(result) {
                      $("#grid-data-title").bootgrid('reload');
                      console.log(result);
                  }
              });
          });
      });


      // //  *****  Title  *****  //    
      var gridPerson = $("#grid-data-person").bootgrid({
          ajax: true,
          search:  false,
          rowCount: rowCountDatagrid,
          post: function (){
              /* To accumulate custom parameter with the request object */
              return {
                  id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
              };
          },
          url: "includes/jsonDataGridSettings.php?settings=person",
          data:{ id: "id", field: "person", table: "personList"}, 
          templates: {
              header: commandsDatagrid
          },
          formatters: {
              "link": function(column, row){
                  return "<button type=\"button\" class=\"btn btn-danger btn-sm command-delete-person\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-remove-sign\"></span></button>";
              }
          }
      }).on("loaded.rs.jquery.bootgrid", function(){
          /* Executes after data is loaded and rendered */
          gridPerson.find(".command-delete-person").on("click", function(e){
              var idSetting = $(this).data("row-id");
              var actionDelete = "deleteSetting";
              var tableToDelete = "personList";

              $.ajax({
                  url: "includes/dataSettings.inc.php",
                  type: 'POST',
                  dataType: "html",
                  data:{ action: actionDelete, idSetting : idSetting, tableToDelete: tableToDelete}, 
                  success: function(result) {
                      $("#grid-data-person").bootgrid('reload');
                      console.log(result);
                  }
              });
          });
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
      $('#personCB').blur(function() {
          $(this).capitalize();
      });
      $('#formatCB').blur(function() {
          this.value = this.value.toUpperCase();
      });
      
      $("#saveBtn").on("click", function() {
          //console.log("Entro al click");
          $.ajax({
              url: "includes/dataSettings.inc.php",
              type: "POST",
              datatype: "html",
              data: $("#settingsForm").serialize(),
              success: function(result){
                  if (result != ""){
                      console.log(result);
                      if ($("#formatCB").val() != ''){
                          $("#grid-data-format").bootgrid('reload');
                      }
                      if ($("#locationCB").val() != ''){
                          $("#grid-data-location").bootgrid('reload');
                      }
                      if ($("#sourceCB").val() != ''){
                          $("#grid-data-source").bootgrid('reload');
                      }
                      if ($("#titleCB").val() != ''){
                          $("#grid-data-title").bootgrid('reload');
                      }
                      if ($("#personCB").val() != ''){
                          $("#grid-data-person").bootgrid('reload');
                      }
                  }
                  // $("#grid-data").bootgrid("reload");
                  $("#resetBtn").trigger("click");
              }
          });
      });

      //Input text field validation
      $("#sourceCB").on('input', function() {
        var c = this.selectionStart,
            r = /[^ a-z_0-9-]/gi,
            v = $(this).val();
        if(r.test(v)) {
          $(this).val(v.replace(r, ''));
          c--;
        }
        this.setSelectionRange(c, c);
      });

      $("#locationCB" ).on('input', function() {
        var c = this.selectionStart,
            r = /[^ a-z_0-9-]/gi,
            v = $(this).val();
        if(r.test(v)) {
          $(this).val(v.replace(r, ''));
          c--;
        }
        this.setSelectionRange(c, c);
      });
      $("#titleCB" ).on('input', function() {
        var c = this.selectionStart,
            r = /[^ a-z_0-9-]/gi,
            v = $(this).val();
        if(r.test(v)) {
          $(this).val(v.replace(r, ''));
          c--;
        }
        this.setSelectionRange(c, c);
      });
      $("#subtitleCB" ).on('input', function() {
        var c = this.selectionStart,
            r = /[^ a-z_0-9-]/gi,
            v = $(this).val();
        if(r.test(v)) {
          $(this).val(v.replace(r, ''));
          c--;
        }
        this.setSelectionRange(c, c);
      });

      $("#personCB").on('input', function() {
        var c = this.selectionStart,
            r = /[^ a-z_0-9-]/gi,
            v = $(this).val();
        if(r.test(v)) {
          $(this).val(v.replace(r, ''));
          c--;
        }
        this.setSelectionRange(c, c);
      });
      $("#formatCB").on('input', function() {
        var c = this.selectionStart,
            r = /[^ a-z_0-9-]/gi,
            v = $(this).val();
        if(r.test(v)) {
          $(this).val(v.replace(r, ''));
          c--;
        }
        this.setSelectionRange(c, c);
      });

      $('#clearBtn').on('click', function(e) {
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


