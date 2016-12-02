<?php

Class Ctrl_User extends Srv_Core_Controller
{
    /**
     * Моя страница (личный кабинет)
     */
    static function index()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/index');
    }

    /**
     * Мои статьи
     */
    static function posts()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/posts');
    }

    /**
     * Мои друзья
     */
    static function friends()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/friends');
    }

    /**
     * Мои сообщения
     */
    static function messages()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/messages');
    }

    /**
     * Мои курсы
     */
    static function courses()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/courses');
    }

    /**
     * Мои вебинары
     */
    static function events()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/events');
    }

    /**
     * Мои организации
     */
    static function orgs()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/orgs');
    }

    /**
     * Уведомления
     */
    static function webnotices()
    {
        $params = Srv_Webnotice::check_search();
        $pagination = new Srv_Core_Pagination($params['items'] ? $params['items'] : 10);
        $result = Model_Webnotice::search($params, $params[$pagination->key] * $pagination->items, $pagination->items);

        $pagination->setCount($result['count']);
        $pagination->setParams($params);
        $pagination->setView('admin/pagination');

        self::$view->set('webnotices', $result['items']);
        self::$view->set('params', $params);
        self::$view->set('pagination', $pagination);

        self::$view->setLayout('admin');
        self::$view->pushScript('admin/webnotices');
        self::$view->render('user/webnotices');
    }

    /**
     * Webnotices
     */
    static function webnotice_old($id = null)
    {
        $result = array('success' => true, 'msg' => 'Уведомление успешно просмотрено');
        try {
            if (!$id) {
                throw new Srv_Exception_Data("Выберите уведомление");
            }

            $webnotice = Model_Webnotice::get($id);

            if ($webnotice['user_id'] != Srv_User::getCurrentId()) {
                throw new Srv_Exception_Data("access denied");
            }

            if ($webnotice['is_old'] == 1) {
                $result['msg'] = 'Уведомление успешно восстановлено';
            }
            Model_Webnotice::update($id, array('is_old' => $webnotice['is_old'] ^ 1));

        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Профиль пользователя
     */
    static function profile()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/profile');
    }

    /**
     * Настройки пользователя
     */
    static function settings()
    {
        self::$view->setLayout('admin');
        self::$view->render('user/settings');
    }
}