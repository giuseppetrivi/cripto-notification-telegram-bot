<?php

/**
 * Class to handle the static table of cryptocurrencies list
 */
class Cryptocurrencies extends Entity {

  private function __construct() {}

  public static function getAllCryptocurrencies() {
    $cryptocurrencies = DB::query("SELECT * FROM cryn_cryptocurrencies");

    if (!empty($cryptocurrencies)) {
      return $cryptocurrencies;
    }

    throw new Exception("Error in cryptocurrencies select");
  }

}