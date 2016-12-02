<?php

Class Srv_Exception_Db extends Srv_Exception_Base
{
    function handle()
    {
        Srv_Page::init(Srv_Core_Boot::getHandler(503));
//        parent::handle();
        die();
    }
}
