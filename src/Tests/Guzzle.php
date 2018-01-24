<?php

namespace App\Tests;

use \GuzzleHttp\Client;

/**
 * Guzzle Class
 */
class Guzzle
{
  /**
   * @var Client
   */
  private $client;

  /**
   *
   */
  function __construct()
  {
    if ($this->client === null) {
      $this->client = new Client();
    }

    return $this->client;
  }

  /**
   * @param string $uri
   * @param string $method
   * @param array $auth
   *
   * @return array
   */
  public function set($uri, $method, $auth = array())
  {
    $res = $this->client->request($method, $uri);

    return array(
      'status' => $res->getStatusCode(),
      'content' => $res->getBody(),
      'headers' => $res->getHeaders()
    );
  }
}
