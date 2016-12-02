<?php

/**
 * Class Srv_User
 */
class Srv_User
{
    /**
     * @var array
     */
    private static $current = false;
    /**
     * @var array
     */
    public static $avatar_paths = array(
        'big' => '/files/avatars/big/',
        'middle' => '/files/avatars/middle/',
        'small' => '/files/avatars/small/',
        'original' => '/files/avatars/original/'
    );

    /**
     * Инициализация сервиса
     */
    static function init()
    {
        self::$current = Srv_Session::getAuthUser();
        Srv_Group::init();
    }

    /**
     * @param $user_id
     * @return mixed
     */
    static function getEnableUser($user_id)
    {
        return Model_User::get($user_id, 0);
    }

    static function getUser2email($email)
    {
        return Model_User::get(null, null, null, $email);
    }

    static function getUser2phone($phone)
    {
        return Model_User::get(null, null, null, null, $phone);
    }

    static function getUser2email_pass($email, $pass)
    {
        return Model_User::get(null, null, $pass, $email);
    }

    /**
     * @param $pass
     * @return string
     */
    static function gen_hash_pass($pass)
    {
        return sha1(md5($pass) . "12f&*9g");
    }

    static function check_login()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->post('email')->trim()->empty_str("Введите E-mail | email")->email("Введите корректный E-mail | email")
            ->post('pass')->trim()->empty_str("Введите пароль | pass")
            ->fetch();
        return $data;
    }

    static function check_reg()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->post('first_name')->trim()->empty_str("Введите Ваше имя | first_name")->max_length(255, "Имя не может быть больше 255 символов | first_name")->ucfirst()
            ->post('last_name')->trim()->empty_str("Введите Вашу фамилию | last_name")->max_length(255, "Фамилия не может быть больше 255 символов | last_name")->ucfirst()
            ->post('email')->trim()->empty_str("Введите E-mail | email")->email("Введите корректный E-mail | email")
            ->post('pass')->empty_str("Введите пароль | pass")->interval_length(6, "Пароль не может быть меньше 6 символов | pass", 255, "Пароль не может быть больше 255 символов | pass")
            ->post('group_id')->array_map_int()
            ->fetch();

        $groups = $data['group_id'];
        unset($data['group_id']);
        return array($data, $groups);
    }

    static function check_email()
    {
        $form = new Srv_Core_Form();
        $data = $form->post('email')->trim()->empty_str("Введите E-mail | email")->email("Введите корректный E-mail | email")
            ->fetch();
        return $data;
    }

    static function check_post_new_pass()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->post('user_id')->int()
            ->post('time')->int()
            ->post('hash')->trim()
            ->post('pass')
            ->empty_str("Введите пароль | pass")
            ->interval_length(6, "Пароль не может быть меньше 6 символов | pass", 255, "Пароль не может быть больше 255 символов | pass")
            ->fetch();
        return $data;
    }

    static function userIP()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'])
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'])
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED'])
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR'])
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED'])
            $ip = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'])
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = 'UNKNOWN';
        return $ip;
    }

    static function userBrowser()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    static function getCurrent()
    {
        return self::$current;
    }

    static function getCurrentEmailConfirm()
    {
        return (isset(self::$current['email_confirm']) ? self::$current['email_confirm'] : false);
    }

    static function getCurrentId()
    {
        return (isset(self::$current['user_id']) ? self::$current['user_id'] : false);
    }

    static function getCurrentEmail()
    {
        return (isset(self::$current['email']) ? self::$current['email'] : false);
    }

    static function getCurrentName()
    {
        return (isset(self::$current['first_name']) ? self::$current['first_name'] : false);
    }

    static function check()
    {
        $form = new Srv_Core_Form();
        $form
            ->post('first_name')->trim()->empty_str("Введите Ваше имя | first_name")->max_length(255, "Имя не может быть больше 255 символов | first_name")->ucfirst()
            ->post('last_name')->trim()->empty_str("Введите Вашу фамилию | last_name")->max_length(255, "Фамилия не может быть больше 255 символов | last_name")->ucfirst()
            ->post('middle_name')->trim()->max_length(255, "Отчество не может быть больше 255 символов | middle_name")->ucfirst()
            ->post('email')->trim()->empty_str("Введите E-mail | email")->email("Введите корректный E-mail | email")
            ->post('phone')->trim()->phone("Введите корректный телефон | phone")
            ->post('avatar')->trim()
            ->post('avatar_x')->int()
            ->post('avatar_y')->int()
            ->post('avatar_w')->int()
            ->post('avatar_h')->int()
            ->post('email_confirm')->int()
            ->post('phone_confirm')->int()
            ->post('group_id')->array_map_int();

        $data = array(
            $form->fetch(),
            $form->fetch('group_id')
        );
        unset($data[0]['group_id']);
        return $data;
    }

    static function check_thumbnail()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->post('filename')->trim()
            ->post('coord')->array_map_int()
            ->fetch();
        return $data;
    }

    static function check_pass()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->post('pass')
            ->empty_str("Введите пароль | pass")
            ->min_length(6, "Пароль не может быть меньше 6 символов | pass")
            ->max_length(255, "Пароль не может быть больше 255 символов | pass")
            ->fetch();
        return $data;
    }

    static function check_search()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->get('search')->trim()->secure()
            ->get('page')
            ->get('items')
            ->get('del')
            ->get('email_confirm')
            ->get('phone_confirm')
            ->get('groups')->array_map_int()
            ->secure()->fetch();
        return $data;
    }

    static function del_avatar($avatar)
    {
        if ($avatar) {
            foreach (Srv_User::$avatar_paths as $value) {
                Srv_Core_File::delete($value . $avatar);
            }
        }
    }
}






















