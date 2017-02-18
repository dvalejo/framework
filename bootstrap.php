<?php

require "config.php";
require "functions.php";

spl_autoload_register(function($className){
    $class = LOCAL_ROOT . _DS_ . str_replace('\\', _DS_, $className) . '.php';
    if (is_file($class)) require $class;
});

define('ABSPATH', 1);