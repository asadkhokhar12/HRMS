"use strict";
$(document).ready(function () {
    $('#submitQuery').on('click',function(){
        var name = $('#name').val();
        var email = $('#email').val();
        var message = $('#message').val();
        var is_ajax = 1;
        if(message == '' && name == '' && email == ''){
            iziToast.warning({
                        title: 'Warning',
                        message: "All fileds is required",
                        position: 'topRight'
                    });
            return false;
        }
        if(name == ''){
            iziToast.warning({
                        title: 'Warning',
                        message: "Name is required",
                        position: 'topRight'
                    });
            return false;
        }
        //check email is null
        if(email == ''){
            iziToast.warning({
                        title: 'Warning',
                        message: "Email is required",
                        position: 'topRight'
                    });
            return false;
        }
        //check message is null
        if(message == ''){
            iziToast.warning({
                        title: 'Warning',
                        message: "Message is required",
                        position: 'topRight'
                    });
            return false;
        }
        var baseUrl = $('meta[name="base-url"]').attr('content');
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: baseUrl+"/contact",
            type: "POST",
            data: {
                name: name,
                email: email,
                message: message,
                is_ajax: is_ajax,
                _token: _token
            },
            success: function(response) {
                $('#name').val("");
                $('#email').val("");
                $('#message').val("");
                $( "#closeContactBox" ).trigger( "click" );
                iziToast.success({
                        title: 'Success',
                        message: "Message Sent Successfully",
                        position: 'topRight'
                    });
            },
            error: function(error) {
                console.log(error);
                iziToast.error({
                        title: 'Error',
                        message: "Message Not Sent",
                        position: 'topRight'
                    });
            }
        });
    });
});