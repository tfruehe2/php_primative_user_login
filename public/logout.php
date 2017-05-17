<?php
require_once '../site/init.php';

$user = new User();
$user->logout();

Redirect::to('index.php');
