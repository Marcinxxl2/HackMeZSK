var form = document.forms['regisForm'];
var validate = {
    login: true,
    email: true,
    pass1: true,
    pass2: true,
    firstname: true,
    lastname: true,
    rules: true
};

var regLogin = /^\w{2,45}$/;
var regEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var regPass = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,45}$/; //Minimum 8 znaków, przynajmniej jedna litera, cyfra i znak specjalny
var regFirstname = /^[\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{2,45}$/;