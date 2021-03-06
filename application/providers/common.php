<?php

session_start();

$user_id = '';

if ( ! empty($_GET['id'])) {
  $_SESSION['unique_hash'] = $_GET['id'];
  $user_id = $_GET['id'];
} elseif ( ! empty($_SESSION['unique_hash'])) {
  $user_id = $_SESSION['unique_hash'];
}


$db = connect();
$data = array('unique_hash' => $user_id);
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
          return array('found' => TRUE);
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
  case 'auth';
    $auth_script = "$provider/auth.php";
    $redirect_url = "http://wowauthlytics.co/$provider/auth";

    $data = array('name' => $provider, 'account_id' => $account->id);
    $auth_data = require $auth_script;

    if ( ! isset($login_url)) {
      if ($exists) {
        $where = $data;
        $data['params'] = json_encode(array('raw' => $auth_data));
        $db['provider']->update($data, $where);
      } else {
        $data['params'] = json_encode(array('raw' => $auth_data));
        $db['provider']->insert($data);
      }
      redirect(url("$provider?id=$user_id"));
    }

    return partial('missing.php', compact('provider', 'login_url'));
  case 'data';
    $params = $_GET;
    $data_script = "$provider/data.php";

    if (isset($params['id'])) {
      unset($params['id']);
    }

    $data = $db['provider']->select('*', $data)->fetch();

    return require $data_script;
}
