<?php

Class Srv_Core_File
{
    /**
     * @var string
     */
    private $index = 0;
    /**
     * @var string
     */
    private $key = '';
    /**
     * @var array
     */
    private $data = array();

    function post($key)
    {
        if (is_array($_FILES[$key]['name'])) {
            foreach ($_FILES[$key]['name'] as $key => $value) {
                $this->data[$key][] = array(
                    'name' => $_FILES[$key]['name'][$key],
                    'type' => $_FILES[$key]['type'][$key],
                    'tmp_name' => $_FILES[$key]['tmp_name'][$key],
                    'error' => $_FILES[$key]['error'][$key],
                    'size' => $_FILES[$key]['size'][$key],
                );
            }
        } else {
            $this->data[$key][] = array(
                'name' => $_FILES[$key]['name'],
                'type' => $_FILES[$key]['type'],
                'tmp_name' => $_FILES[$key]['tmp_name'],
                'error' => $_FILES[$key]['error'],
                'size' => $_FILES[$key]['size'],
            );
        }
        $this->key = $key;
        return $this;
    }

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
     * @param $key
     * @return $this
     */
    function set_key($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @param $key
     * @return array|bool|mixed
     * @throws Srv_Exception_Data
     */
    function fetch($key = null)
    {
        if ($key) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            } else {
                self::set_error("Not found data: " . $key . " in " . __FILE__ . " on line " . __LINE__);
            }
        } else {
            return $this->data;
        }
        return false;
    }

    /**
     * Определение изображения функцией определения типа изображений
     * @param null $allow_types
     * @param $msg
     * @return $this
     * @throws Srv_Exception_Data
     */
    function is_image($allow_types = null, $msg)
    {
        if ($allow_types) {
            if (is_array($allow_types)) {
                if (!in_array(exif_imagetype($this->data[$this->key][$this->index]['tmp_name']), $allow_types)) {
                    $this->set_error($msg);
                }
            } elseif (exif_imagetype($this->data[$this->key][$this->index]['tmp_name']) != $allow_types) {
                $this->set_error($msg);
            }
        } elseif (!exif_imagetype($this->data[$this->key][$this->index]['tmp_name'])) {
            $this->set_error($msg);
        }
        return $this;
    }

    function is_exist($key, $msg)
    {
        if (!isset($this->data[$key])) {
            $this->set_error($msg);
        }
        return $this;
    }

    function is_min_size($width, $height, $msg)
    {
        if ($this->get_width() < $width || $this->get_height() < $height) {
            $this->set_error($msg);
        }
        return $this;
    }

    function get_width()
    {
        $data = getimagesize($this->data[$this->key][$this->index]['tmp_name']);
        return $data[0];
    }

    function get_height()
    {
        $data = getimagesize($this->data[$this->key][$this->index]['tmp_name']);
        return $data[1];
    }

    function image_type_to_extension($include_dot = true)
    {
        return image_type_to_extension(exif_imagetype($this->data[$this->key][$this->index]['tmp_name']), $include_dot);
    }

    function generate_filename($path)
    {
        $filename = sha1_file($this->data[$this->key][$this->index]['tmp_name']) . $this->image_type_to_extension();
        $file = $_SERVER["DOCUMENT_ROOT"] . $path . $filename;

        while (file_exists($file)) {
            $filename = sha1(rand()) . $this->image_type_to_extension();
            $file = $_SERVER["DOCUMENT_ROOT"] . $path . $filename;
        }
        $this->data[$this->key][$this->index]['filename'] = $filename;
        return $this;
    }

    function move_uploaded_file($path, $msg)
    {
        $this->generate_filename($path);

        if (!move_uploaded_file($this->data[$this->key][$this->index]['tmp_name'],
            $_SERVER["DOCUMENT_ROOT"] . $path . $this->data[$this->key][$this->index]['filename'])
        ) {
            $this->set_error($msg);
        }
        return $this;
    }


    static function delete($filename)
    {
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . $filename)) {
            @unlink($_SERVER["DOCUMENT_ROOT"] . $filename);
        }
    }
}