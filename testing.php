<?php

require __DIR__.'/vendor/autoload.php';

use \GuzzleHttp\Client;

// create our http client (Guzzle)
$client = new Client(['base_uri' => 'https://coop.apps.knpuniversity.com/']);
// $nickname = 'FormCoder'. mt_rand(10, 102);
$data = array(
  'amount' => 10000,
  'email' => 'info@fiveninestech.com.ng'
);

$authorize = http_build_query(array(
	'response_type' => 'code',
	'client_id' => 'TopChuck',
	'redirect_uri' => 'https://coop.apps.knpuniversity.com/coop/auth/handle',
	'scope' => 'eggs-count profile'
));
try {
  $res = $client->request('GET', 'authorize?'.$authorize, [
  	'body' => json_encode($data),
  	'headers' => [
  		'authorization' => 'Bearer sk_test_242789e3daa7b4d54587e514266ed966a506657b'
  	]
  ]);
  $res = $res->getBody()->getContents();


} catch (\GuzzleHttp\Exception\ClientException $e) {
  $res = json_decode($e->getResponse()->getBody(), true);
  // print_r($e);
}

// // $resPo = $client->request('GET', $res->getHeaderLine('Location'));
// // $res = $client->request('GET', 'programmers/CowBoyCoder');
print_r($res);

// // echo $res->getStatusCode() . "\r\n";
// //
// // echo $res->getHeaderLine('content-type') . "\r\n";
// // echo $res->getHeaderLine('Cache-Control') . "\r\n";
// // echo $res->getHeaderLine('Location') . "\r\n";
// // $res = $client->request('GET', 'programmers/junta', ['body' => json_encode($data)]);
// // echo $res->getBody() . "\r\n";
// // echo $resPo->getBody();
// 

