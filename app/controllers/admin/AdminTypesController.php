<?php
namespace app\controllers\admin;

use vendor\core\base\Controller;
use vendor\core\Auth;
use vendor\core\Input;
use app\models\admin\AdminTypesModel;

class AdminTypesController extends Controller
{
    protected $layout = 'admin';

    /**
     * TypesAdminController constructor.
     * -------------------------------------------------------------------
     */
    public function __construct()
    {
        if (Auth::check() === false) $this->redirect('/');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function index()
    {
        $t = new AdminTypesModel();
        $types = $t->all();
        $this->setVars([
            'types' => $types
        ]);
        $this->getView('admin/types/types');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function add()
    {
        $this->getView('admin/types/type-add');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function post_add()
    {
        $input = new Input();
        $formErrors = $input->filter('post', [
            'type_name' => 'string',
            'type_slug' => 'string'
        ])->getErrors([
            'type_name' => 'Пожалуйста введите название типа.',
            'type_slug' => 'Пожалуйста введите slug типа.'
        ]);
        if (count($formErrors) > 0) {
            $this->setVars([
                'formErrors' => $formErrors
            ]);
            $this->getView('form-error');
            exit();
        }
        $t = new AdminTypesModel();
        $t->add($input->post());
        $this->redirect('/admin/types/');
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function edit($id)
    {
        $t = new AdminTypesModel();
        $type = $t->single($id);
        $this->setVars([
            'type' => $type
        ]);
        $this->getView('admin/types/type-edit');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function post_edit()
    {
        $input = new Input();
        $formErrors = $input->filter('post', [
            'type_id' => 'number:int',
            'type_name' => 'string',
            'type_slug' => 'string'
        ])->getErrors([
            'type_name' => 'Пожалуйста введите название типа.',
            'type_slug' => 'Пожалуйста введите slug типа.'
        ]);
        if (count($formErrors) > 0) {
            $this->setVars([
                'formErrors' => $formErrors
            ]);
            $this->getView('form-error');
            exit();
        }
        $t = new AdminTypesModel();
        $t->update($input->post());
        $this->redirect('/admin/types/');
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function delete($id)
    {
        $t = new AdminTypesModel();
        $t->delete($id);
        $this->redirect('/admin/types/');
    }
}