<?php
namespace vendor\core;

use app\models\admin\AdminUsersModel;

class Auth
{
    /**
     * -------------------------------------------------------------------
     */
    public static function check()
    {
        if (empty($_SESSION['id']) OR empty($_SESSION['name'])) {
            return false;
        }
        $u = new AdminUsersModel();
        $user = $u->single($_SESSION['name']);
        if ($user['token'] === $_SESSION['id']) {
            return true;
        }
        return false;
    }
}