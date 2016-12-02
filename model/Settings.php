<?php

Class Model_Settings extends Srv_Core_Model
{
    static function getAll()
    {
        if (!self::$db) return false;
        self::$db->select('settings')->where(1);
        return self::$db->secure()->fetchAll();
    }

    static function get($key)
    {
        if (!self::$db) return false;
        self::$db->select('settings')->where(1);
        self::$db->cond_and(array('`key`' => $key));
        return self::$db->secure()->fetch();
    }

    /**
     * Обновление данных
     * @param $key
     * @param $value
     * @return string
     */
    static function update($key, $value)
    {
        if (!self::$db) return false;
        return self::$db->upd('settings', array('value' => $value), array('`key`' => $key));
    }
}