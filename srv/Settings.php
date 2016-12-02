<?php

class Srv_Settings
{
    static function getList()
    {
        $result = array();
        $list = Model_Settings::getAll();
        foreach ($list as $value) {
            $result[$value['key']] = $value['value'];
        }
        return $result;
    }

    private static function getItem($key)
    {
        if ($r = Model_Settings::get($key)) {
            return $r['value'];
        }
        return false;
    }

    static function getName()
    {
        return self::getItem('name');
    }

    static function getEmail()
    {
        return self::getItem('email');
    }

    static function getAuthor()
    {
        return self::getItem('author');
    }

    static function getYear_foundation()
    {
        return self::getItem('year_foundation');
    }

    static function getCopyright()
    {
        return "&copy; " . Srv_Settings::getAuthor() . ", " . Srv_Settings::getYear_foundation();
    }

    static function check()
    {
        $form = new Srv_Core_Form();
        $data = $form->post('name')->trim()->empty_str("Введите название | name")->max_length(255, "Название не может быть больше 255 символов | name")
            ->post('author')->trim()->max_length(255, "Имени (наименования) правообладателя не может быть больше 255 символов | author")
            ->post('year_foundation')->int()
            ->post('email')->email("Введите корректный E-mail | email")
            ->post('image')->trim()
            ->post('fb_id')->int()
            ->fetch();
        return $data;
    }

    static function update($data)
    {
        foreach ($data as $key => $value) {
            Model_Settings::update($key, $value);
        }
    }
}