<?php

use vendor\core\Router;
use vendor\core\Request;

$router = new Router();

// admin routes
// --------------------------------------------------------------------------------- //
$router->get('#^/admin/$#i', 'AdminMainController:index');

$router->get('#^/admin/banners/$#i', 'AdminBannersController:index');
$router->get('#^/admin/banners/add$#i', 'AdminBannersController:add');
$router->post('#^/admin/banners/post-add$#i', 'AdminBannersController:post_add');
$router->get('#^/admin/banners/(?P<id>[\d]+)/edit$#i', 'AdminBannersController:edit');
$router->post('#^/admin/banners/post-edit$#i', 'AdminBannersController:post_edit');
$router->post('#^/admin/banners/ajax-post-upload$#i', 'AdminBannersController:ajax_post_upload');
$router->get('#^/admin/banners/(?P<id>[\d]+)/delete$#i', 'AdminBannersController:delete');

$router->get('#^/admin/types/$#i', 'AdminTypesController:index');
$router->get('#^/admin/types/add$#i', 'AdminTypesController:add');
$router->post('#^/admin/types/post-add$#i', 'AdminTypesController:post_add');
$router->get('#^/admin/types/(?P<id>[\d]+)/edit$#i', 'AdminTypesController:edit');
$router->post('#^/admin/types/post-edit$#i', 'AdminTypesController:post_edit');
$router->get('#^/admin/types/(?P<id>[\d]+)/delete$#i', 'AdminTypesController:delete');

$router->get('#^/admin/uploads/$#i', 'AdminUploadsController:index');
$router->get('#^/admin/uploads/add$#i', 'AdminUploadsController:add');
$router->post('#^/admin/uploads/ajax-post-upload$#i', 'AdminUploadsController:ajax_post_upload');
$router->post('#^/admin/uploads/post-add$#i', 'AdminUploadsController:post_add');
$router->get('#^/admin/uploads/(?P<upload_directory>[\S]+)/delete$#i', 'AdminUploadsController:delete');

$router->get('#^/admin/users/$#i', 'AdminUsersController:index');
$router->get('#^/admin/users/add$#i', 'AdminUsersController:add');
$router->post('#^/admin/users/post-add$#i', 'AdminUsersController:post_add');
$router->get('#^/admin/users/(?P<id>[\d]+)/delete$#i', 'AdminUsersController:delete');

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