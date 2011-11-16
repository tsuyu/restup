-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 10, 2009 at 09:30 PM
-- Server version: 5.1.30
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `rssdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `itemid` int(4) NOT NULL AUTO_INCREMENT,
  `itemname` varchar(50) NOT NULL,
  `category` varchar(30) NOT NULL,
  `price` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemid`, `itemname`, `category`, `price`, `description`) VALUES
(NULL, 'Nasi goreng kampung', 'Western', '3.00', 'Made in Kampung'),
(NULL, 'Tom Yam Puteh', 'Thai Style', '20.00', 'Special Promotion'),
(NULL, 'Sky Juice', 'Drink', '1.00',NULL ),
(NULL, 'Orange Juice', 'Drink', '4.00', NULL),
(NULL, 'Sambal belacan', 'Kampung Style', '12.00',NULL ),
(NULL, 'Kailan Ikan Masin', 'Kampung Style', '45',NULL ),
(NULL, 'Kerabu Manga', 'Thai Style', '13.00',NULL );

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE IF NOT EXISTS `orderitem` (
  `orderitemid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(12) NOT NULL,
  `date` datetime NOT NULL,
  `tableid` varchar(2) NOT NULL,
  `orderstatus` varchar(50) NOT NULL,
  `orderdesc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`orderitemid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;



-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderid` int(10) NOT NULL,
  `itemid` varchar(4) NOT NULL,
  `quantity` varchar(2) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `tableid` varchar(2) NOT NULL,
  `tablename` char(3) DEFAULT '00',
  `status` int(11) NOT NULL,
  PRIMARY KEY (`tableid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tableid`, `tablename`, `status`) VALUES
('1', 'A1', 1),
('2', 'A2', 1),
('3', 'A3', 1),
('4', 'A4', 1),
('5', 'A5', 1),
('6', 'B6', 1),
('7', 'B7', 1),
('8', 'B8', 1),
('9', 'B9', 1),
('10', 'B10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` varchar(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `password` varchar(34) DEFAULT NULL,
  `role` varchar(6) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `name`, `email`, `telephone`, `password`, `role`) VALUES
('123', 'Ali bin Bakar', 'aaaa@gmail.com', '12345', '123', 'Admin'),
('133', 'Lee', 'ccccc@gmail.com', '12345', '123', 'Chef'),
('321', 'Kamal bin Nasir', 'asdvmmmm@gmail.com', '1234534', '123', 'Waiter');
