-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2020 at 03:11 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `place` varchar(200) NOT NULL,
  `start_time` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `end_time` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `money` varchar(200) NOT NULL,
  `amount_in_total` varchar(200) NOT NULL,
  `total_money` varchar(200) NOT NULL,
  `action_slash` varchar(200) NOT NULL,
  `slash_number` varchar(200) NOT NULL,
  `selling_slash` varchar(200) NOT NULL,
  `water_number` varchar(200) NOT NULL,
  `selling_water` varchar(200) NOT NULL,
  `payment_status` varchar(200) NOT NULL,
  `game_status` varchar(200) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `time` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `users_name` varchar(200) NOT NULL,
  `users_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `place`, `start_time`, `end_time`, `money`, `amount_in_total`, `total_money`, `action_slash`, `slash_number`, `selling_slash`, `water_number`, `selling_water`, `payment_status`, `game_status`, `comment`, `time`, `users_name`, `users_id`) VALUES
(1, '1', '2020-08-03 13:05:00.000000', '2020-08-03 16:05:00.000000', '12 ₾', '12 ₾', '31 ₾', '3', '11', '16.5 ₾', '5', '2.5 ₾', 'გადახდილია', 'აქტიური', '', '2020-07-30 10:51:15.640852', 'Game User', '78114590135'),
(2, '5', '2020-08-03 10:07:00.000000', '2020-08-03 13:45:00.000000', '14.53 ₾', '14.53 ₾', '22.03 ₾', '5', '5', '', '', '', 'გადახდილია', 'აქტიური', 'UUUF', '2020-07-30 10:55:51.532144', 'Game User', '78114590135'),
(3, 'VIP', '2020-07-30 11:20:00.000000', '2020-07-30 17:20:00.000000', '48 ₾', '72 ₾', '88 ₾', '8', '8', '12 ₾', '8', '4 ₾', 'გადახდილია', 'აქტიური', '', '2020-07-30 11:21:05.409125', 'Game User', '78114590135'),
(4, '4', '2020-08-03 13:10:00.000000', '2020-08-03 16:10:00.000000', '12 ₾', '24 ₾', '39 ₾', '6', '6', '9 ₾', '12', '6 ₾', 'გადახდილია', 'აქტიური', '', '2020-08-03 12:47:15.907282', 'Game User', '78114590135');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `user_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `pass`, `user_id`) VALUES
(1, 'Game User', '1234', '78114590135'),
(2, 'Game User 1', '4321', '10934671781');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
