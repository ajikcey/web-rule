<?php

class Srv_MenuAdmin
{
    /**
     * @var array
     */
    private static $current = 0;

    static function getCurrent()
    {
        return self::$current;
    }

    static function setCurrent($handler)
    {
        $page = Srv_Page::getEnablePage2handler($handler);
        if (!$page) return false;

        $item_menu = Srv_MenuAdmin::getEnableItem2page($page['page_id']);
        if (!$item_menu) return false;

        self::$current = $item_menu['menu_admin_id'];
        return true;
    }

    static function getEnableItem2page($page_id)
    {
        return Model_MenuAdmin::get(null, 0, null, $page_id);
    }

    static function menu4user()
    {
        $menu = Model_MenuAdmin::getAll(0);
        foreach ($menu as $key => $value) {
            $groups2user = Srv_Group::getCurrent2user();
            $groups2menu_admin = Srv_Group::get2menu_admin($value['menu_admin_id']);

            $accessibly = true;
            if ($groups2menu_admin) {
                $accessibly = false;
                foreach ($groups2user as $u) {
                    foreach ($groups2menu_admin as $m) {
                        if ($u == $m) {
                            $accessibly = true;
                        }
                    }
                }
            }

            if (!$accessibly) {
                unset($menu[$key]);
            }
        }
        return $menu;
    }

    static function getActiveItemIDs($menu)
    {
        $items = array();
        $parent_id = false;
        $continue = true;

        if (self::$current) {
            if (is_array($menu)) foreach ($menu as $key => $value) {
                if ($value['menu_admin_id'] == self::$current) {
                    $parent_id = $value['parent_id'];
                    $items[] = $value['menu_admin_id'];
                    unset($menu[$key]);
                    break;
                }
            }
        } else {
            $page_id = Srv_Page::getCurrentId();

            if (is_array($menu)) foreach ($menu as $key => $value) {
                if ($value['page_id'] == $page_id) {
                    $parent_id = $value['parent_id'];
                    $items[] = $value['menu_admin_id'];
                    unset($menu[$key]);
                    break;
                }
            }
        }

        while ($continue) {
            $continue = false;
            if (is_array($menu)) foreach ($menu as $key => $value) {
                if ($value['menu_admin_id'] == $parent_id) {
                    $parent_id = $value['parent_id'];
                    $items[] = $value['menu_admin_id'];
                    $continue = true;
                    unset($menu[$key]);
                    break;
                }
            }
        }
        return $items;
    }

    static function check()
    {
        $form = new Srv_Core_Form();
        $form
            ->post('title')->trim()->max_length(255, "Заголовок не может быть больше 255 символов | title")
            ->post('icon')->trim()->max_length(255, "Иконка не может быть больше 255 символов | icon")
            ->post('page_id')->int()
            ->post('parent_id')->int()
            ->post('group_id')->array_map_int();

        $data = array(
            $form->fetch(),
            $form->fetch('group_id')
        );
        unset($data[0]['group_id']);
        return $data;
    }

    static function getChildItems($item_id)
    {
        return Model_MenuAdmin::getAll(null, $item_id);
    }

    static function hasChildItems($item_id)
    {
        return Model_MenuAdmin::get(null, null, $item_id) ? true : false;
    }
}