<?php

Class Srv_Session
{
    /**
     * Подпись зависит от идентификатора сессии, идентификатора пользователя, пароля пользователя (при смене пароля надо обновлять подпись),
     * блокировки пользователя (заблокированный пользователь не сможет пройти авторизацию со старой подписью),
     * браузера пользователя и случайного ключа сессии,
     * который меняется каждый раз при обновлении страницы
     * @param $session_id
     * @param $user_id
     * @param $user_pass
     * @param $browser
     * @param $session_key
     * @return string
     */
    private static function gen_hash($session_id, $user_id, $user_pass, $browser, $session_key)
    {
        return sha1(md5(md5($session_id . $user_id) . $user_pass) . $browser . $session_key);
    }

    /**
     * @param $user_id
     * @return bool
     */
    static function addAuth($user_id)
    {
        self::delAuth();
        if ($user = Srv_User::getEnableUser($user_id)) {
            $data = array(
                'user_id' => $user_id,
                'ip' => Srv_User::userIP(),
                'browser' => Srv_User::userBrowser(),
                'date_active' => date("Y-m-d H:i:s"),
                'key' => mt_rand(),
            );
            $session_id = Model_Session::insert($data);
            $hash = self::gen_hash($session_id, $user_id, $user['pass'], $data['browser'], $data['key']);

            self::set_cookie(array(
                'sid' => $session_id,
                'uid' => $user_id,
                'hsid' => $hash,
                'skey' => $data['key'],
            ));
            return true;
        }
        return false;
    }

    /**
     * Logout
     */
    static function delAuth()
    {
        if (isset($_COOKIE['sid'])) {
            Model_Session::delete($_COOKIE['sid']);
        }
        self::del_cookie(array('sid', 'uid', 'hsid', 'skey'));
    }

    /**
     * @param $session
     * @param $user
     */
    private static function updAuth($session, &$user)
    {
        $new_session = array(
            'key' => mt_rand(),
            'date_active' => date("Y-m-d H:i:s")
        );

        Model_Session::update($session['session_id'], $new_session);
        self::set_cookie(array(
            'skey' => $new_session['key'],
            'hsid' => self::gen_hash($session['session_id'], $session['user_id'], $user['pass'], $session['browser'], $new_session['key'])
        ));

        $user['date_active'] = $new_session['date_active'];
        Model_User::update($user['user_id'], array('date_active' => $user['date_active']));
    }

    /**
     * В куках находятся:
     * session_id, user_id, session_hash
     * session_key - ключ, обновляется каждый раз при getAuthUser
     * Дополнительно берется информация о браузере
     * @return mixed|null
     */
    static function getAuthUser()
    {
        if (isset($_COOKIE['sid']) && $_COOKIE['sid'] && isset($_COOKIE['uid']) && $_COOKIE['uid'] && isset($_COOKIE['hsid']) && $_COOKIE['hsid'] && isset($_COOKIE['skey']) && $_COOKIE['skey']) {
            $browser = Srv_User::userBrowser();
            $session = Model_Session::get($_COOKIE['sid'], $_COOKIE['uid'], $browser);
            $user = Srv_User::getEnableUser($session['user_id']);

            if ($_COOKIE['hsid'] == self::gen_hash($session['session_id'], $session['user_id'], $user['pass'], $session['browser'], $_COOKIE['skey'])) {
                if (time() - strtotime($user['date_active']) > AUTH_TIME) {
                    self::updAuth($session, $user);
                }
                return $user;
            } else {
                self::delAuth();
            }
        }
        return false;
    }

    /**
     * Установка куков
     * @param $data array
     */
    static function set_cookie($data)
    {
        foreach ($data as $key => $value) {
            setcookie($key, $value, time() + COOKIE_TIME, '/');
        }
    }

    /**
     * Удаление куков
     * @param $data array
     */
    static function del_cookie($data)
    {
        foreach ($data as $value) {
            setcookie($value, "", time() - 3600, '/');
        }
    }


}
