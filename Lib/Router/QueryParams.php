<?php

namespace Lib\Router;

class QueryParams {
    /**
     * @var \Closure[]
     */
    public $params;

    /**
     * @var int
     */
    private $position;

    /**
     * QueryParams constructor.
     *
     * Используется для задания параметров запроса.
     * Например, '/query/{param:type}' - type - тип параметра param
     */
    public function __construct() {
        $this->position = 0;

        $this->set_default_params();
    }

    /**
     * Установить параметры по умолчанию.
     */
    private function set_default_params() {
        $this->add_param('string', function ($item) {
            return $item;
        });

        $this->add_param('int', function ($item) {
            return (int)$item;
        });
    }

    /**
     * Добавить параметр
     *
     * @param string $type - тип параметра
     * @param \Closure $func - функцию для получения параметра (получает параметр со строки запроса, возвращает обработанное значение)
     */
    public function add_param(string $type, \Closure $func) {
        $this->params[$type] = $func;
    }
}
