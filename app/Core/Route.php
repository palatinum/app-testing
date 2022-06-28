<?php

namespace App\Core;

use Exception;

final class Route {
    private static $routes = [];

    public static function add (string $route, string $controller, string $action, string $method) {
      static::$routes[$route] = [
          'controller' => $controller,
          'action' => $action,
          'method' => $method,
      ];
    }
    
    public static function action ($route = '') :array {
        if(!array_key_exists($route, static::$routes)) {
            throw new Exception('Route not found', 404);
        }
        
        if($_SERVER['REQUEST_METHOD'] !== strtoupper(static::$routes[$route]['method'])) {
            throw new Exception('Route not found', 404);
        }
        
        return static::$routes[$route];
    }
}