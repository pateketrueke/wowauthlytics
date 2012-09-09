<?php

$raw = json_decode($data->params)->raw;

$client = new Facebook(array(
  'appId' => FACEBOOK_ID,
  'secret' => FACEBOOK_SECRET,
  'cookie' => FALSE,
));

$me = $client->setAccessToken($raw)->getUser();
$app = ! empty($params['app_id']) ? $params['app_id'] : $me;

if ( ! empty($params['request_path'])) {
  $data = $client->api(strtr($params['request_path'], '.', '/'));
} else {
  $data = $client->api("/$app/insights/application_active_users");
}

return $data;
