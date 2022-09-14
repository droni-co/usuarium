<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$db = new Capsule;

$db->addConnection([
  "driver" => "sqlsrv",
  "host" => $_ENV['DB_HOST'],
  "database" => $_ENV['DB_DATABASE'],
  "username" => $_ENV['DB_USERNAME'],
  "password" => $_ENV['DB_PASSWORD']
]);

//Make this Capsule instance available globally.
$db->setAsGlobal();

// Setup the Eloquent ORM.
$db->bootEloquent();
$db->bootEloquent();