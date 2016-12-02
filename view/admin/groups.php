<form id="form-listener" method="get" action="">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                <div class="btn-group">
                    <a href="<?= Srv_Page::getUrl('admin/edit_group') ?>" class="btn btn-secondary">
                        Новая группа</a>
                </div>
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

    <!--groups-->
    <div class="set-box set-box-group">
        <?php foreach ($this->groups as $value) { ?>
            <div class="set-box-item float-xs-left text-xs-center">
                <a href="<?= Srv_Page::getUrl('admin/edit_group') ?>/<?= $value['group_id'] ?>"
                   title="<?= $value['name'] ?>" class="text-muted small">

                    <div class="card-img">
                        <?php if ($value['icon']) { ?>
                            <i class="<?= $value['icon'] ?> fa-5x"></i>
                        <?php } ?>
                    </div>

                    <div class="card-text text-truncate">
                        <?= $value['name'] ?>
                    </div>
                </a>

            </div>
        <?php } ?>

        <div class="clear"></div>
    </div>
</form>
<?php $this->pagination->render_view(); ?>