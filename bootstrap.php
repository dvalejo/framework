<?php

require "config.php";
require "functions.php";
require "Autoloader.php";

$autoloader = new Autoloader([
    LOCAL_VENDOR_DIR,
    LOCAL_CORE_DIR,
    LOCAL_BASE_DIR,
    LOCAL_CONTROLLERS_DIR,
    LOCAL_MODELS_DIR,
    LOCAL_ADMIN_CONTROLLERS_DIR,
    LOCAL_ADMIN_MODELS_DIR
]);
$autoloader->run();

define('ABSPATH', 1);