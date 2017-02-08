<?php

class Router
{
    private $request;
    private $routes = [];
    private $controller;
    private $action;
    private $parameters = [];

    public function __construct()
    {
        $this->request = new Request();
    }

    public function build($url)
    {
        return str_replace('/', '\/', $url);
    }

    /**
     * @param $url
     * @param $behavior
     */
    public function add($url, $behavior)
    {
        if (isset($url) && isset($behavior)) {
            $url = $this->build($url);
            $this->routes[$url] = $behavior;
        }
    }

    /**
     * Переход на главную страницу
     */
    public function gotoMainPage() {
        $this->controller = 'MainController';
        $this->action = 'index';
        $controllerInstance = new $this->controller;
        call_user_func([$controllerInstance, $this->action]);
    }

    /**
     *  Сопоставление route и url, а также вызов соответствующего метода контроллера
     */
    public function dispatch()
    {
        foreach ($this->routes as $route => $behavior) {
            if (preg_match($route, $this->request->url, $matches)) {
                list($this->controller, $this->action) = explode(':', $this->routes[$route]);
                $this->parameters = array_slice($matches, 1);

                // Проверяем есть ли такой контроллер
                if (!class_exists($this->controller)) {
                    echo 'Контроллер не найден.';
                    exit();
                }
                $controllerInstance = new $this->controller;

                // Проверяем есть ли такой метод у контроллера
                if (!method_exists($controllerInstance, $this->action)) {
                    echo 'Метод контроллера не найден.';
                    exit();
                }
                //$this->parameters = $parameters;
                return call_user_func_array([$controllerInstance, $this->action], $this->parameters);
            }
        }
        $this->gotoMainPage();
        return false;
    }
}