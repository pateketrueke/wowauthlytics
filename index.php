<?php

$loader = require 'vendor/autoload.php';
$loader->add('Grocery', __DIR__.'/requires/grocery/lib/');

Broil\Config::set('rewrite', TRUE);
Broil\Config::set('request_uri', ! empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/');

$_method = ! empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'HEAD';

if ( ! empty($_POST['_method'])) {
  $_method = strtoupper($_POST['_method']);
}

Broil\Config::set('request_method', $_method);

Tailor\Config::set('cache_dir', '/tmp');
Tailor\Config::set('views_dir', 'application/includes');

Tailor\Base::initialize();

require 'application/functions.php';
require 'application/bootstrap.php';

if ($action = Broil\Routing::run()) {
  $headers = array();

  ob_start();
  $test = call_user_func_array($action['to'], array_values($action['params']));
  $text = ob_get_clean();

  if (is_numeric($test)) {
    $status = $test;
  } elseif (is_array($test)) {
    switch (sizeof($test)) {
      case 3;
        @list($status, $headers, $text) = $test;
      break;
      case 2;
        @list($status, $headers) = $test;
      break;
      default;
        $status = array_shift($test);
      break;
    }
  } else {
    $status = 200;
  }

  $params = array($status, $headers ?: array(), $text);
} else {
  $params = array(404, array(), 'Not found!');
}

$output = new Postman\Response($params);

echo $output;
