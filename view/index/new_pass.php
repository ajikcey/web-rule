<div class="container inner-wrap">
    <form class="form-ajax" method="post"
          action="<?= Srv_Page::getUrl('site/new_pass_json', 0) ?>">

        <input type="hidden" name="user_id" value="<?= $this->user_id ?>">
        <input type="hidden" name="time" value="<?= $this->time ?>">
        <input type="hidden" name="hash" value="<?= $this->hash ?>">

        <div class="row">
            <div class="col-md-7 text-md-left">
                <h1 class="display-4 form-title">Создание нового пароля</h1>
            </div>
            <div class="col-md-5 form-success-msg">

                <div class="form-group text-xs-left">
                    <label class="col-form-label" for="">Новый пароль</label>
                    <input name="pass" type="password" class="form-control form-control-lg" title=""
                           data-required="Введите новый пароль" required autofocus>
                    <div class="form-control-feedback"></div>
                </div>
                <div class="">
                    <div class="btn btn-lg btn-primary btn-block btn-submit">Сохранить</div>
                </div>
            </div>
        </div>
    </form>
</div>