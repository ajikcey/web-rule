<?php

Class Model_Webnotice extends Srv_Core_Model
{
    static function get($webnotice_id = null)
    {
        if (!self::$db) return false;
        self::$db->select('webnotices')->where(1);
        if ($webnotice_id !== null) {
            self::$db->cond_and(array('webnotice_id' => intval($webnotice_id)));
        }
        return self::$db->order(array('`webnotice_id`' => "desc"))->secure()->fetch();
    }

    static function getAll($del = null, $user_id = null, $is_old = null)
    {
        if (!self::$db) return false;
        self::$db->select('webnotices')->where(1);
        if ($del !== null) {
            self::$db->cond_and(array('del' => intval($del)));
        }
        if ($user_id !== null) {
            self::$db->cond_and(array('user_id' => intval($user_id)));
        }
        if ($is_old !== null) {
            self::$db->cond_and(array('is_old' => intval($is_old)));
        }
        return self::$db->order(array('`date`' => "desc"))->secure()->fetchAll();
    }

    static function search($params = array(), $offset = 0, $rows = PHP_INT_MAX)
    {
        if (!self::$db) return false;
        self::$db->select('webnotices', "SQL_CALC_FOUND_ROWS *")->where(1);
        if (isset($params['search']) && $params['search'] != '') {
            self::$db->cond_and();
            self::$db->begin_br();
            $s = $params['search'];
            self::$db->cond(array('text' => "%$s%"), null, "LIKE");
            self::$db->end_br();
        }
        $items = self::$db->order(array('`date`' => "desc"))->limit($rows, $offset)->secure()->fetchAll();
        $count = self::$db->select(null, "FOUND_ROWS()")->fetchAll();
        return array('items' => $items, 'count' => reset($count[0]));
    }

    /**
     * Обновление
     * @param $id
     * @param $data
     * @return string
     */
    static function update($id, $data)
    {
        if (!self::$db) return false;
        return self::$db->upd('webnotices', $data, array('webnotice_id' => intval($id)));
    }

    /**
     * Добавление
     * @param $data
     * @return string
     */
    static function insert($data)
    {
        if (!self::$db) return false;
        return self::$db->add('webnotices', $data);
    }
}