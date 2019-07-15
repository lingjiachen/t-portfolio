<?php
@session_start();

function is_admin()
{
  return isset($_SESSION['email']) && $_SESSION['email'] === 'teacher1@gmail.com';
}

function ensure_login($redirect = 'signin.php')
{
  if (!isset($_SESSION['usr_id'])) {
    header("Location: {$redirect}");
    exit(0);
  }
}
