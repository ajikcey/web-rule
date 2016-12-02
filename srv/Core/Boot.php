<?php

/**
 * Class Srv_Core_Boot
 */
Class Srv_Core_Boot
{
    /**
     * @var null
     */
    private static $config = null;

    /**
     * Инициализация сайта
     * @param $config array
     */
    static function init($config)
    {
        session_start();

        error_reporting(E_ALL);
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        set_error_handler("Srv_Core_Error::handler");
        set_exception_handler("Srv_Core_Exception::handler");

        self::$config = $config;
        Srv_Core_Controller::init();
    }

    /**
     * Получение страницы по ключу из списка доступных
     * @param $key
     * @return mixed
     */
    static function getHandler($key)
    {
        return self::$config['urls'][$key];
    }

    /**
     * Получение настроек БД
     * @return mixed
     */
    static function getDb()
    {
        return self::$config['db'];
    }

    static function getName()
    {
        return self::$config['name'];
    }
}