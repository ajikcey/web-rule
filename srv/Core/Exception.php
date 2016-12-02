<?php

Class Srv_Core_Exception
{
    /**
     * Обработка необработанных исключений
     * Если display_errors=1 - показывать на экране
     * Если display_errors=0 - записывать лог
     * Если при этом лог не записался, все равно вывести на экран
     * @param $e Exception
     */
    static function handler($e)
    {
        $displayErrors = ini_get("display_errors");
        $displayErrors = strtolower($displayErrors);
        // Возвращает TRUE для значений "1", "true", "on" и "yes". Иначе возвращает FALSE.
        if (filter_var($displayErrors, FILTER_VALIDATE_BOOLEAN)) {
            self::display($e);
        } else {
            if (!self::fileLog("Информация об исключении:\r\n" . $e->getMessage())) {
                self::display($e);
            }
        }
        die();
    }

    /**
     * @param $logData
     * @return bool
     */
    private static function fileLog($logData)
    {
        $fileName = $_SERVER["DOCUMENT_ROOT"] . '/log/exceptions/' . date("Y-m-d-H_i_s") . LOG_EXT;
        $fh = fopen($fileName, 'a+');
        if (is_array($logData)) {
            $logData = print_r($logData, 1);
        }
        $status = fwrite($fh, $logData);
        fclose($fh);
        return ($status) ? true : false;
    }

    /**
     * @param $e Exception
     */
    private static function display($e)
    {
        echo "Информация об исключении:<br>" . $e->getMessage();
    }
}