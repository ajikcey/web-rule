ajaxForm('.form-ajax', function (form) {
    // before send callback
    trimTextInputs(form);
    return true;
}, function (form, data) {
    // success callback
    if (data.success) {
        location.reload();
    }
});