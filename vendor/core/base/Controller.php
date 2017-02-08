<?php

class Controller
{
    protected $postVars;
    protected $view;
    protected $layout = 'default';
    protected $vars = [];

    public function __construct()
    {
        $this->postVars = count($_POST) > 0 ? $_POST : [];
    }

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