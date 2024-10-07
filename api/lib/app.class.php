<?php

declare(strict_types=1);

class App {

    protected static $router;
    public static $db;

    public static function getRouter() {
        return self::$router;
    }

    public static function run(string $uri) {
        self::$router = new Router($uri);
        self::$router->initRoute();
        Config::initEnv();
        self::$db = new DB(getenv('DATABASE_HOST'), getenv('DATABASE_NAME'));

        $partUrl = explode('/', self::$router->getUri());

        if (in_array($partUrl[0], Config::get('routes'))) {
            $controllerClass = ucfirst(str_replace($partUrl[0], $partUrl[1], self::$router->getController())) . 'Controller';
            $controllerMethod = self::$router->getAction();

            if (class_exists($controllerClass)) {
                $controllerObject = new $controllerClass();
                if (is_object($controllerObject)) {
                    $controllerObject?->$controllerMethod();
                }
            }
        }
    }
}
