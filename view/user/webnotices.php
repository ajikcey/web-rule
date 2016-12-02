<form id="form-listener" method="get" action="">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">

            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <div class="relative">
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

    <div class="card-block">
        <?php foreach ($this->webnotices as $value) { ?>
            <div class="dropdown-webnotice-item clearfix">
                <div class="dropdown-webnotice-img card-img"></div>
                <div class="dropdown-webnotice-r">

                    <div class="dropdown-webnotice-name text-muted small">
                        <?= Srv_Settings::getName() ?>

                        <a class="webnotice-old float-xs-right btn btn-outline-secondary btn-sm <?= ($value['is_old'] ? 'active' : null) ?>"
                           href="<?= Srv_Page::getUrl('user/webnotice_old', 0) ?>/<?= $value['webnotice_id'] ?>"
                           title="Отметить прочитанным">

                            <i class="fa fa-check" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="dropdown-webnotice-text"><?= $value['text'] ?></div>
                    <div class="dropdown-webnotice-date small text-muted"><?= $value['date'] ?></div>
                </div>
            </div>
        <?php } ?>

        <div class="clear"></div>
    </div>
</form>
<?php $this->pagination->render_view(); ?>