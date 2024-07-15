<?php

class CustomMessages {

  public const PRESS_BACK = "<i>Press Back to go to main menu</i>";


  public static function welcomeStart($username="nulla") {
    $text = "\xF0\x9F\x98\x8A Hi @" . $username . " !\n"
      . "Welcome in this tracker bot of main cryptocurrencies.\n\n"
      . "\xE2\x9A\x93 This below is the main menu";
    return $text;
  }

  public static function mainMenu() {
    $text = "\xE2\x9A\x93 Main menu";
    return $text;
  }


  public static function intervalInformations($actual_interval) {
    $text = "\xF0\x9F\x8E\xB2 Send the minutes of interval between notifications "  
      . "(or send one of standard from buttons below)\n\n"
      . "\xF0\x9F\x95\xA2 Actual interval = <code>$actual_interval</code> min.";
    return $text;
  }

  public static function notificationsInformations() {
    $text = "\xF0\x9F\x8C\x80 Select the option to change the notification settings "
      . "(from on to off and viceversa), or turn silent all notifications (or turn sound)";
    return $text;
  }

  public static function newMinutesIntervalInformations($new_minutes_interval) {
    $text = "\xF0\x9F\x95\xA2 <i>Now you will be updated every " . $new_minutes_interval
      . " minutes starting from now</i>";
    return $text;
  }


  public static function infoAboutCrypto($crypto_info) {
    $crypto_id = $crypto_info['id'];
    $crypto_name = $crypto_info['name'];
    $crypto_price = $crypto_info['price'];
    $crypto_percent_change_24h = $crypto_info['percent_change_24h'];
    $crypto_percent_change_7d = $crypto_info['percent_change_7d'];
    $crypto_percent_change_30d = $crypto_info['percent_change_30d'];


    $emojiPercent24h = $crypto_percent_change_24h>=0 ? "\xF0\x9F\x93\x88" : "\xF0\x9F\x93\x89";
    $emojiPercent7d = $crypto_percent_change_7d>=0 ? "\xF0\x9F\x93\x88" : "\xF0\x9F\x93\x89";
    $emojiPercent30d = $crypto_percent_change_30d>=0 ? "\xF0\x9F\x93\x88" : "\xF0\x9F\x93\x89";
    $text = "[ <b>".$crypto_id."</b> ] <b>".$crypto_name."</b>\n"
      . "\xF0\x9F\x92\xB6 Price: ".number_format($crypto_price, 8, ',', '.')." €\n"
      . "$emojiPercent24h Percentage in last 24h: <u>". ($crypto_percent_change_24h>0 ? "+" : "") .number_format($crypto_percent_change_24h, 3, ',', '.')." %</u>\n"
      . "$emojiPercent7d Percentage in last 7d: <u>". ($crypto_percent_change_7d>0 ? "+" : "") .number_format($crypto_percent_change_7d, 3, ',', '.')." %</u>\n"
      . "$emojiPercent30d Percentage in last 30d: <u>". ($crypto_percent_change_30d>0 ? "+" : "") .number_format($crypto_percent_change_30d, 3, ',', '.')." %</u>\n";
    return $text;
  } 

  public static function latestAvailableUpdates($latest_update_datetime, $final_crypto_info_list) {
    $formatted_datetime = date("H:i:s", strtotime($latest_update_datetime)). " of " . date("d F Y", strtotime($latest_update_datetime));
    $text = "\xE2\x8C\x9A <i>Latest update at " . $formatted_datetime . "</i>\n"
      . "----------\n\n"
      . $final_crypto_info_list;
    return $text;
  } 

}