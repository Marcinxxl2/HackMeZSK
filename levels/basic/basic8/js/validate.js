var form = document.forms['form'];
var pass = form.pass;
var button = document.getElementById('button');
var alert = document.getElementById('alertLevel');

button.addEventListener('click', function() {
    if (pass.value == '') {
        form.submit();
    } else {
        alert.innerHTML = 'Niepoprawne hasło';
    }
});