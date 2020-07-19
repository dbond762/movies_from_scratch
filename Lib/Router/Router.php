<?php

namespace Lib\Router;

class Router {
    public const METHOD_GET  = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_ANY  = '*';

    /**
     * @var Node[]
     */
    private $nodes = [];
    /**
     * @var \Closure[]
     */
    private $middlewares = [];

    /**
     * @var \Closure
     */
    private $serve_http;

    public function __construct() {
        $this->serve_http = $this->getServeHttp();
    }

    private function handle($method, string $pattern, $handler) {
        if (strlen($pattern) === 0 || $pattern[0] != '/') {
            throw new RouterException("routing pattern must begin with '/' in '{$pattern}'");
        }

        $parsed_pattern = explode('/', $pattern);
        $node = new Node($method, $parsed_pattern, $handler);
        array_push($this->nodes, $node);
    }

    public function get(string $pattern, $handler) {
        $this->handle(self::METHOD_GET, $pattern, $handler);
    }

    public function post(string $pattern, $handler) {
        $this->handle(self::METHOD_POST, $pattern, $handler);
    }

    public function having($middlewares) {
        array_push($this->middlewares, ...$middlewares);
    }

    public function with(...$middlewares) {
        $r = new Router();
        $r->having(...$middlewares);

        $node = new Node(self::METHOD_ANY, [], $r->serve_http);
        array_push($this->nodes, $node);

        return $r;
    }

    /**
     * @return \Closure
     */
    private function getServeHttp(): \Closure {
        return function($context) {
            foreach ($this->nodes as $node) {
                $node->check_and_handle($context);
            }
        };
    }

    public function serve() {
        $context['_path']   = explode('/', $_SERVER['REQUEST_URI']);
        $context['_method'] = $_SERVER['REQUEST_METHOD'];
        ($this->serve_http)($context);
    }
}
