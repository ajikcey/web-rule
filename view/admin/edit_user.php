<div class="card">
    <div class="card-header">

        <!-- Nav tabs -->
        <ul class="nav nav-pills card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab_1">Основное</a>
            </li>

            <?php if ($this->user) { ?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab_2">Смена пароля</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab_3">История активностей</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-danger del-user"
                       data-toggle="tooltip" data-placement="top" title="Удалить/восстановить"
                       href="<?= Srv_Page::getUrl('admin/del_user', 0) ?>/<?= $this->user['user_id'] ?>">
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
                <form class="form-ajax" method="post" id="userForm"
                      action="<?= Srv_Page::getUrl('admin/edit_user_json/' . $this->user['user_id'], 0) ?>">

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group text-xs-left">
                                <div class="form-group">
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-secondary fancybox-download"
                                           data-toggle="tooltip" data-placement="top" title="Загрузить аватарку">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" class="btn btn-secondary fancybox-crop"
                                           data-toggle="tooltip" data-placement="top" title="Изменить миниатюру">
                                            <i class="fa fa-crop" aria-hidden="true"></i>
                                        </a>
                                        <a href="<?= Srv_Page::getUrl('admin/del_avatar', 0) ?>"
                                           class="btn btn-secondary btn-del-thumbnail"
                                           data-toggle="tooltip" data-placement="top" title="Удалить аватарку">
                                            <i class="fa fa-ban" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>

                                <a href="#" class="btn-trigger">
                                    <div class="user-avatar card-img d-inline-block" id="avatar"
                                         style="<?= ($this->user['avatar'] ? "background-image: url('" . Srv_User::$avatar_paths['big'] . $this->user['avatar'] . "')" : null) ?>"></div>
                                </a>

                                <input name="avatar" type="hidden" value="<?= $this->user['avatar'] ?>">
                                <input name="avatar_x" type="hidden" value="<?= $this->user['avatar_x'] ?>">
                                <input name="avatar_y" type="hidden" value="<?= $this->user['avatar_y'] ?>">
                                <input name="avatar_w" type="hidden" value="<?= $this->user['avatar_w'] ?>">
                                <input name="avatar_h" type="hidden" value="<?= $this->user['avatar_h'] ?>">
                                <div class="form-control-feedback"></div>
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">Имя <span
                                        class="text-danger">*</span></label>
                                <input name="first_name" type="text" class="form-control" title=""
                                       value="<?= $this->user['first_name'] ?>" data-required="Введите имя"
                                       required autofocus>
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">Фамлия <span
                                        class="text-danger">*</span></label>
                                <input name="last_name" type="text" class="form-control" title=""
                                       data-required="Введите фамилию"
                                       required value="<?= $this->user['last_name'] ?>">
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">Отчество</label>
                                <input name="middle_name" type="text" class="form-control" title=""
                                       value="<?= $this->user['middle_name'] ?>">
                                <div class="form-control-feedback"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">E-mail <span
                                        class="text-danger">*</span></label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <label class="custom-control custom-checkbox"
                                               data-toggle="tooltip" data-placement="top"
                                               title="E-mail подтвержден">
                                            <input type="hidden" value="0" name="email_confirm">
                                            <input type="checkbox" class="custom-control-input" value="1"
                                                   name="email_confirm" <?= ($this->user['email_confirm'] ? 'checked' : '') ?>>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">&nbsp;</span>
                                        </label>
                                    </div>
                                    <input name="email" type="text" class="form-control" title=""
                                           data-required="Введите E-mail"
                                           required value="<?= $this->user['email'] ?>">
                                </div>
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">Телефон</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <label class="custom-control custom-checkbox"
                                               data-toggle="tooltip" data-placement="top"
                                               title="Телефон подтвержден">
                                            <input type="hidden" value="0" name="phone_confirm">
                                            <input type="checkbox" class="custom-control-input" value="1"
                                                   name="phone_confirm" <?= ($this->user['phone_confirm'] ? 'checked' : '') ?>>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">&nbsp;</span>
                                        </label>
                                    </div>
                                    <input name="phone" type="text" class="form-control" title=""
                                           value="<?= $this->user['phone'] ?>">
                                </div>
                                <div class="form-control-feedback"></div>
                            </div>
                            <div class="form-group text-xs-left">
                                <label class="col-form-label" for="">Пользователь состоит в группах</label>
                                <div class="js-select2-wrapper">
                                    <select class="js-select" name="group_id[]" title="" style="width: 100%" multiple>
                                        <?php foreach ($this->groups as $value) { ?>
                                            <option
                                                value="<?= $value['group_id'] ?>" <?= (isset($this->group2user) && in_array($value['group_id'], $this->group2user) ? 'selected' : null) ?>><?= $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-control-feedback"></div>
                            </div>

                            <?php if ($this->user) { ?>
                                <div class="form-group text-xs-left">
                                    <span class="text-muted">Аккаунт создан: <?= $this->user['date'] ?></span>
                                </div>
                            <?php } ?>

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

            <?php if ($this->user) { ?>
                <div class="tab-pane" id="tab_2" role="tabpanel">
                    <form class="form-ajax" method="post"
                          action="<?= Srv_Page::getUrl('admin/change_user_pass_json/' . $this->user['user_id'], 0) ?>">

                        <div class="form-group text-xs-left">
                            <label class="col-form-label" for="">Новый пароль <span
                                    class="text-danger">*</span></label>
                            <input name="pass" type="text" class="form-control" title=""
                                   value="" data-required="Введите новый пароль"
                                   required>
                            <div class="form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <div class="btn btn-block btn-info btn-submit">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Сменить пароль
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab_3" role="tabpanel">
                    <div class="alert alert-info" role="alert">
                        <strong>История активности</strong> показывает информацию о том, с каких устройств и в какое
                        время Вы входили на сайт. Если Вы подозреваете, что кто-то получил доступ к Вашему профилю, Вы
                        можете в любой момент прекратить эту активность.
                    </div>

                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>IP адрес</th>
                            <th>Время</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($this->sessions) { ?>
                            <?php foreach ($this->sessions as $value) { ?>
                                <tr>
                                    <td><?= $value['ip'] ?></td>
                                    <td><?= $value['date_active'] ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="2" class="">
                                    <div class="card-block text-xs-center">
                                        Данных не найдено
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div id="downloadAvatar" class="hidden">
    <div class="card fancybox-card">
        <div class="card-header">
            Загрузка новой аватарки
        </div>
        <div class="card-block text-xs-center">
            <div class="card-text form-group">Вы можете загрузить изображение в формате JPEG или PNG.</div>

            <a href="#" id="dropZone" class="btn card card-block"
               data-target="<?= Srv_Page::getUrl("admin/download_avatar", 0) ?>" onclick="return false;">
                <div class="dz-message">
                    <div class="form-group">
                        <div class="btn btn-primary">
                            <div class="h4">
                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                Выбрать файл
                            </div>
                            <span>или перенести сюда</span>
                        </div>
                    </div>

                    <div class="text-danger">
                        <small class="dz-error-message hidden animated fadeIn"></small>
                    </div>
                    <progress class="progress" value="0" max="100" style="margin-bottom: 0"></progress>
                </div>
            </a>
        </div>
        <div class="card-footer text-muted text-xs-center">
            <small>Если у Вас возникают проблемы с загрузкой, попробуйте выбрать изображение меньшего размера,
                но не меньше 200 х 200 пикселей.
            </small>
        </div>
    </div>
</div>

<div id="originalAvatar" class="hidden overhide">
    <div class="" style="margin: 0 auto">
        <img id="jcrop" alt=""
             src="<?= ($this->user['avatar'] ? Srv_User::$avatar_paths['original'] . $this->user['avatar'] : null) ?>">
    </div>

    <div class="text-xs-right card-footer">
        <span class="error-message text-danger"></span>

        <div class="d-inline-block">
            <a href="#" class="btn btn-secondary" onclick="$.fancybox.close(); return false">Отмена</a>

            <a href="<?= Srv_Page::getUrl('admin/update_avatar') ?>"
               class="btn btn-primary btn-save-thumbnail">Сохранить</a>
        </div>
    </div>
</div>
