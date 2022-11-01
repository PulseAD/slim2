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

  private function retrieveClient () {
    return new Client([
      'base_uri' => 'http://slim2.test'
    ]);
  }

  private function retrievePostRequestAnswer($url, $body) {
    $client = $this->retrieveClient();
    $resolve = $this->getCurlOptions();
    $response = $client->request('POST', $url, [
      'curl' => [
        CURLOPT_RESOLVE =>  $resolve
      ],
      'body' => json_encode($body)
    ]);
    return $response;
  }

  private function retrieveFormDataPostRequestAnswer($url, $body) {
    $client = $this->retrieveClient();
    $resolve = $this->getCurlOptions();
    $response = $client->request('POST', $url, [
      'curl' => [
        CURLOPT_RESOLVE =>  $resolve
      ],
      'form_params' => $body
    ]);
    return $response;
  }

  private function retrieveGetRequestAnswer($url) {
    $client = $this->retrieveClient();
    $resolve = $this->getCurlOptions();
    $response = $client->request('GET', $url, [
      'curl' => [
        CURLOPT_RESOLVE =>  $resolve
      ]
    ]);
    return $response;
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

  public function testShouldReadBodyPost() {
    $response = $this->retrievePostRequestAnswer('/post-with-json', [
      'name' => 'Antoine'
    ]);
    $bodyAsArray = json_decode($response->getBody(), true);
    $this->assertEquals('Hello Antoine', $bodyAsArray['message']);
  }

  public function testShouldReadFormDataPost() {
    $response = $this->retrieveFormDataPostRequestAnswer('/post-with-form-data', [
      'name' => 'Antoine'
    ]);
    $bodyAsArray = json_decode($response->getBody(), true);
    $this->assertEquals('Hi Antoine', $bodyAsArray['message']);
  }
}
