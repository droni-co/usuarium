<?php
$router = new \Bramus\Router\Router();

// Define routes
$router->get('/', function() {
  header('Location: /front_app/dist/');
  exit;
});
$router->get('/api/install/migrate', '\Usuarium\InstallController@migrate');
$router->get('/api/install/fetcher', '\Usuarium\InstallController@fetcher');
$router->get('/api/users', '\Usuarium\UserController@index');
$router->get('/api/users/{id}', '\Usuarium\UserController@show');
$router->post('/api/users', '\Usuarium\UserController@store');
$router->put('/api/users/{id}', '\Usuarium\UserController@update');

// Run it!
$router->run();