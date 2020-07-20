<?php

function view(string $view, array $data = []) {
    extract($data);
    require BASEPATH . '/App/Views/' . $view . '.php';
}
