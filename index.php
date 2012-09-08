<?php

require 'vendor/autoload.php';
require 'application.php';

Broil\Config::set('request_uri', ! empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/');
Broil\Config::set('request_method', ! empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'HEAD');

if ($action = Broil\Routing::run()) {
  ob_start();
  $test = call_user_func_array($action['to'], array_values($action['params']));
  $text = ob_get_clean();

  if (is_numeric($test)) {
    $status = $test;
  } elseif (is_array($test)) {
    @list($status, $headers) = $test;
  } else {
    $status = 200;
    $headers = array();
  }

  $params = array($status, $headers ?: array(), $text);
} else {
  $params = array(404, array(), 'Not found!');
}

$output = new Postman\Response($params);

echo $output;
