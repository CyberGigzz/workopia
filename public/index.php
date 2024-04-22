<?php
require "../helpers.php";

$routes = [
    "/" => "controllers/home.php",
    "/listings" => "controllers/listings/index.php",
    "/listings/create" => "controllers/listings/create.php",
    "404" => "controllers/listings/404.php",
];

$uri = $_SERVER["REQUEST_URI"];

inspect($uri);
