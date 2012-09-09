<?php

get('/', function () { echo 'It works!'; });
get('/done', function () { echo partial('done.php', $_GET); });

$account_params = array();
$account_callback = function () {
    $actions = array(
        'GET' => 'about',
        'POST' => 'create',
        'DELETE' => 'remove',
      );

    $status = 200;
    $headers = array();
    $method = Broil\Config::get('request_method');
    $account_routine = "accounts/$actions[$method].php";

    $result = require $account_routine;

    return as_json($result);
  };

get('/user', $account_callback, $account_params);
post('/user', $account_callback, $account_params);
delete('/user', $account_callback, $account_params);


$provider_params = array('constraints' => array('@provider' => 'youtube|facebook|mailchimp|ganalytics|twitter'));
$provider_callback = function ($provider, $action = 'hook', $item = '') {
    $status = 200;
    $headers = array();
    $method = Broil\Config::get('request_method');
    $provider_routine = "providers/$provider.php";

    $result = require $provider_routine;

    if (is_array($result)) {
      return as_json($result);
    }
    echo $result;
  };

get('/@provider(/:action(/:item)?)?', $provider_callback, $provider_params);
put('/@provider(/:action(/:item)?)?', $provider_callback, $provider_params);
post('/@provider(/:action(/:item)?)?', $provider_callback, $provider_params);
delete('/@provider(/:action(/:item)?)?', $provider_callback, $provider_params);
