<?php

function set_base_url()
{
  if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $GLOBALS['base_url'] = '/' . explode('/', $_SERVER['REQUEST_URI'])[1];
  } else {
    $GLOBALS['base_url'] = $_SERVER['HTTP_HOST'];
  }
  return $GLOBALS['base_url'];
}