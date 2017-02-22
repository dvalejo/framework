<?php
namespace app\models\admin;

use vendor\core\base\Model;

class AdminUsersModel extends Model
{
    /**
     * @return mixed
     * -------------------------------------------------------------------
     */
    public function all() {
        $sql = 'SELECT * FROM users';
        return $this->qBuilder->simpleQuery($sql)->result('all');
    }

    /**
     * @param $session_name
     * -------------------------------------------------------------------
     */
    public function single($session_name)
    {
        $sql = 'SELECT * FROM users WHERE name = :sess_name';
        $binds = [
            ':sess_name' => $session_name
        ];
        return $this->qBuilder->preparedQuery($sql, $binds)->result('single');
    }

    /**
     * @param $post
     * @param $hash
     * -------------------------------------------------------------------
     */
    public function add($post, $hash)
    {
        $sql = 'INSERT INTO users 
                (name, password, created_at, updated_at) 
                VALUES 
                (:user_name, :user_password, NOW(), NULL)';
        $binds = [
            ':user_name' => $post['user_name'],
            ':user_password' => $hash
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    /**
     * @param $post
     * -------------------------------------------------------------------
     */
    public function update($user)
    {
        $sql = 'UPDATE users SET token = :sid WHERE name = :user_name';
        $binds = [
            ':sid' => session_id(),
            ':user_name' => $user['name']
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }

    /**
     * @param $id
     * -------------------------------------------------------------------
     */
    public function delete($id) {
        $sql = 'DELETE FROM users WHERE id = :user_id';
        $binds = [
            ':user_id' => $id
        ];
        $this->qBuilder->preparedQuery($sql, $binds);
    }
}