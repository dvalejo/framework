<?php

class UsersModel extends Model
{
    public function all()
    {
        $sql = 'SELECT * FROM users';
        return $users = $this->qBuilder->simpleQuery($sql)->result();
    }

    public function single($id)
    {
        $sql = 'SELECT * FROM users WHERE name = :sess_name';
        $binds = [
            ':sess_name' => $id
        ];
        return $user = $this->qBuilder->preparedQuery($sql, $binds)->result();
    }
}