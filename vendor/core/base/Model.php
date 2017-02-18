<?php
namespace vendor\core\base;

use vendor\core\Connection;
use vendor\core\QueryBuilder;

class Model
{
    protected $qBuilder;

    function __construct()
    {
        $this->qBuilder = new QueryBuilder(Connection::connect());
    }
}