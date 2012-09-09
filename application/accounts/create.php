<?php

$db = connect();
$data = array('emailaddr' => $_GET['email']);
$exists = $db['account']->where($data)->count();

if ($exists) {
  return array('error' => 'already exists');
} else {
  $data['unique_hash'] = sha1(mt_rand() . microtime(TRUE));
  $db['account']->insert($data);

  return array('success' => 'user created', 'hash_id' => $data['unique_hash']);
}
