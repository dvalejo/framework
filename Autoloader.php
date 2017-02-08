<?php

class Autoloader
{
    private $directories = [];

    public function __construct($directories)
    {
        $this->directories = $directories;
    }

    public function run()
    {
        if (empty($this->directories) OR !is_array($this->directories)) {
            return false;
        }
        foreach ($this->directories as $directory) {
            spl_autoload_register(function ($className) use ($directory) {
                if (file_exists($directory . _DS_ . $className . '.php')) {
                    include $directory . _DS_ . $className . '.php';
                    return true;
                }
                return false;
            });
        }
        return true;
    }
}