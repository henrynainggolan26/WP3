-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 16, 2016 at 05:17 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id_post` int(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  PRIMARY KEY (`id_post`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id_post`, `title`, `content`, `user_id`, `create_at`, `update_at`) VALUES
(31, 'SS MAJU', 'ss maju 771211', '1', '2016-09-16 14:08:50', '2016-09-16 16:27:21'),
(33, 'SS MAJU', 'ss maju 2', '1', '2016-09-16 16:55:57', '2016-09-16 16:59:22'),
(35, 'SS MAJU', 'ss maju 4', '1', '2016-09-16 16:59:30', '2016-09-16 16:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`) VALUES
(1, 'ssmaju', 'ssmaju');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
