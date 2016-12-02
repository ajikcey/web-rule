<?php

Class Model_Session extends Srv_Core_Model
{
    /**
     * Получение сессии из базы
     * @param null $session_id
     * @param null $user_id
     * @param null $browser
     * @return mixed
     */
    static function get($session_id = null, $user_id = null, $browser = null)
    {
        if (!self::$db) return false;
        self::$db->select('sessions')->where(1);
        if ($session_id !== null) {
            self::$db->cond_and(array('session_id' => intval($session_id)));
        }
        if ($user_id !== null) {
            self::$db->cond_and(array('user_id' => intval($user_id)));
        }
        if ($browser !== null) {
            self::$db->cond_and(array('browser' => $browser));
        }
        return self::$db->secure()->fetch();
    }

    static function getAll($session_id = null, $user_id = null, $browser = null)
    {
        if (!self::$db) return false;
        self::$db->select('sessions')->where(1);
        if ($session_id !== null) {
            self::$db->cond_and(array('session_id' => intval($session_id)));
        }
        if ($user_id !== null) {
            self::$db->cond_and(array('user_id' => intval($user_id)));
        }
        if ($browser !== null) {
            self::$db->cond_and(array('browser' => $browser));
        }
        return self::$db->secure()->fetchAll();
    }

    /**
     * Обновление сессии в базе
     * @param $id
     * @param $data
     * @return string
     */
    static function update($id, $data)
    {
        if (!self::$db) return false;
        return self::$db->upd('sessions', $data, array('session_id' => intval($id)));
    }

    /**
     * Добавление сессии в базе
     * @param $data
     * @return string
     */
    static function insert($data)
    {
        if (!self::$db) return false;
        return self::$db->add('sessions', $data);
    }

    /**
     * Удаление сессии из базы
     * @param $session_id
     * @return string
     */
    static function delete($session_id)
    {
        if (!self::$db) return false;
        return self::$db->del('sessions', array('session_id' => intval($session_id)));
    }





}
