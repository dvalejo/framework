<?php
namespace vendor\core;

class Connection
{
    public static function connect()
    {
        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=cr36093_site', 'cr36093_site', 'me432032');
            $pdo->exec('SET NAMES "utf8"');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (\PDOException $e) {
            $error['message'] = $e->getMessage();
            $error['file'] = $e->getFile();
            $error['line'] = $e->getLine();
            require LOCAL_VIEWS_DIR . "/error.view.php";
            exit();
        }
        return $pdo;
    }
}