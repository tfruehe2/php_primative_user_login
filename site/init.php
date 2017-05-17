<?php
session_start();
require_once "includes/functions.php";
require_once "includes/secrets.php"

define('STATIC',
  'http://' . $_SERVER['HTTP_HOST'] .
  str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__DIR__) . '/public')
);

$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => "$DB_HOST",
    'username' => "$DB_USER",
    'password' => "$DB_PASS",
    'db' => "$DB_NAME"
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  'session' => array(
    'session_name' => 'user',
    'token_name' => 'csrf_token'
  )
);

spl_autoload_register(function($class) {
  if (file_exists(__DIR__ .'/'. 'model/' . strtolower($class) . '.php'))
  {
    require_once 'model/' . strtolower($class) . '.php';
  } else if (file_exists(__DIR__ .'/'.'helper/' . strtolower($class) . '.php'))
  {
    require_once 'helper/' . strtolower($class) . '.php';
  }

});

if(Cookie::exists(Config::get('remember/cookie_name'))
  && !Session::exists(Config::get('session/session_name')))
  {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hash_check = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hash_check->count())
    {
      echo "here";
      $user = new User($hash_check->first()->user_id);
      $user->login();
    }
  }
