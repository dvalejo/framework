<?php
namespace vendor\core;

use vendor\core\exceptions\DatabaseException;

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
            try {
                throw new DatabaseException($e->getMessage());
            }
            catch (DatabaseException $e) {
                $e->errorMessage();
                exit();
            }
        }
        return $pdo;
    }
}