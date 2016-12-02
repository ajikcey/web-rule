<?php

Class Srv_Group
{
    /**
     * @var array
     */
    private static $current2user = array();
    /**
     * @var array
     */
    private static $current = array();
    /**
     * @var array
     */
    private static $accesses = array("Не выбрано", "Администратор");
    
    static function getAccesses()
    {
        return self::$accesses;
    }
    
    static function init()
    {
        self::$current2user = self::get2user(Srv_User::getCurrentId());
        foreach (self::$current2user as $value) {
            self::$current[] = Model_Group::get($value);
        }
    }

    static function getCurrent2user()
    {
        return self::$current2user;
    }

    static function getCurrent()
    {
        return self::$current;
    }
    
    static function hasAccessAdmin()
    {
        foreach (self::$current as $value) {
            if ($value['access'] == 1) {
                return true;
            }
        }
        return false;
    }

    static function get2user($user_id)
    {
        $groups = array();
        if ($user_id) {
            $g = Model_Group::getAll2user(null, $user_id);
            foreach ($g as $value) {
                $groups[] = $value['group_id'];
            }
        }
        return $groups;
    }

    static function get2page($page_id)
    {
        $groups = array();
        if ($page_id) {
            $g = Model_Group::getAll2page(null, $page_id);
            foreach ($g as $value) {
                $groups[] = $value['group_id'];
            }
        }
        return $groups;
    }

    static function get_info_groups2page($page_id)
    {
        $groups = array();
        if ($page_id) {
            $g = self::get2page($page_id);
            foreach ($g as $value) {
                $groups[] = Model_Group::get($value);
            }
        }
        return $groups;
    }

    static function get2menu_admin($menu_admin_id)
    {
        $groups = array();
        if ($menu_admin_id) {
            $g = Model_Group::getAll2menu_admin(null, $menu_admin_id);
            foreach ($g as $value) {
                $groups[] = $value['group_id'];
            }
        }
        return $groups;
    }

    static function get_info_groups2menu_admin($menu_admin_id)
    {
        $groups = array();
        if ($menu_admin_id) {
            $g = self::get2menu_admin($menu_admin_id);
            foreach ($g as $value) {
                $groups[] = Model_Group::get($value);
            }
        }
        return $groups;
    }
    
    static function getAdminGroups()
    {
        return Model_Group::getAll(1);
    }

    static function getNames()
    {
        $groups = Model_Group::getAll();
        $names = array();
        foreach ($groups as $value) {
            $names[$value['group_id']] = $value['name'];
        }
        return $names;
    }

    static function getIcons()
    {
        $groups = Model_Group::getAll();
        $names = array();
        foreach ($groups as $value) {
            $names[$value['group_id']] = $value['icon'];
        }
        return $names;
    }

    static function getAssoc()
    {
        $groups = Model_Group::getAll();
        $names = array();
        foreach ($groups as $value) {
            $names[$value['group_id']] = $value;
        }
        return $names;
    }

    static function check()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->post('name')->trim()->empty_str("Введите название группы | name")->max_length(255, "Название группы не может быть больше 255 символов | name")
            ->post('icon')->trim()->max_length(255, "Иконка не может быть больше 255 символов | icon")
            ->post('is_default')->int()
            ->post('access')->int()
            ->fetch();
        return $data;
    }

    static function check_search()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->get('search')->trim()
            ->get('page')
            ->get('items')
            ->secure()->fetch();
        return $data;
    }
}