<?php

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
// $router->add('', ['controller' => 'Home', 'action' => 'index']);
// UI Routes
$router->add('admin', ['controller' => 'HomeController', 'action' => 'login']);
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
// $router->add('bulletins', ['controller' => 'HomeController', 'action' => '']);
$router->add('bulletins/download/{id}', ['controller' => 'BulletinController','action' => 'download']);
// $router->add('login', ['controller' => 'HomeController', 'action' => 'login']);

// Admin panel faculties Routes
$router->add('admin/faculties', ['controller' => 'FacultyController', 'action' => 'index']);
$router->add('admin/faculty-create', ['controller' => 'FacultyController', 'action' => 'create']);
$router->add('admin/faculty-store', ['controller' => 'FacultyController', 'action' => 'store']);
$router->add('admin/faculty-edit', ['controller' => 'FacultyController', 'action' => 'edit']);
$router->add('admin/faculty-update', ['controller' => 'FacultyController', 'action' => 'update']);
$router->add('admin/faculty-delete', ['controller' => 'FacultyController', 'action' => 'destroy']);

// Admin panel positions Routes
$router->add('admin/positions', ['controller' => 'PositionController', 'action' => 'index']);
$router->add('admin/position-create', ['controller' => 'PositionController', 'action' => 'create']);
$router->add('admin/position-store', ['controller' => 'PositionController', 'action' => 'store']);
$router->add('admin/position-edit', ['controller' => 'PositionController', 'action' => 'edit']);
$router->add('admin/position-update', ['controller' => 'PositionController', 'action' => 'update']);
$router->add('admin/position-delete', ['controller' => 'PositionController', 'action' => 'destroy']);

// Admin panel bulletins Routes
$router->add('admin/bulletins', ['controller' => 'BulletinController', 'action' => 'index']);
$router->add('admin/bulletin-create', ['controller' => 'BulletinController', 'action' => 'create']);
$router->add('admin/bulletin-store', ['controller' => 'BulletinController', 'action' => 'store']);
$router->add('admin/bulletin-edit', ['controller' => 'BulletinController', 'action' => 'edit']);
$router->add('admin/bulletin-update', ['controller' => 'BulletinController', 'action' => 'update']);
$router->add('admin/bulletin-delete', ['controller' => 'BulletinController', 'action' => 'destroy']);
$router->add('bulletin-download', ['controller' => 'BulletinController','action' => 'downloadPdf']);
$router->add('bulletin-view', ['controller' => 'BulletinController','action' => 'viewFile']);

// Admin panel users Routes
$router->add('admin/users', ['controller' => 'UserController', 'action' => 'index']);
$router->add('admin/user-create', ['controller' => 'UserController', 'action' => 'create']);
$router->add('admin/user-store', ['controller' => 'UserController', 'action' => 'store']);
$router->add('admin/user-edit', ['controller' => 'UserController', 'action' => 'edit']);
$router->add('admin/user-update', ['controller' => 'UserController', 'action' => 'update']);
$router->add('admin/user-delete', ['controller' => 'UserController', 'action' => 'destroy']);


$router->add('login', ['controller' => 'AuthController', 'action' => 'loginForm']);
$router->add('login-store', ['controller' => 'AuthController', 'action' => 'store']);
$router->add('logout', ['controller' => 'AuthController', 'action' => 'logout']);


$router->dispatch($_SERVER['QUERY_STRING']);


?>