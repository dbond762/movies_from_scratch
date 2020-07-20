<?php

use Lib\Router\Router;
use function App\get_router;

require_once './vendor/autoload.php';

require 'App/Routs.php';

define('BASEPATH', __DIR__);

$r = new Router();
get_router($r);
$r->serve();
