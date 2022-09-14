<?php
$router = new \Bramus\Router\Router();

// Define routes
$router->get('/', '\Ods\Migrator@index');
$router->get('/show', '\Ods\Migrator@show');
$router->get('/procedures', '\Ods\Migrator@procedures');
$router->post('/export', '\Ods\Migrator@export');
$router->post('/import', '\Ods\Migrator@import');

// Run it!
$router->run();