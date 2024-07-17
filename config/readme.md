## Config informations

In `config.json` there are the same fields, for the production and for testing, to have two different static settings:
- TELEGRAM_BOT_API_TOKEN
- COINMARKET_API_TOKEN
- OPEN_ACCESS_TO_BOT : if 1 every Telegram account can use the bot, if is 0 the bot is closed to new users
- DATABASE_INFO

## Database informations
There are 4 tables:
- `cryn_cryptocurrencies` : info about crypto supported by the bot (`cryn_id` is from CoinmarketAPI)
- `cryn_history` : every 5 minuest shold be updated by the cronjob with the info about prices of cryptocurrencies (to show this info without calling the CoinmarketAPI and usa an API call)
- `cryn_notifications` : info about notification activated from the users on specific cryptocurrencies
- `cryn_users` : info about the Telegram users
<br><br>
In the database file there are also two triggers:

#### When a new crypto is inserted
```SQL
DELIMITER //
CREATE TRIGGER on_new_crypto
AFTER INSERT ON cryn_cryptocurrencies
FOR EACH ROW
BEGIN
  INSERT INTO cryn_notifications (user_idtelegram, crypto_id)
	SELECT user_idtelegram, NEW.crypto_id FROM cryn_users;
END //
DELIMITER ;
```

#### When a new user is inserted
```SQL
DELIMITER //
CREATE TRIGGER on_new_user
AFTER INSERT ON cryn_users
FOR EACH ROW
BEGIN
  INSERT INTO cryn_notifications (user_idtelegram, crypto_id)
  SELECT NEW.user_idtelegram, crypto_id FROM cryn_cryptocurrencies;
END //
DELIMITER ;
```
