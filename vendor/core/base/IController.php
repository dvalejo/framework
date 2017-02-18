<?php
namespace vendor\core\base;

interface IController
{
    public function setVars(array $vars);
    public function getView($view, $layout = null);
    public function redirect($route);
}