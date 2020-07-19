<?php

namespace Lib\Router;

class Node {
    /**
     * @var string
     */
    private $method;
    private $pattern;
    /**
     * @var \Closure
     */
    private $handler;

    public function __construct($method, $pattern, $handler) {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->handler = $handler;
    }

    public function check_and_handle(array $context) {
        $path   = $context['_path'];
        $method = $context['_method'];

        if (!in_array($this->method, [Router::METHOD_ANY, $method]) || !$this->match_and_set_params($path, $context)) {
            return;
        }

        $context['_path'] = $this->crop_path($path);

        ($this->handler)($context);
    }

    private function match_and_set_params($path, &$context) {
        return true;
    }

    private function crop_path($path) {
        return $path;
    }
}
