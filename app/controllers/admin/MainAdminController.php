<?php

class MainAdminController extends Controller
{
    protected $layout = 'admin';

    /**
     * MainAdminController constructor.
     * -------------------------------------------------------------------
     */
    public function __construct()
    {
        if (Auth::check() === false) $this->redirect('/');
    }

    public function index()
    {
        $this->getView('admin/index');
    }
}