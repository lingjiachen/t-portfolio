<?php
require_once 'config.php';

$con = mysqli_connect(_DB_HOST_, _DB_USER_, _DB_PASS_, _DB_NAME_);
$con->query('set names utf8mb4');
