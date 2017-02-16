<?php

class BannersModel extends Model
{
    public function all()
    {
        $sql = 'SELECT b.id, b.title, b.width, b.height, b.url, b.thumbnail_url, t.name t_name
                FROM banners AS b
                INNER JOIN types AS t ON b.type_slug = t.slug
                ORDER BY b.id';
        return $banners = $this->qBuilder->simpleQuery($sql)->result('all');
    }
    
    public function single($id)
    {
        $urls = [];
        $sql = 'SELECT project, type_slug, width, height, title, url, description, created_at, updated_at 
                FROM banners WHERE id = :id';
        $binds = [
            ':id' => $id
        ];
        $banner = $this->qBuilder->preparedQuery($sql, $binds)->result('single');
        $urls = explode(',', $banner['url']);
        $banner['url'] = count($urls) > 1 ? $urls : $urls[0];
        return $banner;
    }
}