<?php
namespace app\controllers\admin;

use vendor\core\base\Controller;
use vendor\core\Auth;

class AdminMainController extends Controller
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