<?php

namespace Occazou;

define('ROOTPATH', __DIR__.'/');

require_once 'Autoloader.php';

Autoloader::register();

$router = new Src\Router();
$router->routeRequest();