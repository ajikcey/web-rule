<div class="container inner-wrap">
    <form class="form-ajax" method="post" action="<?= Srv_Page::getUrl('site/login_json', 0) ?>">
        <div class="row">
            <div class="col-md-7">
                <h1 class="display-4 form-title text-md-left">Добро пожаловать!</h1>
            </div>
            <div class="col-md-5">
                <div class="form-group text-xs-left">
                    <label class="col-form-label" for="">E-mail</label>
                    <input name="email" type="text" class="form-control form-control-lg" title=""
                           data-required="Введите Ваш E-mail" required autofocus>
                    <div class="form-control-feedback"></div>
                </div>
                <div class="form-group text-xs-left">
                    <label class="col-form-label" for="">Пароль</label>
                    <input name="pass" type="password" class="form-control form-control-lg" title=""
                           data-required="Введите пароль" required>
                    <div class="form-control-feedback"></div>
                </div>
                <div class="">
                    <div class="text-xs-right">
                        <a href="<?= Srv_Page::getUrl('site/restore_pass') ?>" class=""
                           title="Восстановить пароль">Забыли пароль?</a>
                    </div>
                    <div class="btn btn-lg btn-primary btn-block btn-submit">Войти</div>
                </div>
                <hr/>
                <div class="hr">или</div>
                <a href="<?= Srv_Page::getUrl('site/reg') ?>" class="btn btn-secondary btn-block"
                   title="Создать аккаунт">Создать аккаунт</a>
            </div>
        </div>
    </form>
</div>