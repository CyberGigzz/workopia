<?php
// phpinfo();

require "../helpers.php";
// xdebug_info();

require basePath("Router.php");

// xdebug_info();

$router = new Router();


$routes = require basePath("routes.php");

$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];

$router->route($uri, $method);