-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Created on: Lug 15, 2024 alle 23:18
-- Server version: 10.6.18-MariaDB-cll-lve-log
-- PHP version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `your_database`
--

-- --------------------------------------------------------

--
-- Structure of table `cryn_cryptocurrencies`
--

CREATE TABLE `cryn_cryptocurrencies` (
  `crypto_id` varchar(5) NOT NULL COMMENT 'related to coinmarketapi',
  `crypto_name` varchar(16) NOT NULL,
  `crypto_available_from` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump of data for the table `cryn_cryptocurrencies`
--

INSERT INTO `cryn_cryptocurrencies` (`crypto_id`, `crypto_name`, `crypto_available_from`) VALUES
('BTC', 'Bitcoin', '2023-11-05 18:38:02'),
('DOGE', 'Dogecoin', '2023-11-05 18:38:21'),
('ETH', 'Etherum', '2023-11-05 18:38:02'),
('LTC', 'Litecoin', '2023-11-05 18:38:38'),
('SHIB', 'Shiba Inu', '2023-11-05 18:38:11'),
('SOL', 'Solana', '2023-11-05 23:50:01');

--
-- Trigger `cryn_cryptocurrencies`
--
DELIMITER $$
CREATE TRIGGER `on_new_crypto` AFTER INSERT ON `cryn_cryptocurrencies` FOR EACH ROW BEGIN
   INSERT INTO cryn_notifications (user_idtelegram, crypto_id)
	SELECT user_idtelegram, NEW.crypto_id FROM cryn_users;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure of table `cryn_history`
--

CREATE TABLE `cryn_history` (
  `his_id` int(11) NOT NULL COMMENT 'id auto increment',
  `crypto_id` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'fk crypto_id',
  `his_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `his_price` double NOT NULL,
  `his_percent_change_24h` float NOT NULL,
  `his_percent_change_7d` float NOT NULL,
  `his_percent_change_30d` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure of table `cryn_notifications`
--

CREATE TABLE `cryn_notifications` (
  `user_idtelegram` int(13) NOT NULL,
  `crypto_id` varchar(5) NOT NULL,
  `notify_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 on, 0 off'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure of table `cryn_users`
--

CREATE TABLE `cryn_users` (
  `user_idtelegram` int(13) NOT NULL,
  `user_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 is active, 0 is not',
  `user_expirationdate` date DEFAULT NULL COMMENT 'null means EVER',
  `user_minutesinterval` smallint(6) NOT NULL DEFAULT 120,
  `user_timeleft_notify` smallint(6) NOT NULL DEFAULT 0,
  `user_lastaction_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `user_processname` varchar(32) DEFAULT NULL,
  `user_silent_notifies` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 means silent, 0 not silent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `cryn_users`
--
DELIMITER $$
CREATE TRIGGER `on_new_user` AFTER INSERT ON `cryn_users` FOR EACH ROW BEGIN
  INSERT INTO cryn_notifications (user_idtelegram, crypto_id)
  SELECT NEW.user_idtelegram, crypto_id FROM cryn_cryptocurrencies;
END
$$
DELIMITER ;

--
-- Indexes for downloaded tables
--

--
-- Index for table `cryn_cryptocurrencies`
--
ALTER TABLE `cryn_cryptocurrencies`
  ADD PRIMARY KEY (`crypto_id`);

--
-- Index for table `cryn_history`
--
ALTER TABLE `cryn_history`
  ADD PRIMARY KEY (`his_id`),
  ADD KEY `crypto_id` (`crypto_id`);

--
-- Index for table `cryn_notifications`
--
ALTER TABLE `cryn_notifications`
  ADD PRIMARY KEY (`user_idtelegram`,`crypto_id`),
  ADD KEY `crypto_id` (`crypto_id`);

--
-- index for table `cryn_users`
--
ALTER TABLE `cryn_users`
  ADD PRIMARY KEY (`user_idtelegram`);

--
-- AUTO_INCREMENT for downloaded tables
--

--
-- AUTO_INCREMENT for table `cryn_history`
--
ALTER TABLE `cryn_history`
  MODIFY `his_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id auto increment';

--
-- Limits for downloaded table
--

--
-- Limits for table `cryn_history`
--
ALTER TABLE `cryn_history`
  ADD CONSTRAINT `cryn_history_ibfk_1` FOREIGN KEY (`crypto_id`) REFERENCES `cryn_cryptocurrencies` (`crypto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limits for table `cryn_notifications`
--
ALTER TABLE `cryn_notifications`
  ADD CONSTRAINT `cryn_notifications_ibfk_1` FOREIGN KEY (`user_idtelegram`) REFERENCES `cryn_users` (`user_idtelegram`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cryn_notifications_ibfk_2` FOREIGN KEY (`crypto_id`) REFERENCES `cryn_cryptocurrencies` (`crypto_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
