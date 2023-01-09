<?php
//1 ОБЩИИ НАСТРОЙКИ
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

//2 ПОДКЛЮЧЕНИЕ ФАЙЛОВ
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

//4 ВЫЗОВ РОУТА
$router = new Router();
$router->run();
