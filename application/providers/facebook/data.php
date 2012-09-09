<?php

$raw = json_decode($data->params)->raw;

$client = new Facebook(array(
  'appId' => FACEBOOK_ID,
  'secret' => FACEBOOK_SECRET,
  'cookie' => FALSE,
));


$client->setAccessToken($raw);

if ( ! empty($params['app'])) {
  if ( ! empty($params['path'])) {
    $data = $client->api("/{$params['app']}/insights/" . strtr($params['path'], '.', '/'));
  } else {
    $data = $client->api("/{$params['app']}/insights/application_active_users");
  }
  return $data;
}

return array('error' => 'missing app param');
