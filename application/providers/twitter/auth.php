<?php

$client = new EpiTwitter(TWITTER_KEY, TWITTER_SECRET);

if(empty($_GET['oauth_token'])) {
  $login_url = $client->getAuthorizationUrl();
} else {
  $client->setToken($_GET['oauth_token']);
  return (array) $client->getAccessToken();
}
