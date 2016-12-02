<div class="row">
    <div class="col-sm-8">
        <div class="form-group">
            <div class="btn-group">
                <div id="add_item" class="btn btn-secondary"
                     data-toggle="tooltip" data-placement="top" title="Добавление страницы">
                    <i class="fa fa-plus" aria-hidden="true"></i></div>

                <div id="edit_item" class="btn btn-secondary"
                     data-toggle="tooltip" data-placement="top" title="Редактирование страницы"
                     data-required="Выберите страницу">
                    <i class="fa fa-cog" aria-hidden="true"></i></div>

                <div class="btn btn-secondary text-danger" id="del_item"
                     data-toggle="tooltip" data-placement="top" title="Удаление (восстановление) страницы">
                    <i class="fa fa-ban" aria-hidden="true"></i></div>

                <div class="btn btn-secondary text-success" id="default_page"
                     data-toggle="tooltip" data-placement="top"
                     title="Страница по-умолчанию (может быть только одна)">
                    <i class="fa fa-star" aria-hidden="true"></i></div>

                <div class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></div>

                <div class="dropdown-menu dropdown-menu-right dropdown-with-tag" style="min-width: 190px">
                    <a href="#" class="dropdown-item text-truncate" id="refresh_all">
                        <span class="tag tag-pill tag-default float-xs-right">Alt+R</span> Обновить</a>
                    <a href="#" class="dropdown-item text-truncate" id="close_all">
                        <span class="tag tag-pill tag-default float-xs-right">Alt+C</span> Свернуть</a>
                    <a href="#" class="dropdown-item text-truncate" id="open_all">
                        <span class="tag tag-pill tag-default float-xs-right">Alt+E</span> Развернуть</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#modalLegend" data-toggle="modal">Легенда</a>
                </div>
            </div>

            <div id="modalLegend" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <div class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></div>
                            <h4 class="modal-title" id="mySmallModalLabel">Легенда</h4>
                        </div>
                        <div class="modal-body">
                            <p>
                                <i class="fa fa-file-o jstree-themeicon-custom"
                                   style="vertical-align: baseline" role="presentation"></i>
                                - активная страница сайта</p>
                            <p>
                                <i class="text-success fa fa-star jstree-themeicon-custom"
                                   style="vertical-align: baseline" role="presentation"></i>
                                - страница по-умолчанию
                                (<a href="/" target="_blank"><?= PROTOCOL . '://' . HOST ?></a>)</p>
                            <p>
                                <i class="text-danger fa fa-ban jstree-themeicon-custom"
                                   style="vertical-align: baseline" role="presentation"></i>
                                - удаленная страница</p>
                            <p>
                                <i class="text-warning fa fa-lock jstree-themeicon-custom"
                                   style="vertical-align: baseline" role="presentation"></i>
                                - страница доступна группе пользователей</p>
                            <p>
                                <i class="text-primary fa fa-external-link-square jstree-themeicon-custom"
                                   style="vertical-align: baseline" role="presentation"></i>
                                - страница с установленным перенаправлением</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <div class="input-group-btn">
                <a href="#" class="btn btn-reset btn-absolute pos-a-r hidden-xs-up text-muted animated fadeIn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
                <input class="form-control" type="text" id="search" placeholder="Поиск...">
            </div>
        </div>
    </div>
</div>

<div id="jstree"
     data-url-del="<?= Srv_Page::getUrl('admin/del_page', 0) ?>"
     data-url-edit="<?= Srv_Page::getUrl('admin/edit_page', 1) ?>"
     data-url-default="<?= Srv_Page::getUrl('admin/default_page', 0) ?>"
     data-url-data="<?= Srv_Page::getUrl('admin/lazy_load_pages', 0) ?>"
     data-url-move="<?= Srv_Page::getUrl('admin/move_page', 0) ?>"
></div>