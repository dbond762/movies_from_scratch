<?php

namespace Lib\Router;

class Node {
    /**
     * @var string
     */
    private $method;
    /**
     * @var string[]
     */
    private $pattern;
    /**
     * @var \Closure
     */
    private $handler;

    /**
     * @var QueryParams
     */
    private $query_params;

    public function __construct(string $method, array $pattern, \Closure $handler, QueryParams $query_params) {
        $this->method       = $method;
        $this->pattern      = $pattern;
        $this->handler      = $handler;
        $this->query_params = $query_params;
    }

    public function check_and_handle(array $context) {
        $path   = $context[Router::CTX_KEY_PATH];
        $method = $context[Router::CTX_KEY_METHOD];

        if (!in_array($this->method, [Router::METHOD_ANY, $method]) || !$this->match_and_set_params($path, $context)) {
            return false;
        }

        $context[Router::CTX_KEY_PATH] = $this->crop_path($path);

        ($this->handler)($context);

        return true;
    }

    private function match_and_set_params(array $path, array &$context) : bool {
        if (count($path) < count($this->pattern)) {
            return false;
        }

        $context[Router::CTX_KEY_PARAMS] = [];
        for ($i = 0; $i < count($this->pattern); $i++) {
            if ($path[$i] === $this->pattern[$i]) {
                continue;
            } else if ($param = $this->get_param($path[$i], $this->pattern[$i])) {
                $context[Router::CTX_KEY_PARAMS] = array_merge($context[Router::CTX_KEY_PARAMS], $param);
                continue;
            }
            return false;
        }

        return true;
    }

    private function get_param(string $item, string $pattern) {
        if (empty($pattern) || $pattern[0] !== '{' || substr($pattern, -1) !== '}') {
            return false;
        }

        $cleaned_pattern = substr($pattern, 1, strlen($pattern) - 2);

        foreach ($this->query_params as $type => $fn) {
            if (self::ends_with($cleaned_pattern, ":{$type}")) {
                $cleaned_pattern = self::cute_from_end($cleaned_pattern, $type);
                return [$cleaned_pattern => $fn($item)];
            }
        }

        return [$cleaned_pattern => $item];
    }

    private static function ends_with(string $str, string $end) : bool {
        return substr($str, -strlen($end)) === $end;
    }

    private static function cute_from_end(string $str, string $end) : string {
        return substr($str, 0, strlen($str) - strlen($end));
    }

    private function crop_path(array $path) : array {
        return array_slice($path, count($this->pattern));
    }
}
