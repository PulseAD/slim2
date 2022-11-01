<?php

namespace Api;

class StatusCodeUpdater {
  public function updateWithCode201($app) {
    $app->response->status(201);
    return $app;
  }
}