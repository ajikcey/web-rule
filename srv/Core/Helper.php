<?php

/**
 * Class Srv_Core_Helper
 */
class Srv_Core_Helper
{
    static function json($value)
    {
        echo json_encode($value);
    }

    static function getList($array, $key)
    {
        $list = array();
        foreach ($array as $value) {
            $list[] = $value[$key];
        }
        return $list;
    }
}