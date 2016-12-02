$(function () {
    var jstree = '#jstree';

    $('#add_item').on('click', function () {
        var ref = $(jstree).jstree(true),
            sel = ref.get_selected(),
            href = $(jstree).data('url-edit');

        if (sel.length == 1) {
            href += '?parent_id=' + sel[0];
        }
        document.location.href = href;
        return false;
    });

    $('#edit_item').on('click', function () {
        var ref = $(jstree).jstree(true),
            sel = ref.get_selected();

        if (sel.length == 1) {
            document.location.href = $(jstree).data('url-edit') + '/' + sel[0];
        } else {
            notify($(this).data('required'), 'danger');
        }
        return false;
    });

    $('#open_all').on('click', function () {
        $(jstree).jstree(true).open_all();
        return false;
    });

    runOnKeys(document, function (e) {
        $(jstree).jstree(true).open_all();
    }, 18, 69);

    $('#close_all').on('click', function () {
        $(jstree).jstree(true).close_all();
        return false;
    });

    runOnKeys(document, function (e) {
        $(jstree).jstree(true).close_all();
    }, 18, 67);

    $('#refresh_all').on('click', function () {
        $(jstree).jstree(true).refresh();
        return false;
    });

    runOnKeys(document, function (e) {
        $(jstree).jstree(true).refresh();
    }, 18, 82);

    $('#del_item').on('click', function () {
        var ref = $(jstree).jstree(true),
            sel = ref.get_selected();

        $.ajax($(jstree).data('url-del'), {
            type: 'post',
            data: {ids: sel},
            dataType: "json",
            complete: function () {

            },
            success: function (data) {
                if (data.success) {
                    notify(data.msg);
                    ref.refresh();
                }
                if (data.error) {
                    notify(data.error, 'danger');
                }
            },
            error: function (jqXHR) {
                notify(jqXHR, 'danger');
            }
        });
        return false;
    });

    $('#default_page').on('click', function () {
        var ref = $(jstree).jstree(true),
            sel = ref.get_selected();

        $.ajax($(jstree).data('url-default'), {
            type: 'post',
            data: {ids: sel},
            dataType: "json",
            complete: function () {

            },
            success: function (data) {
                if (data.success) {
                    notify(data.msg);
                    ref.refresh();
                }
                if (data.error) {
                    notify(data.error, 'danger');
                }
            },
            error: function (jqXHR) {
                notify(jqXHR, 'danger');
            }
        });
        return false;
    });

    var to = false;
    $('#search').keyup(function () {
        var search = this;

        $(jstree).jstree(true).load_all();
        if (to) {
            clearTimeout(to);
        }
        to = setTimeout(function () {
            var v = $(search).val();
            $(jstree).jstree(true).search(v);
            if (v) {
                $(search).closest('.form-group').find('.btn-reset').removeClass('hidden-xs-up');
            } else {
                $(search).closest('.form-group').find('.btn-reset').addClass('hidden-xs-up');
            }
        }, 250);
    });

    $('.btn-reset').on('click', function () {
        $(jstree).jstree(true).search('');
        $(this).addClass('hidden-xs-up').closest('.form-group').find('.form-control').val('').focus();
        return false;
    });

    $(jstree).jstree({
        'core': {
            "check_callback": true,
            'data': {
                'url': function (node) {
                    return $(jstree).data('url-data') + '/' + node.id;
                },
                "dataType": "json"
            },
            "themes": {"variant": "large"}
        },
        "types": tree_types,
        "plugins": ["dnd", "search", "types", "state"]
    }).on('move_node.jstree', function (e, data) {
        $.ajax($(jstree).data('url-move') + '/' + data.node.id, {
            type: 'post',
            data: {
                'parent_id': data.parent,
                'index': data.position
            },
            dataType: "json",
            complete: function () {
                data.instance.refresh();
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
    }).on('changed.jstree', function (e, data) {
        if (data.selected.length == 1) {
            $('#edit_item').removeClass('disabled');
            $('#default_page').removeClass('disabled');
        } else {
            $('#edit_item').addClass('disabled');
            $('#default_page').addClass('disabled');
        }

        if (data.selected.length > 0) {
            $('#del_item').removeClass('disabled');
        } else {
            $('#del_item').addClass('disabled');
        }
    }).on('load_node.jstree', function (e, data) {
        data.node.children.forEach(function (item) {
            data.instance.rename_node(item, data.instance.get_text(item) + '<a class="jstree-anchor-edit" onclick="document.location.href=this.href;" href="' +
                $(jstree).data('url-edit') + '/' + item + '" title="Редактировать">' +
                '<i class="animated fadeIn fa fa-cog" aria-hidden="true"></i></a>');
        });
    });

});