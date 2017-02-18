<?php
namespace app\controllers;

use vendor\core\base\Controller;

class MainController extends Controller
{
    /**
     * -------------------------------------------------------------------
     */
    public function index()
    {
        $this->getView('index');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function about()
    {
        $this->getView('about');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function prices()
    {
        $this->getView('prices');
    }
}