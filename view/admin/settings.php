<?php
/**
 * @var $this Srv_Core_View
 */
?>
<div class="form-group">
    <a class="btn btn-secondary fancybox-full" data-fancybox-type="iframe"
       href="<?= Srv_Page::getUrl('admin/phpinfo') ?>"
       target="_blank">PHP Info</a>
</div>

<form class="form-ajax" method="post"
      action="<?= Srv_Page::getUrl('admin/settings_json', 0) ?>">

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Название сайта <span
                        class="text-danger">*</span></label>
                <input name="name" type="text" class="form-control" title=""
                       value="<?= $this->settings['name'] ?>" data-required="Введите название сайта"
                       required autofocus>
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Изображение по-умолчанию</label>

                <div class="input-group">
                    <input name="image" type="text" class="form-control" title=""
                           value="<?= $this->settings['image'] ?>">
                    <div class="input-group-btn">
                        <a href="#winFiles" class="btn btn-secondary fancybox-elfinder">
                            <i class="fa fa-wrench" aria-hidden="true"></i>
                        </a>
                        <a href="#" class="btn btn-secondary fancybox-input" data-target="[name='image']">
                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="form-control-feedback"></div>
                <small class="form-text text-muted">Для устройств с высоким разрешением используйте изображения с
                    размером не менее 1200 x 630 пикселей. Допускаются изображения размером не
                    более 8 МБ. <a href="https://developers.facebook.com/docs/sharing/best-practices?locale=ru_RU"
                                   target="_blank">Все рекомендации.</a>
                </small>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Имя (наименование) правообладателя</label>
                <input name="author" type="text" class="form-control" title=""
                       value="<?= $this->settings['author'] ?>">
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Год основания сайта</label>
                <input name="year_foundation" type="text" class="form-control" title=""
                       value="<?= $this->settings['year_foundation'] ?>">
                <div class="form-control-feedback"></div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Идентификатор приложения Facebook</label>
                <input name="fb_id" type="text" class="form-control" title=""
                       value="<?= $this->settings['fb_id'] ?>">
                <div class="form-control-feedback"></div>
            </div>
            <div class="form-group text-xs-left">
                <label class="col-form-label" for="">Email для отправки уведомлений</label>
                <input name="email" type="text" class="form-control" title=""
                       value="<?= $this->settings['email'] ?>">
                <div class="form-control-feedback"></div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="btn btn-block btn-primary btn-submit">Сохранить</div>
        </div>
        <div class="col-md-4"></div>
    </div>
</form>

<div id="winFiles" class="hidden">
    <div id="elfinder"></div>

    <div class="text-xs-right card-footer">
        <span class="error-message text-danger"></span>

        <div class="d-inline-block">
            <a href="#" class="btn btn-secondary" onclick="$.fancybox.close(); return false">Отмена</a>

            <a href="#" class="btn btn-primary" id="selectFile">Выбрать</a>
        </div>
    </div>
</div>