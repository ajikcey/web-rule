<div class="container inner-wrap">
    <form class="form-ajax" method="post"
          action="<?= Srv_Page::getUrl('site/reg_json', 0) ?>">

        <input type="hidden" name="group_id[]" value="1">

        <div class="row">
            <div class="col-md-7">
                <h1 class="display-4 form-title text-md-left">Приятно познакомиться!</h1>
            </div>
            <div class="col-md-5">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group text-xs-left">
                            <label class="col-form-label" for="">Имя <span class="text-danger">*</span></label>
                            <input name="first_name" type="text" class="form-control form-control-lg" title=""
                                   data-required="Введите Ваше имя" required autofocus>
                            <div class="form-control-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group text-xs-left">
                            <label class="col-form-label" for="">Фамилия <span class="text-danger">*</span></label>
                            <input name="last_name" type="text" class="form-control form-control-lg" title=""
                                   data-required="Введите Вашу фамилию" required>
                            <div class="form-control-feedback"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-xs-left">
                    <label class="col-form-label" for="">E-mail <span class="text-danger">*</span></label>
                    <input name="email" type="text" class="form-control form-control-lg" title=""
                           data-required="Введите E-mail" required>
                    <div class="form-control-feedback"></div>
                </div>
                <div class="form-group text-xs-left">
                    <label class="col-form-label" for="">Пароль <span class="text-danger">*</span></label>
                    <input name="pass" type="password" class="form-control form-control-lg" title=""
                           data-required="Введите пароль" required>
                    <div class="form-control-feedback"></div>
                </div>
                <div class="form-group text-xs-left">
                    <label class="col-form-label" for="">Повторите пароль <span class="text-danger">*</span></label>
                    <input name="pass2" type="password" class="form-control form-control-lg" title=""
                           data-required="Повторите пароль" required>
                    <div class="form-control-feedback"></div>
                </div>
                <div class="form-group text-xs-left">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="1" name="agree"
                               data-required="Для создания аккаунта необходимо принять условия" required>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Принимаю условия <a href="#userRules"
                                                                                         data-toggle="modal">пользовательского соглашения</a>.</span>
                    </label>
                    <div class="form-control-feedback"></div>
                </div>
                <div class="">
                    <div class="btn btn-lg btn-primary btn-block btn-submit">Зарегистрироваться</div>
                </div>
                <div class="text-muted">
                    <i><span class="text-danger">*</span> - обязательное поле для заполнения.</i>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" style="display: none" id="userRules">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Пользовательское соглашение</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>