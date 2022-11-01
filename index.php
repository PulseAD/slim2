<?php
require 'vendor/autoload.php';
use Api\RandomNumberController;
use Api\StatusCodeUpdater;

$app = new \Slim\Slim();

$app->get('/', function () {
  echo 'Hello Slim 2';
});

$app->get('/api', function () use($app) {
  $data = [
    "message" => "Api successfully set up"
  ];
  $app->response->body(json_encode($data));
});

$app->get('/hello/:name', function ($name) {
  echo "Hi, $name";
});

$app->get('/random', function () use($app) {
  $statusCodeUpdater = new StatusCodeUpdater();
  $app = $statusCodeUpdater->updateWithCode201($app);
  $randomController = new RandomNumberController($app);
  $app = $randomController->run();
});

$app->run();