<?php

class Model
{
    protected $qBuilder;

    function __construct()
    {
        $this->qBuilder = new QueryBuilder(Connection::connect());
    }
}