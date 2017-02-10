<?php

class UploadsAdminController extends Controller
{
    protected $layout = 'admin';

    /**
     * UploadsAdminController constructor.
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
        $u = new UploadsAdminModel();
        $uploads = $u->all();
        $this->setVars([
            'uploads' => $uploads
        ]);
        $this->getView('admin/uploads/uploads');
    }

    /**
     * @param $upload_directory
     * -------------------------------------------------------------------
     */
    public function delete($upload_directory)
    {
        $u = new UploadsAdminModel();
        $u->delete($upload_directory);

        $upload_project = substr($upload_directory, 0, strrpos($upload_directory, _DS_));

        removeDirectoryWithFiles($upload_directory);
        if (dir_is_empty($upload_project)) {
            rmdir($upload_project);
        }

        $this->redirect('/admin/uploads/');
    }
}