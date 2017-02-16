<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('_DS_', DIRECTORY_SEPARATOR);

define('LOCAL_PATH_DIR', $_SERVER['DOCUMENT_ROOT']);
define('HTTP_PATH_DIR', $_SERVER['HTTP_HOST']);

define('LOCAL_SITE_DIR', __DIR__);
define('LOCAL_VENDOR_DIR', LOCAL_SITE_DIR . _DS_ . 'vendor');
define('LOCAL_CORE_DIR', LOCAL_VENDOR_DIR . _DS_ . 'core');
define('LOCAL_BASE_DIR', LOCAL_CORE_DIR . _DS_ . 'base');
define('LOCAL_APP_DIR', LOCAL_SITE_DIR . _DS_ . 'app');
define('LOCAL_PUBLIC_DIR', LOCAL_SITE_DIR . _DS_ . 'public');
define('LOCAL_MODELS_DIR', LOCAL_APP_DIR . _DS_ . 'models');
define('LOCAL_CONTROLLERS_DIR', LOCAL_APP_DIR . _DS_ . 'controllers');
define('LOCAL_VIEWS_DIR', LOCAL_APP_DIR . _DS_ . 'views');
define('LOCAL_STYLESHEET_DIR', LOCAL_PUBLIC_DIR . _DS_ . 'css');
define('LOCAL_JS_DIR', LOCAL_PUBLIC_DIR . _DS_ . 'js');
define('LOCAL_PORTFOLIO_DIR', LOCAL_SITE_DIR . _DS_ . 'portfolio');
define('LOCAL_BANNERS_DIR', LOCAL_PORTFOLIO_DIR . _DS_ . 'banners');
define('LOCAL_TEMP_DIR', LOCAL_PORTFOLIO_DIR . _DS_ . 'temp');

define('LOCAL_ADMIN_CONTROLLERS_DIR', LOCAL_CONTROLLERS_DIR . _DS_ . 'admin');
define('LOCAL_ADMIN_MODELS_DIR', LOCAL_MODELS_DIR . _DS_ . 'admin');
define('LOCAL_ADMIN_VIEWS_DIR', LOCAL_VIEWS_DIR . _DS_ . 'admin');

define('HTTP_SITE_DIR', str_replace(LOCAL_PATH_DIR, '', LOCAL_SITE_DIR));
define('HTTP_APP_DIR', HTTP_SITE_DIR . _DS_ . 'app');
define('HTTP_PUBLIC_DIR', HTTP_SITE_DIR . _DS_ . 'public');
define('HTTP_MODELS_DIR', HTTP_APP_DIR . _DS_ . 'models');
define('HTTP_CONTROLLERS_DIR', HTTP_APP_DIR . _DS_ . 'controllers');
define('HTTP_VIEWS_DIR', HTTP_APP_DIR . _DS_ . 'views');
define('HTTP_STYLESHEET_DIR', HTTP_PUBLIC_DIR . _DS_ . 'css');
define('HTTP_JS_DIR', HTTP_PUBLIC_DIR . _DS_ . 'js');
define('HTTP_PORTFOLIO_DIR', HTTP_SITE_DIR . _DS_ . 'portfolio');
define('HTTP_BANNERS_DIR', HTTP_PORTFOLIO_DIR . _DS_ . 'banners');