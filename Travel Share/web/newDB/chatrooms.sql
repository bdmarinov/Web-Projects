-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 15 дек 2019 в 23:06
-- Версия на сървъра: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websocket`
--

-- --------------------------------------------------------

--
-- Структура на таблица `chatrooms`
--

CREATE TABLE `chatrooms` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `msg` varchar(200) COLLATE utf8_bin NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `chatrooms`
--

INSERT INTO `chatrooms` (`id`, `userid`, `msg`, `created_on`) VALUES
(58, 12, 'Ооо Боги дай да го пробваме тоя чат ще тръгне ли', '2019-12-15 11:01:59'),
(59, 6, 'Всичко точно', '2019-12-15 11:02:11'),
(60, 6, 'Зарежда съобщенията на български', '2019-12-15 11:02:22'),
(61, 6, 'Изкарва времето и потребителя', '2019-12-15 11:02:34'),
(62, 12, 'Q da vidim na latinica kak shte e chata', '2019-12-15 11:02:46'),
(63, 6, 'I na latinica gi zarejda', '2019-12-15 11:03:01'),
(64, 6, 'Значи всичко точно', '2019-12-15 11:03:30'),
(65, 12, 'Сега да видим дали ги пази в базите данни', '2019-12-15 11:03:38'),
(66, 12, 'И дали ще ги зареди ако рефрешнем', '2019-12-15 11:03:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
