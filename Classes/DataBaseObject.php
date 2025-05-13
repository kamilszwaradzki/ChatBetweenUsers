<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of DataBaseObject
 *
 * @author tom
 */
class DataBaseObject extends PDO {

    protected int $last_id = 0;
    protected string $where = '';
    protected string $table = '';
    protected string $id_column = 'id';

    public function __construct($file = '.env.ini') {
        global $config;
        if (!isset($config) && !$config = parse_ini_file($file, TRUE)) {
            throw new exception('Unable to open ' . $file . '.');
        }
        $dns = $config['database']['DRIVER'] . ':host=' . $config['database']['HOST'] .
                ((!empty($config['database']['PORT'])) ? (';port=' . $config['database']['PORT']) : '') .
                ';dbname=' . $config['database']['NAME'];
        parent::__construct($dns, $config['database']['USER'], $config['database']['PASSWORD']);
    }

    public function __get($name) {
        debug("Getting '$name'\n");
        return $this->$name;
    }

    public function __set($name, $value) {
        debug("Setting '$name' to '$value'\n");
        $this->$name = $value;
    }

    public function __isset($name) {
        debug(isset($this->$name) ? "'$name' is set.\n" : "'$name' is not set.\n");
        return isset($this->$name);
    }

    public function __unset($name) {
        debug("Unsetting '$name'\n");
        unset($this->data[$name]);
    }

    public function getLastId() {
        return intval($this->query("SELECT MAX({$this->id_column}) FROM {$this->table};")->fetchColumn());
    }
    protected function countAllTables() {
        $this->query("SHOW TABLES LIKE 'dbo_%'")->rowCount();
    }

    public function insert() {
        return self::getLastId();
    }
}
