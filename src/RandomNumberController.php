<?php

namespace Api;

class RandomNumberController {
  private $app;

  public function __construct($app) {
    $this->app = $app;
  }

  public function run() {
    $nb = rand(1, 10);
    $this->app->response->body(json_encode(['number' => $nb]));
    return $this->app;
  }
}