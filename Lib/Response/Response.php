<?php

namespace Lib\Response;

class Response {
    public static function view(string $view, array $data = []) {
        require BASEPATH . '/Lib/Response/template_funcs.php';
        view($view, $data);
    }

    public static function redirect(string $path) {
        header("Location: {$path}");
    }
}
