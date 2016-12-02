<?php

Class Srv_Core_Database extends PDO
{
    /**
     * @var string | array
     */
    private $sql = '';
    /**
     * @var array
     */
    private $data = array();
    /**
     * @var int
     */
    private $cur_index = 1;
    /**
     * @var array
     */
    public $last = array();

    /**
     * Database constructor.
     * @param $dsn
     * @param $username
     * @param $pass
     * @param array $options
     * @throws Srv_Exception_Base
     */
    public function __construct($dsn, $username, $pass, $options = array())
    {
        try {
            parent::__construct($dsn, $username, $pass, $options);
        } catch (PDOException $e) {
            throw new Srv_Exception_Db($e);
        }
    }

    /**
     * Set default values
     */
    function clear()
    {
        $this->sql = '';
        $this->data = array();
        $this->cur_index = 1;
    }

    /**
     * @param $value string
     */
    private function add_data($value)
    {
        $this->data[$this->cur_index++] = strval($value);
    }

    /**
     * @return $this
     * @throws Srv_Exception_Base
     */
    function secure()
    {
        $form = new Srv_Core_Form();
        foreach ($this->data as $key => $value) {
            $form->set($key, $value)->secure();
        }
        $this->data = $form->fetch();
        return $this;
    }

    /**
     * @return $this
     * @throws Srv_Exception_Base
     */
    function entities()
    {
        $form = new Srv_Core_Form();
        foreach ($this->data as $key => $value) {
            $form->set($key, $value)->entities();
        }
        $this->data = $form->fetch();
        return $this;
    }

    /**
     * @param string | array $sql
     * @param array $data
     */
    public function set_sql($sql, $data = array())
    {
        $this->sql = $sql;
        $this->data = $data;
    }

    /**
     * @param string | array $sql
     * @param string | array $data
     */
    public function add_sql($sql, $data)
    {
        if (is_array($sql)) {
            foreach ($sql as $value) {
                $this->sql[] = $value;
            }
        } else {
            $this->sql[] = $sql;
        }

        if (is_array($data)) {
            foreach ($data as $value) {
                $this->add_data($value);
            }
        } else {
            $this->add_data($data);
        }
    }

    /**
     * Получение всей выборки текущего запроса
     * @param int $fetchMod
     * @return array
     * @throws Srv_Exception_Data
     */
    public function fetchAll($fetchMod = PDO::FETCH_ASSOC)
    {
        $sth = $this->execute();
//        $sth->debugDumpParams();
        return $sth->fetchAll($fetchMod);
    }

    /**
     * Получение первой записи текущего запроса
     * @param int $fetchMod
     * @return mixed
     * @throws Srv_Exception_Data
     */
    public function fetch($fetchMod = PDO::FETCH_ASSOC)
    {
        $sth = $this->execute();
//        $sth->debugDumpParams();
        return $sth->fetch($fetchMod);
    }

    /**
     * Выполнение текущего запроса
     * @return PDOStatement
     * @throws Srv_Exception_Data
     */
    public function execute()
    {
        if (is_array($this->sql)) {
            $this->sql = implode(" ", $this->sql);
        }

        $sth = $this->prepare($this->sql);
        foreach ($this->data as $key => $value) {
            $sth->bindValue($key, $value, PDO::PARAM_STR);
        }

        $this->last = array(
            'sql' => $this->sql,
            'data' => $this->data,
        );

        $this->clear();
        $success = $sth->execute();
        if (!$success) {
            throw new Srv_Exception_Data($sth->errorInfo()[2] . " " . print_r($this->last, 1));
        }
        return $sth;
    }

    /**
     * Left bracket
     * @return $this
     */
    function begin_br()
    {
        $this->sql[] = "(";
        return $this;
    }

    /**
     * Right bracket
     * @return $this
     */
    function end_br()
    {
        $this->sql[] = ")";
        return $this;
    }

    /**
     * Формирование SELECT
     * Варианты использования:
     * $table = 'users'; = array('users', 'products')
     * $data = 'COUNT(*)'; = array('user_id', 'name', 'pass'); = array(array('user_id', 'name'), array('title', 'price'))
     * = array('*', 'SUM(`orders`.`price`)', '`product`.`title` AS `product_title`')
     * Запросы без таблицы, например: SELECT FOUND_ROWS()
     * @param string | array $table
     * @param string | array $data
     * @return $this
     */
    function select($table = null, $data = "*")
    {
        $this->sql[] = "SELECT";

        $a = array();
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $a[] = ($table[$key] ? "`" . $table[$key] . "`." : "") . $v;
                    }
                } else {
                    $a[] = $value;
                }
            }
        } else {
            $a[] = $data;
        }
        $this->sql[] = implode(", ", $a);
        if ($table) {
            $this->from($table);
        }
        return $this;
    }

    /**
     * @param string | array $table
     * @return $this
     */
    function from($table)
    {
        $this->sql[] = "FROM";

        $a = array();
        if (is_array($table)) {
            foreach ($table as $key => $value) {
                $a[] = "`" . $value . "`";
            }
        } else {
            $a[] = "`" . $table . "`";;
        }
        $this->sql[] = implode(", ", $a);
        return $this;
    }

    /**
     * Формирование WHERE
     * @param array | string $data
     * @param string $exp
     * @return $this
     */
    function where($data = null, $exp = "=")
    {
        $this->sql[] = "WHERE";
        if ($data) {
            if (is_array($data) && count($data) > 1) {
                $first = array(key($data) => current($data));
                array_shift($data);
                $this->cond($first, null, $exp);
                $this->cond($data, "AND", $exp);
            } else {
                $this->cond($data, null, $exp);
            }
        }
        return $this;
    }

    /**
     * Формирование логического выражения (condition)
     * @param array | string $data
     * @param string $logic_exp (AND, OR, NOT)
     * @param string $exp (=,!=,<=,>=,>,<,LIKE)
     * @return $this
     * @throws Srv_Exception_Data
     */
    function cond($data = null, $logic_exp = null, $exp = "=")
    {
        if ($logic_exp) {
            $logic_exp = mb_strtoupper(trim($logic_exp));
            $logic_exp_arr = array("AND", "OR", "NOT");
            if (!in_array($logic_exp, $logic_exp_arr)) {
                throw new Srv_Exception_Data("Logical expression: " . $logic_exp . " not contain in Array (" .
                    implode(",", $logic_exp_arr) . ") in " . __FILE__ . " on line " . __LINE__);
            }
        }

        $exp = mb_strtoupper(trim($exp));
        $exp_arr = array("=", "!=", ">", "<", ">=", "<=", "LIKE", "IN");
        if (!in_array($exp, $exp_arr)) {
            throw new Srv_Exception_Data("Expression: " . $exp . " not contain in Array (" .
                implode(",", $exp_arr) . ") in " . __FILE__ . " on line " . __LINE__);
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if ($logic_exp) {
                    $this->sql[] = $logic_exp;
                }
                if (ctype_digit($key)) {
                    $this->sql[] = $value;
                } elseif ($exp == "IN") {
                    $this->sql[] = "$key $exp";
                    $this->begin_br();
                    $r = array();
                    foreach ($data[$key] as $v) {
                        $r[] = "?";
                        $this->add_data($v);
                    }
                    $this->sql[] = implode(",", $r);
                    $this->end_br();
                } else {
                    $this->sql[] = "$key $exp ?";
                    $this->add_data($value);
                }
            }
        } else {
            if ($logic_exp) {
                $this->sql[] = $logic_exp;
            }
            if ($data) {
                $this->sql[] = $data;
            }
        }
        return $this;
    }

    /**
     * @param null $data
     * @param string $exp
     * @return $this
     * @throws Srv_Exception_Data
     */
    function cond_and($data = null, $exp = "=")
    {
        return $this->cond($data, "AND", $exp);
    }

    /**
     * @param null $data
     * @param string $exp
     * @return $this
     * @throws Srv_Exception_Data
     */
    function cond_or($data = null, $exp = "=")
    {
        return $this->cond($data, "OR", $exp);
    }

    /**
     * @param null $data
     * @param string $exp
     * @return $this
     * @throws Srv_Exception_Data
     */
    function cond_not($data = null, $exp = "=")
    {
        return $this->cond($data, "NOT", $exp);
    }

    /**
     * Формирование GROUP BY
     * @param string $field
     * @return $this
     */
    function group($field)
    {
        $this->sql[] = "GROUP BY";
        $this->sql[] = $field;
        return $this;
    }

    /**
     * Формирование ORDER BY
     * @param array | string $fields
     * @return $this
     */
    function order($fields)
    {
        $this->sql[] = "ORDER BY";
        if (is_array($fields)) {
            $a = array();

            foreach ($fields as $key => $value) {
                $s = $key;
                $value = mb_strtoupper($value);
                if ($value == "DESC" || $value == "ASC") {
                    $s .= " " . $value;
                }
                $a[] = $s;
            }
            $this->sql[] = implode(", ", $a);
        } else {
            $this->sql[] = $fields;
        }
        return $this;
    }

    /**
     * Формирование LIMIT
     * @param $rows
     * @param int $offset
     * @return $this
     */
    function limit($rows, $offset = 0)
    {
        $this->sql[] = "LIMIT";
        $a = array();
        if ($offset) {
            $a[] = intval($offset);
        }
        $a[] = intval($rows);
        $this->sql[] = implode(", ", $a);
        return $this;
    }

    /**
     * Получение информации о столбцах таблицы
     * @param string | array $table
     * @return array
     */
    function show_columns($table)
    {
        $this->sql[] = "SHOW COLUMNS";
        return $this->from($table)->execute()->fetchAll();
    }

    /**
     * Добавление записи в базу
     * Возвращает: идентификатор последней записи
     * Если у записи двойной ключ - возвращает 0
     * @param $table
     * @param $data
     * @return $this
     * @throws Srv_Exception_Data
     */
    public function insert($table, $data)
    {
        $this->sql = array("INSERT INTO");
        $this->sql[] = "`$table`";
        $this->sql[] = "SET";

        $a = array();
        foreach ($data as $key => $value) {
            $a[] = "`$key`= ?";
            $this->add_data($value);
        }

        $this->sql[] = implode(", ", $a);
        return $this;
    }

    public function add($table, $data)
    {
        $this->insert($table, $data)->secure()->execute();
        return $this->lastInsertId();
    }

    public function unsecure_add($table, $data)
    {
        $this->insert($table, $data)->entities()->execute();
        return $this->lastInsertId();
    }

    /**
     * Подготавливает SQL запрос для изменения записи
     * @param $table string
     * @param $data array
     * @param $where string | array
     * @param $exp string
     * @return $this
     * @throws Srv_Exception_Data
     */
    public function update($table, $data, $where = null, $exp = "=")
    {
        $this->sql = array("UPDATE", $table, "SET");

        if (is_array($data)) {
            $a = array();
            foreach ($data as $key => $value) {
                $a[] = "`$key`= ?";
                $this->add_data($value);
            }

            $this->sql[] = implode(",", $a);
        } else {
            $this->sql[] = $data;
        }

        if ($where) {
            $this->where($where, $exp);
        }
        return $this;
    }

    /**
     * Изменение записи в базе
     * Возвращает: количество измененных строк
     * @param $table string
     * @param $data array
     * @param $where array | string
     * @param $exp string
     * @return int
     * @throws Srv_Exception_Data
     */
    public function upd($table, $data, $where, $exp = "=")
    {
        return $this->update($table, $data, $where, $exp)->secure()->execute()->rowCount();
    }

    /**
     * Изменение записи в базе
     * Возвращает: количество измененных строк
     * @param $table string
     * @param $data array
     * @param $where array | string
     * @param $exp string
     * @return int
     * @throws Srv_Exception_Data
     */
    public function unsecure_upd($table, $data, $where, $exp = "=")
    {
        return $this->update($table, $data, $where, $exp)->entities()->execute()->rowCount();
    }

    /**
     * Подготавливает SQL запрос для удаления записи
     * @param $table string
     * @param $where string | array
     * @param $exp string
     * @return $this
     * @throws Srv_Exception_Data
     */
    public function delete($table, $where, $exp = "=")
    {
        $this->sql = array("DELETE");
        return $this->from($table)->where($where, $exp);
    }

    /**
     * Удаление из базы записи
     * Возвращает: количество удаленных строк
     * @param $table string
     * @param $where string | array
     * @param $exp string
     * @return int
     * @throws Srv_Exception_Data
     */
    public function del($table, $where, $exp = "=")
    {
        return $this->delete($table, $where, $exp)->execute()->rowCount();
    }

}
