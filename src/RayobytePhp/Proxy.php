<?php

namespace Kokiddp\RayobytePhp;

class Proxy
{
  /**
   * @var string ip
   */
  private string $ip;

  /**
   * @var int port
   */
  private int $port;

  /**
   * @var string username
   */
  private string $username;

  /**
   * @var string password
   */
  private string $password;

  /**
   * @var string region
   */
  private string $region;

  /**
   * @var string country
   */
  private string $country;

  /**
   * @var string category
   */
  private string $category;

  /**
   * Constructor
   * 
   * @param string $ip
   * @param int $port
   * @param string $username
   * @param string $password
   * @param string $region
   * @param string $country
   * @param string $category
   */
  public function __construct(string $ip, int $port, string $username, string $password, string $region = '', string $country = '', string $category = '')
  {
    $this->ip = $ip;
    $this->port = $port;
    $this->username = $username;
    $this->password = $password;
    $this->region = $region;
    $this->country = $country;
    $this->category = $category;
  }

  /**
   * Create from string
   *
   * @param string $string
   * @return Proxy
   */
  public static function fromString(string $string) : Proxy
  {
    $parts = explode(':', $string);
    $ip = $parts[0];
    $port = (int) $parts[1];
    $username = $parts[2];
    $password = $parts[3];

    $extraParts = explode(',', $parts[3]);
    if (count($extraParts) < 4) {
      if (count($extraParts) == 1) {
        $password = $extraParts[0];        
      }
      else {
        $password = '';
      }
      $region = '';
      $country = '';
      $category = '';
    }
    $password = $extraParts[0];
    $region = $extraParts[1];
    $country = $extraParts[2];
    $category = $extraParts[3];    

    return new Proxy($ip, $port, $username, $password, $region, $country, $category);
  }

  /**
   * Get IP
   * 
   * @return string
   */
  public function getIp() : string
  {
    return $this->ip;
  }

  /**
   * Get Port
   * 
   * @return int
   */
  public function getPort() : int
  {
    return $this->port;
  }

  /**
   * Get Full IP
   * 
   * @return string
   */
  public function getFullIp() : string
  {
    return 'http://' . $this->username . ':' . $this->password . '@' . $this->ip . ':' . $this->port;
  }

  /**
   * Get Username
   * 
   * @return string
   */
  public function getUsername() : string
  {
    return $this->username;
  }

  /**
   * Get Password
   * 
   * @return string
   */
  public function getPassword() : string
  {
    return $this->password;
  }

  /**
   * Get Region
   * 
   * @return string
   */
  public function getRegion() : string
  {
    return $this->region;
  }

  /**
   * Get Country
   * 
   * @return string
   */
  public function getCountry() : string
  {
    return $this->country;
  }

  /**
   * Get Category
   * 
   * @return string
   */
  public function getCategory() : string
  {
    return $this->category;
  }
}