<?php

$vars = compact('provider');
$vars['hash'] = $account->unique_hash;

$data = array('name' => $provider, 'account_id' => $account->id);
$provider = $db['provider']->where($data)->select()->fetch();

$data = array('name' => $action, 'provider_id' => $provider->id);
$exists = $db['service']->where($data)->count();

$vars['name'] = $action;
$vars['service'] = $db['service']->where($data)->select()->fetch();

switch ($method) {
  case 'GET';
    $mode = array_key_exists('edit', $_GET) ? 'edit' : 'new';

    if ($exists) {
      if ($mode <> 'edit') {
        return partial('exists.php', $vars);
      }
    }

    return partial("$vars[provider]/$mode.php", $vars);
  case 'PUT';
    if ( ! $exists) {
      return partial('missing.php', $vars);
    }

    $db['service']->update(array('config' => json_encode($_POST['params'])), $data);
    redirect(url("done?provider=$vars[provider]&update=$action"));
  case 'POST';
    if ($exists) {
      return partial('exists.php', $vars);
    }

    $data['config'] = json_encode($_POST['params']);
    $data['provider_id'] = $provider->id;
    $data['name'] = $action;

    $db['service']->insert($data);

    redirect(url("done?provider=$vars[provider]"));
  case 'DELETE';
    if ( ! $exists) {
      return partial('missing.php', $vars);
    }

    if ($_POST['confirm']) {
      $db['service']->delete($data);
      redirect(url("done?provider=$vars[provider]&delete=$action"));
    }

    return partial("$vars[provider]/remove.php", $vars);
}

return partial('missing.php', $vars);
