<?php

Class Ctrl_Admin extends Srv_Core_Controller
{
    /**
     * Главная страница кабинета
     */
    static function index()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/index');
    }

    static function phpinfo()
    {
        if (!Srv_Group::hasAccessAdmin()) {
            Srv_Page::noAccess("Access denied to the function " . __CLASS__ . "::" . __FUNCTION__ . " for user " .
                Srv_User::getCurrentId() . " in " . __FILE__ . " on line " . __LINE__);
        }
        phpinfo();
    }

    /**
     * Повторное отправление письма для подтверждения почты
     */
    static function confirm_email_json()
    {
        $result = array('success' => true, 'msg' => 'Письмо успешно отправлено!');
        try {
            if (!Srv_User::getCurrent()) {
                throw new Srv_Exception_Data("Вам необходимо войти");
            } elseif (Srv_User::getCurrentEmailConfirm()) {
                throw new Srv_Exception_Data("Ваш E-mail уже подтвержден");
            } elseif (!Srv_Notice::confirmEmail()) {
                throw new Srv_Exception_Data("Письмо не отправлено, обратитесь к администратору");
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
     * Основные настройки системы
     */
    static function settings()
    {
        self::$view->set('settings', Srv_Settings::getList());
        self::$view->setLayout('admin');
        self::$view->pushScript('admin/settings');
        self::$view->render('admin/settings');
    }

    static function settings_json()
    {
        $result = array('success' => true, 'msg' => 'Настройки успешно сохранены!');
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $data = Srv_Settings::check();
            Srv_Settings::update($data);

        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Загруженные файлы
     */
    static function upload_files()
    {
        self::$view->setLayout('admin');
        self::$view->pushScript('admin/upload_files');
        self::$view->render('admin/upload_files');
    }

    /**
     * ElFinder connector
     * @throws Srv_Exception_Access
     */
    static function elfinder()
    {
        if (!Srv_Group::hasAccessAdmin()) {
            Srv_Page::noAccess("Access denied to the function " . __CLASS__ . "::" . __FUNCTION__ . " for user " .
                Srv_User::getCurrentId() . " in " . __FILE__ . " on line " . __LINE__);
        }

        require __DIR__ . '/../plugins/elFinder/php/autoload.php';
        elFinder::$netDrivers['ftp'] = 'FTP';

        function access($attr, $path)
        {
            return strpos(basename($path), '.') === 0
                ? !($attr == 'read' || $attr == 'write')
                : null;
        }

        $connector = new elFinderConnector(new elFinder(array(
            'debug' => true,
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => $_SERVER["DOCUMENT_ROOT"] . '/files/',
                    'URL' => '/files/',
                    'uploadDeny' => array('all'),
                    'uploadAllow' => array('image', 'text/plain', 'application/pdf'),
                    'uploadOrder' => array('deny', 'allow'),
                    'accessControl' => 'access',
                    'encoding' => SERVER_ENCODING
                )
            )
        )));
        $connector->run();
    }

    /**
     * Страницы сайта
     */
    static function pages()
    {
        self::$view->setLayout('admin');

        self::$view->pushScript('admin/pages');
        self::$view->render('admin/pages');
    }

    static function edit_page($id = null)
    {
        self::$view->set('page', null);

        $page = null;
        if ($id) {
            $page = Model_Page::get($id);
        }

        if ($page) {
            self::$view->set('page', $page);
            Srv_Page::setCurrentTitle($page['title']);
            self::$view->set('group2page', Srv_Group::get2page($id));
        } else {
            Srv_Page::setCurrentTitle("Добавление страницы");
        }

        self::$view->set('parent_id', isset($_GET['parent_id']) && $_GET['parent_id'] ? intval($_GET['parent_id']) : 0);
        self::$view->set('groups', Model_Group::getAll());

        Srv_MenuAdmin::setCurrent('admin/pages');
        self::$view->setLayout('admin');
        self::$view->pushScript('admin/edit_page');
        self::$view->render('admin/edit_page');
    }
    
    static function edit_page_json($id = null)
    {
        $result = array('success' => true, 'msg' => 'Страница успешно сохранена!');
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            list($data_page, $data_groups) = Srv_Page::check();
            $o_page = Srv_Page::getPage2url($data_page['url'], $data_page['parent_id']);

            if ($o_page && $o_page['page_id'] != $id) {
                throw new Srv_Exception_Data("Указанный URL уже существует");
            }

            $old_groups = array();
            if ($id) {
                Model_Page::update($id, $data_page);

                $old_groups = Srv_Group::get2page($id);
            } else {
                $id = Model_Page::insert($data_page);
            }

            foreach ($data_groups as $value) {
                if (!in_array($value, $old_groups)) {
                    Model_Group::insert2page($value, $id);
                }
            }

            foreach ($old_groups as $value) {
                if (!in_array($value, $data_groups)) {
                    Model_Group::del2page($value, $id);
                }
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
     * @param int $id parent_id
     */
    static function lazy_load_pages($id = 0)
    {
        $result = array();
        if (Srv_Group::hasAccessAdmin()) {
            $pages = Srv_Page::getChildPages($id);

            if ($pages) foreach ($pages as $key => $value) {
                $title = $value['title'];
                $icon = null;
                $type = null;
                if ($value['del']) {
                    $type = 'del';
                } elseif ($value['redirect_url']) {
                    $type = 'redirect';
                } elseif ($value['is_default']) {
                    $type = 'star';
                } elseif ($value['icon']) {
                    $icon = $value['icon'];
                }

                $groups = Srv_Group::get_info_groups2page($value['page_id']);
                foreach ($groups as $v) {
                    $title .= ' <i class="text-muted ' . $v['icon'] . '"></i>';
                }

                $result[] = array(
                    'id' => $value['page_id'],
                    'text' => $title,
                    'children' => Srv_Page::hasChildPages($value['page_id']),
                    'type' => $type,
                    'icon' => $icon
                );
            }
        }
        Srv_Core_Helper::json($result);
    }

    static function move_page($id = 0)
    {
        $result = array('success' => true, 'msg' => 'Страница успешно перемещена');
        $page = Model_Page::get($id);
        try {
            if (!$page) {
                throw new Srv_Exception_Data("Выберите страницу");
            } elseif (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $form = new Srv_Core_Form();
            $data = $form->post('parent_id')->int()
                ->post('index')->int()
                ->fetch();

            $o_page = Srv_Page::getPage2url($page['url'], $data['parent_id']);

            if ($o_page && $o_page['page_id'] != $id) {
                throw new Srv_Exception_Data("Страницу: " . $page['title'] . " невозможно переместить, так как URL уже существует");
            }

            Model_Page::downNextIndex($page['parent_id'], $page['index']);
            Model_Page::upIndex($data['parent_id'], $data['index']);
            Model_Page::update($id, $data);
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    static function del_page()
    {
        $result = array('success' => true, 'msg' => 'Страница успешно удалена');
        try {
            if (!isset($_POST['ids']) || !$_POST['ids'] || !is_array($_POST['ids'])) {
                throw new Srv_Exception_Data("Выберите страницу");
            } elseif (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            foreach ($_POST['ids'] as $id) {
                $page = Model_Page::get($id);
                if ($page['del'] == 1) {
                    $result['msg'] = 'Страница успешно восстановлена';
                }
                if ($page['is_default']) {
                    throw new Srv_Exception_Data("Не удаляйте страницу по-умолчанию");
                }
                Model_Page::update($id, array('del' => $page['del'] ^ 1));
            }
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    static function default_page()
    {
        $result = array('success' => true, 'msg' => 'Страница по-умолчанию успешно установлена');
        try {
            if (!isset($_POST['ids']) || !$_POST['ids'] || !is_array($_POST['ids'])) {
                throw new Srv_Exception_Data("Выберите страницу");
            } elseif (count($_POST['ids']) > 1) {
                throw new Srv_Exception_Data("Выберите одну страницу");
            } elseif (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            foreach ($_POST['ids'] as $id) {
                $page = Model_Page::get($id);
                if ($page['del']) {
                    throw new Srv_Exception_Data("Страница по-умолчанию не должна быть удаленной");
                }
                Model_Page::resetDefault();
                Model_Page::update($id, array('is_default' => 1));
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
     * Меню администратора
     */
    static function menu_admin()
    {
        self::$view->setLayout('admin');

        self::$view->pushScript('admin/menu_admin');
        self::$view->render('admin/menu_admin');
    }

    static function edit_menu_admin($id = null)
    {
        self::$view->set('item', null);
        $item = null;
        if ($id) {
            $item = Model_MenuAdmin::get($id);
        }

        if ($item) {
            self::$view->set('item', $item);
            self::$view->set('group2menu_admin', Srv_Group::get2menu_admin($id));
        } else {
            Srv_Page::setCurrentTitle("Добавление меню");
        }

        self::$view->set('parent_id', isset($_GET['parent_id']) && $_GET['parent_id'] ? intval($_GET['parent_id']) : 0);
        self::$view->set('groups', Model_Group::getAll());
        self::$view->set('pages', Model_Page::getAll());

        Srv_MenuAdmin::setCurrent('admin/menu_admin');
        self::$view->setLayout('admin');

        self::$view->pushScript('admin/edit_menu_admin');
        self::$view->render('admin/edit_menu_admin');
    }

    static function edit_menu_admin_json($id = null)
    {
        $result = array('success' => true, 'msg' => 'Пункт меню успешно сохранена!');
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            list($data_menu_admin, $data_groups) = Srv_MenuAdmin::check();

            $old_groups = array();
            if ($id) {
                Model_MenuAdmin::update($id, $data_menu_admin);
                $old_groups = Srv_Group::get2menu_admin($id);
            } else {
                $id = Model_MenuAdmin::insert($data_menu_admin);
            }

            foreach ($data_groups as $value) {
                if (!in_array($value, $old_groups)) {
                    Model_Group::insert2menu_admin($value, $id);
                }
            }

            foreach ($old_groups as $value) {
                if (!in_array($value, $data_groups)) {
                    Model_Group::del2menu_admin($value, $id);
                }
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
     * @param int $id parent_id
     */
    static function lazy_load_menu_admin($id = 0)
    {
        $result = array();
        if (Srv_Group::hasAccessAdmin()) {
            $items = Srv_MenuAdmin::getChildItems($id);

            if ($items) foreach ($items as $key => $value) {
                $type = null;
                $icon = $value['icon'];
                $title = $value['title'];
                $groups = Srv_Group::get_info_groups2menu_admin($value['menu_admin_id']);

                if ($value['del']) {
                    $type = 'del';
                }

                if ($value['page_id']) {
                    $page = Model_Page::get($value['page_id']);
                    if (!$title) {
                        $title = $page['title'];
                    }
                    if (!$value['del']) {
                        $icon = $page['icon'];
                    }
                }

                foreach ($groups as $v) {
                    $title .= ' <i class="text-muted ' . $v['icon'] . '"></i>';
                }

                $result[] = array(
                    'id' => $value['menu_admin_id'],
                    'text' => $title,
                    'children' => Srv_MenuAdmin::hasChildItems($value['menu_admin_id']),
                    'type' => $type,
                    'icon' => $icon
                );
            }
        }
        Srv_Core_Helper::json($result);
    }

    static function move_menu_admin($id = 0)
    {
        $result = array('success' => true, 'msg' => 'Пункт меню успешно перемещен');
        $item = Model_MenuAdmin::get($id);
        try {
            if (!$item) {
                throw new Srv_Exception_Data("Выберите пункт меню");
            } elseif (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $form = new Srv_Core_Form();
            $data = $form->post('parent_id')->int()
                ->post('index')->int()
                ->fetch();

            Model_MenuAdmin::downNextIndex($item['parent_id'], $item['index']);
            Model_MenuAdmin::upIndex($data['parent_id'], $data['index']);
            Model_MenuAdmin::update($id, $data);
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    static function del_menu_admin()
    {
        $result = array('success' => true, 'msg' => 'Пункт меню успешно удален');
        try {
            if (!isset($_POST['ids']) || !$_POST['ids'] || !is_array($_POST['ids'])) {
                throw new Srv_Exception_Data("Выберите пункт меню");
            } elseif (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            foreach ($_POST['ids'] as $id) {
                $item = Model_MenuAdmin::get($id);
                if ($item['del'] == 1) {
                    $result['msg'] = 'Пункт меню успешно восстановлен';
                }
                Model_MenuAdmin::update($id, array('del' => $item['del'] ^ 1));
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
     * Группы пользователей
     */
    static function groups()
    {
        $params = Srv_Group::check_search();
        $pagination = new Srv_Core_Pagination($params['items'] ? $params['items'] : 10);
        $result = Model_Group::search($params, $params[$pagination->key] * $pagination->items, $pagination->items);

        $pagination->setCount($result['count']);
        $pagination->setParams($params);
        $pagination->setView('admin/pagination');

        self::$view->set('groups', $result['items']);
        self::$view->set('params', $params);
        self::$view->set('pagination', $pagination);

        self::$view->setLayout('admin');
        self::$view->pushScript('admin/groups');
        self::$view->render('admin/groups');
    }

    static function edit_group($id = null)
    {
        self::$view->set('group', null);

        $group = null;
        if ($id) {
            $group = Model_Group::get($id);
        }

        if ($group) {
            self::$view->set('group', $group);
            Srv_Page::setCurrentTitle($group['name']);
        } else {
            Srv_Page::setCurrentTitle("Добавление группы");
        }

        self::$view->set('parent_id', isset($_GET['parent_id']) && $_GET['parent_id'] ? intval($_GET['parent_id']) : 0);

        Srv_MenuAdmin::setCurrent('admin/groups');
        self::$view->setLayout('admin');
        self::$view->pushScript('admin/edit_group');
        self::$view->render('admin/edit_group');
    }

    static function edit_group_json($id = null)
    {
        $result = array('success' => true, 'msg' => 'Группа пользователей успешно сохранена!');
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $data = Srv_Group::check();

            if ($id) {
                Model_Group::update($id, $data);
            } else {
                Model_Group::insert($data);
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
     * Пользователи
     */
    static function users()
    {
        $params = Srv_User::check_search();
        $pagination = new Srv_Core_Pagination($params['items'] ? $params['items'] : 10);
        $result = Model_User::search($params, $params[$pagination->key] * $pagination->items, $pagination->items);

        $pagination->setCount($result['count']);
        $pagination->setParams($params);
        $pagination->setView('admin/pagination');

        foreach ($result['items'] as $key => $value) {
            $result['items'][$key]['groups'] = Srv_Group::get2user($value['user_id']);
        }

        self::$view->set('users', $result['items']);
        self::$view->set('groups', Srv_Group::getAssoc());
        self::$view->set('params', $params);
        self::$view->set('pagination', $pagination);

        self::$view->pushScript('admin/users');
        self::$view->setLayout('admin');
        self::$view->render('admin/users');
    }

    static function edit_user($id = 0)
    {
        self::$view->set('user', null);

        $user = null;
        if ($id) {
            $user = Model_User::get($id);
        }

        if ($user) {
            self::$view->set('user', $user);
            Srv_Page::setCurrentTitle($user['first_last_name']);
            self::$view->set('sessions', Model_Session::getAll(null, $id));
            self::$view->set('group2user', Srv_Group::get2user($id));
        } else {
            Srv_Page::setCurrentTitle("Добавление пользователя");
        }

        self::$view->set('groups', Model_Group::getAll());
        Srv_MenuAdmin::setCurrent('admin/users');

        self::$view->pushPluginJs('dropzone/dropzone.min');
        self::$view->pushPluginCss('Jcrop/css/jquery.Jcrop.min');
        self::$view->pushPluginJs('Jcrop/js/jquery.Jcrop.min');

        self::$view->pushScript('admin/edit_user');
        self::$view->setLayout('admin');
        self::$view->render('admin/edit_user');
    }
    
    static function edit_user_json($id = null)
    {
        $result = array('success' => true, 'msg' => 'Пользователь успешно сохранен!');
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            list($data_user, $data_groups) = Srv_User::check();
            $data_user['full_name'] = $data_user['last_name'] . ' ' . $data_user['first_name'] . ($data_user['middle_name'] ? ' ' . $data_user['middle_name'] : '');
            $data_user['first_last_name'] = $data_user['first_name'] . ' ' . $data_user['last_name'];

            $user2email = Srv_User::getUser2email($data_user['email']);
            if ($user2email && $user2email['user_id'] != $id) {
                throw new Srv_Exception_Data("Данный E-mail уже зарегистрирован | email");
            }

            if ($data_user['phone']) {
                $user2phone = Srv_User::getUser2phone($data_user['phone']);
                if ($user2phone && $user2phone['user_id'] != $id) {
                    throw new Srv_Exception_Data("Данный телефон уже зарегистрирован | phone");
                }
            }

            $old_groups = array();
            if ($id) {
                $user = Model_User::get($id);
                if ($user['avatar'] && $user['avatar'] != $data_user['avatar']) {
                    Srv_User::del_avatar($user['avatar']);
                }
                Model_User::update($id, $data_user);

                $old_groups = Srv_Group::get2user($id);
            } else {
                $id = Model_User::insert($data_user);
            }

            foreach ($data_groups as $value) {
                if (!in_array($value, $old_groups)) {
                    Model_Group::insert2user($value, $id);
                }
            }

            foreach ($old_groups as $value) {
                if (!in_array($value, $data_groups)) {
                    Model_Group::del2user($value, $id);
                }
            }
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    static function change_user_pass_json($id = null)
    {
        $result = array('success' => true, 'msg' => 'Пароль успешно изменен!');
        try {
            if (!$id) {
                throw new Srv_Exception_Data("Выберите пользователя");
            } elseif (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }
            $data = Srv_User::check_pass();
            $data['pass'] = Srv_User::gen_hash_pass($data['pass']);
            Model_User::update($id, $data);
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    static function del_user($id = null)
    {
        $result = array('success' => true, 'msg' => 'Пользователь успешно удален');
        try {
            if (!$id) {
                throw new Srv_Exception_Data("Выберите пользователя");
            } elseif ($id == Srv_User::getCurrentId()) {
                throw new Srv_Exception_Data("Нельзя удалить самого себя");
            } elseif (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $user = Model_User::get($id);
            if ($user['del'] == 1) {
                $result['msg'] = 'Пользователь успешно восстановлен';
            }
            Model_User::update($id, array('del' => $user['del'] ^ 1));

        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Загрузка аватарки пользователя
     */
    static function download_avatar()
    {
        $result = array('success' => true, 'msg' => 'Аватарка успешно загружена', 'filename' => null,
            'x' => 0, 'y' => 0, 'w' => 0, 'h' => 0);
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $file = new Srv_Core_File();
            $data = $file->post('file')
                ->is_exist('file', "Файл не загружен")
                ->is_image(array(IMAGETYPE_JPEG, IMAGETYPE_PNG), "Выберите изображение в формате JPEG или PNG")
                ->is_min_size(200, 200, "Выберите изображение больше 200x200 пикселей")
                ->move_uploaded_file(Srv_User::$avatar_paths['original'], "Файл не загружен")
                ->fetch('file');

            $data = array_shift($data);
            $result['filename'] = $data['filename'];
            $result['big_img'] = Srv_User::$avatar_paths['big'] . $data['filename'];
            $result['original_img'] = Srv_User::$avatar_paths['original'] . $data['filename'];

            $image = new Srv_Core_Image();
            $image->open(Srv_User::$avatar_paths['original'] . $data['filename']);
            $image->reduce_max_size(1000, 1000);

            $size = $image->getSize();
            $result['original_w'] = $image->getWidth($size);
            $result['original_h'] = $image->getHeight($size);

            $image->save(Srv_User::$avatar_paths['original'] . $data['filename']);

            $image->crop_center_square($thumbnail)->reduce_min_size(200, 200);
            $result['x'] = $thumbnail['x'];
            $result['y'] = $thumbnail['y'];
            $result['w'] = $thumbnail['w'];
            $result['h'] = $thumbnail['h'];
            $image->save(Srv_User::$avatar_paths['big'] . $data['filename']);

            $image->reduce_min_size(100, 100);
            $image->save(Srv_User::$avatar_paths['middle'] . $data['filename']);

            $image->reduce_min_size(50, 50);
            $image->save(Srv_User::$avatar_paths['small'] . $data['filename']);
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    static function del_avatar()
    {
        $result = array('success' => true, 'msg' => 'Аватарка успешно удалена');
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $data = Srv_User::check_thumbnail();
            Srv_User::del_avatar($data['filename']);
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    static function update_avatar()
    {
        $result = array('success' => true, 'msg' => 'Аватарка успешно изменена',
            'x' => 0, 'y' => 0, 'w' => 0, 'h' => 0);
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $data = Srv_User::check_thumbnail();

            if (!$data['coord']['w'] || !$data['coord']['h']) {
                throw new Srv_Exception_Data("Выберите область для аватарки");
            }

            $result['filename'] = $data['filename'];
            $result['x'] = $data['coord']['x'];
            $result['y'] = $data['coord']['y'];
            $result['w'] = $data['coord']['w'];
            $result['h'] = $data['coord']['h'];
            $result['big_img'] = Srv_User::$avatar_paths['big'] . $data['filename'];

            $image = new Srv_Core_Image();
            $image->open(Srv_User::$avatar_paths['original'] . $data['filename']);

            $image->crop($data['coord']['x'], $data['coord']['y'], $data['coord']['w'], $data['coord']['h'])->reduce_min_size(200, 200);
            $image->save(Srv_User::$avatar_paths['big'] . $data['filename']);

            $image->reduce_min_size(100, 100);
            $image->save(Srv_User::$avatar_paths['middle'] . $data['filename']);

            $image->reduce_min_size(50, 50);
            $image->save(Srv_User::$avatar_paths['small'] . $data['filename']);
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Уведомления
     */
    static function notices()
    {
        $params = Srv_Notice::check_search();
        $pagination = new Srv_Core_Pagination($params['items'] ? $params['items'] : 10);
        $result = Model_Notice::search($params, $params[$pagination->key] * $pagination->items, $pagination->items);

        $pagination->setCount($result['count']);
        $pagination->setParams($params);
        $pagination->setView('admin/pagination');

        self::$view->set('notices', $result['items']);
        self::$view->set('params', $params);
        self::$view->set('pagination', $pagination);

        self::$view->setLayout('admin');
        self::$view->render('admin/notices');
    }
    
    static function edit_notice($id = null)
    {
        self::$view->set('notice', null);

        $notice = null;
        if ($id) {
            $notice = Model_Notice::get($id);
        }

        if ($notice) {
            self::$view->set('notice', $notice);
            Srv_Page::setCurrentTitle($notice['subject']);
        } else {
            Srv_Page::setCurrentTitle("Добавление уведомления");
        }
        
        Srv_MenuAdmin::setCurrent('admin/notices');
        self::$view->setLayout('admin');
        self::$view->pushExtPluginJs('//cdn.ckeditor.com/4.6.0/full/ckeditor.js');
        self::$view->pushScript('admin/edit_notice');
        self::$view->render('admin/edit_notice');
    }

    static function edit_notice_json($id = null)
    {
        $result = array('success' => true, 'msg' => 'Уведомление успешно сохранено!');
        try {
            if (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $data = Srv_Notice::check();

            if ($id) {
                Model_Notice::update($id, $data);
            } else {
                Model_Notice::insert($data);
            }
        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    static function del_notice($id = null)
    {
        $result = array('success' => true, 'msg' => 'Уведомление успешно удалено');
        try {
            if (!$id) {
                throw new Srv_Exception_Data("Выберите уведомление");
            } elseif (!Srv_Group::hasAccessAdmin()) {
                throw new Srv_Exception_Data("access denied");
            }

            $notice = Model_Notice::get($id);
            if ($notice['del'] == 1) {
                $result['msg'] = 'Уведомление успешно восстановлено';
            }
            Model_Notice::update($id, array('del' => $notice['del'] ^ 1));

        } catch (Srv_Exception_Data $e) {
            $result = array(
                'success' => false,
                'error' => $e->getMessage()
            );
        }
        Srv_Core_Helper::json($result);
    }

    /**
     * Товары
     */
    static function goods()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/goods');
    }

    /**
     * Форум
     */
    static function topics()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/topics');
    }

    /**
     * Комментарии
     */
    static function comments()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/comments');
    }

    /**
     * Курсы
     */
    static function courses()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/courses');
    }

    /**
     * Вебинары
     */
    static function events()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/events');
    }

    /**
     * Статьи
     */
    static function posts()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/posts');
    }

    /**
     * Организации
     */
    static function orgs()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/orgs');
    }

    /**
     * Помощь
     */
    static function help()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/help');
    }

    /**
     * Вопросы
     */
    static function questions()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/questions');
    }

    /**
     * Правовые документы
     */
    static function legal()
    {
        self::$view->setLayout('admin');
        self::$view->render('admin/legal');
    }


}


