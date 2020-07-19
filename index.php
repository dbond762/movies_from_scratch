<?php

require_once './vendor/autoload.php';

$r = new Lib\Router\Router();

$r->get('/', function ($context) {
    echo 'Nobody expects a bugs! Their weapons are surprise, ruthlessness and fear.';
});

$r->serve();
