<?php

Class Model_Group extends Srv_Core_Model
{
    static function get($group_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('groups')->where(1);
        if ($group_id !== null) {
            self::$db->cond_and(array('group_id' => intval($group_id)));
        }
        return self::$db->order(array('`group_id`' => "desc"))->secure()->fetch();
    }

    static function getAll($access = null)
    {
        if (!self::$db) return false;
        self::$db->select('groups')->where(1);
        if ($access !== null) {
            self::$db->cond_and(array('`access`' => intval($access)));
        }
        return self::$db->order(array('`group_id`' => "desc"))->secure()->fetchAll();
    }

    static function search($params = array(), $offset = 0, $rows = PHP_INT_MAX)
    {
        if (!self::$db) return false;
        self::$db->select('groups', "SQL_CALC_FOUND_ROWS *")->where(1);
        if (isset($params['search']) && $params['search'] != '') {
            self::$db->cond_and();
            self::$db->begin_br();
            $s = $params['search'];
            self::$db->cond(array('name' => "%$s%"), null, "LIKE");
            self::$db->end_br();
        }
        $items = self::$db->limit($rows, $offset)->secure()->fetchAll();
        $count = self::$db->select(null, "FOUND_ROWS()")->fetchAll();
        return array('items' => $items, 'count' => reset($count[0]));
    }

    /**
     * Обновление группы пользователей
     * @param $id
     * @param $data
     * @return string
     */
    static function update($id, $data)
    {
        if (!self::$db) return false;
        return self::$db->upd('groups', $data, array('group_id' => intval($id)));
    }

    /**
     * Добавление группы пользователей
     * @param $data
     * @return string
     */
    static function insert($data)
    {
        if (!self::$db) return false;
        return self::$db->add('groups', $data);
    }

    /**
     * 2 user
     *
     * @param null $group_id
     * @param null $user_id
     * @return bool|mixed
     */
    static function get2user($group_id = null, $user_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('group2user')->where(1);
        if ($user_id !== null) {
            self::$db->cond_and(array('user_id' => intval($user_id)));
        }
        if ($group_id !== null) {
            self::$db->cond_and(array('group_id' => intval($group_id)));
        }
        return self::$db->order(array('`group_id`' => "desc"))->secure()->fetch();
    }

    static function getAll2user($group_id = null, $user_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('group2user')->where(1);
        if ($user_id !== null) {
            self::$db->cond_and(array('user_id' => intval($user_id)));
        }
        if ($group_id !== null) {
            self::$db->cond_and(array('group_id' => intval($group_id)));
        }
        return self::$db->order(array('`group_id`' => "desc"))->secure()->fetchAll();
    }

    /**
     * Добавление пользователя в группу
     * @param $group_id
     * @param $user_id
     * @return string
     */
    static function insert2user($group_id, $user_id)
    {
        if (!self::$db) return false;
        return self::$db->add('group2user', array('group_id' => intval($group_id), 'user_id' => intval($user_id)));
    }

    /**
     * Удаление пользователя из группы
     * @param $group_id
     * @param $user_id
     * @return string
     */
    static function del2user($group_id, $user_id)
    {
        if (!self::$db) return false;
        return self::$db->del('group2user', array('group_id' => intval($group_id), 'user_id' => intval($user_id)));
    }

    /**
     * 2 page
     *
     * @param null $group_id
     * @param null $page_id
     * @return bool|mixed
     */
    static function get2page($group_id = null, $page_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('group2page')->where(1);
        if ($page_id !== null) {
            self::$db->cond_and(array('page_id' => intval($page_id)));
        }
        if ($group_id !== null) {
            self::$db->cond_and(array('group_id' => intval($group_id)));
        }
        return self::$db->order(array('`group_id`' => "desc"))->secure()->fetch();
    }

    static function getAll2page($group_id = null, $page_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('group2page')->where(1);
        if ($page_id !== null) {
            self::$db->cond_and(array('page_id' => intval($page_id)));
        }
        if ($group_id !== null) {
            self::$db->cond_and(array('group_id' => intval($group_id)));
        }
        return self::$db->order(array('`group_id`' => "desc"))->secure()->fetchAll();
    }

    /**
     * Добавление страницы в группу
     * @param $group_id
     * @param $page_id
     * @return string
     */
    static function insert2page($group_id, $page_id)
    {
        if (!self::$db) return false;
        return self::$db->add('group2page', array('group_id' => intval($group_id), 'page_id' => intval($page_id)));
    }

    /**
     * Удаление страницы из группы
     * @param $group_id
     * @param $page_id
     * @return string
     */
    static function del2page($group_id, $page_id)
    {
        if (!self::$db) return false;
        return self::$db->del('group2page', array('group_id' => intval($group_id), 'page_id' => intval($page_id)));
    }

    /**
     * 2 menu_admin
     *
     * @param null $group_id
     * @param null $menu_admin_id
     * @return bool|mixed
     */
    static function get2menu_admin($group_id = null, $menu_admin_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('group2menu_admin')->where(1);
        if ($menu_admin_id !== null) {
            self::$db->cond_and(array('menu_admin_id' => intval($menu_admin_id)));
        }
        if ($group_id !== null) {
            self::$db->cond_and(array('group_id' => intval($group_id)));
        }
        return self::$db->order(array('`group_id`' => "desc"))->secure()->fetch();
    }

    static function getAll2menu_admin($group_id = null, $menu_admin_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('group2menu_admin')->where(1);
        if ($menu_admin_id !== null) {
            self::$db->cond_and(array('menu_admin_id' => intval($menu_admin_id)));
        }
        if ($group_id !== null) {
            self::$db->cond_and(array('group_id' => intval($group_id)));
        }
        return self::$db->order(array('`group_id`' => "desc"))->secure()->fetchAll();
    }

    /**
     * Добавление пункта меню в группу
     * @param $group_id
     * @param $menu_admin_id
     * @return string
     */
    static function insert2menu_admin($group_id, $menu_admin_id)
    {
        if (!self::$db) return false;
        return self::$db->add('group2menu_admin', array('group_id' => intval($group_id), 'menu_admin_id' => intval($menu_admin_id)));
    }

    /**
     * Удаление пункта меню из группы
     * @param $group_id
     * @param $menu_admin_id
     * @return string
     */
    static function del2menu_admin($group_id, $menu_admin_id)
    {
        if (!self::$db) return false;
        return self::$db->del('group2menu_admin', array('group_id' => intval($group_id), 'menu_admin_id' => intval($menu_admin_id)));
    }


}
