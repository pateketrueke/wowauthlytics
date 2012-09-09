<?php

require_once('libraries/mailchimp/MC_OAuth2Client.php');
require_once('libraries/mailchimp/MC_RestClient.php');

$client = new MC_OAuth2Client();
$session = $client->getSession();

if ( ! $session) {
  echo '<a href="' . $client->getLoginUri() . '">Login</a>';
} else {
  $rest = new MC_RestClient($session);
  $data = $rest->getMetadata();

  return array('acces_token' => $session['access_token'], 'dc' => $data['dc']);
}
