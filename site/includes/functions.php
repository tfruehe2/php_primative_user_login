<?php

function redirect_to($location = null)
{
  if($location != null)
  {
    header("Location: {$location}");
    exit();
  }
}

function escape($string) {
  return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function sanitize_output($value)
{
  return htmlspecialchars(strip_tags($value));
}
