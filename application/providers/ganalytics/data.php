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
          ! empty($params['since']) ? $params['since'] : date('Y-m-d', strtotime('-1 month')),
          ! empty($params['to']) ? $params['to'] : date('Y-m-d'),
          ! empty($params['type']) ? $params['type'] : 'ga:visits',
          array(
              'dimensions' => ! empty($params['dims']) ? $params['dims'] : 'ga:source,ga:keyword',
              'sort' => ! empty($params['sort']) ? $params['sort'] : '-ga:visits,ga:keyword',
              'filters' => ! empty($params['filter']) ? $params['filter'] : 'ga:medium==organic',
              'max-results' => ! empty($params['max']) ? $params['max'] : '100'));

  return $data;
}

return array('error' => 'missing ga param');
