<?php

$client = new EpiTwitter(TWITTER_KEY, TWITTER_SECRET);

if(empty($_GET['oauth_token'])) {
  echo '<a href="' . $client->getAuthorizationUrl() . '">Login</a>';
} else {
  $client->setToken($_GET['oauth_token']);
  return array('access_token' => $client->getAccessToken());
}
