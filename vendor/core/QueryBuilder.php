<?php
namespace vendor\core;

class QueryBuilder
{
    private $pdo;
    private $statement;

    /**
     * QueryBuilder constructor.
     * @param \PDO $pdo
     * -------------------------------------------------------------------
     */
    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $sql
     * @return $this
     * -------------------------------------------------------------------
     */
    public function simpleQuery($sql)
    {
        try {
            $this->statement = $this->pdo->query($sql);
            return $this;
        }
        catch (\PDOException $e) {
            $error['message'] = $e->getMessage();
            $error['file'] = $e->getFile();
            $error['line'] = $e->getLine();
            $error['trace'] = $e->getTrace();
            require LOCAL_VIEWS_DIR . "/error.view.php";
            exit();
        }
    }

    /**
     * @param $sql
     * @param $binds
     * @return $this
     * -------------------------------------------------------------------
     */
    public function preparedQuery($sql, $binds)
    {
        try {
            $this->statement = $this->pdo->prepare($sql);
            $this->statement->execute($binds);
            return $this;
        }
        catch (\PDOException $e) {
            $error['message'] = $e->getMessage();
            $error['file'] = $e->getFile();
            $error['line'] = $e->getLine();
            require LOCAL_VIEWS_DIR . "/error.view.php";
            exit();
        }
    }

    /**
     * @param $param
     * @return bool
     * -------------------------------------------------------------------
     */
    public function result($param)
    {
        switch ($param) {
            case 'single': return $this->statement->fetch(\PDO::FETCH_ASSOC); break;
            case 'all': return $this->statement->fetchAll(\PDO::FETCH_ASSOC); break;
            default: break;
        }
        return false;
    }
}