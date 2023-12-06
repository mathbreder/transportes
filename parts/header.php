<?php
require_once __DIR__ . '/../functions.php';
if (!isset($title)) {
  $title = "Home";
}
set_base_url();

function getActiveClass($path)
{
  $request_uri = $_SERVER['REQUEST_URI'];
  if (str_ends_with($request_uri, '/')) {
    $request_uri = substr($request_uri, 0, -1);
  }
  global $base_url;
  $request_uri = str_replace($base_url, '', $request_uri);
  echo $request_uri;
  return $request_uri == $path ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?> - Transportes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>