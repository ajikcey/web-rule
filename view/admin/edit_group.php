<form class="form-ajax" method="post"
      action="<?= Srv_Page::getUrl('admin/edit_group_json/' . $this->group['group_id'], 0) ?>">

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Название группы <span
                        class="text-danger">*</span></label>
                <input name="name" type="text" class="form-control" title=""
                       value="<?= $this->group['name'] ?>" data-required="Введите заголовок"
                       required autofocus>
                <div class="form-control-feedback"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Права доступа</label>
                <select name="access" class="form-control" title="">
                    <?php $accesses = Srv_Group::getAccesses(); ?>

                    <?php foreach ($accesses as $key => $value) { ?>
                        <option value="<?= $key ?>" <?= ($this->group['access'] == $key ? 'selected' : null) ?>><?= $value ?></option>
                    <?php } ?>
                </select>
                <div class="form-control-feedback"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Иконка</label>
                <div class="input-group">
                    <i class="input-group-addon <?= $this->group['icon'] ?>" aria-hidden="true"></i>
                    <input name="icon" type="text" class="form-control" title="" value="<?= $this->group['icon'] ?>">
                </div>
                <div class="form-control-feedback"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">

            <div class="form-group text-xs-left">
                <label class="custom-control custom-checkbox">
                    <input type="hidden" name="is_default" value="0">
                    <input type="checkbox" class="custom-control-input" name="is_default"
                           value="1" <?= ($this->group['is_default'] ? 'checked' : null) ?>>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Группа по-умолчанию</span>
                </label>
                <div class="form-control-feedback"></div>
                <small class="form-text text-muted"> В данную группу
                    добавляются зарегистрированные пользователи.
                </small>
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