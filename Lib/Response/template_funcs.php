<?php

function view(string $view, array $data = []) {
    extract($data);
    require BASEPATH . '/App/Views/' . $view . '.php';
}

function is_page(string $path, string $echo = '') {
    if ($_SERVER['REQUEST_URI'] !== $path) {
        return false;
    }

    if (!empty($echo)) {
        echo $echo;
    }

    return true;
}
