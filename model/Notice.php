<?php

Class Model_Notice extends Srv_Core_Model
{
    static function get($notice_id = null, $del = null, $type = null, $event = null)
    {
        if (!self::$db) return false;
        self::$db->select('notices')->where(1);
        if ($notice_id !== null) {
            self::$db->cond_and(array('notice_id' => intval($notice_id)));
        }
        if ($type !== null) {
            self::$db->cond_and(array('type' => intval($type)));
        }
        if ($del !== null) {
            self::$db->cond_and(array('del' => intval($del)));
        }
        if ($event !== null) {
            self::$db->cond_and(array('event' => intval($event)));
        }
        return self::$db->order(array('notice_id' => "desc"))->secure()->fetch();
    }

    static function getAll($del = null, $event = null)
    {
        if (!self::$db) return false;
        self::$db->select('notices')->where(1);
        if ($del !== null) {
            self::$db->cond_and(array('del' => intval($del)));
        }
        if ($event !== null) {
            self::$db->cond_and(array('event' => intval($event)));
        }
        return self::$db->order(array('notice_id' => "desc"))->secure()->fetchAll();
    }

    static function search($params = array(), $offset = 0, $rows = PHP_INT_MAX)
    {
        if (!self::$db) return false;
        self::$db->select('notices', "SQL_CALC_FOUND_ROWS *")->where(1);
        if (isset($params['search']) && $params['search'] != '') {
            self::$db->cond_and();
            self::$db->begin_br();
            $s = $params['search'];
            self::$db->cond(array('subject' => "%$s%"), null, "LIKE");
            self::$db->end_br();
        }
        $items = self::$db->limit($rows, $offset)->secure()->fetchAll();
        $count = self::$db->select(null, "FOUND_ROWS()")->fetchAll();
        return array('items' => $items, 'count' => reset($count[0]));
    }

    /**
     * Обновление уведомления
     * @param $id
     * @param $data
     * @return string
     */
    static function update($id, $data)
    {
        if (!self::$db) return false;
        return self::$db->unsecure_upd('notices', $data, array('notice_id' => intval($id)));
    }

    /**
     * Добавление уведомления
     * @param $data
     * @return string
     */
    static function insert($data)
    {
        if (!self::$db) return false;
        return self::$db->unsecure_add('notices', $data);
    }
}
