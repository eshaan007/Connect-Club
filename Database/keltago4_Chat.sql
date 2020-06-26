-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2020 at 06:42 PM
-- Server version: 5.7.30
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keltago4_Chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_clubs`
--

CREATE TABLE `chat_clubs` (
  `club_id` int(11) NOT NULL,
  `club_name` varchar(255) DEFAULT NULL,
  `club_password` varchar(255) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `members` int(11) DEFAULT NULL,
  `club_type` enum('private','public') DEFAULT NULL,
  `vkey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chat_club_member`
--

CREATE TABLE `chat_club_member` (
  `u_id` int(11) NOT NULL,
  `club_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chat_msgs`
--

CREATE TABLE `chat_msgs` (
  `chat_id` int(11) NOT NULL,
  `chat_msg` varchar(1000) DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  `time_stamp` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `otheruserview`
-- (See below for the actual view)
--
CREATE TABLE `otheruserview` (
`u_id` int(11)
,`u_name` varchar(255)
,`real_name` varchar(255)
,`email` varchar(255)
,`gender` enum('Male','Female','Other')
);

-- --------------------------------------------------------

--
-- Table structure for table `pokes`
--

CREATE TABLE `pokes` (
  `poker_id` int(11) DEFAULT NULL,
  `rece_id` int(11) DEFAULT NULL,
  `seen` enum('0','1') DEFAULT NULL,
  `poke_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `theme_user`
--

CREATE TABLE `theme_user` (
  `u_id` int(11) DEFAULT NULL,
  `theme_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) DEFAULT NULL,
  `real_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `u_password` varchar(255) DEFAULT NULL,
  `vkey` varchar(255) DEFAULT NULL,
  `verified` enum('0','1') DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `web_theme`
--

CREATE TABLE `web_theme` (
  `theme_id` int(11) NOT NULL,
  `theme_color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `web_theme`
--

INSERT INTO `web_theme` (`theme_id`, `theme_color`) VALUES
(1, 'blue'),
(2, 'indigo'),
(3, 'red'),
(4, 'pink'),
(5, 'green');

-- --------------------------------------------------------

--
-- Structure for view `otheruserview`
--
DROP TABLE IF EXISTS `otheruserview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`keltago40`@`localhost` SQL SECURITY DEFINER VIEW `otheruserview`  AS  select `users`.`u_id` AS `u_id`,`users`.`u_name` AS `u_name`,`users`.`real_name` AS `real_name`,`users`.`email` AS `email`,`users`.`gender` AS `gender` from `users` ;
