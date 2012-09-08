<?php

Broil\Routing::add('GET', '/', function () {
    echo 'Hello World!';
  });

Broil\Routing::add('GET', '/:var', function ($value) {
    echo "Var: $value";
  });
