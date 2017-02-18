<?php
namespace vendor\core;

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => []
    ];
    private $controller;
    private $action;
    private $parameters = [];

    /**
     * @param $url
     * @param $behavior
     * -------------------------------------------------------------------
     */
    public function get($url, $behavior)
    {
        if (isset($url) && isset($behavior)) {
            $url = str_replace('/', '\/', $url);
            $this->routes['GET'][$url] = $behavior;
        }
    }

    /**
     * @param $url
     * @param $behavior
     * -------------------------------------------------------------------
     */
    public function post($url, $behavior)
    {
        if (isset($url) && isset($behavior)) {
            $url = str_replace('/', '\/', $url);
            $this->routes['POST'][$url] = $behavior;
        }
    }

    /**
     * @param $url
     * @param $behavior
     * -------------------------------------------------------------------
     */
    public function add($url, $behavior)
    {
        if (isset($url) && isset($behavior)) {
            $url = str_replace('/', '\/', $url);
            $this->routes[$url] = $behavior;
        }
    }

    /**
     * @return mixed
     * -------------------------------------------------------------------
     */
    public function gotoMainPage() {
        $this->controller = 'app\controllers\MainController';
        $this->action = 'index';
        $controllerInstance = new $this->controller;
        return call_user_func([$controllerInstance, $this->action]);
    }

    /**
     * @param $requestUri
     * @param $requestMethod
     * @return bool|mixed
     * Сопоставление route и url, а также вызов соответствующего метода контроллера
     * -------------------------------------------------------------------
     */
    public function dispatch($requestUri, $requestMethod)
    {
        foreach ($this->routes[$requestMethod] as $route => $behavior) {
            if (preg_match($route, $requestUri, $matches)) {
                list($this->controller, $this->action) = explode(':', $this->routes[$requestMethod][$route]);

                // Если контроллер админский то у него namespace app\controllers\admin
                if (strpos($this->controller, 'Admin') !== false) {
                    $this->controller = 'app\controllers\admin\\' . $this->controller;
                }
                else {
                    // Иначе обычный пользовательский namespace app\controllers
                    $this->controller = 'app\controllers\\' . $this->controller;
                }
                $this->parameters = array_slice($matches, 1);

                // Проверяем есть ли такой контроллер
                if (!class_exists($this->controller)) {
                    echo "Контроллер {$this->controller} не найден.";
                    exit();
                }
                $controllerInstance = new $this->controller;

                // Проверяем есть ли такой метод у контроллера
                if (!method_exists($controllerInstance, $this->action)) {
                    echo 'Метод контроллера не найден.';
                    exit();
                }
                return call_user_func_array([$controllerInstance, $this->action], $this->parameters);
            }
        }
        $this->gotoMainPage();
        return false;
    }
}