# crypto-notification-telegram-bot
## What is this?
cosa è, lo scopo del bot e dove si può provare @CryptoNotification_bot

---
## Libraries and services used

---
## How does it work?

---
## How to adapt on your own server
1. You need your [Telegram bot API token](https://core.telegram.org/bots#how-do-i-create-a-bot), your [CoinmarketAPI token](https://coinmarketcap.com/api/documentation/v1/), info of the database (username, password, hostname and database name).

2. You have to upload into your server's database the file `crypto_notification_db.sql` in `config/` folder. There is also the `readme.md` file about the config info and the database tables.

3. After this you have to set the webhook of the bot ([by the `setWebhook` Telegram bot API call](https://core.telegram.org/bots/api#setwebhook)) and (eventually) insert a record into the `cryn_users` table with your data, so you can use it. But if, into the `config.json` file you set `OPEN_ACCESS_TO_BOT` to 1 you should not need this.

---
