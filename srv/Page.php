<?php

/**
 * Class Srv_Page
 */
class Srv_Page
{
    /**
     * @var array
     */
    private static $current = array();
    /**
     * @var array
     */
    private static $pages = array();
    /**
     * @var string
     */
    private static $handler = null;

    /**
     * @param null $handler
     */
    static function init($handler = null)
    {
        if (!$handler) {
            $handler = (isset($_GET['url']) ? filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL) : null);
        }

        self::$current = array();
        if (Srv_Core_Model::$db) {
            $d = self::getDefaultUrl();

            if (!$handler) {
                $handler = $d;
            } elseif ($handler == $d) {
                self::redirect('/');
            }

            $pars = $o_params = $params = explode('/', $handler);
            $parent_id = 0;
            $count = count($params);
            $new_handler = null;

            self::checkRedirect($params);
            for ($i = 0; $i < $count; $i++) {
                $pars = $params;

                $h = self::getEnablePage2url($p = array_shift($params), $parent_id);

                if ($h['redirect_url'] && trim($h['redirect_url'], "/") != $handler) {
                    self::redirect($h['redirect_url']);
                } elseif ($h) {
                    self::$pages[] = self::$current = $h;
                    $parent_id = $h['page_id'];
                    $new_handler = $h['handler'];

                    array_shift($pars);
                    array_unshift($pars, $new_handler);
                } else {
                    if ($i == 1) {
                        list($controller, $action) = self::parseHandler($handler);
                        if (class_exists($controller) && method_exists($controller, $action)) {
                            $pars = $o_params;
                            break;
                        }
                    }
                    if ($new_handler) {
                        array_unshift($pars, $new_handler);
                    }
                    break;
                }
            }
            $handler = implode("/", $pars);
        }

        self::$handler = $handler;
        self::runHandler();
    }

    /**
     * Вывод страницы
     */
    private static function runHandler()
    {
        list($controller, $action, $params) = self::parseHandler(self::$handler);
        if (class_exists($controller) && method_exists($controller, $action)) {
            try {
                self::checkAccess();
                call_user_func_array("$controller::$action", $params);
            } catch (Srv_Exception_Access $e) {
                // Forbidden
                $e->handle();
            }
        } elseif (self::$handler == Srv_Core_Boot::getHandler(404)) {
            // чтобы не зациклилась 404 ошибка
            header("HTTP/1.0 404 Not Found", true, 404);
            die("Page not found");
        } else {
            self::init(Srv_Core_Boot::getHandler(404));
            die();
        }
    }

    /**
     * Получение контроллера, действия и параметров
     * @param $url string
     * @return array
     */
    private static function parseHandler($url)
    {
        $params = explode('/', $url);
        return array(
            CTRL_PREFIX . FS . array_shift($params),
            array_shift($params),
            $params,
        );
    }

    /**
     * Проверка на получение доступа к странице не через URL, а через `обработчика`
     * Например: доступ к странице /test через /site/test
     * Если так, редирект на URL (+ добавить параметры если URL не пустой)
     * @param $params
     */
    private static function checkRedirect($params)
    {
        $count = count($params);

        for ($i = $count; $i > 1; $i--) {
            $h = array();
            $p = $params;
            for ($j = 0; $j < $i; $j++) {
                $h[] = array_shift($p);
            }

            $r = self::getEnablePage2handler(implode("/", $h));
            if ($r) {
                if ($r['url']) {
                    array_unshift($p, $r['url']); // добавить в начало массива значение
                }

                while ($r = Model_Page::get($r['parent_id'])) {
                    array_unshift($p, $r['url']);
                }

                if ($p != $params) {
                    $r['url'] = implode("/", $p);
                    self::redirect('/' . $r['url']);
                    break;
                }
            }
        }
    }

    /**
     * 301 Moved Permanently
     * @param $url
     */
    static function redirect($url = null)
    {
        header('Location: ' . trim($url ? $url : '/'), true, 301);
        die();
    }

    /**
     * Проверка доступа к странице
     */
    private static function checkAccess()
    {
        $groups2user = Srv_Group::getCurrent2user();
        $groups2page = Srv_Group::get2page(Srv_Page::getCurrentId());

        $accessibly = true;
        if ($groups2page) {
            $accessibly = false;
            foreach ($groups2user as $u) {
                foreach ($groups2page as $p) {
                    if ($u == $p) {
                        $accessibly = true;
                    }
                }
            }
        }
        if (!$accessibly) {
            self::noAccess("Access denied to the page " . self::getCurrentId() . " for user " .
                Srv_User::getCurrentId() . " in " . __FILE__ . " on line " . __LINE__);
        }
        return true;
    }

    static function noAccess($msg = null)
    {
        throw new Srv_Exception_Access($msg);
    }

    /**
     * @param $handler string
     * @param int $db_found
     * @return string
     */
    static function getUrl($handler, $db_found = 1)
    {
        if ($db_found) {
            $a = array();
            $h = Model_Page::get(null, null, $handler, null);
            if ($h) {
                $a[] = $h['url'];

                while ($h = Model_Page::get($h['parent_id'])) {
                    $a[] = $h['url'];
                }

                if ($a) {
                    $handler = implode("/", array_reverse($a));
                }
            }
        }
        return PROTOCOL . '://' . HOST . DS . $handler;
    }

    static function getBackUrl()
    {
        return isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : false;
    }

    /**
     * Наличие обработчика в текущем наборе страниц
     * @param $handler
     * @return bool
     */
    static function hasHandler($handler)
    {
        if (self::$pages) {
            foreach (self::$pages as $value) {
                if ($value['handler'] == $handler) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $handler
     * @param $parent_id
     * @return mixed
     */
    static function getEnablePage2handler($handler, $parent_id = null)
    {
        return Model_Page::get(null, null, $handler, $parent_id, 0);
    }

    static function getEnablePage($page_id)
    {
        return Model_Page::get($page_id, null, null, null, 0);
    }

    /**
     * @param $url
     * @param null $parent_id
     * @return mixed
     */
    static function getEnablePage2url($url, $parent_id = null)
    {
        return Model_Page::get(null, $url, null, $parent_id, 0);
    }

    /**
     * @param $url
     * @param null $parent_id
     * @return mixed
     */
    static function getPage2url($url, $parent_id = null)
    {
        return Model_Page::get(null, $url, null, $parent_id);
    }

    static function setCurrentTitle($value)
    {
        self::$current['title'] = $value;
    }

    static function setCurrentDesc($value)
    {
        self::$current['desc'] = $value;
    }

    static function setCurrentKeywords($value)
    {
        self::$current['keywords'] = $value;
    }

    static function getTitle()
    {
        return isset(self::$current['title']) ? self::$current['title'] : false;
    }

    static function getCurrentHeadTitle()
    {
        return self::getTitle() . " &middot; " . Srv_Settings::getName();
    }

    static function getCurrentIcon()
    {
        return self::$current['icon'];
    }

    static function getCurrentDesc()
    {
        return isset(self::$current['desc']) ? self::$current['desc'] : false;
    }

    static function getCurrentKeywords()
    {
        return isset(self::$current['keywords']) ? self::$current['keywords'] : false;
    }

    static function getCurrent()
    {
        return self::$current;
    }

    static function getPages()
    {
        return self::$pages;
    }

    static function getCurHandler()
    {
        return self::$handler;
    }

    static function getCurrentId()
    {
        return isset(self::$current['page_id']) ? self::$current['page_id'] : false;
    }

    static function getChildPages($parent_id)
    {
        return Model_Page::getAll($parent_id);
    }

    static function hasChildPages($parent_id)
    {
        return Model_Page::get(null, null, null, $parent_id) ? true : false;
    }

    static function getDefaultUrl()
    {
        $h = Model_Page::get(null, null, null, null, 0, 1);
        $handler = "";

        $a = array();
        if ($h) {
            $a[] = $h['url'];

            while ($h = Model_Page::get($h['parent_id'])) {
                $a[] = $h['url'];
            }

            if ($a) {
                $handler = implode("/", array_reverse($a));
            }
        }
        return $handler;
    }

    static function check()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->post('title')->trim()->empty_str("Введите заголовок страницы | title")->max_length(255, "Заголовок не может быть больше 255 символов | title")
            ->post('url')->trim()->empty_str("Введите URL | url")->max_length(255, "URL не может быть больше 255 символов | url")
            ->post('handler')->trim()->empty_str("Введите обработчик | handler")->max_length(255, "Обработчик не может быть больше 255 символов | handler")
            ->post('icon')->trim()->max_length(255, "Иконка не может быть больше 255 символов | icon")
            ->post('parent_id')->int()
            ->post('desc')->trim()
            ->post('keywords')->trim()
            ->post('redirect_url')->trim()
            ->post('group_id')->array_map_int()
            ->fetch();
        
        $groups = $data['group_id'];
        unset($data['group_id']);
        return array($data, $groups);
    }

}