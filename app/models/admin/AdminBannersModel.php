<?php
namespace app\models\admin;

use vendor\core\base\Model;

class AdminBannersModel extends Model
{
    public function all()
    {
        $sql = 'SELECT banners.*, DATE_FORMAT(banners.updated_at,\'%d-%m-%Y %H:%i\') as updated_at, types.name AS type_name
                FROM banners
                LEFT JOIN types ON banners.type_slug = types.slug';
        return $this->qBuilder->simpleQuery($sql)->result('all');
    }

    public function single($id)
    {
        $sql = 'SELECT * FROM banners WHERE id = :id';
        $binds = [
            ':id' => $id
        ];
        return $this->qBuilder->preparedQuery($sql, $binds)->result('single');
    }

    public function add($post)
    {
        $sql = 'INSERT INTO banners 
                (project, type_slug, width, height, title, thumbnail_url, url, created_at) 
                VALUES 
                (:banner_project, :banner_type, :banner_width, :banner_height, :banner_title, :banner_thumb_url, :banner_url, NOW())';
        $binds = [
            ':banner_project' => $post['banner_project'],
            ':banner_type' => $post['banner_type'],
            ':banner_width' => $post['banner_width'],
            ':banner_height' => $post['banner_height'],
            ':banner_title' => $post['banner_title'],
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
                  type_slug = :banner_type,
                  width = :banner_width,
                  height = :banner_height,
                  title = :banner_title,
                  thumbnail_url = :banner_thumb_url,
                  url = :banner_url,
                  updated_at = NOW()
                WHERE id = :banner_id';
        $binds = [
            ':banner_project' => $post['banner_project'],
            ':banner_type' => $post['banner_type'],
            ':banner_width' => $post['banner_width'],
            ':banner_height' => $post['banner_height'],
            ':banner_title' => $post['banner_title'],
            ':banner_thumb_url' => $post['banner_thumb_url'],
            // Make string from
            ':banner_url' => implode(',', $post['banner_url']),
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