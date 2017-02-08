<?php

class BannersModel extends Model
{
    public function all()
    {
        $sql = 'SELECT b.id, b.title, b.width, b.height, b.url, b.thumb_url, t.name t_name
                FROM banners AS b
                INNER JOIN types AS t ON b.type_slug = t.slug
                ORDER BY b.id';
        return $banners = $this->qBuilder->simpleQuery($sql)->result();
    }
    
    public function single($id)
    {
        $urls = [];
        $sql = 'SELECT title, type_slug, width, height, project, directory, url, description, created_at, updated_at 
                FROM banners WHERE id = :id';
        $binds = [
            ':id' => $id
        ];
        $banner = $this->qBuilder->preparedQuery($sql, $binds)->result();
        $urls = explode(',', $banner['url']);
        $banner['url'] = count($urls) === 1 ? $urls[0] : $urls;
        return $banner;
    }
}