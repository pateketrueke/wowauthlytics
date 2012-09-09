<?php

$db = connect();
$data = array('emailaddr' => $_GET['email']);
$exists = $db['account']->where($data)->count();

if ( ! $exists) {
  return array('error' => 'not exists');
} else {
  $data['unique_hash'] = $_GET['confirm'];
  $success = $db['account']->delete($data);

  if ($success) { // TODO: eliminar proveedores + servicios + datos
    return array('success' => 'user deleted');
  } else {
    return array('error' => 'missing confirmation');
  }
}
