<?php
namespace app\controllers\admin;

use vendor\core\base\Controller;
use vendor\core\Auth;
use vendor\core\Input;
use app\models\admin\BannersAdminModel;
use app\models\admin\TypesAdminModel;

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
            'banner_width' => 'string',
            'banner_height' => 'string',
            'banner_title' => 'string',
            'banner_thumb_url' => 'url',
            'banner_url' => 'array:url'
        ])->getErrors([
            'banner_project' => 'Введите корректное название каталога проекта.',
            'banner_type' => 'Выберите тип баннера.',
            'banner_width' => 'Введите корректную ширину баннера.',
            'banner_height' => 'Введите корректную высоту баннера.',
            'banner_title' => 'Введите название баннера.',
            'banner_thumb_url' => 'Введите корректную ссылку на миниатюру.',
            'banner_url' => 'Введите корректную ссылку на баннер.'
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
        $this->redirect('/admin/banners/');
    }

    /**
     * -------------------------------------------------------------------
     */
    public function ajax_post_upload()
    {
        $result = [];
        $input = new Input();
        $result['errors'] = $input->filter('post', [
            'banner_project' => 'string',
            'banner_type' => 'string',
            'banner_width' => 'string',
            'banner_height' => 'string',
            'banner_directory' => 'url',
            'banner_edit' => 'number:int'
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
            $result['errors'] = 'Нет файлов для загрузки.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        $bannerFileName = basename($_FILES['banner_file']['name']);
        $bannerTempName = $_FILES['banner_file']['tmp_name'];
        $bannerExtension = pathinfo($bannerFileName, PATHINFO_EXTENSION);
        $bannerName = pathinfo($bannerFileName, PATHINFO_FILENAME);
        $bannerProject = $input->post('banner_project');
        $bannerType = $input->post('banner_type');

        // Если это редактирование баннера, а не добавление
        if ($input->post('banner_edit') === 1) {
            $bannerOldDirectory = $input->post('banner_directory');
            // Предварительно удаляем директорию со старым баннером
            removeDirectoryWithFiles($bannerOldDirectory);
        }

        $bannerUnzipFullDir = LOCAL_BANNERS_DIR . _DS_ . $bannerType . _DS_ . $bannerProject . _DS_ . $bannerName;
        $bannerFullName = $bannerUnzipFullDir . _DS_ . $bannerFileName;

        // -----------------------------------------------------------------------------
        if ($_FILES['banner_file']['error'] !== 0) {
            switch ($_FILES['banner_file']['error']) {
                case 1:
                    $result['errors'][] = 'Ваш файл слишком большой.';
                    break;
                default:
                    $result['errors'][] = 'Другая ошибка.';
                    break;
            }
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // -----------------------------------------------------------------------------
        if ( ! is_uploaded_file($bannerTempName)) {
            $result['errors'][] = 'Файл не был загружен с помощью формы загрузки.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // -----------------------------------------------------------------------------
        if ( ! in_array($bannerExtension, ['zip'])) {
            $result['errors'][] = 'Недопустимое расширение файла. Можно загружать только zip - архивы.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // -----------------------------------------------------------------------------
        if ( ! is_dir($bannerUnzipFullDir)) {
            if ( ! mkdir($bannerUnzipFullDir, 0777, true)) {
                $result['errors'][] = 'Не можем создать каталог для баннера. Возможно он уже существует.';
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
                exit();
            }
        }

        // -----------------------------------------------------------------------------
        if ( ! move_uploaded_file($bannerTempName, $bannerFullName)) {
            $result['errors'][] = 'Не можем переместить файл из php/temp.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // -----------------------------------------------------------------------------
        $zip = new \ZipArchive();
        $arch = $zip->open($bannerFullName);
        if ( ! $arch === true) {
            $result['errors'][] = 'Не можем открыть архив.';
            unlink($bannerFullName);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // -----------------------------------------------------------------------------
        if ( ! $zip->extractTo($bannerUnzipFullDir)) {
            $result['errors'][] = 'Не можем извлечь файлы из архива.';
            unlink($bannerFullName);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }
        $zip->close();

        // Looking for a banner and thumbnail files in unzipped directory
        // -----------------------------------------------------------------------------
        $thumbFiles = [];
        $bannerFiles = [];

        foreach (new \DirectoryIterator($bannerUnzipFullDir) as $file) {
            if ($file->isDot()) continue;

            if (preg_match('#^(thumb.*?)(\.)(jpg|png)$#i', $file->getFilename())) {
                $thumbFiles[] = $file->getPathname();
            }
            else {
                switch ($bannerType) {
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
            $result['errors'][] = 'Не можем найти в распакованном архиве файл миниатюры. Название миниатюры должно начинаться со слова `thumb` и иметь расширение JPG или PNG';
            unlink($bannerFullName);
            removeDirectoryWithFiles($bannerUnzipFullDir);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // -----------------------------------------------------------------------------
        if (empty($bannerFiles)) {
            $result['errors'][] = 'Не можем найти в распакованном архиве файл(ы) баннера. Возможно вы ошиблись с типом баннера.';
            unlink($bannerFullName);
            removeDirectoryWithFiles($bannerUnzipFullDir);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        foreach ($thumbFiles as $thumbFile) {
            $result['local']['thumbs'][] = $thumbFile;
            $result['urls']['thumbs'][] = HTTP_BANNERS_DIR . _DS_ . $bannerType . _DS_ . $bannerProject . _DS_ . $bannerName . _DS_ . basename($thumbFile);
        }
        foreach ($bannerFiles as $bannerFile) {
            $result['local']['banners'][] = $bannerFile;
            $result['urls']['banners'][] = HTTP_BANNERS_DIR . _DS_ . $bannerType . _DS_ . $bannerProject . _DS_ . $bannerName . _DS_ . basename($bannerFile);
        }
        $result['title'] = $bannerName;

        // -----------------------------------------------------------------------------
        if ( ! unlink($bannerFullName)) {
            $result['errors'][] = 'Не можем удалить архив баннера.';
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // -----------------------------------------------------------------------------
        $result['message'] = 'Загрузка завершена!';
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
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
        $bannerUrls = explode(',', $banner['url']);
        // Get current banner directory
        $bannerDirectory = LOCAL_BANNERS_DIR ._DS_. $banner['type_slug'] ._DS_. $banner['project'] ._DS_. $banner['title'];

        $this->setVars([
            'types' => $types,
            'banner' => $banner,
            'bannerUrls' => $bannerUrls,
            'bannerDirectory' => $bannerDirectory
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
            'banner_type' => 'string',
            'banner_width' => 'string',
            'banner_height' => 'string',
            'banner_title' => 'string',
            'banner_thumb_url' => 'url',
            'banner_url' => 'array:url',
            'banner_id' => 'number:int'
        ])->getErrors([
            'banner_project' => 'Введите корректное название каталога проекта.',
            'banner_type' => 'Выберите тип баннера.',
            'banner_width' => 'Введите корректную ширину баннера.',
            'banner_height' => 'Введите корректную высоту баннера.',
            'banner_title' => 'Введите название баннера.',
            'banner_thumb_url' => 'Введите корректную ссылку на миниатюру.',
            'banner_url' => 'Введите корректную ссылку на баннер.'
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
        // Удаляем баннер и если каталог проекта пустой - его тоже удаляем
        // --------------------------------
        $banner_project = LOCAL_BANNERS_DIR . _DS_ . $banner['type_slug'] . _DS_ . $banner['project'];
        $banner_directory = $banner_project . _DS_ . $banner['title'];
        removeDirectoryWithFiles($banner_directory);
        if (directoryIsEmpty($banner_project)) {
            rmdir($banner_project);
        }
        // --------------------------------
        $b->delete($id);
        $this->redirect('/admin/banners/');
    }
}