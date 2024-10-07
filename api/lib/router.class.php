<?php

declare(strict_types=1);

class Router {

    protected $uri;
    protected $controller;
    protected $action;
    protected $params;
    protected $route;
    protected $methodPrefix;

    public function getUri()
    {
        return $this->uri;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getMethodPrefix()
    {
        return $this->methodPrefix;
    }

    public function __construct(string $uri)
    {
        $this->uri = urldecode(trim($uri, '/'));
        $routes = $this->uri;
        $this->route = Config::get('default');
        $this->methodPrefix = $routes[$this->route] ?? '';
        $this->controller = Config::get('default_controller');
        $this->action = $this->getApiMethods($_SERVER['REQUEST_METHOD'], $this->getIdFromUrl());
        $uriParts = explode('/', $this->uri);

        if ($uriParts) {
            $path = $uriParts[0];
            $pathParts = explode('/', $path);
            if (count($pathParts)) {
                if (current($pathParts)) {
                    $this->controller = strtolower(current($pathParts));
                    array_shift($pathParts);
                }

                $this->params = $pathParts;
            }
        }
    }

    public function getIdFromUrl(): int
    {
        $uriParts = explode('/', $this->uri);
        if ($uriParts) {
            $id = !empty($uriParts[2]) ? $uriParts[2] : 0;
        }
        return (int) $id;
    }

    public static function getApiMethods(string $requestMethods, int $id): string
    {
        $typeSwitch = 'index';

        if ($id > 0) {
            $typeSwitch = 'show';
        }

        $methods = match ($requestMethods) {
            'GET' => $typeSwitch,
            'POST' => 'store',
            'DELETE' => 'delete',
            'PUT' => 'edit',
            'PATCH' => 'edit',
            default => $typeSwitch
        };

        return $methods;
    }

    public static function redirect(string $location) {
        header("Location: $location");
    }

    /*
     * Urls
     *
     * api/user
     * api/user/{id}
     *
     */
    public function initRoute()
    {
        $id = $this->getIdFromUrl();

        $user = '/user';

        if ($id > 0) {
            $user = '/user/' . $id;
        }

        Config::set('routes', [
            'default' => 'api',
            'user' => $user,
        ]);
    }
}





