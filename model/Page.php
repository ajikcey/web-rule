<?php

Class Model_Page extends Srv_Core_Model
{
    static function get($page_id = null, $url = null, $handler = null, $parent_id = null, $del = null, $is_default = null)
    {
        if (!self::$db) return false;
        self::$db->select('pages')->where(1);
        if ($page_id !== null) {
            self::$db->cond_and(array('page_id' => intval($page_id)));
        }
        if ($url !== null) {
            self::$db->cond_and(array('url' => $url));
        }
        if ($handler !== null) {
            self::$db->cond_and(array('handler' => $handler));
        }
        if ($parent_id !== null) {
            self::$db->cond_and(array('parent_id' => intval($parent_id)));
        }
        if ($del !== null) {
            self::$db->cond_and(array('del' => intval($del)));
        }
        if ($is_default !== null) {
            self::$db->cond_and(array('is_default' => intval($is_default)));
        }
        return self::$db->secure()->order(array('`index`' => "ASC"))->fetch();
    }

    static function getAll($parent_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('pages')->where(1);
        if ($parent_id !== null) {
            self::$db->cond_and(array('parent_id' => intval($parent_id)));
        }
        return self::$db->secure()->order(array('`index`' => "ASC"))->fetchAll();
    }

    /**
     * Обновление страницы
     * @param $id
     * @param $data
     * @return string
     */
    static function update($id, $data)
    {
        if (!self::$db) return false;
        return self::$db->upd('pages', $data, array('page_id' => intval($id)));
    }

    /**
     * Добавление страницы
     * @param $data
     * @return string
     */
    static function insert($data)
    {
        if (!self::$db) return false;
        return self::$db->add('pages', $data);
    }

    /**
     * @return string
     */
    static function resetDefault()
    {
        if (!self::$db) return false;
        return self::$db->update('pages', array('is_default' => 0))->execute()->rowCount();
    }

    static function upIndex($parent_id, $index)
    {
        if (!self::$db) return false;
        return self::$db->update('pages', '`index` = `index` + 1', array('parent_id' => $parent_id))->cond_and(array('`index`' => $index), '>=')->execute()->rowCount();
    }

    static function downNextIndex($parent_id, $index)
    {
        if (!self::$db) return false;
        return self::$db->update('pages', '`index` = `index` - 1', array('parent_id' => $parent_id))->cond_and(array('`index`' => $index), '>')->execute()->rowCount();
    }


}
