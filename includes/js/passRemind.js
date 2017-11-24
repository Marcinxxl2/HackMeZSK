$(document).ready(function () {

    var f = document.forms['passRemindForm'];
    var elEmail = f.email;
    var elSubmitButton = $('#passRemindForm button');
    var regEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    var aEmail = $('#alertEmail');
    var aCaptcha = $('#alertCaptcha');

    function switchClass (element, classToRemoveName, classToAddName) {
        $(element).removeClass(classToRemoveName);
        $(element).addClass(classToAddName);
    }

    var validate = false;

    $(elEmail).on('blur', function () {
        if (!regEmail.test($(elEmail).val())) {
            $(aEmail).text('Nieprawidłowy E-mail');
            switchClass(elEmail, 'goodInput', 'warningInput');
            validate = false;           
        }
    });

    $(elEmail).on('input', function () {
        if (regEmail.test($(elEmail).val())) {
            $(aEmail).text('');
            switchClass(elEmail, 'warningInput', 'goodInput');
            validate = true; 
        }
    });

    $(elSubmitButton).on('click', function () {
        if (grecaptcha.getResponse().length == 0) {
            $(aCaptcha).text('Zweryfikuj Captche');
        } 
        
        if (validate) {
            f.submit();
        } else {
            $(elEmail).trigger('blur');
        }
    });


    //Aby się nie psuło gdy przeglądarka zapamięta wartości
    if ($(elEmail).val() != '') {
        $(elEmail).trigger('input');
    }
 


});