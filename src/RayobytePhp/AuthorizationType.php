<?php

namespace Kokiddp\RayobytePhp;

class AuthorizationType
{
  /**
   * The auth type
   * @var string
   */
  private string $authType;

  /**
   * The username
   * @var string
   */
  private string $username;

  /**
   * The password
   * @var string
   */
  private string $password;

  /**
   * Constructor
   * @param string $authType 
   * @param string $username 
   * @param string $password 
   * @return void 
   */
  public function __construct(string $authType, string $username, string $password)
  {
    $this->authType = $authType;
    $this->username = $username;
    $this->password = $password;
  }

  /**
   * Get Authorization Type
   * @return string
   */
  public function getAuthType(): string
  {
    return $this->authType;
  }

  /**
   * Get Username
   * @return string
   */
  public function getUsername(): string
  {
    return $this->username;
  }

  /**
   * Get Password
   * @return string
   */
  public function getPassword(): string
  {
    return $this->password;
  }
}