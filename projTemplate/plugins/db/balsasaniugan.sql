-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2018 at 06:51 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `balsasaniugan`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_tbl`
--

CREATE TABLE IF NOT EXISTS `access_tbl` (
  `employee_id_fk` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branch_tbl`
--

CREATE TABLE IF NOT EXISTS `branch_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `branch_code` varchar(10) NOT NULL,
  `modified_by_fk` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

CREATE TABLE IF NOT EXISTS `category_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category_code` varchar(10) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by_fk` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_tbl`
--

CREATE TABLE IF NOT EXISTS `employee_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `position_fk` int(11) DEFAULT NULL,
  `branch_fk` int(11) DEFAULT NULL,
  `salary` decimal(11,2) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by_fk` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `birth_day` date DEFAULT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients_tbl`
--

CREATE TABLE IF NOT EXISTS `ingredients_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `quantity` int(11) DEFAULT '1',
  `unit` varchar(15) DEFAULT 'pieces',
  `description` varchar(500) DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by_fk` int(11) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_line_tbl`
--

CREATE TABLE IF NOT EXISTS `order_line_tbl` (
  `order_id_fk` int(11) NOT NULL,
  `product_id_fk` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `discount` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_tbl`
--

CREATE TABLE IF NOT EXISTS `order_tbl` (
  `id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seat_number` int(11) DEFAULT '0',
  `cashier_fk` int(11) NOT NULL,
  `branch_fk` int(11) NOT NULL,
  `waiter_fk` int(11) NOT NULL,
  `void_fk` int(11) NOT NULL DEFAULT '0',
  `total_amount` decimal(11,2) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `payment` decimal(11,2) DEFAULT NULL,
  `notes` varchar(200) DEFAULT NULL,
  `down_payment` decimal(11,2) NOT NULL DEFAULT '0.00',
  `received_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `position_tbl`
--

CREATE TABLE IF NOT EXISTS `position_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

CREATE TABLE IF NOT EXISTS `product_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `item_code` varchar(10) DEFAULT NULL,
  `category_fk` int(11) DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by_fk` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `price` decimal(11,2) DEFAULT NULL,
  `available` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
