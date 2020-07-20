<?php

namespace Lib\Model;

use Lib\Config\Config;

class Model {
    protected $pdo;

    public function __construct() {
        $host    = Config::get_param('host');
        $db      = Config::get_param('db');
        $user    = Config::get_param('user');
        $pass    = Config::get_param('pass');
        $charset = Config::get_param('charset');

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new \PDO($dsn, $user, $pass, $opt);
    }
}
