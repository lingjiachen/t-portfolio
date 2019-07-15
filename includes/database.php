<?php
require_once 'config.php';
require_once "{__DIR__}/../vendor/autoload.php";

use Medoo\Medoo;

$database = new Medoo([
  'database_type' => 'mysql',
  'database_name' => _DB_NAME_,
  'server' => _DB_HOST_,
  'username' => _DB_USER_,
  'password' => _DB_PASS_,
  'charset' => 'utf8mb4',
]);
