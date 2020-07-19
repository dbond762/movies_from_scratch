<?php

namespace Lib\Router;

class QueryParams implements \Iterator {
    /**
     * @var \Closure[]
     */
    private $params;

    /**
     * @var int
     */
    private $position;

    public function __construct() {
        $this->position = 0;

        $this->set_default_params();
    }

    private function set_default_params() {
        $this->add_param('string', function ($item) {
            return $item;
        });

        $this->add_param('int', function ($item) {
            return (int)$item;
        });
    }

    public function add_param(string $type, \Closure $func) {
        $this->params[$type] = $func;
    }

    public function current() {
        return $this->params[$this->position];
    }

    public function next() {
        $this->position++;
    }

    public function key() {
        return $this->position;
    }

    public function valid() {
        return isset($this->params[$this->position]);
    }

    public function rewind() {
        $this->position = 0;
    }
}
