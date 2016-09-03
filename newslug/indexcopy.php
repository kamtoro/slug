<?php
include_once 'config/dbconfig.php';
?>
<?php include_once 'header.php'; ?>



<form id="tooltipContainerForm" class="form-horizontal">
    <div class="form-group">
        <label class="col-xs-3 control-label">Full name</label>
        <div class="col-xs-3">
            <input type="text" class="form-control" name="firstName" placeholder="First name" />
        </div>
        <div class="col-xs-3">
            <input type="text" class="form-control" name="lastName" placeholder="Last name" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Phone number</label>
        <div class="col-xs-4">
            <input type="text" class="form-control" name="phone" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-9 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Validate</button>
            <button type="button" class="btn btn-default" id="resetButton">Reset</button>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#tooltipContainerForm')
        .formValidation({
            framework: 'bootstrap',
            err: {
                container: 'tooltip'
            },
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                firstName: {
                    validators: {
                        notEmpty: {
                            message: 'The first name is required and can not be empty'
                        }
                    }
                },
                lastName: {
                    validators: {
                        notEmpty: {
                            message: 'The last name is required and can not be empty'
                        }
                    }
                },
                phone: {
                    validators: {
                        digits: {
                            message: 'The phone number can contain digits only'
                        },
                        notEmpty: {
                            message: 'The phone number is required and can not be empty'
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

    // Reset the Tooltip container form
    $('#resetButton').on('click', function(e) {
        var fields = $('#tooltipContainerForm').data('formValidation').getOptions().fields,
            $parent, $icon;

        for (var field in fields) {
            $parent = $('[name="' + field + '"]').parents('.form-group');
            $icon   = $parent.find('.form-control-feedback[data-fv-icon-for="' + field + '"]');
            $icon.tooltip('destroy');
        }

        // Then reset the form
        $('#tooltipContainerForm').data('formValidation').resetForm(true);
    });
});
</script>



<?php include_once 'footer.php'; ?>