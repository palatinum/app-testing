<?php

namespace App\Core;

use App\Core\Route;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Dotenv\Dotenv;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Core\Connection;

final class Application {
    public function __construct() {
        try {
            $dotenv = Dotenv::createImmutable(ROOT_PATH);
            $dotenv->load();

            Connection::init();
            
            $url = $this->parseUrl();
            $route = Route::action($url);
            $controllerName = $route['controller'];
            $action = $route['action'];
            $namespace = "App\\Controllers\\" . $controllerName;
            $controller = new $namespace();
            $controller->$action();
        } catch (BadRequestException $ex) {
            $response = new JsonResponse(json_decode($ex->getMessage()), $ex->getCode());
            $response->send();
            exit();
        } catch (Exception $ex) {
            $code = $ex->getCode();
            if(!isset(JsonResponse::$statusTexts[$code])) {
                $code = 500;
            }
            $response = new JsonResponse($ex->getMessage(), $code);
            $response->send();
            exit();
        }
    }
    
    public function parseUrl () {
        if(isset($_GET['url'])) {
            return $_GET['url'];
        }
    }
}
