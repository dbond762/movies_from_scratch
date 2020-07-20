<?php

namespace App;

use Lib\Router\Router;

use App\Controllers\Movies;

function get_router(Router $r) {
    $r->route('/movies', function (Router $r) {
        $r->get('/list', Router::controller(Movies::class, 'movies_list'));
        $r->get('/add', Router::controller(Movies::class, 'add_view'));
        $r->post('/add', Router::controller(Movies::class, 'add'));
        $r->post('/delete/{id:int}', Router::controller(Movies::class, 'delete'));
        $r->get('/detail/{id:int}', Router::controller(Movies::class, 'detail'));
        $r->get('/search', Router::controller(Movies::class, 'search'));
        $r->post('/import', Router::controller(Movies::class, 'import'));
    });

    $r->get('/', function ($ctx) {
        echo 'Nobody expects a bugs! Their weapons are surprise, ruthlessness and fear.';
    });
}
