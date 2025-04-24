<?php

namespace Core;

class Router {
    private static $routes = [];
    public static function get($uri, $controllerMethod) {
        
        self::$routes['GET'][$uri] = $controllerMethod;
    }

    public static function post($uri, $controllerMethod) {
        
        self::$routes['POST'][$uri] = $controllerMethod;
    }

    public static function dispatch() {
              
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];
    

        $uri = trim($_GET['url'] ?? '', '/');
  


        //var_dump(@self::$routes[$method][$uri]); 
        if (isset(self::$routes[$method][$uri])) {
            $controllerAction = explode('@', self::$routes[$method][$uri]);
            $controllerName = "App\\Controllers\\" . str_replace('/', '\\', $controllerAction[0]);
            $methodName = $controllerAction[1];

            if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
                $controller = new $controllerName();
                $controller->$methodName();
                return;
            }
        }
        
        http_response_code(404);
        echo "404 - Page Not Found prima data";    
    }
    
}
