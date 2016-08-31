<!-- <script src="/js/jquery-1.12.4.min.js"></script> -->

<!-- JQuery libraries -->
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">

<!-- Autocomplete -->
<!-- <script type="text/javascript" src="/js/jquery.ui.autocomplete.html.js"></script>
<link rel="stylesheet" type="text/css" href="/css/autocomplete.css"> -->

<!-- Bootstrap libraries -->
<script src="/js/bootstrap.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">   

<!-- Bootstrap Validator -->
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>

<style type="text/css">
/* Custom the feedback icon styles */
.form-horizontal .has-feedback .form-control-feedback {
    top: 0;
    right: 5px;
}
</style>


<!-- Local js Library -->
<script src="/js/functionsJS.js"></script>

<!-- Clipboard.js Libary -->
<script src="/js/dist/clipboard.min.js"></script>

<script type="text/javascript">
  $( function() {
    $( "#sourceCB" ).autocomplete({
      minLength: 1,
      source: "/includes/jsonObjetDataList.php?table=sourceList&field=source",
      // focus: function( event, ui ) {
      //   $( "#sourceCB" ).val( ui.item.label );
      //   return false;
      // },
      select: function( event, ui ) {
        $( "#sourceCB" ).val( ui.item.label );
        // $( "#sourceCB-id" ).val( ui.item.value ); ID To save ID of record

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

    $( "#clearBtn").on("click", function() {
      // alert( $( this ).text() );
      $("#resetBtn").trigger( "click" );
    });

    $("#saveBtn").on("click", function() {

      // $.ajax({
      //   url: "/includes/dataRecordings.inc.php",
      //   data: { param1: "value1", param2: "value2" },
      //   type: "GET",
      //   context: document.body
      // }).done(function() {
      //   // your code goes here
      // });

      // CTORO FUNCIONA PARA HACER EL SUBMIT DEL FORM
      // $.post( "/includes/dataRecordings.inc.php", $( "#recordingsForm").serialize() );


      // Use Ajax to submit form data

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
        }
      });
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
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);

        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
    //var clipboard = new Clipboard('.btn');
    // .autocomplete( "instance" )._renderItem = function( ul, item ) {
    //   return $( "<li>" )
    //     .append( "<div>" + item.label + "<br>" + item.desc + "</div>" )
    //     .appendTo( ul );
    // };
  } );

  $(document).ready(function() {
      $('#recordingsForm').bootstrapValidator({
          container: '#messages',
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
              sourceCB: {
                  validators: {
                      notEmpty: {
                          message: 'The Source is required and cannot be empty'
                      }
                  }
              },
              locationCB: {
                  validators: {
                      notEmpty: {
                          message: 'The Location is required and cannot be empty'
                      }
                      // ,
                      // emailAddress: {
                      //     message: 'The email address is not valid'
                      // }
                  }
              },
              personCB: {
                  validators: {
                      notEmpty: {
                          message: 'The For is required and cannot be empty'
                      }
                      // ,
                      // stringLength: {
                      //     max: 100,
                      //     message: 'The title must be less than 100 characters long'
                      // }
                  }
              }
          }
      });
  });
</script>


