<?php

session_start();

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(dirname(__FILE__))));
}
if (!defined('API')) {
    define('API', ROOT.DS.'api'.DS);
}

require_once(API.'init'.DS.'autoload.php');

App::run($_SERVER['REQUEST_URI']);

