<?php

require 'bootstrap.php';

session_start();

$router = new Router();

// admin routes
// --------------------------------------------------------------------------------- //
$router->add('#^/admin/$#i', 'MainAdminController:index');

$router->add('#^/admin/banners/$#i', 'BannersAdminController:index');
$router->add('#^/admin/banners/add$#i', 'BannersAdminController:add');
$router->add('#^/admin/banners/post-add$#i', 'BannersAdminController:post_add');
$router->add('#^/admin/banners/(?P<id>[\d]+)/edit$#i', 'BannersAdminController:edit');
$router->add('#^/admin/banners/post-edit$#i', 'BannersAdminController:post_edit');
$router->add('#^/admin/banners/post-upload$#i', 'BannersAdminController:post_upload');
$router->add('#^/admin/banners/(?P<id>[\d]+)/delete$#i', 'BannersAdminController:delete');

$router->add('#^/admin/types/$#i', 'TypesAdminController:index');
$router->add('#^/admin/types/add$#i', 'TypesAdminController:add');
$router->add('#^/admin/types/post-add$#i', 'TypesAdminController:post_add');
$router->add('#^/admin/types/(?P<id>[\d]+)/edit$#i', 'TypesAdminController:edit');
$router->add('#^/admin/types/post-edit$#i', 'TypesAdminController:post_edit');
$router->add('#^/admin/types/(?P<id>[\d]+)/delete$#i', 'TypesAdminController:delete');

$router->add('#^/admin/uploads/$#i', 'UploadsAdminController:index');
$router->add('#^/admin/uploads/(?P<upload_directory>[\S]+)/delete$#i', 'UploadsAdminController:delete');

$router->add('#^/admin/users/$#i', 'UsersAdminController:index');
$router->add('#^/admin/users/add$#i', 'UsersAdminController:add');
$router->add('#^/admin/users/post-add$#i', 'UsersAdminController:post_add');
$router->add('#^/admin/users/(?P<id>[\d]+)/delete$#i', 'UsersAdminController:delete');

$router->add('#^/login$#i', 'AuthController:login');
$router->add('#^/post-login$#i', 'AuthController:post_login');
$router->add('#^/logout$#i', 'AuthController:logout');

// user routes
// --------------------------------------------------------------------------------- //
$router->add('#^[/]?$#i', 'MainController:index');
$router->add('#^/about/$#i', 'MainController:about');
$router->add('#^/prices/$#i', 'MainController:prices');

$router->add('#^/banners/$#i', 'BannersController:index');
$router->add('#^/banners/ajax$#i', 'BannersController:indexAjax');
$router->add('#^/banners/(?P<id>[\d]+)/$#i', 'BannersController:single');

$router->dispatch();
