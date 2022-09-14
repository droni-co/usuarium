<?php
// load base
require "vendor/autoload.php";

// dot env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// database
require "config/database.php";
 
// routing
require "config/router.php";