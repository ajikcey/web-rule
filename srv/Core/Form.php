<?php

Class Srv_Core_Form
{
    /**
     * @var string
     */
    private $cur_index = '';
    /**
     * @var array
     */
    private $data = array();
    /**
     * @var array
     */
    public $errors = array();

    /**
     * Устанаваливет ошибку для текущего индекса
     * @param $msg
     * @throws Srv_Exception_Data
     */
    private function set_error($msg)
    {
        throw new Srv_Exception_Data($msg);
    }

    /**
     * @param $field
     * @return $this
     */
    public function post($field)
    {
        $this->data[$field] = isset($_POST[$field]) ? $_POST[$field] : null;
        $this->cur_index = $field;
        return $this;
    }

    /**
     * @param $field
     * @return $this
     */
    public function get($field)
    {
        $this->data[$field] = isset($_GET[$field]) ? $_GET[$field] : null;
        $this->cur_index = $field;
        return $this;
    }

    /**
     * @param $field
     * @param $data
     * @return $this
     */
    public function set($field, $data)
    {
        $this->data[$field] = $data;
        $this->cur_index = $field;
        return $this;
    }

    /**
     * Получение данных
     * @param null $key
     * @return array|mixed
     */
    public function fetch($key = null)
    {
        if ($key) {
            return $this->data[$key];
        }
        return $this->data;
    }

    /**
     * @param null $allowable_tags
     * @param int $quote_style
     * @param null $char_list
     * @return $this
     */
    public function secure($allowable_tags = null, $quote_style = ENT_QUOTES, $char_list = null)
    {
        return $this->strip_tags($allowable_tags)->entities($quote_style)->trim($char_list);
    }

    /**
     * @param null $base
     * @return $this
     */
    public function int($base = null)
    {
        $this->data[$this->cur_index] = intval($this->data[$this->cur_index], $base);
        return $this;
    }

    /**
     * @return $this
     */
    public function array_map_int()
    {
        if (is_array($this->data[$this->cur_index])) {
            $this->data[$this->cur_index] = array_map('intval', $this->data[$this->cur_index]);
        } else {
            $this->data[$this->cur_index] = array();
        }
        return $this;
    }

    /**
     * @param int $quote_style
     * @return $this
     */
    public function entities($quote_style = ENT_QUOTES)
    {
        if (is_array($this->data[$this->cur_index])) {
            foreach ($this->data[$this->cur_index] as $key => $value) {
                $this->data[$this->cur_index][$key] = htmlentities($value, $quote_style, 'UTF-8');
            }
        } else {
            $this->data[$this->cur_index] = htmlentities($this->data[$this->cur_index], $quote_style, 'UTF-8');
        }
        return $this;
    }

    /**
     * @param null $allowable_tags
     * @return $this
     */
    public function strip_tags($allowable_tags = null)
    {
        if (is_array($this->data[$this->cur_index])) {
            foreach ($this->data[$this->cur_index] as $key => $value) {
                $this->data[$this->cur_index][$key] = strip_tags($value, $allowable_tags);
            }
        } else {
            $this->data[$this->cur_index] = strip_tags($this->data[$this->cur_index], $allowable_tags);
        }
        return $this;
    }

    /**
     * @param int $flags
     * @return $this
     */
    public function special_chars($flags = ENT_COMPAT)
    {
        $this->data[$this->cur_index] = htmlspecialchars($this->data[$this->cur_index], $flags);
        return $this;
    }

    /**
     * @param string $char_list
     * @return $this
     */
    public function trim($char_list = null)
    {
        if (is_array($this->data[$this->cur_index])) {
            foreach ($this->data[$this->cur_index] as $key => $value) {
                if ($char_list) {
                    $this->data[$this->cur_index][$key] = trim($value, $char_list);
                } else {
                    $this->data[$this->cur_index][$key] = trim($value);
                }
            }
        } else {
            if ($char_list) {
                $this->data[$this->cur_index] = trim($this->data[$this->cur_index], $char_list);
            } else {
                $this->data[$this->cur_index] = trim($this->data[$this->cur_index]);
            }
        }
        return $this;
    }

    /**
     * @param string $encoding
     * @return $this
     */
    public function strtolower($encoding = 'UTF-8')
    {
        $this->data[$this->cur_index] = mb_strtolower($this->data[$this->cur_index], $encoding);
        return $this;
    }

    /**
     * @param string $encoding
     * @return $this
     */
    public function ucfirst($encoding = 'UTF-8')
    {
        $this->strtolower();
        $this->data[$this->cur_index] = mb_convert_case($this->data[$this->cur_index], MB_CASE_TITLE, $encoding);
        return $this;
    }

    /**
     * @param int $filter
     * @param string $msg
     * @return $this
     */
    public function filter_validate($filter = FILTER_DEFAULT, $msg)
    {
        if (filter_var($this->data[$this->cur_index], $filter) === false) {
            $this->set_error($msg);
        }
        return $this;
    }

    /**
     * @param int $filter
     * @return $this
     */
    public function filter_sanitize($filter = FILTER_DEFAULT)
    {
        $this->data[$this->cur_index] = filter_var($this->data[$this->cur_index], $filter);
        return $this;
    }

    /**
     * @param string $pattern
     * @param string $msg
     * @return $this
     */
    public function preg_match($pattern, $msg)
    {
        if (!preg_match($pattern, $this->data[$this->cur_index])) {
            $this->set_error($msg);
        }
        return $this;
    }

    /**
     * @param string $pattern
     * @param string $replacement
     * @return $this
     */
    public function preg_replace($pattern, $replacement)
    {
        $this->data[$this->cur_index] = preg_replace($pattern, $replacement, $this->data[$this->cur_index]);
        return $this;
    }

    /**
     * @param int $arg
     * @param string $msg
     * @return $this
     */
    public function min_length($arg, $msg)
    {
        if (mb_strlen($this->data[$this->cur_index], 'UTF-8') < $arg) {
            $this->set_error($msg);
        }
        return $this;
    }

    /**
     * Проверка непустой строки
     * @param string $msg
     * @return $this
     */
    public function empty_str($msg)
    {
        $this->min_length(1, $msg);
        return $this;
    }

    /**
     * @param int $arg
     * @param string $msg
     * @return $this
     */
    public function max_length($arg, $msg)
    {
        if (mb_strlen($this->data[$this->cur_index], 'UTF-8') > $arg) {
            $this->set_error($msg);
        }
        return $this;
    }

    /**
     * @param $arg1
     * @param $msg1
     * @param $arg2
     * @param $msg2
     * @return $this
     */
    public function interval_length($arg1, $msg1, $arg2, $msg2)
    {
        return $this->min_length($arg1, $msg1)->max_length($arg2, $msg2);
    }

    /**
     * Проверка, является ли данное целым числом
     * @param string $msg
     * @return $this
     */
    public function is_int($msg)
    {
        if (ctype_digit($this->data[$this->cur_index]) == false) {
            $this->set_error($msg);
        }
        return $this;
    }

    /**
     * Проверка, является ли данное действительным числом
     * Пропускает действительные числа (в том числе целые)
     * Предварительно запятая заменяется на точку
     * @param string $msg
     * @return $this
     */
    public function is_float($msg)
    {
        $this->preg_replace('/,/', '.');
        if (is_numeric($this->data[$this->cur_index]) == false) {
            $this->set_error($msg);
        }
        return $this;
    }

    /**
     * @param string $msg
     * @return $this
     */
    public function email($msg)
    {
        if ($this->data[$this->cur_index]) {
            $this->strtolower()->filter_validate(FILTER_VALIDATE_EMAIL, $msg);
        }
        return $this;
    }

    /**
     * @param string $msg
     * @return $this
     */
    public function phone($msg)
    {
        if ($this->data[$this->cur_index]) {
            $this->preg_replace('/(\D)/', '')->preg_match('/^\d{4,15}$/i', $msg);
        }
        return $this;
    }

}