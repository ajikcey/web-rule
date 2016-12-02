<?php

/**
 * Class Srv_Webnotice
 */
class Srv_Webnotice
{
    static function getNews()
    {
        return Model_Webnotice::getAll(0, Srv_User::getCurrentId(), 0);
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
}