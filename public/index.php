<?php

// require __DIR__ . '/../vendor/autoload.php';
require "../helpers.php";


// use Framework\Router;
// use Framework\Database;


// if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
//     require __DIR__ . '/../vendor/autoload.php';
//     echo 'autoload.php exists!';
// } else {
//     echo 'autoload.php does not exist.';
// }


spl_autoload_register(function ($class) {
    $path = basePath('Framework/' . $class . '.php');
    if (file_exists($path)) {
        require $path;
    }
});

// Instatiate the router
$router = new Router();

// Get routes
$routes = require basePath("routes.php");

// Get current URI and HTTP method
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

// Route the request
$router->route($uri, $method);
