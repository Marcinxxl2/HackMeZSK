$(document).ready(function () {

    var validate = {
        login: true,
        email: true,
        firstname: true,
        lastname: true,
        pass1: true,
        pass2: true,
        rules: true
    };

    var f = document.forms['regisForm'];
    var elLogin = f.login;
    var elEmail = f.email;
    var elFirstname = f.firstname;
    var elLastname = f.lastname;
    var elPass1 = f.password1;
    var elPass2 = f.password2;
    var elRegu = f.regulations;
    
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
    var aPass2 = $('#alertPassword1');
    var aRegu = $('#alertPassword1');

    function validateAlert (inputElement, regex, objectValidateElementName, alertText, alertElement) {
        $(inputElement).on('blur', function () {
            if (!regex.test($(inputElement).val())) {
                $(alertElement).text(alertText);
                $(inputElement).removeClass('goodInput');
                $(inputElement).addClass('warningInput');
                validate[objectValidateElementName] = false;
            } else {
                $(alertElement).text('');
                $(inputElement).removeClass('warningInput');
                $(inputElement).addClass('goodInput');
                validate[objectValidateElementName] = true;               
            }
        });
    }

    validateAlert(elLogin, regLogin, 'login', 'Niepoprawny Login', aLogin);
    validateAlert(elEmail, regEmail, 'email', 'Niepoprawny Email', aEmail);
    validateAlert(elFirstname, regFirstname, 'firstname', 'Niepoprawne imię', aFirstname);
    validateAlert(elLastname, regLastname, 'lastname', 'Niepoprawne nazwisko', aLastname);
});



