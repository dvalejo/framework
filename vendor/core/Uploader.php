<?php
namespace vendor\core;

use vendor\core\exceptions\UploadException;

class Uploader
{
    protected $inputFile;
    protected $allowedExtensions;
    protected $isUploaded = false;
    protected $fileName;
    protected $fileNameBeforeDot;
    protected $fileTempName;
    protected $fileExtension;
    protected $fileType;
    protected $fileSize;
    protected $fileError;
    protected $fileDestination;
    protected $error;

    /**
     * Uploader constructor.
     * @param array $options
     * -----------------------------------------------------------------------------
     */
    public function __construct(array $options)
    {
        $this->inputFile = $options['input'];
        $this->allowedExtensions = $options['extensions'];
    }

    /**
     * @return mixed
     * -----------------------------------------------------------------------------
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param $extensions
     * @return $this
     * @throws UploadException
     * -----------------------------------------------------------------------------
     */
    public function getFile()
    {
        try {
            if (empty($_FILES[$this->inputFile]['name']) && empty($_FILES[$this->inputFile]['size'])) {
                $this->error = 'Нет файлов для загрузки.';
                throw new UploadException($this->error);
            }
            $this->fileName = $_FILES[$this->inputFile]['name'];
            $this->fileNameBeforeDot = pathinfo($this->fileName, PATHINFO_FILENAME);
            $this->fileTempName = $_FILES[$this->inputFile]['tmp_name'];
            $this->fileExtension = pathinfo($this->fileName, PATHINFO_EXTENSION);
            $this->fileType = $_FILES[$this->inputFile]['type'];
            $this->fileSize = $_FILES[$this->inputFile]['size'];
            $this->fileError = $_FILES[$this->inputFile]['error'];

            if ($this->fileError !== 0) {
                switch ($this->fileError) {
                    case 1: $this->error = 'Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini'; break;
                    case 2: $this->error = 'Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме.'; break;
                    case 3: $this->error = 'Загружаемый файл был получен только частично.'; break;
                    case 4: $this->error = 'Файл не был загружен.'; break;
                    case 5: $this->error = 'Отсутствует временная папка.'; break;
                    case 6: $this->error = 'Не удалось записать файл на диск.'; break;
                    case 7: $this->error = 'PHP-расширение остановило загрузку файла.'; break;
                    default: $this->error = 'Другая ошибка.'; break;
                }
                throw new UploadException($this->error);
            }
            if ( ! is_uploaded_file($_FILES[$this->inputFile]['tmp_name'])) {
                $this->error = 'Файл не был загружен с помощью формы загрузки.';
                throw new UploadException($this->error);
            }
            if ( ! in_array($this->fileExtension, $this->allowedExtensions)) {
                $this->error = 'Недопустимое расширение файла: [' . $this->fileExtension . ']. Разрешены: [' . implode(',', $this->allowedExtensions) . ']';
                throw new UploadException($this->error);
            }
        }
        catch (UploadException $e) {
            $e->errorMessage();
            exit();
        }
        $this->isUploaded = true;
        return $this;
    }

    /**
     * @param $directory
     * @return $this
     * @throws UploadException
     * -----------------------------------------------------------------------------
     */
    public function moveTo($directory)
    {
        try {
            if ( ! $this->isUploaded) {
                $this->error = 'Сначала необходимо получить файлы с сервера функцией getFile()';
                throw new UploadException($this->error);
            }

            if ( ! is_dir($directory)) {
                if ( ! mkdir($directory, 0777, true)) {
                    $this->error = 'Не можем создать каталог для файла. Возможно он уже существует.';
                    throw new UploadException($this->error);
                }
            }

            $fileFullPath = $directory . DIRECTORY_SEPARATOR . $this->fileName;
            if ( ! move_uploaded_file($this->fileTempName, $fileFullPath)) {
                $this->error = 'Не можем переместить файл из php/temp.';
                throw new UploadException($this->error);
            }
            $this->fileDestination = $directory;
            return $this;
        }
        catch (UploadException $e) {
            $e->errorMessage();
            exit();
        }
    }

    /**
     * @param $directory
     * @param bool $toArchName
     * @return $this
     * @throws UploadException
     * -----------------------------------------------------------------------------
     */
    public function unZipTo($directory, $withArchName = false)
    {
        if ($withArchName === true) {
            $this->fileDestination = $directory . DIRECTORY_SEPARATOR . $this->fileNameBeforeDot;
        }
        else {
            $this->fileDestination = $directory;
        }
        $this->moveTo($this->fileDestination);

        try {
            if ( ! $this->isUploaded) {
                $this->error = 'Сначала необходимо получить файлы с сервера функцией getFile()';
                throw new UploadException($this->error);
            }

            $zip = new \ZipArchive();
            $arch = $zip->open($this->fileDestination . DIRECTORY_SEPARATOR . $this->fileName);
            if ( ! $arch === true) {
                $this->error = 'Не можем открыть архив.';
                throw new UploadException($this->error);
            }

            if ( ! $zip->extractTo($this->fileDestination)) {
                $this->error = 'Не можем извлечь файлы из архива.';
                throw new UploadException($this->error);
            }
            $zip->close();
            if ( ! unlink($this->fileDestination . DIRECTORY_SEPARATOR . $this->fileName)) {
                $this->error = 'Не можем удалить файл архива.';
                throw new UploadException($this->error);
            }
            return $this;
        }
        catch (UploadException $e) {
            $e->errorMessage();
            exit();
        }
    }
}