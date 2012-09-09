<?php

$client = new GoogleApi\Client();

$client->setApplicationName('Wowauthlytics!');

$client->setClientId(GANALYTICS_CLIENT_ID);
$client->setClientSecret(GANALYTICS_CLIENT_SECRET);
$client->setDeveloperKey(GOOGLE_DEVELOPER_KEY);

$client->setRedirectUri($redirect_url);
$client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));

$service = new GoogleApi\Contrib\apiAnalyticsService($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  return $client->getAccessToken();
}

if ($client->getAccessToken()) {
  return $client->getAccessToken();
} else {
  $login_url = $client->createAuthUrl();
}
