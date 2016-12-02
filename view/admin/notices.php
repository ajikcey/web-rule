<form id="form-listener" method="get" action="">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group">
                <div class="btn-group">
                    <a href="<?= Srv_Page::getUrl('admin/edit_notice') ?>" class="btn btn-secondary">
                        Новое уведомление</a>
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

                    <input class="form-control change-submit" type="text" name="search"
                           placeholder="Поиск..."
                           value="<?= $this->params['search'] ?>">
                </div>
            </div>
        </div>
    </div>
</form>

<div class="list-group">

    <?php
    $types = Srv_Notice::getTypes();
    $events = Srv_Notice::getEvents();
    ?>

    <?php foreach ($this->notices as $value) { ?>

        <a href="<?= Srv_Page::getUrl('admin/edit_notice') ?>/<?= $value['notice_id'] ?>" class="list-group-item list-group-item-action">

            <?php if ($value['del']) { ?>
                <i class="fa fa-ban text-danger" aria-hidden="true"></i>
            <?php } ?>

            <?php if (isset($types[$value['type']])) { ?>
                <span class="tag tag-default"><?= $types[$value['type']] ?></span>
            <?php } ?>

            <?php if (isset($events[$value['event']])) { ?>
                <span class="tag tag-default"><?= $events[$value['event']] ?></span>
            <?php } ?>
            <?= $value['subject'] ?>
        </a>
    <?php } ?>

</div>

<?php $this->pagination->render_view(); ?>