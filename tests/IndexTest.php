<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class IndexTest extends TestCase
{

  private function getCurlOptions () {
    return array(sprintf(
      "%s:%d:%s",
      'slim2.test',
      80,
      '127.0.0.1'
    ));
  }

  private function retrieveGetRequestAnswer($url) {
    $client = new Client([
      'base_uri' => 'http://slim2.test'
    ]);
    $resolve = $this->getCurlOptions();
    $response = $client->request('GET', $url, [
      'curl' => [
        CURLOPT_RESOLVE =>  $resolve
      ]
    ]);
    return $response;
  }
  public function testFirst()
  {
    $this->assertEquals(1, 1);
  }

  public function testCallHttp() {
    $response = $this->retrieveGetRequestAnswer('/api');
    $body = $response->getBody();
    $bodyAsArray = json_decode($body, true);
    $this->assertEquals("Api successfully set up", $bodyAsArray['message']);
  }

  public function testShouldReturnRandomNumber() {
    $response = $this->retrieveGetRequestAnswer('/random');
    $bodyAsArray = json_decode($response->getBody(), true);
    $isNumberInRange = $bodyAsArray['number'] > 0 && $bodyAsArray['number'] < 11;
    $this->assertTrue($isNumberInRange);
    $this->assertEquals(201, $response->getStatusCode());
  }
}
