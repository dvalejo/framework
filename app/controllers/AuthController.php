<?php

class AuthController extends Controller
{
    protected $layout = 'default';

    /**
     * -------------------------------------------------------------------
     */
    public function login()
    {
        $this->getView('login');
    }
    
    /**
     * -------------------------------------------------------------------
     */
    public function post_login()
    {
        $form_errors = setErrorsMessages('POST', [
            'user_name' => 'Пожалуйста введите имя.',
            'user_password' => 'Пожалуйста введите пароль.'
        ]);
        if (count($form_errors) > 0) {
            echo 'У вас ошибочка.';
            exit();
        }
        $u = new UsersAdminModel();
        $users = $u->all();

        foreach ($users as $user) {
            if ($this->postVars['user_name'] === $user['name'] AND password_verify($this->postVars['user_password'], $user['password'])) {

                session_regenerate_id();
                $_SESSION['id'] = session_id();
                $_SESSION['name'] = $user['name'];

                $u->update($user);
                $this->redirect('/admin/');
                break;
            }
        }
    }

    /**
     * -------------------------------------------------------------------
     */
    public function logout()
    {
        $_SESSION = array();
        session_destroy();
        $this->redirect('/');
    }

}