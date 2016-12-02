<?php

Class Ctrl_Site extends Srv_Core_Controller
{
    static function index()
    {
        self::$view->set('str', "Hello world!");
        self::$view->setLayout('index');
        self::$view->render('index/index');
    }

    /**
     * Выход
     */
    static function logout()
    {
        Srv_Session::delAuth();
        Srv_Page::redirect();
    }

    /**
     * Авторизация
     */
    static function login()
    {
        if (Srv_User::getCurrent()) {
            Srv_Page::redirect(Srv_Page::getUrl('user/index'));
        }
        self::$view->setLayout('index');
        self::$view->pushScript('index/login');
        self::$view->render('index/login');
    }

    static function login_json()
    {
        $result = array('success' => true);
        try {
            $data = Srv_User::check_login();
            $user = Srv_User::getUser2email_pass($data['email'], Srv_User::gen_hash_pass($data['pass']));
            if (!$user) {
                throw new Srv_Exception_Data("Неверный E-mail или пароль");
            } elseif ($user['del']) {
                throw new Srv_Exception_Data("Ваш аккаунт заблокирован | email");
            } elseif (Srv_User::getCurrent()) {
                throw new Srv_Exception_Data("Вы уже авторизованы");
            } elseif (!Srv_Session::addAuth($user['user_id'])) {
                throw new Srv_Exception_Data("Извините, ошибка авторизации");
            }
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Регистрация
     */
    static function reg()
    {
        if (Srv_User::getCurrent()) {
            Srv_Page::redirect(Srv_Page::getUrl('user/index'));
        }

        self::$view->setLayout('index');
        self::$view->pushScript('index/reg');
        self::$view->render('index/reg');
    }

    static function reg_json()
    {
        $result = array('success' => true);
        try {
            list($data, $groups) = Srv_User::check_reg();
            $user = Srv_User::getUser2email($data['email']);

            if (Srv_User::getCurrent()) {
                throw new Srv_Exception_Data("Вы авторизованы");
            } elseif ($user) {
                throw new Srv_Exception_Data("Данный E-mail уже зарегистрирован | email");
            }

            $user_id = Model_User::insert(array(
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'first_last_name' => $data['first_name'] . " " . $data['last_name'],
                'full_name' => $data['first_name'] . " " . $data['last_name'],
                'email' => $data['email'],
                'pass' => Srv_User::gen_hash_pass($data['pass']),
            ));

            foreach ($groups as $value) {
                Model_Group::insert2user($value, $user_id);
            }

            if (!Srv_Notice::confirmEmail($user_id)) {
                throw new Srv_Exception_Data("Письмо не отправлено, обратитесь к администратору");
            } elseif (!Srv_Session::addAuth($user_id)) {
                throw new Srv_Exception_Data("Извините, ошибка авторизации");
            }
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Подтверждение E-mail
     * @param $user_id
     * @param $hash
     */
    static function confirm_email($user_id, $hash)
    {
        $user = Srv_User::getEnableUser($user_id);

        Srv_Page::setCurrentTitle('E-mail не подтвержден!');
        self::$view->set('status', "&#10006;");

        if ($hash == Srv_Notice::gen_hash_email($user['email'])) {

            Model_User::update($user['user_id'], array(
                'email_confirm' => 1,
            ));

            Srv_Page::setCurrentTitle('E-mail успешно подтвержден!');
            self::$view->set('status', "&#10004;");
            self::$view->set('btn', Srv_Page::getUrl('user/index'));
        }

        self::$view->setLayout('index');
        self::$view->render('index/page');
    }

    /**
     * Восстановление пароля
     */
    static function restore_pass()
    {
        if (Srv_User::getCurrent()) {
            Srv_Page::redirect(Srv_Page::getUrl('user/index'));
        }

        self::$view->setLayout('index');
        self::$view->pushScript('index/restore_pass');
        self::$view->render('index/restore_pass');
    }

    static function restore_pass_json()
    {
        try {
            $data = Srv_User::check_email();
            $user = Srv_User::getUser2email($data['email']);

            if (Srv_User::getCurrent()) {
                throw new Srv_Exception_Data("Вы авторизованы");
            } elseif (!$user) {
                throw new Srv_Exception_Data("Данный E-mail не зарегистрирован | email");
            } elseif ($user['del']) {
                throw new Srv_Exception_Data("Ваш аккаунт заблокирован | email");
            }

            Srv_Notice::passRecovery($user['user_id']);

            $result = array('success' => true, 'msg' => '<div class="alert alert-success" role="alert"><h4 class="alert-heading">Письмо успешно отправлено!</h4> ' .
                'Не забудьте проверить папку <i>Спам</i>. <a class="" href="//' . explode('@', $user['email'])[1] . '" target="_blank">Проверить почту</a></div>');
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Создание нового пароля
     * страница доступна только сутки
     * @param int $user_id
     * @param int $time
     * @param null $hash
     * @throws Srv_Exception_Access
     */
    static function new_pass($user_id = 0, $time = 0, $hash = null)
    {
        $user = Model_User::get($user_id);

        if (!$user || $user['del'] ||
            (time() - $time > ACCESS_TIME) ||
            (Srv_Notice::gen_hash_pass_recovery($user['user_id'], $time, $user['pass']) != $hash) ||
            (Srv_User::getCurrent() && $user_id != Srv_User::getCurrentId())
        ) {
            Srv_Page::noAccess("Access denied for user: $user_id (time recovery: " . date("Y-m-d H:i:s", $time) . ") in " . __FILE__ . " on line " . __LINE__);
        }
        Srv_Session::addAuth($user['user_id']);

        self::$view->set('user_id', $user_id);
        self::$view->set('time', $time);
        self::$view->set('hash', $hash);

        self::$view->setLayout('index');
        self::$view->pushScript('index/new_pass');
        self::$view->render('index/new_pass');
    }

    static function new_pass_json()
    {
        $result = array('success' => true, 'msg' => '<div class="alert alert-success" role="alert"><h4 class="alert-heading">Пароль успешно сохранен!</h4> ' .
            'Теперь Вы можете <a href="' . Srv_Page::getUrl('admin/index') . '" title="Войти">войти</a>.</div>');

        try {
            $data = Srv_User::check_post_new_pass();
            $user = Model_User::get($data['user_id']);

            if (!$user) {
                throw new Srv_Exception_Data("Пользователь не найден");
            } elseif ($user['del']) {
                throw new Srv_Exception_Data("Ваш аккаунт заблокирован");
            } elseif ($user['pass'] == Srv_User::gen_hash_pass($data['pass'])) {
                throw new Srv_Exception_Data("Старый пароль");
            } elseif (Srv_User::getCurrent() && $user['user_id'] != Srv_User::getCurrentId()) {
                throw new Srv_Exception_Data("Вы не можете редактировать чужой пароль");
            } elseif (time() - $data['time'] > ACCESS_TIME) {
                throw new Srv_Exception_Data('Заявка отправлена сутки назад. Необходимо заново <a href="' .
                    Srv_Page::getUrl('site/restore_pass') . '" title="Восстановить пароль">восстановить пароль</a>');
            } elseif (Srv_Notice::gen_hash_pass_recovery($user['user_id'], $data['time'], $user['pass']) != $data['hash']) {
                throw new Srv_Exception_Data("Проверка не пройдена");
            }

            if (!Model_User::update($data['user_id'], array('pass' => Srv_User::gen_hash_pass($data['pass'])))) {
                throw new Srv_Exception_Data("Извините, ошибка сервера");
            }

            if (!Srv_Session::addAuth($user['user_id'])) {
                throw new Srv_Exception_Data("Извините, ошибка авторизации");
            }
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Помощь
     */
    static function help()
    {
        self::$view->setLayout('admin');
        self::$view->render('index/help');
    }

    /**
     * Отзывы
     */
    static function feedbacks()
    {
        self::$view->setLayout('admin');
        self::$view->render('index/feedbacks');
    }

    /**
     * Страницы ошибок
     */
    static function page403()
    {
        header("HTTP/1.0 403 Forbidden", true, 403);

        Srv_Page::setCurrentTitle('Доступ запрещен');
        self::$view->set('status', 403);
        self::$view->setLayout('index');
        self::$view->render('index/page');
    }

    static function page404()
    {
        header("HTTP/1.0 404 Not Found", true, 404);

        Srv_Page::setCurrentTitle('Страница не найдена');
        self::$view->set('status', 404);
        self::$view->setLayout('index');
        self::$view->render('index/page');
    }

    static function page503()
    {
        header("HTTP/1.0 503 Service Unavailable", true, 503);

        Srv_Page::setCurrentTitle('Сервис временно не доступен');
        self::$view->set('status', 503);
        self::$view->setLayout('error');
        self::$view->render('index/error');
    }

}


