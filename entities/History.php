<?php

/**
 * 
 */
class History extends Entity {

  protected $id_telegram;

  public function __construct($id_telegram) {
    $this->setIdTelegram($id_telegram);
  }


  /**
   * 
   */
  public static function insertNewHistoryRecords($_CoinmarketResponse) {
    self::deleteOldHistoryRecords();

    $crypto_list = Cryptocurrencies::getAllCryptocurrencies();
    foreach ($crypto_list as $crypto_info) {
      $crypto_id = $crypto_info['crypto_id'];
      $crypto_price = $_CoinmarketResponse->getPriceFromCryptoId($crypto_id);
      $crypto_percent_change_24h =  $_CoinmarketResponse->getPercentChange24hFromCryptoId($crypto_id);
      $crypto_percent_change_7d =  $_CoinmarketResponse->getPercentChange7dFromCryptoId($crypto_id);
      $crypto_percent_change_30d =  $_CoinmarketResponse->getPercentChange30dFromCryptoId($crypto_id);

      $created_rows = DB::insert("cryn_history", [
          "crypto_id" => $crypto_id,
          "his_price" => $crypto_price,
          "his_percent_change_24h" => $crypto_percent_change_24h,
          "his_percent_change_7d" => $crypto_percent_change_7d,
          "his_percent_change_30d" => $crypto_percent_change_30d
        ]
      );

      if ($created_rows>1) {
        throw new Exception("Errore nell'inserimento delle crypto in history");
      }

    }
  }


  /**
   * 
   */
  private static function deleteOldHistoryRecords() {
    $affected_rows = DB::query("DELETE FROM cryn_history WHERE 1");
  }


  /**
   * 
   */
  public function getUserLatestUpdates() {
    $latest_updates = DB::query("SELECT c.crypto_id, c.crypto_name, h.his_datetime, h.his_price, h.his_percent_change_24h,
      h.his_percent_change_7d, h.his_percent_change_30d
      FROM cryn_users as u
      INNER JOIN cryn_notifications as n ON u.user_idtelegram=n.user_idtelegram
      INNER JOIN cryn_cryptocurrencies as c ON n.crypto_id=c.crypto_id
      INNER JOIN cryn_history as h ON c.crypto_id=h.crypto_id
      WHERE u.user_idtelegram=%i AND n.notify_status=1
      ORDER BY h.his_datetime, h.his_price DESC",
      $this->getIdTelegram()
    );
    
    if (count($latest_updates)<1) {
      throw new Exception("Errore nell'prendere i dati degli ultimi update sulle crypto");
    }
    return $latest_updates;
  }

}