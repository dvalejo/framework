<?php

class UsersAdminController extends Controller
{
    protected $layout = 'admin';

    public function __construct()
    {
        parent::__construct();
        if (Auth::check() === false) $this->redirect('/');
    }

    public function index()
    {
        $u = new UsersAdminModel();
        $users = $u->all();
        $this->setVars([
            'users' => $users
        ]);
        $this->getView('admin/users/users');
    }

    public function add()
    {
        $this->getView('admin/users/user-add');
    }

    public function post_add()
    {
        $form_errors = setErrorsMessages('POST', [
            'user_name' => 'Пожалуйста введите имя пользователя.',
            'user_password' => 'Пожалуйста введите пароль пользователя.',
            'user_password_repeat' => 'Пожалуйста повторите пароль пользователя.',
        ]);
        if (count($form_errors) > 0) {
            echo 'У вас ошибочка.';
            exit();
        }
        if ($this->postVars['user_password'] !== $this->postVars['user_password_repeat']) {
            $form_errors = ['Вы ввели разные пароли.'];
            echo 'У вас ошибочка.';
            exit();
        }
        $hash = password_hash($this->postVars['user_password'], PASSWORD_DEFAULT);

        $u = new UsersAdminModel();
        $u->add($this->postVars, $hash);
        $this->redirect('/admin/users/');
    }
    
    public function delete($id)
    {
        $u = new UsersAdminModel();
        $user = $u->delete($id);
        $this->setVars([
            ':user_id' => $id
        ]);
        $this->redirect('/admin/users/');
    }
}