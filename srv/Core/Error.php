<?php

class Srv_Core_Error
{
    const FATAL_ERROR = 0;
    const WARNING = 1;
    const NOTICE = 2;
    const STRICT = 3;
    const DEPRECATED = 4;
    const UNDEFINED_ERROR = 5;

    const ERRORS = array('Fatal Error', 'Warning', 'Notice', 'Strict', 'Deprecated', 'Undefined Error');

    /**
     * Обработчик ошибок
     * @param $code
     * @param $description
     * @param null $file
     * @param null $line
     * @param null $context
     * @return bool
     */
    static function handler($code, $description, $file = null, $line = null, $context = null)
    {
        $error = self::mapErrorCode($code);
        $text = self::ERRORS[$error] . ": $description in $file on line $line";
        Srv_Notice::error($text);
        if ($error == self::FATAL_ERROR) {
            die();
        }
        return false;
    }

    /**
     * @param $code
     * @return int|null
     */
    static function mapErrorCode($code)
    {
        $error = null;
        switch ($code) {
            case E_PARSE:
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                $error = self::FATAL_ERROR;
                break;
            case E_WARNING:
            case E_USER_WARNING:
            case E_COMPILE_WARNING:
            case E_RECOVERABLE_ERROR:
                $error = self::WARNING;
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
                $error = self::NOTICE;
                break;
            case E_STRICT:
                $error = self::STRICT;
                break;
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                $error = self::DEPRECATED;
                break;
            default :
                $error = self::UNDEFINED_ERROR;
                break;
        }
        return $error;
    }

    /**
     * @param $data
     * @return bool
     */
    private static function fileLog($data)
    {
        $fileName = $_SERVER["DOCUMENT_ROOT"] . '/log/errors/' . date("Y-m-d-H_i_s") . LOG_EXT;
        $fh = fopen($fileName, 'a+');
        $status = fwrite($fh, $data);
        fclose($fh);
        return ($status) ? true : false;
    }


}