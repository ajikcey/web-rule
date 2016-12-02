<?php

Class Srv_Core_View
{
    private $view = null;
    private $layout = null;
    private $arr_plugin_css = array();
    private $arr_plugin_js = array();
    private $arr_ext_plugin_css = array();
    private $arr_ext_plugin_js = array();
    private $arr_css = array();
    private $arr_js = array();

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    function set($name, $value)
    {
        $this->{$name} = $value;
        return $this;
    }

    /**
     * Воспроизведение шаблона (если задано)
     * или представления
     * @param $name
     * @return $this
     */
    function render($name)
    {
        $this->setView($name);
        if ($this->layout) {
            $this->render_layout();
        } else {
            $this->render_view();
        }
        return $this;
    }

    /**
     * Воспроизведение представления
     * @return Srv_Core_View
     */
    private function render_view()
    {
        return $this->req(VIEW_DIR . $this->view);
    }

    /**
     * Воспроизведение шаблона
     * @return Srv_Core_View
     */
    private function render_layout()
    {
        return $this->req(LAYOUT_DIR . $this->layout);
    }

    /**
     * Подключение файла
     * @param $path
     * @return $this
     */
    private function req($path)
    {
        require ($_SERVER["DOCUMENT_ROOT"] . DS . $path . PHP_EXT);
        return $this;
    }

    /**
     * Установка шаблона
     * @param $layout
     * @return $this
     */
    function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Установка представления
     * @param $view
     * @return $this
     */
    function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Получение имен js файлов плагинов
     * @return array
     */
    function getPluginJs()
    {
        return $this->arr_plugin_js;
    }

    /**
     * Добавление в набор js файлов плагинов
     * @param $value
     * @return $this
     */
    function pushPluginJs($value)
    {
        $this->arr_plugin_js[] = $value;
        return $this;
    }

    /**
     * Получение имен js файлов внешних плагинов
     * @return array
     */
    function getExtPluginJs()
    {
        return $this->arr_ext_plugin_js;
    }

    /**
     * Добавление в набор js файлов внешних плагинов
     * @param $value
     * @return $this
     */
    function pushExtPluginJs($value)
    {
        $this->arr_ext_plugin_js[] = $value;
        return $this;
    }

    /**
     * Получение имен css файлов плагинов
     * @return array
     */
    function getPluginCss()
    {
        return $this->arr_plugin_css;
    }

    /**
     * Добавление в набор css файлов плагинов
     * @param $value
     * @return $this
     */
    function pushPluginCss($value)
    {
        $this->arr_plugin_css[] = $value;
        return $this;
    }

    /**
     * Получение имен css файлов внешних плагинов
     * @return array
     */
    function getExtPluginCss()
    {
        return $this->arr_ext_plugin_css;
    }

    /**
     * Добавление в набор css файлов внешних плагинов
     * @param $value
     * @return $this
     */
    function pushExtPluginCss($value)
    {
        $this->arr_ext_plugin_css[] = $value;
        return $this;
    }

    /**
     * Получение имен css файлов
     * @return array
     */
    function getCss()
    {
        return $this->arr_css;
    }

    /**
     * Добавление в набор css файлов
     * @param $value
     * @return $this
     */
    function pushCss($value)
    {
        $this->arr_css[] = $value;
        return $this;
    }

    /**
     * Получение имен js файлов
     * @return array
     */
    function getJs()
    {
        return $this->arr_js;
    }

    /**
     * Добавление в набор js файлов
     * @param $value
     * @return $this
     */
    function pushScript($value)
    {
        $this->arr_js[] = $value;
        return $this;
    }

    /**
     * Для отладки
     * @return $this
     */
    function getCur()
    {
        return $this;
    }
}
