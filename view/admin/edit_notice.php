<div class="card">
    <div class="card-header">

        <!-- Nav tabs -->
        <ul class="nav nav-pills card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab_1">Основное</a>
            </li>

            <?php if ($this->notice) { ?>
                <li class="nav-item">
                    <a class="btn btn-danger del-notice"
                       data-toggle="tooltip" data-placement="top" title="Удалить/восстановить"
                       href="<?= Srv_Page::getUrl('admin/del_notice', 0) ?>/<?= $this->notice['notice_id'] ?>">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
    <div class="card-block">

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="active tab-pane" id="tab_1" role="tabpanel">

                <form class="form-ajax" method="post"
                      action="<?= Srv_Page::getUrl('admin/edit_notice_json/' . $this->notice['notice_id'], 0) ?>">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">Заголовок <span
                                        class="text-danger">*</span></label>
                                <input name="subject" type="text" class="form-control" title=""
                                       value="<?= $this->notice['subject'] ?>" data-required="Введите заголовок"
                                       required autofocus>
                                <div class="form-control-feedback"></div>
                            </div>

                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">Тип</label>

                                <?php $types = Srv_Notice::getTypes(); ?>

                                <select name="type" class="form-control" title="">
                                    <?php foreach ($types as $key => $value) { ?>
                                        <option
                                            value="<?= $key ?>" <?= ($this->notice['type'] == $key ? 'selected' : null) ?>><?= $value ?></option>
                                    <?php } ?>
                                </select>
                                <div class="form-control-feedback"></div>
                            </div>

                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">Событие</label>

                                <?php $events = Srv_Notice::getEvents(); ?>

                                <select name="event" class="form-control" title="">
                                    <?php foreach ($events as $key => $value) { ?>
                                        <option
                                            value="<?= $key ?>" <?= ($this->notice['event'] == $key ? 'selected' : null) ?>><?= $value ?></option>
                                    <?php } ?>
                                </select>
                                <div class="form-control-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">
                                    Текст уведомления
                                    <small class="text-muted">%user_name%, %link%, %text%</small>
                                </label>

                                <label class="custom-control custom-checkbox float-xs-right" style="margin-top: .5rem;">
                                    <input type="checkbox" class="custom-control-input" name="is_html"
                                           value="1" <?= ($this->notice['is_html'] ? 'checked' : null) ?>>
                                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Html-редактор
                                </label>


                                <textarea rows="12" id="editor1" name="text" class="form-control"
                                          title=""><?= $this->notice['text'] ?></textarea>
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
            </div>
        </div>
    </div>
</div>