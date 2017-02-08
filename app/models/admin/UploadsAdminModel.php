<?php

class UploadsAdminModel extends Model
{
    public function all()
    {
        $sql = 'SELECT * FROM uploads';
        return $this->qBuilder->simpleQuery($sql)->result();
    }
    
    public function allByDirectory($bannerDir)
    {
        $sql = 'SELECT * FROM uploads WHERE banner_directory = :banner_directory';
        $binds = [
            ':banner_directory' => $bannerDir
        ];
        return $this->qBuilder->preparedQuery($sql, $binds)->result();
    }

    public function add($projectDir, $bannerDir)
    {
        $sql = 'INSERT INTO uploads
                (project_directory, banner_directory, uploaded_at, in_use)
                VALUES
                (:project_directory, :banner_directory, NOW(), 0)';
        $binds = [
            ':project_directory' => $projectDir,
            ':banner_directory' => $bannerDir
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    public function updateInUse($post)
    {
        $sql = 'UPDATE uploads SET in_use = 1 WHERE banner_directory = :post_banner_dir';
        $binds = [
            'post_banner_dir' => $post['banner_directory']
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    public function updateOffUse($bannerDir)
    {
        $sql = 'UPDATE uploads SET in_use = 0 WHERE banner_directory = :get_banner_dir';
        $binds = [
            'get_banner_dir' => $bannerDir
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    public function updateUploadTime($bannerDir)
    {
        $sql = 'UPDATE uploads SET uploaded_at = NOW()
                WHERE banner_directory = :banner_directory';
        $binds = [
            ':banner_directory' => $bannerDir
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    public function delete($upload_directory)
    {
        $sql = 'DELETE FROM uploads WHERE banner_directory = :upload_directory';
        $binds = [
            ':upload_directory' => $upload_directory
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }
}