<?php

class BannersAdminModel extends Model
{
    public function all()
    {
        $sql = 'SELECT banners.*, types.name AS type_name, uploads.id AS upload_id
                FROM banners
                LEFT JOIN types ON banners.type_slug = types.slug
                LEFT JOIN uploads ON banners.directory = uploads.banner_directory';
        return $this->qBuilder->simpleQuery($sql)->result();
    }

    public function single($id)
    {
        $sql = 'SELECT * FROM banners WHERE id = :id';
        $binds = [
            ':id' => $id
        ];
        return $this->qBuilder->preparedQuery($sql, $binds)->result();
    }

    public function add($post)
    {
        $sql = 'INSERT INTO banners 
                (title, type_slug, width, height, project, directory, url, thumb_url, created_at, updated_at) 
                VALUES 
                (:banner_title, :banner_type, :banner_width, :banner_height, :banner_project, :banner_directory, :banner_url, :banner_thumb_url, NOW(), NULL)';
        $binds = [
            ':banner_title' => $post['banner_title'],
            ':banner_type' => $post['banner_type'],
            ':banner_width' => $post['banner_width'],
            ':banner_height' => $post['banner_height'],
            ':banner_project' => $post['banner_project'],
            ':banner_directory' => $post['banner_directory'],
            ':banner_url' => implode(',', $post['banner_url']),
            ':banner_thumb_url' => $post['banner_thumb_url']
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    public function update($post)
    {
        $sql = 'UPDATE banners 
                SET
                  project = :banner_project,
                  title = :banner_title,
                  type_slug = :banner_type,
                  width = :banner_width,
                  height = :banner_height,
                  thumb_url = :banner_thumb_url,
                  url = :banner_url,
                  directory = :banner_directory,
                  updated_at = NOW()
                WHERE id = :banner_id';
        $binds = [
            ':banner_project' => $post['banner_project'],
            ':banner_title' => $post['banner_title'],
            ':banner_type' => $post['banner_type'],
            ':banner_width' => $post['banner_width'],
            ':banner_height' => $post['banner_height'],
            ':banner_thumb_url' => $post['banner_thumb_url'],
            // Make string from
            ':banner_url' => implode(',', $post['banner_url']),
            ':banner_directory' => $post['banner_directory'],
            ':banner_id' => $post['banner_id']
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM banners WHERE id = :banner_id';
        $binds = [
            ':banner_id' => $id
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }
}