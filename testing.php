<?php

require __DIR__.'/vendor/autoload.php';

use \GuzzleHttp\Client;

// create our http client (Guzzle)
$client = new Client(['base_uri' => 'http://localhost:8000/api/']);
$nickname = 'FormCoder'. mt_rand(10, 102);
$data = array(
  'nickname' => $nickname,
  'avatarNumber' => 12,
  'tagLine' => 'a resource dev',
  'language' => 'PHP',
  'created' => new \DateTime('now')
);
try {
  $res = $client->request('POST', 'programmers', ['body' => json_encode($data)]);
  $res = $res->getBody();
} catch (\GuzzleHttp\Exception\ClientException $e) {
  $res = json_decode($e->getResponse()->getBody(), true);
  // print_r($e);
}

// $resPo = $client->request('GET', $res->getHeaderLine('Location'));
// $res = $client->request('GET', 'programmers/CowBoyCoder');
print_r($res);

// echo $res->getStatusCode() . "\r\n";
//
// echo $res->getHeaderLine('content-type') . "\r\n";
// echo $res->getHeaderLine('Cache-Control') . "\r\n";
// echo $res->getHeaderLine('Location') . "\r\n";
// $res = $client->request('GET', 'programmers/junta', ['body' => json_encode($data)]);
// echo $res->getBody() . "\r\n";
// echo $resPo->getBody();
