ajaxForm('.form-ajax', function (form) {
    // before send callback
    trimTextInputs(form);
    return true;
}, function (form, data) {
    // success callback
    if (data.success) {
        notify(data.msg);
    }
});

$(function () {
    var win = "#winFiles",
        elfinder_api;

    $(".fancybox-elfinder").fancybox({
        padding: 0,
        closeBtn: false,
        scrollOutside: false,
        minWidth: '100%',
        minHeight: '100%',
        width: '100%',
        height: '100%',
        helpers: {
            overlay: {
                closeClick: false
            }
        },
        afterShow: function () {
            elfinder_api = $('#elfinder').elfinder({
                url: '/admin/elfinder',
                lang: 'ru',
                height: this.inner[0].clientHeight - 70,
                resizable: false,
                soundPath: '/plugins/elFinder/sounds/'
            }).elfinder('instance');
        }
    });

    $("#selectFile").on('click', function () {
        $(win).find('.error-message').html("");
        if (elfinder_api) {
            var selected = elfinder_api.selectedFiles();
            if (selected.length == 1) {
                $('[name="image"]').val(selected[0].url);
                $.fancybox.close();
            } else {
                $(win).find('.error-message').html("Выберите файл");
            }
        }
        return false;
    });

    $(".fancybox-input").on('click', function () {
        $.fancybox($($(this).data('target')).val(), default_fancybox_opts);
    });
});