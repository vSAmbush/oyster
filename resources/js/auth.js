/**
 * Masks are available only with maskedinput.js
 */
$(document).ready(function () {
    //Set the mask to login field
    $('#login').mask('+79888888888', {
        placeholder:'+79XXXXXXXXX'
    });

    //Set the mask to password field
    $('#password').mask('8888', {
        placeholder:'XXXX'
    });

    /**
     * Use this because we don't submit form, in turn, we must set this property like in form as default
     */
    $('#login').keypress(function(e){
        if(e.keyCode==13){
            $('#enter_btn').click();
        }
    });

    $('#password').keypress(function(e){
        if(e.keyCode==13){
            $('#enter_btn').click();
        }
    });

    $('#login').focus();
});

function showPhone() {

    $('#answer').hide();
    $('#loader').hide();
    $('#login').show();
    $('#enter_btn').show();
    $('#login').focus();
}

function showCode() {

    $('#answer').hide();
    $('#loader').hide();
    $('#password').show();
    $('#enter_btn').show();
    $('#password').focus();
}

function showError(type) {

    $('#loader').hide();
    $('#answer').html('Ошибка авторизации!');
    $('#password').val('');
    $('#answer').show();

    if (type === 'phone') {
        $('#login').val('');
        setTimeout(showPhone, 1000);
    }

    if (type === 'code') {
        setTimeout(showCode, 1000);
    }

    return;
}

$('#enter_btn').on('click', function (e) {

    e.preventDefault();

    $(this).hide();
    $('#login').hide();
    $('#password').hide();
    $('#answer').hide();
    $('#loader').show();

    var phone = $('#login').val();
    var passwd = $('#password').val();
    var flag = true;

    if(flag)
        $.ajax({
            type: 'POST',
            //clear /crm_v2 on remote server
            url: '/crm_v2/auth/authentication/',
            data: {
                login: phone,
                password: passwd
            },
            success: function(answer) {
                console.log(answer);
                if (answer === 'code') {
                    setTimeout(showCode, 1000);
                }
                if (answer === 'wrong') {
                    //setTimeout with parameters
                    setTimeout(showError, 1000, 'code');
                }
                if (answer === 'fail') {
                    setTimeout(showError, 1000, 'phone');
                }
                if (answer === 'success') {
                    flag = false;
                    setTimeout(window.location.href = '/crm_v2/auth/saveuser', 1000);
                }
                return false;
            },
            error: function() {
                alert('Error!');
                window.location.reload();
            }
        });
});