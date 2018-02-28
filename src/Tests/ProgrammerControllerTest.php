<?php

namespace App\Tests;

use GuzzleHttp\Exception\ServerException;
use PHPUnit\Framework\TestCase;
use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\ClientException;

/**
 * Programmer Controller Unit test
 */
class ProgrammerControllertest extends TestCase
{

  // public function testPOST()
  // {
  //   // create our http client (Guzzle)
  //   $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
  //   $nickname = 'ObjectOrienter'. mt_rand(0, 999);
  //   $data = array(
  //     'nickname' => $nickname,
  //     'avatarNumber' => mt_rand(2, 17),
  //     'tagLine' => 'a newly random generated dev'
  //   );
  //
  //   $request = $client->request('POST', 'programmers', ['body' => json_encode($data)]);
  //
  //   $this->assertEquals(201, $request->getStatusCode());
  //   $this->assertTrue($request->hasHeader('Location'));
  //   $data = json_decode($request->getBody(true), true);
  //   $this->assertArrayHasKey('tagLine', $data);
  // }

  // public function testPUT()
  // {
  //   $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
  //   $payload = array(
  //     'nickname' => 'CowgirlCoder',
  //     'avatarNumber' => 21,
  //     'tagLine' => 'a re-tested dev'
  //   );
  
  //   $request = $client->request('PUT', 'programmers/CowboyCoder', ['body' => json_encode($payload)]);
  
  //   $this->assertEquals(200, $request->getStatusCode());
  //   $data = json_decode($request->getBody(), true);
  //   $this->assertEquals('CowboyCoder', $data['nickname']);
  // }

  // public function testNotFoundPUT()
  // {
  //   $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
  //   $payload = array(
  //     'nickname' => 'CowBoyCoder',
  //     'avatarNumber' => 21,
  //     'tagLine' => 'a re-tested dev'
  //   );
  
  //   try {
  //     $request = $client->request('PUT', 'programmers/CowgirlCoder', ['body' => json_encode($payload)]);
  //   } catch (ClientException $e) {
  //     $request = $e->getResponse();
  //   }
  
  //   $this->assertEquals(404, $request->getStatusCode());
  //   $this->assertEquals('application/problem+json', $request->getHeaderLine('Content-Type'));
  // }


  // public function testDELETE()
  // {
  //   $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
  //   $payload = array(
  //     'nickname' => 'ObinnaOkafor',
  //     'avatarNumber' => 10
  //   );
  
  //   try {
  //     $response = $client->request('DELETE', 'programmers/'.$payload['nickname'], ['body' => json_encode($payload)]);
  //   } catch (ClientException $e) {
  //     $response = $e->getResponse();
  //   }
  
  //   $this->assertEquals(404, $response->getStatusCode());
  
  // }
  // 
  
  public function testGETProgrammersCollectionPaginated()
  {
    $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
    try {
      $response = $client->request('GET', 'programmers?filter=Object');
    } catch (ServerException $e) {
      $response = $e->getResponse();
      // print_r($response);
    }
    $res = json_decode($response->getBody(), true);

    // $this->assertEquals(5, $res['items'][4]['id']);
    $this->assertEquals(10, $res['count']);
    $this->assertEquals(51, $res['total']);
    $this->assertArrayHasKey('_links.next', $res);
    $nextLink = $res['_links.next'];
    $response = $client->request('GET', $nextLink);
    $res = json_decode($response->getBody(), true);
    // $this->assertEquals(16, $res['items'][4]['id']);
    $this->assertEquals(10, $res['count']);
    $this->assertEquals(51, $res['total']);
    $this->assertArrayHasKey('_links.next', $res);
    $lastLink = $res['_links.last'];
    $response = $client->request('GET', $lastLink);
    $res = json_decode($response->getBody(), true);
    unset($res['items']);
    print_r($res);
    $this->assertEquals(1, $res['count']);
    $this->assertArrayNotHasKey('_link.next', $res);
  }

  // public function testPATCH()
  // {
  //   $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
  //   $payload = array(
  //     'avatarNumber' => '101',
  //     'nickname' => 'tryThis',
  //     'tagLine' => 'a tried and tested dev'
  //   );
  //
  //   $request = $client->request('PATCH', 'programmers/ObjectOrienter196', ['body' => json_encode($payload)]);
  //
  //   $this->assertEquals(200, $request->getStatusCode());
  //   $data = json_decode($request->getBody(), true);
  //   $this->assertEquals('a tried and tested dev', $data['tagLine']);
  //   $this->assertEquals('ObjectOrienter196', $data['nickname']);
  //   $this->assertEquals(101, $data['avatarNumber']);
  // }

  // public function testERROR()
  // {
  //     $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
  //     $nickname = 'ObjectOrienter'. mt_rand(0, 999);
  //     $data = array(
  //       'avatarNumber' => "23",
  //       'tagLine' => 'a random generated dev'
  //     );
  //
  //     try {
  //       $response = $client->request('POST', 'programmers', ['body' => json_encode($data)]);
  //     } catch (ClientException $e) {
  //       $response = $e->getResponse();
  //     }
  //
  //
  //     $this->assertEquals(400, $response->getStatusCode());
  //     $data = json_decode($response->getBody(), true);
  //     $this->assertArrayHasKey('type', $data);
  //     $this->assertArrayHasKey('title', $data);
  //     $this->assertArrayHasKey('nickname', $data['errors']);
  //
  // }

  // public function test404()
  // {
  //     $client = new Client(['base_uri' => 'http://localhost:8000/api/']);
  //     try {
  //       $response = $client->request('GET', 'programmers/junta');
  //     } catch (ClientException $e) {
  //       $response = $e->getResponse();
  //     }

  //     $this->assertEquals(404, $response->getStatusCode());
  //     $data = json_decode($response->getBody(), true);
  //     $this->assertEquals('about:blank', $data['type']);
  //     $this->assertEquals('Not Found', $data['title']);
  //     $this->assertEquals('The programmer junta doesnt exist', $data['details']);

  // }
}
