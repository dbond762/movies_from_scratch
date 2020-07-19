<?php

require_once './vendor/autoload.php';
use Lib\Router\Router;

$r = new Router();

$r->get('/search/{query:string}', function ($ctx) {
    echo "search {$ctx['params']['query']}";
});

$r->get('/', function ($ctx) {
    echo 'Nobody expects a bugs! Their weapons are surprise, ruthlessness and fear.';
});

$r->serve();
