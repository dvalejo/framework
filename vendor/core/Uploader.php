<?php

class Uploader
{
    protected $inputFile;
    protected $files;
    protected $currentFile;

    public function __construct($inputFile)
    {
        $this->inputFile = $inputFile;
        $this->files = $_FILES;

        if ($_FILES[$this->inputFile]['error'] !== 0) {
            switch ($_FILES[$this->inputFile]['error']) {
                case 1:
                    $result['errors'][] = 'Размер принятого файла превысил максимально допустимый размер, 
                    который задан директивой upload_max_filesize конфигурационного файла php.ini';
                    break;
                case 2:
                    $result['errors'][] = 'Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме.';
                    break;
                case 3:
                    $result['errors'][] = 'Загружаемый файл был получен только частично.';
                    break;
                case 4:
                    $result['errors'][] = 'Файл не был загружен.';
                    break;
                case 5:
                    $result['errors'][] = 'Отсутствует временная папка.';
                    break;
                case 6:
                    $result['errors'][] = 'Не удалось записать файл на диск.';
                    break;
                case 7:
                    $result['errors'][] = 'PHP-расширение остановило загрузку файла.';
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
    }

    public function getFile($fileName)
    {

    }
}



//$upload->getFile('filename.swf');
//$upload->moveTo('/portfolio/banners/');
//$upload->unzipTo('/portfolio/banners/superbanner');
//$upload->remove();
$upload->getFile('file.zip')->unzipTo('/portfolio/banners/superbanner')->remove();