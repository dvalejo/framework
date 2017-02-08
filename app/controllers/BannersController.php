<?php

class BannersController extends Controller
{
    /**
     * -------------------------------------------------------------------
     */
    public function index()
    {
        $b = new BannersModel();
        $banners = $b->all();
        $this->setVars([
            'banners' => $banners
        ]);
        $this->getView('banners/banners');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function indexAjax()
    {
        $b = new BannersModel();
        $banners = $b->all();
        echo json_encode($banners);
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function single($id)
    {
        $b = new BannersModel();
        $banner = $b->single($id);
        $this->setVars([
            'banner' => $banner
        ]);
        $this->getView('banners/banner-single-' . $banner['type_slug']);
    }
}