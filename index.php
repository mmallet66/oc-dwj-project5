<?php

namespace Occazou;

require_once 'Autoloader.php';

Autoloader::register();

$router = new Src\Router();
$router->routeRequest();