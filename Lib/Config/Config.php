<?php

namespace Lib\Config;

class Config {
    public static function get_param(string $param) {
        require BASEPATH . '/App/config.php';
        return $config[$param];
    }
}
