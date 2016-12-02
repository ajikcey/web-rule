<?php

/**
 * Class Srv_Notice
 */
class Srv_Notice
{
    /**
     * @var array
     */
    private static $types = array('Не выбрано', 'E-mail', 'Web');
    /**
     * @var array
     */
    private static $events = array('Не выбрано', 'Регистрация', 'Восстановление пароля', 'Ошибка', 'Исключение');

    static function getTypes()
    {
        return self::$types;
    }

    static function getEvents()
    {
        return self::$events;
    }

    static function getRegNotices()
    {
        return Model_Notice::getAll(0, 1);
    }

    static function getPassRecoveryNotices()
    {
        return Model_Notice::getAll(0, 2);
    }

    static function getErrorNotices()
    {
        return Model_Notice::getAll(0, 3);
    }

    static function getExceptionNotices()
    {
        return Model_Notice::getAll(0, 4);
    }

    static function gen_hash_pass_recovery($user_id, $time, $old_pass)
    {
        return sha1(md5($user_id . $time) . $old_pass . "^&(L[f68%");
    }

    static function gen_hash_email($email)
    {
        return sha1($email . ">4g&fjg%45");
    }

    static function confirmEmail($user_id = null)
    {
        if (intval($user_id)) {
            $user = Srv_User::getEnableUser($user_id);
        } else {
            $user = Srv_User::getCurrent();
        }

        $notices = self::getRegNotices();
        $params = array(
            'link' => implode("/", array(
                Srv_Page::getUrl("site/confirm_email"),
                $user['user_id'],
                self::gen_hash_email($user['email']))),
            'user_name' => $user['first_name']
        );

        self::send($notices, $params, $user);
        return true;
    }

    static function passRecovery($user_id)
    {
        $user = Srv_User::getEnableUser($user_id);
        $notices = self::getPassRecoveryNotices();

        $time = time();
        $params = array(
            'link' => implode("/", array(
                Srv_Page::getUrl("site/new_pass"),
                $user['user_id'],
                $time,
                self::gen_hash_pass_recovery($user['user_id'], $time, $user['pass'])
            )),
            'user_name' => $user['first_name']
        );

        self::send($notices, $params, $user);
        return true;
    }

    /**
     * Отправление уведомлений пользователю,
     * предварительно заменяя переменные в тексте сообщения.
     * @param $notices
     * @param array $replacements
     * @param null $user
     */
    static function send($notices, $replacements = array(), $user = null)
    {
        if (!$user) {
            $user = Srv_User::getCurrent();
        }
        if ($user && is_array($notices)) {
            foreach ($notices as $notice) {

                $notice['text'] = html_entity_decode($notice['text']);

                foreach ($replacements as $key => $param) {
                    $notice['text'] = preg_replace("/%$key%/", $param, $notice['text']);
                }

                switch ($notice['type']) {
                    case 1:
                        if ($user['email']) {
                            $Mail = new Srv_Core_Mail();
                            $Mail->addRecipient($user['email'], $user['first_name'])
                                ->setMessage($notice['subject'], $notice['text'])->send();
                        }
                        break;
                    case 2:
                        if ($user['user_id']) {
                            Model_Webnotice::insert(array(
                                'user_id' => $user['user_id'],
                                'text' => $notice['text']
                            ));
                        }
                        break;
                }
            }
        }
    }

    static function error($text)
    {
        $groups = Srv_Group::getAdminGroups();
        $list = Srv_Core_Helper::getList($groups, 'group_id');
        $users = Model_User::search(array('groups' => $list));

        $params = array(
            'text' => $text
        );

        $notices = self::getErrorNotices();
        foreach ($users['items'] as $user) {
            self::send($notices, $params, $user);
        }
    }

    static function exception($text)
    {
        $groups = Srv_Group::getAdminGroups();
        $list = Srv_Core_Helper::getList($groups, 'group_id');
        $users = Model_User::search(array('groups' => $list));

        $params = array(
            'text' => $text
        );

        $notices = self::getExceptionNotices();

        foreach ($users['items'] as $user) {
            self::send($notices, $params, $user);
        }
    }

    static function check_search()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->get('search')->trim()
            ->get('page')
            ->get('items')
            ->secure()->fetch();
        return $data;
    }

    static function check()
    {
        $form = new Srv_Core_Form();
        $data = $form
            ->post('subject')->trim()->empty_str("Введите заголовок | subject")->max_length(255, "Заголовок не может быть больше 255 символов | subject")
            ->post('text')->trim()
            ->post('type')->int()
            ->post('is_html')->int()
            ->post('event')->int()
            ->fetch();
        return $data;
    }

}