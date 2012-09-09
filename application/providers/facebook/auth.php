<?php

$client = new Facebook(array(
  'appId' => FACEBOOK_ID,
  'secret' => FACEBOOK_SECRET,
  'cookie' => FALSE,
));


if ($test = $client->getUser()) {
  return array('me' => $test);
} else {
  $login_url = $client->getLoginUrl(array('scope' => 'read_insights'));
}
