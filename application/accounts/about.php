<?php

$db = connect();
$data = array('emailaddr' => $_GET['email']);
$exists = $db['account']->where($data)->count();

if ( ! $exists) {
  return array('error' => 'not exists');
} else {
  $account = $db['account']->where($data)->select()->fetch();
  $result = array('found' => TRUE, 'hash' => $account->unique_hash);

  $result['providers'] = array();

  $db['provider']->where(array('account_id' => $account->id))->each(function ($provider)
    use (&$result) {
      $result['providers'] []= $provider->name;
    });

  return $result;
}