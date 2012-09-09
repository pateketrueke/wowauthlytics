<?php

$client = new Facebook(array(
  'appId' => FACEBOOK_ID,
  'secret' => FACEBOOK_SECRET,
  'cookie' => FALSE,
));


if ($client->getUser()) {
  return $client->getAccessToken();
} else {
  $login_url = $client->getLoginUrl(array('scope' => 'read_insights'));
}
