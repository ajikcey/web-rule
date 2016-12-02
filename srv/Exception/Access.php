<?php

Class Srv_Exception_Access extends Srv_Exception_Base
{
    function handle()
    {
        Srv_Page::init(Srv_Core_Boot::getHandler(403));
        parent::handle();
    }
}