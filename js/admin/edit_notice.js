$(function () {
    var editor_api,
        editor = '#editor1';

    ajaxForm('.form-ajax', function (form) {
        // before send callback
        if (editor_api) {
            $(editor_api.element.$).val(editor_api.getData());
        }
        trimTextInputs(form);
        return true;
    }, function (form, data) {
        // success callback
        if (data.success) {
            notify(data.msg);
            if ($(form).data('back')) {
                history.back();
            }
        }
    });

    function editorToggle() {
        if ($('[name="is_html"]').prop('checked')) {
            editor_api = CKEDITOR.replace(editor.substring(1), {
                toolbar: 'noticeToolbar',
                customConfig: '/js/admin/ckeditor_config.js',
                fullPage: true,
                height: 500
            });
        } else if (editor_api) {
            editor_api.destroy();
            $(editor).val($(editor).text());
        }
    }

    editorToggle();
    $('[name="is_html"]').on('change', editorToggle);

    $('.del-notice').on('click', function () {
        var b = this;
        $.ajax(b.href, {
            dataType: "json",
            complete: function () {

            },
            success: function (d) {
                if (d.success) {
                    notify(d.msg);
                }
                if (d.error) {
                    notify(d.error, 'danger');
                }
            },
            error: function (jqXHR) {
                notify(jqXHR, 'danger');
            }
        });
        return false;
    });
});
