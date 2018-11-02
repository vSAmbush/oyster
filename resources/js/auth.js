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