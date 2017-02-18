<?php
namespace vendor\core\base;

class Controller implements IController
{
    protected $request;
    protected $view;
    protected $layout = 'default';
    protected $vars = [];

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }
    
    public function getView($view, $layout = null)
    {
        if (isset($layout)) {
            $this->layout = $layout;
        }
        $this->view = new View($view, $this->layout);
        $this->view->render($this->vars);
    }

    public function redirect($route)
    {
        header('Location: ' . $route);
    }
}