<?php

class BannersAdminController extends Controller
{
    protected $layout = 'admin';

    /**
     * BannersAdminController constructor.
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
        $b = new BannersAdminModel();
        $banners = $b->all();
        $this->setVars([
            'banners' => $banners
        ]);
        $this->getView('admin/banners/banners');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function add()
    {
        $t = new TypesAdminModel();
        $types = $t->allForBanners();
        $this->setVars([
            'types' => $types
        ]);
        $this->getView('admin/banners/banner-add');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function post_add()
    {
        $input = new Input();
        $formErrors = $input->filter('post', [
            'banner_project' => 'string',
            'banner_type' => 'string',
            'banner_width' => 'number:int',
            'banner_height' => 'number:int',
            'banner_title' => 'string',
            'banner_directory' => 'string',
            'banner_url' => 'array:string',
            'banner_thumb_url' => 'string'
        ])->getErrors([
            'banner_project' => 'Пожалуйста введите название каталога проекта.',
            'banner_type' => 'Пожалуйста выберите тип баннера.',
            'banner_width' => 'Пожалуйста введите ширину баннера.',
            'banner_height' => 'Пожалуйста введите высоту баннера.',
            'banner_title' => 'Пожалуйста введите название баннера.',
        ]);
        if (count($formErrors) > 0) {
            $this->setVars([
                'formErrors' => $formErrors
            ]);
            $this->getView('form-error');
            exit();
        }
        $b = new BannersAdminModel();
        $b->add($input->post());
        $u = new UploadsAdminModel();
        $u->updateInUse($input->post());
        $this->redirect('/admin/banners/');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function post_upload()
    {
        $result = [];
        $input = new Input();
        $result['errors'] = $input->filter('post', [
            'banner_project' => 'string',
            'banner_type' => 'string',
            'banner_width' => 'number:int',
            'banner_height' => 'number:int',
        ])->getErrors([
            'banner_project' => 'Введите название каталога проекта.',
            'banner_type' => 'Выберите тип баннера.',
            'banner_width' => 'Введите ширину баннера.',
            'banner_height' => 'Введите высоту баннера.'
        ]);
        if (count($result['errors']) > 0) {
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // -----------------------------------------------------------------------------
        if (empty($_FILES)) {
            $result['errors'] = 'Not found uploaded files.';
            echo json_encode($result);
            exit();
        }

        $ajaxBannerProject = $input->post('banner_project');
        $ajaxBannerType = $input->post('banner_type');

        $bannerFileName = basename($_FILES['banner_file']['name']);
        $bannerTempName = $_FILES['banner_file']['tmp_name'];
        $bannerExtension = pathinfo($bannerFileName, PATHINFO_EXTENSION);
        $bannerTypeDir = $ajaxBannerType;
        $bannerProjectDir = $ajaxBannerProject;

        $bannerProjectFullDir = LOCAL_BANNERS_DIR . _DS_ . $bannerTypeDir . _DS_ . $bannerProjectDir;
        $bannerFullName = $bannerProjectFullDir . _DS_ . $bannerFileName;

        $pathParts = pathinfo($bannerFullName);
        $bannerUnzipDir = $pathParts['filename'];
        $bannerUnzipFullDir = $pathParts['dirname'] . _DS_ . $pathParts['filename'];

        // -----------------------------------------------------------------------------
        if ($_FILES['banner_file']['error'] !== 0) {
            switch ($_FILES['banner_file']['error']) {
                case 1:
                    $result['errors'][] = 'Your file is too big';
                    break;
                default:
                    $result['errors'][] = 'Other error.';
                    break;
            }
            echo json_encode($result);
            exit();
        }

        // -----------------------------------------------------------------------------
        if ( ! is_uploaded_file($bannerTempName)) {
            $result['errors'][] = 'Banner file was not loaded by the form.';
            echo json_encode($result);
            exit();
        }

        // -----------------------------------------------------------------------------
        if ( ! in_array($bannerExtension, ['zip'])) {
            $result['errors'][] = 'Wrong banner file extension.';
            echo json_encode($result);
            exit();
        }

        // -----------------------------------------------------------------------------
        if ( ! is_dir($bannerProjectFullDir)) {
            if ( ! mkdir($bannerProjectFullDir)) {
                $result['errors'][] = 'We can not create project directory.';
                echo json_encode($result);
                exit();
            }
        }

        // -----------------------------------------------------------------------------
        if ( ! move_uploaded_file($bannerTempName, $bannerFullName)) {
            $result['errors'][] = 'We can not move files from TEMP to banner directory.';
            echo json_encode($result);
            exit();
        }

        // -----------------------------------------------------------------------------
        $zip = new ZipArchive();
        $arch = $zip->open($bannerFullName);
        if ( ! $arch === true) {
            $result['errors'][] = 'We can not open banner archive.';
            removeBannerArchive($bannerFullName);
            echo json_encode($result);
            exit();
        }

        // -----------------------------------------------------------------------------
        if ( ! is_dir($bannerUnzipFullDir)) {
            if ( ! mkdir($bannerUnzipFullDir)) {
                $result['errors'][] = 'We can not make directory to extract banner files. Directory with that name is already exist.';
                removeBannerArchive($bannerFullName);
                echo json_encode($result);
                exit();
            }
        }

        // -----------------------------------------------------------------------------
        if ( ! $zip->extractTo($bannerUnzipFullDir)) {
            $result['errors'][] = 'Can not extract from banner archive file.';
            removeBannerArchive($bannerFullName);
            echo json_encode($result);
            exit();
        }
        $zip->close();

        // Looking for a banner and thumbnail files in unzipped directory
        // -----------------------------------------------------------------------------
        $thumbFiles = [];
        $bannerFiles = [];

        foreach (new DirectoryIterator($bannerUnzipFullDir) as $file) {
            if ($file->isDot()) continue;

            if (preg_match('/(.*thumb.*)\.(jpg|png)$/i', $file->getFilename())) {
                $thumbFiles[] = $file->getPathname();
            }
            else {
                switch ($ajaxBannerType) {
                    case 'flash':
                        if (preg_match('/.+\.swf$/i', $file->getFilename())) {
                            $bannerFiles[] = $file->getPathname();
                        }
                        break;
                    case 'html5':
                        if (preg_match('/.+\.html$/i', $file->getFilename())) {
                            $bannerFiles[] = $file->getPathname();
                        }
                        break;
                    case 'gif':
                        if (preg_match('/.+\.gif$/i', $file->getFilename())) {
                            $bannerFiles[] = $file->getPathname();
                        }
                        break;
                    case 'static':
                        if (preg_match('/.+\.(jpg|png)/i', $file->getFilename())) {
                            $bannerFiles[] = $file->getPathname();
                        }
                        break;
                    case 'adwords':
                        if (preg_match('/.+\.(jpg|png)/i', $file->getFilename())) {
                            $bannerFiles[] = $file->getPathname();
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        // -----------------------------------------------------------------------------
        if (empty($thumbFiles)) {
            $result['errors'][] = 'We can not find correct thumbnail file. Filename must have a word `thumb` and extension JPG or PNG';
            removeBannerArchive($bannerFullName);
            removeDirectoryWithFiles($bannerUnzipFullDir);
            echo json_encode($result);
            exit();
        }

        // -----------------------------------------------------------------------------
        if (empty($bannerFiles)) {
            $result['errors'][] = 'We can not find correct banner file. Maybe you are selected wrong banner type.';
            removeBannerArchive($bannerFullName);
            removeDirectoryWithFiles($bannerUnzipFullDir);
            echo json_encode($result);
            exit();
        }

        foreach ($thumbFiles as $thumbFile) {
            $result['local']['files']['thumbs'][] = $thumbFile;
            $result['http']['urls']['thumbs'][] = HTTP_BANNERS_DIR . _DS_ . $bannerTypeDir . _DS_ . $bannerProjectDir . _DS_ . $bannerUnzipDir . _DS_ . basename($thumbFile);
        }
        foreach ($bannerFiles as $bannerFile) {
            $result['local']['files']['banners'][] = $bannerFile;
            $result['http']['urls']['banners'][] = HTTP_BANNERS_DIR . _DS_ . $bannerTypeDir . _DS_ . $bannerProjectDir . _DS_ . $bannerUnzipDir . _DS_ . basename($bannerFile);
        }
        $result['local']['banner_directory'] = $bannerUnzipFullDir;
        $result['title'] = pathinfo($bannerFileName, PATHINFO_FILENAME);

        // -----------------------------------------------------------------------------
        if ( ! unlink($bannerFullName)) {
            $result['errors'][] = 'Can not remove banner archive.';
            echo json_encode($result);
            exit();
        }

        // Add to uploads
        // -----------------------------------------------------------------------------
        $u = new UploadsAdminModel();
        $uploads = $u->allByDirectory($bannerUnzipFullDir);

        if (count($uploads) > 0) {
            $u->updateUploadTime($bannerUnzipFullDir);
        }
        else {
            $u->add($bannerProjectFullDir, $bannerUnzipFullDir);
        }

        $result['message'] = 'Upload complete!';
        echo json_encode($result);
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function edit($id)
    {
        $t = new TypesAdminModel();
        $types = $t->allForBanners();
        $b = new BannersAdminModel();
        $banner = $b->single($id);

        // Create an array from urls string.
        $bannersUrls = explode(',', $banner['url']);

        $this->setVars([
            'types' => $types,
            'banner' => $banner,
            'bannersUrls' => $bannersUrls
        ]);
        $this->getView('admin/banners/banner-edit');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function post_edit()
    {
        $input = new Input();
        $formErrors = $input->filter('post', [
            'banner_project' => 'string',
            'banner_title' => 'string',
            'banner_type' => 'string',
            'banner_width' => 'number:int',
            'banner_height' => 'number:int',
            'banner_thumb_url' => 'string',
            'banner_url' => 'array:string',
            'banner_directory' => 'string',
            'banner_id' => 'number:int'
        ])->getErrors([
            'banner_project' => 'Пожалуйста введите название каталога проекта.',
            'banner_title' => 'Пожалуйста введите название баннера.',
            'banner_type' => 'Пожалуйста выберите тип баннера.',
            'banner_width' => 'Пожалуйста введите ширину баннера.',
            'banner_height' => 'Пожалуйста введите высоту баннера.',
            'banner_thumb_url' => 'Пожалуйста введите URL миниатюры.',
            'banner_url' => 'Пожалуйста введите URL баннера.',
            'banner_directory' => 'Пожалуйста введите каталог баннера.'
        ]);
        if (count($formErrors) > 0) {
            $this->setVars([
                'formErrors' => $formErrors
            ]);
            $this->getView('form-error');
            exit;
        }

        $b = new BannersAdminModel();
        $b->update($input->post());

        $u = new UploadsAdminModel();
        $u->updateInUse($input->post());

        $this->redirect('/admin/banners/');
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function delete($id)
    {
        $b = new BannersAdminModel();
        $banner = $b->single($id);
        $b->delete($id);

        $u = new UploadsAdminModel();
        $u->updateOffUse($banner['directory']);

        $this->redirect('/admin/banners/');
    }
}