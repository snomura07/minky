<?php

namespace App\Core;

class Route
{
    private static array$routes = [];

    public static function get($path, $handler)
    {
        self::$routes['GET'][$path] = $handler;
    }

    public static function post($path, $handler)
    {
        self::$routes['POST'][$path] = $handler;
    }

    public static function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset(self::$routes[$method][$uri])) {
            http_response_code(404);
            echo "Not Found";
            return;
        }

        $controllerClass = self::$routes[$method][$uri];
        $controller      = new $controllerClass();
        $controller();
    }
}
