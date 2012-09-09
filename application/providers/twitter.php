<?php

if (is_array($result = require 'common.php')) {
  return $result;
}
return require 'service.php';
