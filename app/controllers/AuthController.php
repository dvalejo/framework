<?php
namespace app\controllers;

use vendor\core\base\Controller;
use vendor\core\Input;
use app\models\admin\AdminUsersModel;

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
        $input = new Input();
        $formErrors = $input->filter('post', [
            'user_name' => 'string',
            'user_password' => 'string'
        ])->getErrors([
            'user_name' => 'Пожалуйста введите имя.',
            'user_password' => 'Пожалуйста введите пароль.'
        ]);
        if (count($formErrors) > 0) {
            $this->setVars([
                'formErrors' => $formErrors
            ]);
            $this->getView('form-error');
            exit();
        }
        
        $u = new AdminUsersModel();
        $users = $u->all();

        foreach ($users as $user) {
            if ($input->post('user_name') === $user['name'] && 
                password_verify($input->post('user_password'), $user['password'])) {

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