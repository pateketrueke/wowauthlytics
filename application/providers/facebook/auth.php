<?php

$client = new Facebook(array(
  'appId' => FACEBOOK_ID,
  'secret' => FACEBOOK_SECRET,
  'cookie' => FALSE,
));


if ($test = $client->getUser()) {
  return array('me' => $test);
} else {
  echo '<a href="' . $client->getLoginUrl(array('scope' => 'read_insights')) . '">Login</a>';
}
