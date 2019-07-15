<?php
@session_start();
require_once 'dbconnect.php';
require_once 'database.php';

function user_login($email, $password)
{
  global $con;
  global $database;

  $email = mysqli_real_escape_string($con, $email);
  $password = mysqli_real_escape_string($con, $password);

  $user = $database->get('user', [
    'id',
    'name',
    'email',
  ], [
    'email' => "{$email}",
    'password' => "{$password}",
  ]);

  if ($err = $database->error()[2]) {
    return $err;
  }

  if (!$user) {
    return 'Incorrect Email or Password.';
  }

  $_SESSION['usr_id'] = $user['id'];
  $_SESSION['name'] = $user['name'];
  $_SESSION['email'] = $user['email'];

  return false;
}

function user_register($name, $email, $password, $cpassword)
{
  global $database;

  if ($err = register_check($name, $email, $password, $cpassword)) {
    return $err;
  }

  $database->insert('user', [
    'name' => "{$name}",
    'email' => "{$email}",
    'password' => "{$password}",
  ]);

  if ($err = $database->error()[2]) {
    return $err;
  } else {
    return false;
  }
}

function register_check($name, $email, $password, $cpassword)
{
  global $con;

  $name = mysqli_real_escape_string($con, $name);
  $email = mysqli_real_escape_string($con, $email);
  $password = mysqli_real_escape_string($con, $password);
  $cpassword = mysqli_real_escape_string($con, $cpassword);
  $error = '';

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Please Enter Valid Email ID";
  }
  if (strlen($password) < 6) {
    $error = "Password must be minimum of 6 characters";
  }
  if ($password != $cpassword) {
    $error = "Password and Confirm Password doesn't match";
  }

  return $error;
}
