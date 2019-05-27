<?php

use Src\Core\Application;

require 'bootstrap.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$controllerName = $uri[2];
$id = null;
$method = $_SERVER["REQUEST_METHOD"];
$query = null;
//$requestContentType = $_SERVER['HTTP_ACCEPT'];
//var_dump($requestContentType);
if (isset($_SERVER['QUERY_STRING'])) {
    $query = $_SERVER['QUERY_STRING'];
}
if (isset($uri[3])) {
    $id = $uri[3];
}

$app = new Application($controllerName, $method, $id, $query);
$app->start();
