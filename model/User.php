<?php

Class Model_User extends Srv_Core_Model
{
    static function get($user_id = null, $del = null, $pass = null, $email = null, $phone = null)
    {
        if (!self::$db) return false;
        self::$db->select('users')->where(1);
        if ($user_id !== null) {
            self::$db->cond_and(array('user_id' => intval($user_id)));
        }
        if ($del !== null) {
            self::$db->cond_and(array('del' => intval($del)));
        }
        if ($pass !== null) {
            self::$db->cond_and(array('pass' => $pass));
        }
        if ($email !== null) {
            self::$db->cond_and(array('email' => $email));
        }
        if ($phone !== null) {
            self::$db->cond_and(array('phone' => $phone));
        }
        return self::$db->secure()->fetch();
    }

    static function getAll()
    {
        if (!self::$db) return false;
        self::$db->select('users')->where(1);
        return self::$db->secure()->fetchAll();
    }

    static function search($params = array(), $offset = 0, $rows = PHP_INT_MAX)
    {
        if (!self::$db) return false;
        self::$db->select(array('users'), "SQL_CALC_FOUND_ROWS *")->where(1);
        if (isset($params['search']) && $params['search'] != '') {
            self::$db->cond_and();
            self::$db->begin_br();
            $s = $params['search'];
            self::$db->cond(array('`users`.`email`' => "%$s%"), null, "LIKE");
            self::$db->cond_or(array('`users`.`phone`' => "%$s%", '`users`.`first_name`' => "%$s%",
                '`users`.`last_name`' => "%$s%", '`users`.`middle_name`' => "%$s%",
                '`users`.`full_name`' => "%$s%", '`users`.`first_last_name`' => "%$s%"), "LIKE");

            self::$db->end_br();
        }
        if (isset($params['email_confirm']) && ctype_digit($params['email_confirm'])) {
            self::$db->cond_and(array('`users`.`email_confirm`' => intval($params['email_confirm'])));
        }
        if (isset($params['del']) && ctype_digit($params['del'])) {
            self::$db->cond_and(array('`users`.`del`' => intval($params['del'])));
        }
        if (isset($params['phone_confirm']) && ctype_digit($params['phone_confirm'])) {
            self::$db->cond_and(array('`users`.`phone_confirm`' => intval($params['phone_confirm'])));
        }
        if (isset($params['groups']) && is_array($params['groups']) && $params['groups']) {
            self::$db->cond_and("EXISTS");
            self::$db->begin_br();
            self::$db->select(array('group2user'), "*");
            self::$db->where("`users`.`user_id`=`group2user`.`user_id`");
            self::$db->cond_and(array('`group2user`.`group_id`' => $params['groups']), "IN");
            self::$db->end_br();
        }
        $items = self::$db->limit($rows, $offset)->secure()->fetchAll();
        $count = self::$db->select(null, "FOUND_ROWS()")->fetchAll();
        return array('items' => $items, 'count' => reset($count[0]));
    }

    static function update($id, $data)
    {
        if (!self::$db) return false;
        return self::$db->upd('users', $data, array('user_id' => intval($id)));
    }

    static function insert($data)
    {
        if (!self::$db) return false;
        return self::$db->add('users', $data);
    }


}
