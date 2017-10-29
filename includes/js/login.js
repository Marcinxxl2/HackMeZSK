$(document).ready(function () {
    $('#loginForm input').on('blur', function () {
        if ($(this).val() == '') { 
            $(this).addClass('warningInput');
            test = false;
        }
    });

    $('#loginForm input').on('input', function () {
        if ($(this).val() != '') {
            $(this).removeClass('warningInput');
        }
    });

    $('#loginForm button').on('click', function () {
        var isValid = true;

        $('#loginForm input').each(function() {
            if ($(this).val() == '') {
                isValid = false;
                $(this).addClass('warningInput');
            }
        })

        if (isValid) {
            $('#loginForm').submit();
        } else {
            $('#alert').text('Wypełnij wszystkie pola');
        }
        
    });
});