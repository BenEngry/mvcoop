<?php

//ini_set("display_errors", 1);
//error_reporting(E_ALL);

session_start();

//exit("ded");

include_once('init.php');
require_once('./model/Messagess.php');
require_once('./model/Authorization.php');

/** @var string $left */
$left = '';
/**
 * @var string $title
 * @var string $content
 */
$title = $content = 'Error 404';

$uri = $_SERVER['REQUEST_URI'];
$badUrl = BASE_URL . 'index.php';

if(strpos($uri, $badUrl) === 0){
    $cname = 'errors/e404';
} else {
    $routes = include('routes.php');
    $url = $_GET['mvcsystemurl'] ?? '';

    $routerRes = parseUrl($url, $routes);
    $cname = $routerRes['controller'];

    $urlLen = strlen($url);

    if($urlLen > 0 && $url[$urlLen - 1] == '/'){
        $url = substr($url, 0, $urlLen - 1);
    }
}

$mes = new Messagess($connect);
$auth = new Authorization($connect);

/** @var string $path */
$path = "controller/$cname.php";
include_once($path);

