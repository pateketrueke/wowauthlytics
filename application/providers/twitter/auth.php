<?php

$client = new EpiTwitter(TWITTER_KEY, TWITTER_SECRET);

if(empty($_GET['oauth_token'])) {
  echo '<a href="' . $client->getAuthorizationUrl() . '">Login</a>';
} else {
  $client->setToken($_GET['oauth_token']);
  $token = $client->getAccessToken();
  return array('access_token' => array('oauth_token' => $token->oauth_token, 'oauth_token_secret' => $token->oauth_token_secret));
}
