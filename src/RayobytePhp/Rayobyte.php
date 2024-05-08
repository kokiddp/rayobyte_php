<?php

namespace Kokiddp\RayobytePhp;

use \Psr\Http\Client\ClientInterface;

class Rayobyte
{
  /**
   * The email
   * @var string
   */
  private string $email;

  /**
   * The apikey
   * @var string
   */
  private string $apikey;

  /**
   * Constructor
   * @param string $email
   * @param string $apikey
   * @param ClientInterface $client (optional)
   * @return void 
   */
  public function __construct(string $email, string $apikey, ClientInterface $client = null)
  {
    $this->email = $email;
    $this->apikey = $apikey;

    if ($client === null) {
      $client = new \GuzzleHttp\Client([
        'base_uri' => Endpoints::BASE_URL,
      ]);
    }
    Request::setHttpClient($client);
  }

  /**
   * @param ClientInterface $client
   */
  public static function setHttpClient(ClientInterface $client): void
  {
    Request::setHttpClient($client);
  }

  /**
   * GET CURRENT AUTHORIZATION TYPE
   * 
   * @return AuthorizationType
   */
  public function getAuthorizationType(): AuthorizationType
  {
    $response = Request::get(Endpoints::AUTHORIZATION_TYPE . $this->email . '/' . $this->apikey);

    if ($response->code !== 200) {
      throw new \Exception('Failed to get authorization type');
    }

    return new AuthorizationType($response->body->authType, $response->body->username, $response->body->password);
  }

  /**
   * CHANGE AUTHORIZATION TYPE
   * 
   * Change proxy authorization configuration with allowed types
   * 
   * @param string $authType PW or IP
   * @return bool
   */
  public function changeAuthorizationType(string $authType): bool
  {
    $response = Request::get(Endpoints::AUTHORIZATION_TYPE . $this->email . '/' . $this->apikey . '/' . $authType);

    if ($response->code !== 200) {
      throw new \Exception('Failed to change authorization type');
    }

    if ($response->body->status == 'ok') {
      return true;
    }

    return false;
  }

  /**
   * VIEW WHITELISTED AUTHORIZED ADDRESSES
   * 
   * Returns IPs that are authorized on your account to access proxies.
   * It could take 3-5 minutes after an authorization request for the newly authorized IPs to show in this listing.
   * 
   * @return string[]
   */
  public function getAuthorizedIps(): array
  {
    $response = Request::get(Endpoints::AUTHORIZED_IPS . $this->email . '/' . $this->apikey);

    if ($response->code !== 200) {
      throw new \Exception('Failed to change authorization type');
    }

    return $response->body->ips;
  }

  /**
   * LIST ALL PROXIES
   * 
   * Returns the newest list of authorized proxies.
   * 
   * @return Proxy[]
   */
  public function getProxies(): array
  {
    $response = Request::get(Endpoints::PROXY_IPS_ALL . $this->email . '/' . $this->apikey . '/list.csv?additionalValues=region,country,category');

    if ($response->code !== 200) {
      throw new \Exception('Failed to get proxy ips');
    }

    $body = explode("\n", $response->body);
    $proxies = [];
    foreach ($body as $proxy) {
      $proxies[] = Proxy::fromString($proxy);
    }

    return $proxies;
  }

  /**
   * ADD AUTHORIZED IP
   * 
   * Add a new IP to your authorized list.
   * 
   * @param string|string[] $ip
   * @return bool
   */
  public function addAuthorizedIp($ip): bool
  {
    if (is_array($ip)) {
      $ip = implode(',', $ip);
    }

    $response = Request::get(Endpoints::ADD_IPS . $this->email . '/' . $this->apikey . '/' . $ip);

    if ($response->code !== 200) {
      throw new \Exception('Failed to add authorized ip');
    }

    if ($response->body->status == 'ok') {
      return true;
    }

    return false;
  }

  /**
   * REMOVE AUTHORIZED IP
   * 
   * Remove an IP from your authorized list.
   * 
   * @param string $ip
   * @return bool
   */
  public function removeAuthorizedIp(string $ip): bool
  {
    $response = Request::get(Endpoints::REMOVE_IPS . $this->email . '/' . $this->apikey . '/' . $ip);

    if ($response->code !== 200) {
      throw new \Exception('Failed to remove authorized ip');
    }

    if ($response->body->status == 'ok') {
      return true;
    }

    return false;
  }

  /**
   * GET AVAILABLE REPLACEMENTS
   * 
   * Returns the list of available replacements.
   * 
   * @return Replacement[]
   */
  public function getAvailableReplacements(): array
  {
    $response = Request::get(Endpoints::REPLACEMENTS . $this->email . '/' . $this->apikey);

    if ($response->code !== 200) {
      throw new \Exception('Failed to get available replacements');
    }

    print_r($response);

    $replacements = [];
    foreach ($response->body as $replacement) {
      $replacements[] = new Replacement($replacement->country, $replacement->category, $replacement->available);
    }

    return $replacements;
  }

  /**
   * REPLACE IP
   * 
   * Replace a single IP with a new one.
   * 
   * @param string $ip
   * @return bool
   */
  public function replaceIp(string $ip): bool
  {
    $response = Request::get(Endpoints::REPLACE_IP . $this->email . '/' . $this->apikey . '/' . $ip);

    if ($response->code !== 200) {
      throw new \Exception('Failed to replace ip');
    }

    if ($response->body->status == 'ok') {
      return true;
    }

    return false;
  }

  /**
   * REPLACE MULTIPLE IPS
   * 
   * Replace multiple IPs with new ones.
   * 
   * @param string|string[] $ips
   * @return bool
   */
  public function replaceMultipleIps($ips): bool
  {
    if (is_array($ips)) {
      $ips = implode(',', $ips);
    }

    $response = Request::get(Endpoints::REPLACE_MULTIPLE_IPS . $this->email . '/' . $this->apikey . '/' . $ips);

    if ($response->code !== 200) {
      throw new \Exception('Failed to replace multiple ips');
    }

    if ($response->body->status == 'ok') {
      return true;
    }

    return false;
  }  
}