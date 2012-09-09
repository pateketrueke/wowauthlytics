<?php

$raw = substr($data->params, 8, -2);

$client = new GoogleApi\Client();

$client->setApplicationName('Wowauthlytics!');

$client->setClientId(GANALYTICS_CLIENT_ID);
$client->setClientSecret(GANALYTICS_CLIENT_SECRET);
$client->setDeveloperKey(GOOGLE_DEVELOPER_KEY);

$client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
$client->setAccessToken($raw);


if ( ! empty($params['ga'])) {
  $service = new GoogleApi\Contrib\apiAnalyticsService($client);
  $data = $service->data_ga->get(
          "ga:{$params['ga']}",
          '2010-01-01',
          '2010-01-15',
          'ga:visits',
          array(
              'dimensions' => 'ga:source,ga:keyword',
              'sort' => '-ga:visits,ga:keyword',
              'filters' => 'ga:medium==organic',
              'max-results' => '25'));

  return $data;
}

return array('error' => 'missing ga param');
