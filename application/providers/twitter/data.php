<?php

$raw = json_decode($data->params)->raw;

$client = new EpiTwitter(TWITTER_KEY, TWITTER_SECRET, $raw->oauth_token, $raw->oauth_token_secret);


# /list/memberships

var_Dump($client);
