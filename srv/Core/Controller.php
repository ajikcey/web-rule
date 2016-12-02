<?php

/**
 * Class Srv_Core_Controller
 * Контроллеры управляют данными, связывают модели с представлением,
 * передают данные из БД в представление и обратно
 */
Class Srv_Core_Controller
{
    /**
     * @var Srv_Core_View
     */
    public static $view;

    /**
     * Инициалиация контроллера
     */
    static function init()
    {
        self::$view = new Srv_Core_View();
        Srv_Core_Model::init();
        Srv_User::init();
        Srv_Page::init();
    }
}

