<?php

namespace App;

use Lib\Router\Router;

use App\Controllers\Movies;

$r = new Router();

$r->route('/movies', function ($r) {
    $r->get('/list', function ($ctx) {
        Movies::movies_list($ctx);
    });
});

$r->get('/', function ($ctx) {
    echo 'Nobody expects a bugs! Their weapons are surprise, ruthlessness and fear.';
});

$r->serve();
