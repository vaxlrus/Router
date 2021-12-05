<?php
/*
* Interace to interact with FastRouter
*/


namespace App\Components;


use FastRoute;


class Router
{
    // Свойство для хранения конфига маршрутов
    private $routes;

    // Свойство для хранения объекта компонента fast route
    private $dispatcher;



    // Конструктор объекта Router
    public function __construct($pathToConfig)
    {
        // Получить роуты
        $this->getRoutes($pathToConfig);

        // Внести роуты в роутер
        $this->buildRoutes();
        
        // Пустить роутер в работу
        $this->initializeRouter($dispatcherObject);
    }



    // Инициализировать роутер
    private function initializeRouter(): void
    {
        // Получить метод и uri
        $httpMethod = $this->getMethod();
        $uri = $this->getUri();
        
        // Управление маршрутами
        $this->dispatchRoutes($httpMethod, $uri);
    }



    // Управление маршрутами
    private function dispatchRoutes($httpMethod, $uri): void
    {
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                echo "ошибка";
                
                break;

            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                echo "method not allowed";
                
                break;

            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                
                $controller = new $handler[0];
                call_user_func([$controller, $handler[1]], $vars);

                break;
        }
    }



    // Получить маршруты из конфига
    private function getRoutes($pathToConfig): void
    {
        // Подгрузка конфига
        $this->routes = require $pathToConfig;
    }



    // Собрать маршруты для роутера
    private function buildRoutes(): void
    {
        // Определение маршрутов
        $this->dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {
            foreach ($this->routes as $route)
            {
                // [0] - method, [1] - uri, [2] - handler
                $router->addRoute($route[0], $route[1], $route[2]);
            }
        });
    }



    // Получить uri
    private function getUri(): string
    {
        // Fetch method and URI from somewhere
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        return rawurldecode($uri);
    }



    // Получить метод
    private function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

?>