<?php

Class Model_MenuAdmin extends Srv_Core_Model
{
    static function get($menu_admin_id = null, $del = null, $parent_id = null, $page_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('menu_admin')->where(1);
        if ($menu_admin_id !== null) {
            self::$db->cond_and(array('menu_admin_id' => intval($menu_admin_id)));
        }
        if ($del !== null) {
            self::$db->cond_and(array('del' => intval($del)));
        }
        if ($parent_id !== null) {
            self::$db->cond_and(array('parent_id' => intval($parent_id)));
        }
        if ($page_id !== null) {
            self::$db->cond_and(array('page_id' => intval($page_id)));
        }
        return self::$db->order(array('`index`' => "asc"))->secure()->fetch();
    }

    static function getAll($del = null, $parent_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('menu_admin')->where(1);
        if ($del !== null) {
            self::$db->cond_and(array('del' => intval($del)));
        }
        if ($parent_id !== null) {
            self::$db->cond_and(array('parent_id' => intval($parent_id)));
        }
        return self::$db->order(array('`index`' => "asc"))->secure()->fetchAll();
    }

    /**
     * Обновление пункта меню
     * @param $id
     * @param $data
     * @return string
     */
    static function update($id, $data)
    {
        if (!self::$db) return false;
        return self::$db->upd('menu_admin', $data, array('menu_admin_id' => intval($id)));
    }

    /**
     * Добавление пункта меню
     * @param $data
     * @return string
     */
    static function insert($data)
    {
        if (!self::$db) return false;
        return self::$db->add('menu_admin', $data);
    }

    static function upIndex($parent_id, $index)
    {
        if (!self::$db) return false;
        return self::$db->update('menu_admin', '`index` = `index` + 1', array('parent_id' => $parent_id))->cond_and(array('`index`' => $index), '>=')->execute()->rowCount();
    }

    static function downNextIndex($parent_id, $index)
    {
        if (!self::$db) return false;
        return self::$db->update('menu_admin', '`index` = `index` - 1', array('parent_id' => $parent_id))->cond_and(array('`index`' => $index), '>')->execute()->rowCount();
    }
}