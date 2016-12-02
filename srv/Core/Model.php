<?php

/**
 * Class Srv_Core_Model
 * Модели необходимы для работа с БД:
 * получение, изменение, добавление и удаление данных
 */
Class Srv_Core_Model
{
    /**
     * @var Srv_Core_Database
     */
    public static $db;

    static function init()
    {
        self::connect(Srv_Core_Boot::getDb());
    }

    /**
     * @param $config array
     */
    static function connect($config)
    {
        try {
            self::$db = new Srv_Core_Database($config['dsn'], $config['username'], $config['pass'], $config['options']);
        } catch (Srv_Exception_Db $e) {
            // Service Unavailable
            $e->handle();
        }
    }

}

