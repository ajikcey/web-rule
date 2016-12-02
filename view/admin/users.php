<form id="form-listener" method="get" action="">

    <!--tooltips-->
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">

                <a href="<?= Srv_Page::getUrl('admin/edit_user') ?>" id="" class="btn btn-secondary">
                    Новый пользователь</a>

                <div class="float-xs-right">
                    <label class="col-form-label">Количество записей:</label>

                    <select name="items" class="form-control change-submit d-inline-block" style="width: auto" title="">
                        <?php foreach (array(10, 25, 50, 100, 250, 500) as $value) { ?>
                            <option <?= ($this->params['items'] == $value ? 'selected' : null) ?>><?= $value ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-btn">
                        <a href="#filter" id="" class="btn btn-secondary" data-toggle="collapse">
                            <i class="fa fa-filter" aria-hidden="true"></i> <i class="fa fa-caret-down"></i></a>
                    </div>

                    <a href="?" title="Сбросить"
                       class="btn btn-reset btn-absolute pos-a-r text-muted search-close <?= (!$this->params['search'] ? 'hidden-xs-up' : null) ?>">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>

                    <input class="form-control change-submit" type="text" name="search" placeholder="Поиск..."
                           value="<?= $this->params['search'] ?>">
                </div>
            </div>
        </div>
    </div>


    <!--filter-->
    <div id="filter"
         class="collapse <?= ((ctype_digit($this->params['del'])
             || ctype_digit($this->params['email_confirm'])
             || ctype_digit($this->params['phone_confirm'])
             || $this->params['groups']) ? 'in' : null) ?>">
        <div class="row">
            <div class="col-lg-8 col-xs-12">

                <div class="btn-group form-group custom-buttons">
                    <label
                        class="btn btn-outline-primary <?= $this->params['email_confirm'] == '' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Все E-mail">
                        <input type="radio" class="change-submit" name="email_confirm"
                               value="" <?= $this->params['email_confirm'] == '' ? 'checked' : null ?>>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </label>
                    <label
                        class="btn btn-outline-primary <?= $this->params['email_confirm'] == '0' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Неподтвержденные">
                        <input type="radio" class="change-submit" name="email_confirm"
                               value="0" <?= $this->params['email_confirm'] == '0' ? 'checked' : null ?>>
                        <i class="fa fa-square-o" aria-hidden="true"></i>
                    </label>
                    <label
                        class="btn btn-outline-primary <?= $this->params['email_confirm'] == '1' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Подтвержденные">
                        <input type="radio" class="change-submit" name="email_confirm"
                               value="1" <?= $this->params['email_confirm'] == '1' ? 'checked' : null ?>>
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                    </label>
                </div>

                <div class="btn-group form-group custom-buttons">
                    <label
                        class="btn btn-outline-primary <?= $this->params['phone_confirm'] == '' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Все телефоны">
                        <input type="radio" class="change-submit" name="phone_confirm" value=""
                            <?= $this->params['phone_confirm'] == '' ? 'checked' : null ?>>
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </label>
                    <label
                        class="btn btn-outline-primary <?= $this->params['phone_confirm'] == '0' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Неподтвержденные">
                        <input type="radio" class="change-submit" name="phone_confirm" value="0"
                            <?= $this->params['phone_confirm'] == '0' ? 'checked' : null ?>>
                        <i class="fa fa-square-o" aria-hidden="true"></i>
                    </label>
                    <label
                        class="btn btn-outline-primary <?= $this->params['phone_confirm'] == '1' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Подтвержденные">
                        <input type="radio" class="change-submit" name="phone_confirm" value="1"
                            <?= $this->params['phone_confirm'] == '1' ? 'checked' : null ?>>
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                    </label>
                </div>

                <div class="btn-group form-group custom-buttons">
                    <label
                        class="btn btn-outline-primary <?= $this->params['del'] == '' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Все пользователи">
                        <input type="radio" class="change-submit" name="del" value=""
                            <?= $this->params['del'] == '' ? 'checked' : null ?>>
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </label>
                    <label
                        class="btn btn-outline-primary <?= $this->params['del'] == '1' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Удаленные">
                        <input type="radio" class="change-submit" name="del" value="1"
                            <?= $this->params['del'] == '1' ? 'checked' : null ?>>
                        <i class="fa fa-user-times" aria-hidden="true"></i>
                    </label>
                    <label
                        class="btn btn-outline-primary <?= $this->params['del'] == '0' ? 'active' : null ?>"
                        data-toggle="tooltip" data-placement="top" title="Неудаленные">
                        <input type="radio" class="change-submit" name="del" value="0"
                            <?= $this->params['del'] == '0' ? 'checked' : null ?>>
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </label>
                </div>

            </div>
            <div class="col-lg-4 col-xs-12">
                <div class="form-group js-select2-wrapper">
                    <select name="groups[]" class="form-control js-select change-submit" title="" multiple
                            style="width: 100%" data-placeholder="Все группы пользователей">

                        <?php if ($this->groups) foreach ($this->groups as $value) { ?>
                            <option value="<?= $value['group_id'] ?>"
                                <?= ($this->params['groups'] && in_array($value['group_id'], $this->params['groups']) ? 'selected' : null) ?>>
                                <?= $value['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>


    <!--users-->
    <div class="set-box set-box-user">
        <?php foreach ($this->users as $value) { ?>
            <div class="set-box-item float-xs-left text-xs-center">
                <a href="<?= Srv_Page::getUrl('admin/edit_user') ?>/<?= $value['user_id'] ?>"
                   title="<?= $value['first_last_name'] ?>" class="text-muted small">

                    <div class="user-avatar card-img" style="<?= ($value['avatar'] ? "background-image: url('" . Srv_User::$avatar_paths['big'] . $value['avatar'] . "')" : null) ?>"></div>

                    <div class="card-text text-truncate">
                        <?php if ($value['del']) { ?>
                            <i class="fa fa-ban text-danger" aria-hidden="true"
                               data-toggle="tooltip" data-placement="top" title="Пользователь удален"></i>
                        <?php } ?>

                        <?php foreach ($value['groups'] as $group) { ?>
                            <i class="<?= $this->groups[$group]['icon'] ?>"></i>
                        <?php } ?>

                        <?= $value['first_last_name'] ?>
                    </div>
                </a>

            </div>
        <?php } ?>

        <div class="clear"></div>
    </div>
</form>


<?php $this->pagination->render_view(); ?>