<?php

function url() { return Broil\Routing::path(join('/', func_get_args())); }

function get($path, $to, $params = array()) { Broil\Routing::add('GET', $path, $to, $params); }
function put($path, $to, $params = array()) { Broil\Routing::add('PUT', $path, $to, $params); }
function post($path, $to, $params = array()) { Broil\Routing::add('POST', $path, $to, $params); }
function delete($path, $to, $params = array()) { Broil\Routing::add('DELETE', $path, $to, $params); }

function connect() {
  static $db,
         $db_file = 'application/database/db.sqlite';

  if ( ! $db) {
    is_file($db_file) OR touch($db_file);
    $db = Grocery\Base::connect("sqlite:$db_file");

    require 'application/database/tables.php';
  }
  return $db;
}

function partial($path, array $vars = array()) {
  if ($tpl = Tailor\Base::partial($path)) {
    return Tailor\Base::render($tpl, $vars);
  }
  return $path;
}

function as_json($data) {
  return array(200, array('Content-Type' => 'application/json'), json_encode($data));
}

function redirect($to) {
  header("Location: $to");
  exit;
}
