<?php

Class Srv_Core_Pagination extends Srv_Core_View
{
    /**
     * Items per page
     * @var int
     */
    public $items = 10;
    /**
     * Count All Items
     * @var int
     */
    private $count = 0;
    /**
     * @var array
     */
    public $params = array();
    /**
     * @var string
     */
    public $key = 'page';
    /**
     * @var integer
     */
    public $pages = 0;
    /**
     * @var integer
     */
    public $first = 1;
    /**
     * @var integer
     */
    public $cur = 0;
    /**
     * @var integer
     */
    public $together = 4;

    public function __construct($items = null)
    {
        if ($items != null) {
            $this->setItems($items);
        }
    }

    public function setItems($items)
    {
        $this->items = intval($items);
    }
    
    public function setCount($count)
    {
        $this->count = intval($count);
        $this->calcPages();
    }

    public function setParams($params)
    {
        if (isset($params[$this->key])) {
            $this->cur = $params[$this->key];
            if ($this->pages) {
                $this->cur = min($this->cur, $this->pages);
            }
            unset($params[$this->key]);
        }
        $this->params = $params;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function calcPages()
    {
        if (!$this->items) $this->pages = 0;
        if (!$this->count) $this->pages = 0;
        $this->pages = ceil($this->count / $this->items);
    }
}