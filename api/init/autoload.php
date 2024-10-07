<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(dirname(__FILE__))));
}
if (!defined('API')) {
    define('API', ROOT.DS.'api'.DS);
}

spl_autoload_register(function ($className) {
    $libSource = API.'lib'.DS.strtolower($className).'.class.php';
    $modelsSource = API.'models'.DS.ucfirst($className).'.php';
    $controllersSource = API.'controllers'.DS.str_replace('controller', '', strtolower($className)).'.controller.php';

    if (file_exists($libSource)) {
        require_once "{$libSource}";
    }
    elseif (file_exists($modelsSource)) {
        require_once "{$modelsSource}";
    }
    elseif (file_exists($controllersSource)) {
        require_once "{$controllersSource}";
    } else {
        throw new Exception('Failed to include class '.$className);
    }
});

require_once(API.'config'.DS.'config.php');

