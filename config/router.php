<?php
$router = new \Bramus\Router\Router();

// Activate CORS
function sendCorsHeaders()
{
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
}
$router->options('/.*', function () {
    sendCorsHeaders();
});
sendCorsHeaders();

// define middleware
$router->before('GET', '/api/users/{id}', '\Usuarium\ApiClientController@middleware');

// Define routes
$router->get('/', function() {
  header('Location: /front_app/dist/');
  exit;
});
// instalation routes
$router->get('/api/install/check', '\Usuarium\InstallController@check');
$router->get('/api/install/migrate', '\Usuarium\InstallController@migrate');
$router->get('/api/install/fetcher', '\Usuarium\InstallController@fetcher');
// user routes
$router->get('/api/users', '\Usuarium\UserController@index');
$router->get('/api/users/{id}', '\Usuarium\UserController@show');
$router->post('/api/users', '\Usuarium\UserController@store');
$router->put('/api/users/{id}', '\Usuarium\UserController@update');
// api client routes
$router->get('/api/api_clients', '\Usuarium\ApiClientController@index');
$router->post('/api/api_clients', '\Usuarium\ApiClientController@store');

// Run it!
$router->run();