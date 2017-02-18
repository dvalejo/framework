<?php
namespace vendor\core;

class Request {

    public static function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function referer() {
        return $_SERVER['HTTP_REFERER'];
    }
}