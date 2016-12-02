$(function () {
    $('.btn-submit').on('click', function () {
        $(this).closest('form').submit();
        return false;
    });

    $('.change-submit').on('change', function() {
        $(this).closest('form').submit();
        return false;
    });

    $('.btn-submit-exit').on('click', function () {
        $(this).closest('form').data('back', true).submit();
        return false;
    });

    $("input").keyup(function (e) {
        if (e.keyCode == 13) {
            $(this).closest('form').submit();
        }
    });

    runOnKeys("textarea", function (e) {
        $(e).closest('form').submit();
    }, 13, 17);

    tooltipInit();
});

function tooltipInit() {
    $('[data-toggle="tooltip"]').tooltip();
}

function ajaxForm(form, beforeSendCallback, successCallback, errorCallback, completeCallback) {
    $(form).on('submit', function () {
        var next = true,
            f = this;
        try {
            if (isLoadingForm(f)) return false;
            if (!checkRequired(f)) return false;
            if (typeof beforeSendCallback === 'function') {
                next = beforeSendCallback(f);
            }
            loadingForm(f);
            if (next) {
                $.ajax($(f).attr('action'), {
                    type: $(f).attr('method'),
                    data: $(f).serialize(),
                    dataType: "json",
                    complete: function (jqXHR, textStatus) {
                        unLoadingForm(f);
                        if (typeof completeCallback === 'function') {
                            completeCallback(f, jqXHR, textStatus)
                        }
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.error) {
                            var a = data.error.split("|");
                            errorInput(f, a[1], a[0]);
                        }
                        if (typeof successCallback === 'function') {
                            successCallback(f, data, textStatus, jqXHR);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        errorInput(f);
                        if (typeof errorCallback === 'function') {
                            errorCallback(f, jqXHR, textStatus, errorThrown);
                        }
                    }
                });
            }
        } catch (e) {
            console.log(e);
        }
        return false;
    });
}

function resetInput(form, name) {
    name = $.trim(name);

    var s = '[name="' + name + '"]';
    if (!name) s = '[name]';

    $(form).find(s).removeClass('form-control-danger').removeClass('form-control-success');
    $(form).find(s).closest('.form-group').removeClass('has-danger').removeClass('has-success');
    $(form).find(s).closest('.form-group').find('.form-control-feedback').html("");
}

function errorInput(form, name, msg) {
    resetInput(form, name);

    if (!msg) {
        msg = 'Ошибка сервера, попробуйте позднее или обратитесь к администратору.';
    }

    name = $.trim(name);
    msg = $.trim(msg);

    var s = '[name="' + name + '"]';
    if (!name) s = '[name]';

    $(form).find(s).addClass('form-control-danger');
    $(form).find(s).closest('.form-group').addClass('has-danger');
    $(form).find(s).closest('.form-group').find('.form-control-feedback').html(msg);
}

function successInput(form, name, msg) {
    resetInput(form, name);

    name = $.trim(name);
    msg = $.trim(msg);

    var s = '[name="' + name + '"]';
    if (!name) s = '[name]';

    $(form).find(s).addClass('form-control-success');
    $(form).find(s).closest('.form-group').addClass('has-success');
    $(form).find(s).closest('.form-group').find('.form-control-feedback').html(msg);
}

function trimTextInputs(form) {
    $(form).find('input[type="text"]').each(function (i, e) {
        $(e).val($.trim($(e).val()));
    });
}

function loadingForm(form) {
    $(form).find('.btn-submit')
        .data('loading', 1)
        .data('original-text', $(form).find('.btn-submit').html())
        .html('<i class="fa fa-pulse fa-spinner" aria-hidden="true"></i>');
}

function isLoadingForm(form) {
    return $(form).find('.btn-submit').data('loading');
}

function unLoadingForm(form) {
    $(form).find('.btn-submit').data('loading', 0);
    $(form).find('.btn-submit').html($(form).find('.btn-submit').data('original-text'));
}

function checkRequired(form) {
    var result = true;
    var s = $(form).serializeArray();

    var field, find, name;

    s.forEach(function (item) {
        field = $(form).find('[name="' + item.name + '"]');
        if (item.value || field.is(':not(:required)')) {
            successInput(form, item.name);
        }
    });

    $(form).find(':required').each(function () {
        find = false;
        name = this.name;
        s.forEach(function (item) {
            if (item.name == name && item.value) {
                find = true;
            }
        });

        if (!find) {
            errorInput(form, name, $(this).data('required') ? $(this).data('required') : "Введите");
            result = false;
        }
    });
    return result;
}

/**
 * Одновременное нажатие нескольких клавиш
 * https://learn.javascript.ru/task/check-sync-keydown
 * runOnKeys(el, Callback, code1, code2, ... code_n)
 * запускает Callback при одновременном нажатии клавиш в элементе (textarea) со скан-кодами code1, code2, …, code_n
 * @param el
 * @param Callback
 */
function runOnKeys(el, Callback) {
    var codes = [].slice.call(arguments, 2);
    var pressed = {};
    $(el).on('keydown', function (e) {
        e = e || window.event;
        pressed[e.keyCode] = true;
        for (var i = 0; i < codes.length; i++) {
            if (!pressed[codes[i]]) {
                return;
            }
        }
        pressed = {};
        Callback(el);
    });
    $(el).on('keyup', function (e) {
        e = e || window.event;
        delete pressed[e.keyCode];
    });
}