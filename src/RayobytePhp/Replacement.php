<?php

namespace Kokiddp\RayobytePhp;

class Replacement
{
  /**
   * @var string country
   */
  private string $country;

  /**
   * @var string category
   */
  private string $category;

  /**
   * @var int available
   */
  private int $available;

  /**
   * Constructor
   * 
   * @param string $country
   * @param string $category
   * @param int $available
   * @return void
   */
  public function __construct(string $country, string $category, int $available)
  {
    $this->country = $country;
    $this->category = $category;
    $this->available = $available;
  }

  /**
   * Get Country
   * 
   * @return string
   */
  public function getCountry(): string
  {
    return $this->country;
  }

  /**
   * Get Category
   * 
   * @return string
   */
  public function getCategory(): string
  {
    return $this->category;
  }

  /**
   * Get Available
   * 
   * @return int
   */
  public function getAvailable(): int
  {
    return $this->available;
  }
}
