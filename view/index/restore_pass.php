<div class="container inner-wrap">
    <form class="form-ajax" method="post"
          action="<?= Srv_Page::getUrl('site/restore_pass_json', 0) ?>">

        <div class="row">
            <div class="col-md-7 text-md-left">
                <h1 class="display-4 form-title">Восстановление пароля</h1>
                <p>К Вам на почту придет письмо со сылкой, пройдя по которой Вы сможете установить новый пароль.</p>
            </div>
            <div class="col-md-5 form-success-msg">

                <div class="form-group text-xs-left">
                    <label class="col-form-label" for="">E-mail</label>
                    <input name="email" type="text" class="form-control form-control-lg" title=""
                           data-required="Введите Ваш E-mail" required autofocus>
                    <div class="form-control-feedback"></div>
                </div>
                <div class="">
                    <div class="btn btn-lg btn-primary btn-block btn-submit">Отправить письмо</div>
                </div>
            </div>
        </div>
    </form>
</div>