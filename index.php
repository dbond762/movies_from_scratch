<?php

require_once './vendor/autoload.php';

$r = new Lib\Router\Router();

$r->get('/search/{query}', function ($ctx) {
    echo "search {$ctx['params']['query']}";
});

$r->get('/', function ($ctx) {
    echo 'Nobody expects a bugs! Their weapons are surprise, ruthlessness and fear.';
});

$r->serve();
