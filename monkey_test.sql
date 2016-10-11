-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 172.17.0.4
-- Generation Time: Oct 11, 2016 at 06:11 AM
-- Server version: 5.6.33
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monkey_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `pcore_system_test_a`
--

CREATE TABLE `pcore_system_test_a` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统测试用表A';

-- --------------------------------------------------------

--
-- Table structure for table `pcore_system_test_b`
--

CREATE TABLE `pcore_system_test_b` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统测试用表B';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pcore_system_test_a`
--
ALTER TABLE `pcore_system_test_a`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pcore_system_test_b`
--
ALTER TABLE `pcore_system_test_b`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pcore_system_test_a`
--
ALTER TABLE `pcore_system_test_a`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pcore_system_test_b`
--
ALTER TABLE `pcore_system_test_b`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
