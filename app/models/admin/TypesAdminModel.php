<?php

class TypesAdminModel extends Model
{
    public function all()
    {
        $sql = 'SELECT types.*, count(banners.id) AS quantity
                FROM types
                LEFT JOIN banners ON types.slug = banners.type_slug
                GROUP BY types.id;';
        return $types = $this->qBuilder->simpleQuery($sql)->result();
    }

    public function allForBanners()
    {
        $sql = 'SELECT * FROM types';
        return $this->qBuilder->simpleQuery($sql)->result();
    }

    public function single($id)
    {
        $sql = 'SELECT * FROM types WHERE id = :type_id';
        $binds = [
            ':type_id' => $id
        ];
        return $type = $this->qBuilder->preparedQuery($sql, $binds)->result();
    }

    public function add($post)
    {
        $sql = 'INSERT INTO types 
                (name, slug, created_at, updated_at) 
                VALUES 
                (:type_name, :type_slug, NOW(), NULL)';
        $binds = [
            ':type_name' => $post['type_name'],
            ':type_slug' => $post['type_slug']
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    public function update($post)
    {
        $sql = 'UPDATE types 
                SET name = :type_name, 
                    slug = :type_slug,
                    updated_at = NOW()
                WHERE id = :type_id';
        $binds = [
            ':type_id' => $post['type_id'],
            ':type_name' => $post['type_name'],
            ':type_slug' => $post['type_slug']
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM types WHERE id = :type_id';
        $binds = [
            ':type_id' => $id
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }
}