$(document).ready(function () {

    var validate = {
        login: false,
        email: false,
        firstname: false,
        lastname: false,
        pass1: false,
        pass2: false
    };

    var f = document.forms['regisForm'];
    var elLogin = f.login;
    var elEmail = f.email;
    var elFirstname = f.firstname;
    var elLastname = f.lastname;
    var elPass1 = f.password1;
    var elPass2 = f.password2;
    var elRegu = f.regulations;

    var elSubmitButton = $('#regisForm button');
    
    var regLogin = /^\w{2,45}$/;
    var regEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var regFirstname = /^[\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{2,45}$/;
    var regLastname = /^[\wąężćńółĄĆĘŁŃÓŚŹŻ]{2,32}(\-[\wąężćńółĄĆĘŁŃÓŚŹŻ]{2,32}$)?$/;
    var regPass = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,45}$/; //Minimum 8 znaków, przynajmniej jedna litera, cyfra i znak specjalny

    var aLogin = $('#alertLogin');
    var aEmail = $('#alertEmail');
    var aFirstname = $('#alertFirstname');
    var aLastname = $('#alertLastname');
    var aPass1 = $('#alertPassword1');
    var aPass2 = $('#alertPassword2');
    var aRegu = $('#alertRegulations');

    var aMeterLength = $('#meterLength');
    var aMeterLetter = $('#meterLetter');
    var aMeterDigit = $('#meterDigit');
    var aMeterSpecial = $('#meterSpecial');

    function toggleClass (element, classToRemoveName, classToAddName) {
        $(element).removeClass(classToRemoveName);
        $(element).addClass(classToAddName);
    }

    function validateAlert (inputElement, regex, objectValidateElementName, alertText, alertElement) {
        $(inputElement).on('blur', function () {
            if (!regex.test($(inputElement).val())) {
                $(alertElement).text(alertText);
                toggleClass(inputElement, 'goodInput', 'warningInput');
                validate[objectValidateElementName] = false;           
            }
        });
        $(inputElement).on('input', function () {
            if (regex.test($(inputElement).val())) {
                $(alertElement).text('');
                toggleClass(inputElement, 'warningInput', 'goodInput');
                validate[objectValidateElementName] = true; 
            }
        });
    }

    validateAlert(elLogin, regLogin, 'login', 'Niepoprawny login', aLogin);
    validateAlert(elEmail, regEmail, 'email', 'Niepoprawny E-mail', aEmail);
    validateAlert(elFirstname, regFirstname, 'firstname', 'Niepoprawne imię', aFirstname);
    validateAlert(elLastname, regLastname, 'lastname', 'Niepoprawne nazwisko', aLastname);

    var regPassLetter = /[a-zA-Z]+/;
    var regPassDigit = /[0-9]+/;
    var regPassSpecial = /[\W]+/;

    $(elPass1).on('focus', function () {
       $('#passwordMeter').show(200); 
    });

    $(elPass1).on('blur', function () {
        $('#passwordMeter').hide(200); 

        if (!regPass.test($(elPass1).val())) {
            $(aPass1).text('Nieprawidłowe hasło');
            toggleClass(elPass1, 'goodInput', 'warningInput');
            validate['pass1'] = false;   
            $(elPass2).attr('disabled', true);        
        }
    });

    $(elPass1).on('input', function () {
        if ($(elPass1).val().length < 8) {
            toggleClass(aMeterLength, 'goodText', 'badText');
        } else {
            toggleClass(aMeterLength, 'badText', 'goodText');
        }

        if (!regPassLetter.test($(elPass1).val())) {
            toggleClass(aMeterLetter, 'goodText', 'badText');
        } else {
            toggleClass(aMeterLetter, 'badText', 'goodText');
        }

        if (!regPassDigit.test($(elPass1).val())) {
            toggleClass(aMeterDigit, 'goodText', 'badText');
        } else {
            toggleClass(aMeterDigit, 'badText', 'goodText');
        }

        if (!regPassSpecial.test($(elPass1).val())) {
            toggleClass(aMeterSpecial, 'goodText', 'badText');
        } else {
            toggleClass(aMeterSpecial, 'badText', 'goodText');
        }

        if (regPass.test($(elPass1).val())) {
            $(aPass1).text('');
            toggleClass(elPass1, 'warningInput', 'goodInput');
            validate['pass1'] = true; 
            $(elPass2).removeAttr('disabled');
        }
    });

    $(elPass2).on('blur', function () {
        if ($(elPass2).val() != $(elPass1).val()) {
            $(aPass2).text('Hasła się nie zgadzają');
            toggleClass(elPass2, 'goodInput', 'warningInput');
            validate['pass2'] = false;           
        }
    });
    $(elPass2).on('input', function () {
        if ($(elPass2).val() == $(elPass1).val()) {
            $(aPass2).text('');
            toggleClass(elPass2, 'warningInput', 'goodInput');
            validate['pass2'] = true; 
        }
    });

    $(elRegu).on('change', function () {
        if ($(elRegu).is(':checked')) {
            $(aRegu).text('');
        }
    });

    function allOk () {
        for (var i in validate) {
            if (!validate[i]) {
                return false;
            }
        }
        return true;
    }

    $(elSubmitButton).on('click', function () {
        if (!$(elRegu).is(':checked')) {
            $(aRegu).text('Akceptacja jest wymagana');
        } else if (allOk()) {
            f.submit();
        }
    });
});



