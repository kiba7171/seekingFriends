<?php
use Application\Models\Add;
require_once __DIR__ . '/autoload.php';
$controllerName = isset($_GET['cln']) ? $_GET['cln'] : 'News';
$controllerAction = isset($_GET['act']) ? $_GET['act'] : 'all';

$controllerName = 'Controller_' . $controllerName;
$method = 'action_' . $controllerAction;

if (!class_exists($controllerName) or !method_exists($controllerName, $method))
{
    header('Location: views/404.php');
}


try {
    $controller = new $controllerName;
    $controller -> $method();
} catch (E404Exception $eror404) {
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    Add::AddLogs ($url, '404 Not Found: ');
    exit();
}



