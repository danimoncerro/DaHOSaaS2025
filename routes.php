<?php
// Acest fișier este inclus de index.php, care deja a creat instanța $router

$router->get('admin/users', 'admin\\UserController@index');
$router->get('users', 'UserController@index');
$router->get('test', 'HomeController@test');
$router->get('', 'HomeController@index'); 
$router->get('taraba-hortigrup', 'stores\\TarabaController@index');
$router->get('admin/modules', 'admin\\ModuleController@index');
$router->post('admin/modules/select', 'admin\\ModuleController@select');
$router->post('admin/users/updateRole', 'admin\\UserController@updateRole');


