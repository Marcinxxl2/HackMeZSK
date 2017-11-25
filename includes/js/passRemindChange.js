$(document).ready(function () {

    var f = document.forms['passRemindChangeForm'];
    var elPass1 = f.password1;
    var elPass2 = f.password2;

    var elSubmitButton = $('#passRemindChangeForm button');

    var aPass1 = $('#alertPassword1');
    var aPass2 = $('#alertPassword2');

    var aMeterLength = $('#meterLength');
    var aMeterLetter = $('#meterLetter');
    var aMeterDigit = $('#meterDigit');
    var aMeterSpecial = $('#meterSpecial');

    var regPass = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,45}$/;

    var regPassLetter = /[a-zA-Z]+/;
    var regPassDigit = /[0-9]+/;
    var regPassSpecial = /[\W]+/;

    function switchClass (element, classToRemoveName, classToAddName) {
        $(element).removeClass(classToRemoveName);
        $(element).addClass(classToAddName);
    }

    var validate = {
        pass1: false,
        pass2: false
    };

    $(elPass1).on('focus', function () {
       $('#passwordMeter').show(200); 
    });

    $(elPass1).on('blur', function () {
        $('#passwordMeter').hide(200); 

        if (!regPass.test($(elPass1).val())) {
            $(aPass1).text('Nieprawidłowe hasło');
            switchClass(elPass1, 'goodInput', 'warningInput');
            validate['pass1'] = false;   
            $(elPass2).attr('disabled', true);        
        }
    });

    $(elPass1).on('input', function () {
        if ($(elPass1).val().length < 8) {
            switchClass(aMeterLength, 'goodText', 'badText');
        } else {
            switchClass(aMeterLength, 'badText', 'goodText');
        }

        if (!regPassLetter.test($(elPass1).val())) {
            switchClass(aMeterLetter, 'goodText', 'badText');
        } else {
            switchClass(aMeterLetter, 'badText', 'goodText');
        }

        if (!regPassDigit.test($(elPass1).val())) {
            switchClass(aMeterDigit, 'goodText', 'badText');
        } else {
            switchClass(aMeterDigit, 'badText', 'goodText');
        }

        if (!regPassSpecial.test($(elPass1).val())) {
            switchClass(aMeterSpecial, 'goodText', 'badText');
        } else {
            switchClass(aMeterSpecial, 'badText', 'goodText');
        }

        if (regPass.test($(elPass1).val())) {
            $(aPass1).text('');
            switchClass(elPass1, 'warningInput', 'goodInput');
            validate['pass1'] = true; 
            $(elPass2).removeAttr('disabled');
        }

        if ($(elPass2).val() != '') {
            $(elPass2).val('');
            $(elPass2).trigger('blur');
        }
    });

    $(elPass2).on('blur', function () {
        if ($(elPass2).val() != $(elPass1).val()) {
            $(aPass2).text('Hasła się nie zgadzają');
            switchClass(elPass2, 'goodInput', 'warningInput');
            validate['pass2'] = false;           
        }
    });

    $(elPass2).on('input', function () {
        if ($(elPass2).val() == $(elPass1).val()) {
            $(aPass2).text('');
            switchClass(elPass2, 'warningInput', 'goodInput');
            validate['pass2'] = true; 
        }
    });

    $(elSubmitButton).on('click', function () {
        if (validate.pass1 && validate.pass2) {
            f.submit();
        } else {
            $(elPass1).trigger('blur');
            $(elPass2).trigger('blur');
        }

    });

});