<?php
require 'vendor/autoload.php';
require 'backend/rest/routes/user_routes.php';
require 'backend/rest/routes/product_routes.php';
require 'backend/rest/routes/order_routes.php';

Flight::route('/', function () {
    echo 'hello world!';
  });



Flight::start();