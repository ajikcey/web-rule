<form class="form-ajax" method="post"
      action="<?= Srv_Page::getUrl('admin/edit_page_json/' . $this->page['page_id'], 0) ?>">

    <input type="hidden" name="parent_id"
           value="<?= $this->page['parent_id'] ? $this->page['parent_id'] : $this->parent_id ?>">

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Заголовок страницы <span
                        class="text-danger">*</span></label>
                <input name="title" type="text" class="form-control" title=""
                       value="<?= $this->page['title'] ?>" data-required="Введите заголовок страницы"
                       required autofocus>
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">URL <span
                        class="text-danger">*</span></label>
                <input name="url" type="text" class="form-control" title="" data-required="Введите URL"
                       required value="<?= $this->page['url'] ?>">
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Обработчик <span
                        class="text-danger">*</span></label>
                <input name="handler" type="text" class="form-control" title=""
                       data-required="Введите обработчик"
                       required value="<?= $this->page['handler'] ?>">
                <div class="form-control-feedback"></div>
            </div>
            
        </div>
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Доступ группам пользователей</label>
                <div class="js-select2-wrapper">
                    <select class="js-select" name="group_id[]" title="" style="width: 100%" multiple>
                        <?php foreach ($this->groups as $value) { ?>
                            <option
                                value="<?= $value['group_id'] ?>" <?= (isset($this->group2page) && in_array($value['group_id'], $this->group2page) ? 'selected' : null) ?>><?= $value['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Иконка</label>
                <div class="input-group">
                    <i class="input-group-addon <?= $this->page['icon'] ?>" aria-hidden="true"></i>
                    <input name="icon" type="text" class="form-control" title="" value="<?= $this->page['icon'] ?>">
                </div>
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">URL для перенаправления</label>
                <input name="redirect_url" type="text" class="form-control" title=""
                       value="<?= $this->page['redirect_url'] ?>">
                <div class="form-control-feedback"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Описание</label>
                                <textarea rows="6" name="desc" class="form-control"
                                          title=""><?= $this->page['desc'] ?></textarea>
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Ключевые слова</label>
                                <textarea rows="6" name="keywords" class="form-control"
                                          title=""><?= $this->page['keywords'] ?></textarea>
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