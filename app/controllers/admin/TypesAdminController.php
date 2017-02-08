<?php

class TypesAdminController extends Controller
{
    protected $layout = 'admin';

    /**
     * TypesAdminController constructor.
     * -------------------------------------------------------------------
     */
    public function __construct()
    {
        parent::__construct();
        if (Auth::check() === false) $this->redirect('/');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function index()
    {
        $t = new TypesAdminModel();
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
        $form_errors = setErrorsMessages('POST', [
            'type_name' => 'Пожалуйста введите название типа.',
            'type_slug' => 'Пожалуйста введите slug типа.'
        ]);
        if (count($form_errors) > 0) {
            echo 'У вас ошибочка.';
            exit();
        }
        $t = new TypesAdminModel();
        $t->add($this->postVars);
        $this->redirect('/admin/types/');
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function edit($id)
    {
        $t = new TypesAdminModel();
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
        $form_errors = setErrorsMessages('POST', [
            'type_name' => 'Пожалуйста введите название типа.',
            'type_slug' => 'Пожалуйста введите slug типа.'
        ]);
        if (count($form_errors) > 0) {
            echo 'У вас ошибочка.';
            exit();
        }
        $t = new TypesAdminModel();
        $t->update($this->postVars);
        $this->redirect('/admin/types/');
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function delete($id)
    {
        $t = new TypesAdminModel();
        $t->delete($id);
        $this->redirect('/admin/types/');
    }
}