<?php

$client = new GoogleApi\Client();

$client->setApplicationName('Wowauthlytics!');

$client->setClientId(GANALYTICS_CLIENT_ID);
$client->setClientSecret(GANALYTICS_CLIENT_SECRET);
$client->setDeveloperKey(GANALYTICS_DEVELOPER_KEY);

$client->setRedirectUri($redirect_url);
$client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));

$service = new GoogleApi\Contrib\apiAnalyticsService($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  return array('access_token' => $client->getAccessToken());
}

if ($client->getAccessToken()) {
  return array('access_token' => $client->getAccessToken());
} else {
  echo '<a href="' . $client->createAuthUrl() . '">Login</a>';
}
