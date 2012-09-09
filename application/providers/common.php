<?php

$db = connect();
$data = array('unique_hash' => $_GET['id']);
$exists = $db['account']->where($data)->count();

if ( ! $exists) {
  return array('error' => 'account not found');
}


$account = $db['account']->select('*', $data)->fetch();
$data = array('name' => $provider, 'account_id' => $account->id);
$exists = $db['provider']->where($data)->count();

switch ($action) {
  case 'hook';
    switch ($method) {
      case 'GET';
        if ( ! $exists) {
          return array('error' => "no $provider provider");
        } else {
          $provider = $db['provider']->select('*', $data)->fetch();

          $result = array('found' => TRUE);
          $result['services'] = array();

          $db['service']->where(array('provider_id' => $provider->id))->each(function ($service)
            use (&$result) {
              $result['services'] []= $service->name;
            });

          return $result;
        }
      break;
      case 'POST';
        if ($exists) {
          return array('error' => "provider $provider already exists");
        } else {
          $db['provider']->insert($data);
          return array('success' => "provider $provider created");
        }
      break;
      case 'DELETE';
        if ( ! $exists) {
          return array('error' => "provider $provider not found");
        } else { // TODO: eliminar servicios + datos
          $db['provider']->delete($data);
          return array('success' => "provider $provider deleted");
        }
      break;
      default;
        return array('error' => "unknown method $method");
      break;
    }
}
