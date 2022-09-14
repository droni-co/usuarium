<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$db = new Capsule;

$db->addConnection([
  "driver" => "sqlsrv",
  "host" => $_ENV['DB_HOST'],
  "database" => $_ENV['DB_NAME'],
  "username" => $_ENV['DB_USER'],
  "password" => $_ENV['DB_PASS']
]);

//Make this Capsule instance available globally.
$db->setAsGlobal();

// Setup the Eloquent ORM.
$db->bootEloquent();