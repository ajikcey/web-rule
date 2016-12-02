var default_fancybox_opts = {
        autoSize: true,
        autoResize: true,
        padding: 0,
        scrollOutside: false
    },
    tree_types = {
        "default": {"icon": 'fa fa-file-o'},
        "del": {"icon": 'text-danger fa fa-ban'},
        "star": {"icon": 'text-success fa fa-star'},
        "lock": {"icon": 'text-warning fa fa-lock'},
        "redirect": {"icon": 'text-primary fa fa-external-link-square'}
    };

$(function () {
    // Menu Toggle
    $('.menu-collapse').click(function () {
        $('.leftpanel').toggleClass('slideInLeft slideOutLeft').addClass('show-leftpanel');
        return false;
    });

    // simple-admin-form-ajax
    // in header top
    ajaxForm('.simple-admin-form-ajax', null, function (form, data) {
        if (data.success) {
            $(form).find('.form-response-success').html(data.msg);
        }
    });

    $(".fancybox").fancybox(default_fancybox_opts);

    $(".fancybox-full").fancybox({
        padding: 0,
        scrollOutside: false,
        minWidth: '100%',
        minHeight: '100%',
        width: '100%',
        height: '100%'
    });

    $('.js-select').select2();

    $('.webnotice-old').on('click', function () {
        var b = this;
        $(b).toggleClass('active');
        $.ajax(b.href, {
            dataType: "json",
            complete: function () {

            },
            success: function (d) {
                if (d.success) {

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


function notify($msg, $type) {
    $.notify({
        // options
        message: $msg
    }, {
        // settings
        type: $type ? $type : 'success',
        offset: {
            x: 20,
            y: 80
        },
        delay: 2000
    });
}

$(function () {
    var to = false;
    $('.search').keyup(function () {
        var search = this;
        var jstree = $(this).data('target');

        $(jstree).jstree(true).load_all();
        if (to) {
            clearTimeout(to);
        }
        to = setTimeout(function () {
            var v = $(search).val();
            $(jstree).jstree(true).search(v);
        }, 250);
    });

    $('.btn-search-reset').on('click', function () {
        var jstree = $(this).data('target');
        $(jstree).jstree(true).search('');
        $($(this).data('input')).val('');
        return false;
    });

    $('.js-tree').jstree({
        'core': {
            "check_callback": true,
            'data': {
                'url': function (node) {
                    return $(this.element[0]).data('url-data') + '/' + node.id;
                },
                "dataType": "json"
            },
            "themes": {"variant": "large"}
        },
        "types": tree_types,
        "plugins": ["search", "types"]
    }).on('ready.jstree', function (e, data) {
        var jstree = this;
        var v = parseInt($($(jstree).data('input')).val());
        if (v) {
            data.instance.load_all(null, function () {
                data.instance.select_node(v);
                $($(jstree).data('target')).html(data.instance.get_text(v));
            });
        } else {
            $($(jstree).data('target')).html($($(jstree).data('target')).data('default'));
        }
    });

    $(".btn-tree-reset").on('click', function () {
        var jstree = $(this).data('target');
        $($(jstree).data('target')).html($($(jstree).data('target')).data('default'));
        $($(jstree).data('input')).val('');
    });

    $(".btn-tree-select").on('click', function () {
        var jstree = $(this).data('target');
        var ref = $(jstree).jstree(true),
            sel = ref.get_selected();

        if (sel.length != 1) {
            $(this).closest('.win').find('.error-message').html($(this).closest('.win').find('.error-message').data('error'));
            return false;
        }
        sel = sel[0];

        $($(jstree).data('target')).html(ref.get_text(sel));
        $($(jstree).data('input')).val(sel);

        $.fancybox.close();
        return false;
    });
});