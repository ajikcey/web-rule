<form class="form-ajax" method="post"
      action="<?= Srv_Page::getUrl('admin/edit_menu_admin_json/' . $this->item['menu_admin_id'], 0) ?>">

    <input type="hidden" name="parent_id"
           value="<?= $this->item['parent_id'] ? $this->item['parent_id'] : $this->parent_id ?>">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Страница</label>
                <input type="hidden" name="page_id" value="<?= $this->item['page_id'] ?>">

                <div class="input-group">
                    <div class="input-group-btn">
                        <a href="#winPages" id="targetPage" class="btn btn-block btn-secondary fancybox-full"
                           data-default="[Страница не выбрана]">
                            <i class="fa fa-spinner fa-pulse"></i>
                        </a>
                    </div>
                    <div class="input-group-btn">
                        <div class="btn btn-secondary btn-tree-reset" data-target="#jstreePage"
                             data-toggle="tooltip" data-placement="top" title="Сбросить">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="form-control-feedback"></div>
            </div>

            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Доступ группам пользователей</label>
                <div class="js-select2-wrapper">
                    <select class="js-select" name="group_id[]" title="" style="width: 100%" multiple>
                        <?php foreach ($this->groups as $value) { ?>
                            <option
                                value="<?= $value['group_id'] ?>" <?= (isset($this->group2menu_admin) && in_array($value['group_id'], $this->group2menu_admin) ? 'selected' : null) ?>><?= $value['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-control-feedback"></div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Заголовок пункта меню</label>
                <input name="title" type="text" class="form-control" title=""
                       value="<?= $this->item['title'] ?>" autofocus>
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Иконка</label>
                <div class="input-group">
                    <i class="input-group-addon <?= $this->item['icon'] ?>" aria-hidden="true"></i>
                    <input name="icon" type="text" class="form-control" title="" value="<?= $this->item['icon'] ?>">
                </div>
                <div class="form-control-feedback"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 push-md-4">
            <div class="form-group">
                <?php if ($href = Srv_Page::getBackUrl()) { ?>
                    <a href="<?= $href ?>" class="btn btn-block btn-primary btn-submit-exit">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Сохранить и
                        выйти</a>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-4 push-md-4">
            <div class="form-group">
                <div class="btn btn-block btn-info btn-submit">
                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить
                </div>
            </div>
        </div>
        <div class="col-md-4 pull-md-8">
            <div class="form-group">
                <?php if ($href = Srv_Page::getBackUrl()) { ?>
                    <a href="<?= $href ?>" class="btn btn-block btn-secondary">
                        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Назад</a>
                <?php } ?>
            </div>
        </div>
    </div>
</form>

<div id="winPages" class="card win-card hidden win">
    <div class="card-header">
        Страницы сайта
    </div>
    <div class="card-block">
        <div class="form-group">
            <div class="input-group">
                <input id="searchPage" type="text" class="form-control search" placeholder="Найти страницу..."
                       data-target="#jstreePage">
                <div class="input-group-btn">
                    <div class="btn btn-secondary btn-search-reset" data-target="#jstreePage" data-input="#searchPage">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>

        <div id="jstreePage" class="js-tree" data-target="#targetPage" data-input="[name='page_id']"
             data-url-data="<?= Srv_Page::getUrl('admin/lazy_load_pages', 0) ?>"
        ></div>
    </div>
    <div class="card-footer text-xs-right">
        <span class="error-message text-danger" data-error="Выберите страницу"></span>

        <div class="d-inline-block">
            <div class="btn btn-secondary" onclick="$.fancybox.close();">Отмена</div>
            <div class="btn btn-primary btn-tree-select" data-target="#jstreePage">Выбрать</div>
        </div>
    </div>
</div>

<div id="winGroups" class="card win-card hidden win">
    <div class="card-header">
        Группы пользователей
    </div>
    <div class="card-block">
        <div class="form-group">
            <div class="input-group">
                <input id="searchGroup" type="text" class="form-control search" placeholder="Найти группу..."
                       data-target="#jstreeGroup">
                <div class="input-group-btn">
                    <div class="btn btn-secondary btn-search-reset" data-target="#jstreeGroup"
                         data-input="#searchGroup">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>

        <div id="jstreeGroup" class="js-tree" data-target="#targetGroup" data-input="[name='group_id']"
             data-url-data="<?= Srv_Page::getUrl('admin/lazy_load_group', 0) ?>"
        ></div>
    </div>
    <div class="card-footer text-xs-right">
        <span class="error-message text-danger" data-error="Выберите страницу"></span>

        <div class="d-inline-block">
            <div class="btn btn-secondary" onclick="$.fancybox.close();">Отмена</div>
            <div class="btn btn-primary btn-tree-select" data-target="#jstreeGroup">Выбрать</div>
        </div>
    </div>
</div>
