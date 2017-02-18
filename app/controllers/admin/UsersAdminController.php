<?php
namespace app\controllers\admin;

use vendor\core\base\Controller;
use vendor\core\Auth;
use vendor\core\Input;
use app\models\admin\UsersAdminModel;

class UsersAdminController extends Controller
{
    protected $layout = 'admin';

    public function __construct()
    {
        if (Auth::check() === false) $this->redirect('/');
    }

    /*
     * -------------------------------------------------------------------
     */
    public function index()
    {
        $u = new UsersAdminModel();
        $users = $u->all();
        $this->setVars([
            'users' => $users
        ]);
        $this->getView('admin/users/users');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function add()
    {
        $this->getView('admin/users/user-add');
    }

    /**
     * @throws \Exception
     * -------------------------------------------------------------------
     */
    public function post_add()
    {
        $input = new Input();
        $formErrors = $input->filter('post', [
            'user_name' => 'string',
            'user_password' => 'string',
            'user_password_repeat' => 'string'
        ])->getErrors([
            'user_name' => 'Пожалуйста введите корректное имя.',
            'user_password' => 'Пожалуйста введите корректный пароль.',
            'user_password_repeat' => 'Пожалуйста повторите пароль.',
        ]);
        if ($input->post('user_password') !== $input->post('user_password_repeat')) {
            $formErrors = ['Вы ввели разные пароли.'];
        }
        if (count($formErrors) > 0) {
            $this->setVars([
                'formErrors' => $formErrors
            ]);
            $this->getView('form-error');
            exit();
        }
        $hash = password_hash($input->post('user_password'), PASSWORD_DEFAULT);

        $u = new UsersAdminModel();
        $u->add($input->post(), $hash);
        $this->redirect('/admin/users/');
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function delete($id)
    {
        $u = new UsersAdminModel();
        $u->delete($id);
        $this->redirect('/admin/users/');
    }
}