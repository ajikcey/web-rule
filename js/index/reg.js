ajaxForm('.form-ajax', function (form) {
    // before send callback
    trimTextInputs(form);

    if ($(form).find('[name="pass"]').val() != $(form).find('[name="pass2"]').val()) {
        errorInput(form, 'pass2', 'Пароль повторен неверно');
        return false;
    }

    successInput(form, 'pass2');
    return true;
}, function (form, data) {
    // success callback
    if (data.success) {
        location.reload();
    }
});