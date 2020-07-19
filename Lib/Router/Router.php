<?php

namespace Lib\Router;

class Router {
    public const METHOD_GET  = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_ANY  = '*';

    public const CTX_KEY_PATH   = '_path';
    public const CTX_KEY_METHOD = '_method';
    public const CTX_KEY_PARAMS = 'params';

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
    private $serve_route;

    /**
     * @var QueryParams
     */
    private $query_params;

    public function __construct($query_params = null) {
        if (is_null($query_params)) {
            $query_params = new QueryParams();
        }
        $this->query_params = $query_params;

        $this->serve_route = $this->get_serve_route();
    }

    private function handle(string $method, string $pattern, \Closure $handler) {
        if (strlen($pattern) === 0 || $pattern[0] != '/') {
            throw new RouterException("routing pattern must begin with '/' in '{$pattern}'");
        }

        $node = new Node($method, self::parse_path($pattern), $handler, $this->query_params);
        array_push($this->nodes, $node);
    }

    public function get(string $pattern, \Closure $handler) {
        $this->handle(self::METHOD_GET, $pattern, $handler);
    }

    public function post(string $pattern, \Closure $handler) {
        $this->handle(self::METHOD_POST, $pattern, $handler);
    }

    public function having(...$middlewares) {
        array_push($this->middlewares, ...$middlewares);
    }

    public function with(...$middlewares) {
        $r = new Router();
        $r->having(...$middlewares);

        $node = new Node(self::METHOD_ANY, self::parse_path('/'), $r->serve_route, $this->query_params);
        array_push($this->nodes, $node);

        return $r;
    }

    /**
     * @return \Closure
     */
    private function get_serve_route(): \Closure {
        return function($context) {
            foreach ($this->nodes as $node) {
                if ($node->check_and_handle($context)) {
                    break;
                }
            }
        };
    }

    public function serve() {
        $context[self::CTX_KEY_PATH]   = self::parse_path($_SERVER['REQUEST_URI']);
        $context[self::CTX_KEY_METHOD] = $_SERVER['REQUEST_METHOD'];
        ($this->serve_route)($context);
    }

    private static function parse_path(string $path) : array {
        $parsed_path = trim($path, '/');
        if (empty($parsed_path)) {
            return [];
        }
        return explode('/', $parsed_path);
    }
}
