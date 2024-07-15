<?php


/**
 * Process at start of the bot
 */
class MainProcess extends AbstractProcess {

  protected array $valid_inputs = [
    MenuOptions::COMMAND_START => 'startProcedure',
    MenuOptions::SET_TIME_INTERVAL => 'openSetIntervalProcedure',
    MenuOptions::NOTIFY_CENTER => 'openNotifyCenterProcedure',
    MenuOptions::LATEST_UPDATES => 'openLatestUpdatesProcedure',
  ];

  protected function mainCode() {
    parent::mainCode();
  }


  /**
   * 
   */
  protected function startProcedure() {
    $reply_markup = Keyboards::getMainMenu();

    $this->_Bot->sendMessage([
      'text' => CustomMessages::welcomeStart($this->_Bot->getWebhookUpdate()->getMessage()->getFrom()->getUsername()),
      'reply_markup' => $reply_markup
    ]);
  }

  /**
   * 
   */
  protected function openSetIntervalProcedure() {
    $reply_markup = Keyboards::getSetTimeInterval();
    $this->_Bot->sendMessage([
      'text' => CustomMessages::intervalInformations($this->_User->getMinutesInterval()),
      'reply_markup' => $reply_markup
    ]);

    $this->next_process = 'SetTimeInterval';
  }

  /**
   * 
   */
  protected function openNotifyCenterProcedure() {
    $raw_notify_status_data = $this->_User->getNotificationsHandler()->getAllNotifyStatus();
    $silent = $this->_User->getSilentNotify();

    $reply_markup = InlineKeyboards::getNotifyStatus($raw_notify_status_data, $silent);
    $this->_Bot->sendMessage([
      'text' => CustomMessages::notificationsInformations(),
      'reply_markup' => $reply_markup
    ]);

    $reply_markup = Keyboards::getOnlyBack();
    $this->_Bot->sendMessage([
      'text' => CustomMessages::PRESS_BACK,
      'reply_markup' => $reply_markup
    ]);

    $this->next_process = 'NotifyCenter';
  }

  /**
   * 
   */
  protected function openLatestUpdatesProcedure() {
    $latest_updates = $this->_User->getHistory()->getUserLatestUpdates();

    $latest_update_datetime = date("Y-m-d H:i:s");
    $final_message_to_send = "";
    foreach ($latest_updates as $update_info) {
      $latest_update_datetime = $update_info['his_datetime'];
      $crypto_info = [
        'id' => $update_info['crypto_id'],
        'name' => $update_info['crypto_name'],
        'price' => $update_info['his_price'],
        'percent_change_24h' => $update_info['his_percent_change_24h'],
        'percent_change_7d' => $update_info['his_percent_change_7d'],
        'percent_change_30d' => $update_info['his_percent_change_30d']
      ];

      $final_message_to_send .= CustomMessages::infoAboutCrypto($crypto_info)."\n";
    }

    $this->_Bot->sendMessage([
      'text' => CustomMessages::latestAvailableUpdates($latest_update_datetime, $final_message_to_send)
    ]);
  }

}