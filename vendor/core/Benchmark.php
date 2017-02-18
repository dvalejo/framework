<?php
namespace vendor\core;

class Benchmark
{
    static protected $startTime;
    static protected $stopTime;

    static public function start()
    {
        self::$startTime = microtime(true);
	}

    static public function stop()
    {
        self::$stopTime = microtime(true);
    }

    static public function result()
    {
        return (self::$stopTime - self::$startTime);
    }
}