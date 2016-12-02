ajaxForm('.form-ajax', function (form) {
    // before send callback
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

$(function () {
    $('.del-user').on('click', function () {
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

    /**
     * Common variables
     */
    var avatar_input = '[name="avatar"]',
        avatar_x_input = '[name="avatar_x"]',
        avatar_y_input = '[name="avatar_y"]',
        avatar_w_input = '[name="avatar_w"]',
        avatar_h_input = '[name="avatar_h"]',
        avatar_thumbnail = '#avatar',
        avatar_jcrop = '#jcrop',
        avatar_jcrop_win = '#originalAvatar',
        avatar_form = '#userForm';

    function setThumbnail(filename, x, y, w, h, big_img) {
        $(avatar_input).val(filename);
        $(avatar_x_input).val(x);
        $(avatar_y_input).val(y);
        $(avatar_w_input).val(w);
        $(avatar_h_input).val(h);
        if (big_img) {
            $(avatar_thumbnail).css('background-image', 'url("' + big_img + '")');
        } else {
            $(avatar_thumbnail).css('background', '');
        }
    }

    /**
     * Jcrop
     */
    var jcrop_api;

    /**
     * Костыль для пресечения образования пустого выделения
     * @param c
     */
    function showCoords(c) {
        // if (!c.w || !c.h) initJcrop();
    }

    function initJcrop() {
        destroyJcrop();
        jcrop_api = $.Jcrop(avatar_jcrop, {
            allowSelect: false,
            bgColor: 'black',
            bgOpacity: .4,
            aspectRatio: 1,
            minSize: [200, 200],
            setSelect: [
                parseInt($(avatar_x_input).val()),
                parseInt($(avatar_y_input).val()),
                parseInt($(avatar_x_input).val()) + parseInt($(avatar_w_input).val()),
                parseInt($(avatar_y_input).val()) + parseInt($(avatar_h_input).val())
            ],
            onSelect: showCoords,
            onChange: showCoords
        });
    }

    function destroyJcrop() {
        if (jcrop_api) {
            jcrop_api.destroy();
        }
    }

    /**
     * Dropzone
     */
    var drop_el = '#dropZone',
        drop_btn = '.btn',
        drop_error = '.dz-error-message';

    new Dropzone(drop_el, {
        url: $(drop_el).data('target'),
        acceptedFiles: "image/*",
        maxFiles: 1,
        uploadMultiple: false,
        previewTemplate: '<div id="preview-template" style="display: none;"></div>'
    }).on("addedfile", function () {
        $(this.element).find(drop_btn).data('original', $(this.element).find(drop_btn).html()).html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i> Загрузка...');
        $(this.element).find(drop_error).html("").hide();
        $.fancybox.update();
    }).on("error", function (file, errorMessage) {
        $(this.element).find('.dz-error-message').html(errorMessage).show();
    }).on("uploadprogress", function (file, progress) {
        $(this.element).find('progress').val(progress);
    }).on("success", function (file, d) {
        var data = JSON.parse(d);
        if (data.error) {
            $(this.element).find(drop_error).html(data.error).show();
        }
        if (data.success) {
            $(avatar_jcrop).attr('src', data.original_img).css({width: data.original_w, height: data.original_h});
            setThumbnail(data.filename, data.x, data.y, data.w, data.h, data.big_img);
            notify(data.msg);
            $(avatar_form).submit();
            showWinCrop();
        }
    }).on("complete", function (file) {
        $(this.element).removeClass('disabled');
        $(this.element).find('progress').val(0);
        $(this.element).find(drop_btn).html($(this.element).find(drop_btn).data('original'));
        this.removeFile(file); // для возможность еще загружать файлы
        $.fancybox.update();
    }).on("sending", function () {
        $(this.element).addClass('disabled');
    });

    /**
     * Button delete avatar
     */
    $(".btn-del-thumbnail").on('click', function () {
        if (!$(avatar_input).val()) {
            notify("Аватарка не загружена", "danger");
            return false;
        }
        if (!confirm("Удалить аватарку пользователя?")) return false;

        var btn = this;
        $(btn).data('original', $(btn).html()).html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>');
        $.ajax(btn.href, {
            type: 'post',
            data: {
                filename: $(avatar_input).val()
            },
            dataType: "json",
            complete: function () {
                $(btn).html($(btn).data('original'));
            },
            success: function (data) {
                if (data.error) {
                    notify(data.error, "danger");
                }
                if (data.success) {
                    setThumbnail('', 0, 0, 0, 0, '');
                    notify(data.msg);
                    $(avatar_form).submit();
                }
            }
        });
        return false;
    });

    /**
     * Button save thumbnail
     */
    $(".btn-save-thumbnail").on('click', function () {
        if (!jcrop_api) alert("Ошибка инициализации плагина Jcrop");
        var btn = this;
        $(btn).data('original', $(btn).html()).html('<i class="fa fa-spinner fa-pulse" aria-hidden="true"></i>').addClass('disabled');
        $(avatar_jcrop_win).find('a.btn').addClass('disabled');
        $(avatar_jcrop_win).find('.error-message').html("").hide();
        jcrop_api.disable();

        $.ajax(btn.href, {
            type: 'post',
            data: {
                coord: jcrop_api.tellSelect(),
                filename: $(avatar_input).val()
            },
            dataType: "json",
            complete: function () {
                $(btn).html($(btn).data('original')).removeClass('disabled');
                $(avatar_jcrop_win).find('a.btn').removeClass('disabled');
                jcrop_api.enable();
            },
            success: function (data) {
                if (data.error) {
                    $(avatar_jcrop_win).find('.error-message').html(data.error).show();
                }
                if (data.success) {
                    setThumbnail(data.filename, data.x, data.y, data.w, data.h, data.big_img + '?t=' + Date.now());
                    notify(data.msg);
                    $(avatar_form).submit();
                    $.fancybox.close(true);
                }
            }
        });
        return false;
    });

    function showWinCrop() {
        $.fancybox($(avatar_jcrop_win), {
            live: false,
            closeBtn: false,
            autoSize: true,
            autoResize: true,
            minWidth: 250,
            padding: 0,
            helpers: {
                overlay: {
                    closeClick: false
                }
            },
            beforeShow: function () {
                initJcrop();
            },
            beforeClose: function () {
                destroyJcrop();
            }
        });
    }

    function showWinDownload() {
        $.fancybox($("#downloadAvatar"), default_fancybox_opts);
    }

    $('.fancybox-crop').on('click', function () {
        if (!$(avatar_input).val()) {
            notify("Аватарка не загружена", "danger");
            return false;
        }
        showWinCrop();
        return false;
    });

    $('.fancybox-download').on('click', function () {
        showWinDownload();
        return false;
    });

    $('.btn-trigger').on('click', function () {
        if ($(avatar_input).val()) {
            showWinCrop();
        } else {
            showWinDownload();
        }
        return false;
    });
});