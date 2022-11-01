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

$app->post('/post-with-form-data', function () use($app) {
  $name = $app->request->params('name', 'No one');
  $app->response->body(json_encode([
    'message' => "Hi $name"
  ]));
});

$app->post('/post-with-json', function () use($app) {
  $body = $app->request->getBody();
  $name = json_decode($body, true)['name'];
  $app->response->body(json_encode([
    'message' => "Hello $name"
  ]));
});

$app->get('/random', function () use($app) {
  $statusCodeUpdater = new StatusCodeUpdater();
  $app = $statusCodeUpdater->updateWithCode201($app);
  $randomController = new RandomNumberController($app);
  $app = $randomController->run();
});

$app->run();