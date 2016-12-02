<?php

Class Srv_Exception_Base extends Exception
{
    function __construct($message = '', $code = 0) {
        parent::__construct($message, 0);
    }

    /**
     * Отправка сообщения о критическом исключении
     * @throws Exception
     */
    function handle()
    {
        throw new Exception($this->getMessage(), 0, $this);
    }
}