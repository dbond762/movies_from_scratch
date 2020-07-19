<?php

namespace Lib\Router;

use Lib\StringHelper\StringHelper;

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

    /**
     * Node constructor.
     *
     * @param string $method
     * @param array $pattern
     * @param \Closure $handler
     * @param QueryParams $query_params
     */
    public function __construct(string $method, array $pattern, \Closure $handler, QueryParams $query_params) {
        $this->method       = $method;
        $this->pattern      = $pattern;
        $this->handler      = $handler;
        $this->query_params = $query_params;
    }

    /**
     * Проверить, подходит ли запрос текущей ноде, и вызвать обработчик
     *
     * @param array $context
     *
     * @return bool
     */
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

    /**
     * Проверить, подходит ли путь этой ноде, и если есть параметры, записать их в контекст
     *
     * @param array $path
     * @param array $context
     *
     * @return bool
     */
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

    /**
     * Получить параметр запроса.
     *
     * Возвращает ['query_name' => $query_value];
     *
     * @param string $item
     * @param string $pattern
     *
     * @return bool|string[]
     */
    private function get_param(string $item, string $pattern) {
        if (empty($pattern) || $pattern[0] !== '{' || substr($pattern, -1) !== '}') {
            return false;
        }

        $pattern = substr($pattern, 1, strlen($pattern) - 2);
        foreach ($this->query_params->params as $type => $fn) {
            if (StringHelper::ends_with($pattern, ":{$type}")) {
                $pattern = StringHelper::cute_from_end($pattern, ":{$type}");
                return [$pattern => $fn($item)];
            }
        }

        return [$pattern => $item];
    }

    /**
     * Убрать с начала пути текущий паттерн
     *
     * @param array $path
     *
     * @return array
     */
    private function crop_path(array $path) : array {
        return array_slice($path, count($this->pattern));
    }
}
