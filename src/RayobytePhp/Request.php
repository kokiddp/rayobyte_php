<?php

namespace Kokiddp\RayobytePhp;

use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

class Request 
{
  /**
   * @var ClientInterface
   */
  private static $client;

  /**
   * @param ClientInterface $client
   */
  public static function setHttpClient(ClientInterface $client)
  {
    self::$client = $client;
  }

  /**
   * Send a cURL request
   * @param string $method HTTP method to use
   * @param string|Uri $uri URL to send the request to
   * @return Response
   * @throws ClientExceptionInterface
   */
  private static function send(string $method, $uri)
  {
    $request = new Psr7Request($method, $uri);
    return new Response(self::$client->sendRequest($request));
  }

  /**
   * Send a GET request to a URL
   *
   * @param string $url URL to send the GET request to
   * @return Response
   * @throws ClientExceptionInterface
   */
  public static function get(string $url, array $parameters = null)
  {
    $uri = new Uri($url);
    return self::send('GET', $uri);
  }

  /**
   * @param string $url
   * @return Response
   * @throws ClientExceptionInterface
   */
  public static function post(string $url)
  {
    $uri = new Uri($url);
    return self::send('POST', $uri);
  }
}