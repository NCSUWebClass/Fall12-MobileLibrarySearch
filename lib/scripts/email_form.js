$(document).ready(function() {

        $('#esubmit').click(function(){

            $.ajax({
                url: "email.php",
                type: "POST",
                data: { email_to:$("#email_to").val(),
                        erecord_id:$("#erecord_id").val(),
                },
            });
            $('div.ui-collapsible').trigger('collapse');
            return false;
// We probably want an error case for non-AJAX support
// Maybe to a wrapper script that actually returns content
        });


//         $('#text-form').hide().submit(function(){
        $('#text-form').submit(function(){
            $.ajax({
                url: "email.php",
                type: "POST",
                data: { phone_number:$("#phone_number").val(),
                        text_provider:$("#text_provider").val(),
                        trecord_id:$("#trecord_id").val(),
                      },
            });
            $('div.ui-collapsible').trigger('collapse');
            return false;
        });

});
