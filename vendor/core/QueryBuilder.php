<?php

class QueryBuilder
{
    private $pdo;
    private $statement;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function simpleQuery($sql)
    {
        try {
            $this->statement = $this->pdo->query($sql);
            return $this;
        }
        catch (PDOException $e) {
            $error['message'] = $e->getMessage();
            $error['file'] = $e->getFile();
            $error['line'] = $e->getLine();
            require LOCAL_VIEWS_DIR . "/error.view.php";
            exit();
        }
    }

    public function preparedQuery($sql, $binds)
    {
        try {
            $this->statement = $this->pdo->prepare($sql);
            $this->statement->execute($binds);
            return $this;
        }
        catch (PDOException $e) {
            $error['message'] = $e->getMessage();
            $error['file'] = $e->getFile();
            $error['line'] = $e->getLine();
            require LOCAL_VIEWS_DIR . "/error.view.php";
            exit();
        }
    }

    public function result()
    {
        $rows = $this->statement->fetchAll(PDO::FETCH_ASSOC);
        return count($rows) === 1 ? $rows[0] : $rows;
    }
}