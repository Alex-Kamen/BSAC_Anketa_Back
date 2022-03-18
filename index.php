<?php
header('Access-Control-Allow-Origin: http://anketa.vfbsac.by');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Content-Type");
header('Access-Control-Allow-Methods: GET, POST, PUT');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Router.php');

$router = new Router();
$router->run();