<?php

use vendor\core\Router;
use vendor\core\Request;

$router = new Router();

// admin routes
// --------------------------------------------------------------------------------- //
$router->get('#^/admin/$#i', 'MainAdminController:index');

$router->get('#^/admin/banners/$#i', 'BannersAdminController:index');
$router->get('#^/admin/banners/add$#i', 'BannersAdminController:add');
$router->post('#^/admin/banners/post-add$#i', 'BannersAdminController:post_add');
$router->get('#^/admin/banners/(?P<id>[\d]+)/edit$#i', 'BannersAdminController:edit');
$router->post('#^/admin/banners/post-edit$#i', 'BannersAdminController:post_edit');
$router->post('#^/admin/banners/ajax-post-upload$#i', 'BannersAdminController:ajax_post_upload');
$router->get('#^/admin/banners/(?P<id>[\d]+)/delete$#i', 'BannersAdminController:delete');

$router->get('#^/admin/types/$#i', 'TypesAdminController:index');
$router->get('#^/admin/types/add$#i', 'TypesAdminController:add');
$router->post('#^/admin/types/post-add$#i', 'TypesAdminController:post_add');
$router->get('#^/admin/types/(?P<id>[\d]+)/edit$#i', 'TypesAdminController:edit');
$router->post('#^/admin/types/post-edit$#i', 'TypesAdminController:post_edit');
$router->get('#^/admin/types/(?P<id>[\d]+)/delete$#i', 'TypesAdminController:delete');


$router->get('#^/admin/uploads/$#i', 'UploadsAdminController:index');
$router->get('#^/admin/uploads/add$#i', 'UploadsAdminController:add');
$router->post('#^/admin/uploads/ajax-post-upload$#i', 'UploadsAdminController:ajax_post_upload');
$router->post('#^/admin/uploads/post-add$#i', 'UploadsAdminController:post_add');
$router->get('#^/admin/uploads/(?P<upload_directory>[\S]+)/delete$#i', 'UploadsAdminController:delete');

$router->get('#^/admin/users/$#i', 'UsersAdminController:index');
$router->get('#^/admin/users/add$#i', 'UsersAdminController:add');
$router->post('#^/admin/users/post-add$#i', 'UsersAdminController:post_add');
$router->get('#^/admin/users/(?P<id>[\d]+)/delete$#i', 'UsersAdminController:delete');

$router->get('#^/login$#i', 'AuthController:login');
$router->post('#^/post-login$#i', 'AuthController:post_login');
$router->get('#^/logout$#i', 'AuthController:logout');

// user routes
// --------------------------------------------------------------------------------- //
$router->get('#^[/]?$#i', 'MainController:index');
$router->get('#^/about/$#i', 'MainController:about');
$router->get('#^/prices/$#i', 'MainController:prices');

$router->get('#^/banners/$#i', 'BannersController:index');
$router->get('#^/banners/ajax$#i', 'BannersController:indexAjax');
$router->get('#^/banners/(?P<id>[\d]+)/$#i', 'BannersController:single');

$router->dispatch(Request::uri(), Request::method());