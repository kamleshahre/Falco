-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2011 at 03:14 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `falco_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent_payments`
--

DROP TABLE IF EXISTS `agent_payments`;
CREATE TABLE IF NOT EXISTS `agent_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` varchar(255) NOT NULL,
  `month` int(22) NOT NULL,
  `year` int(22) NOT NULL,
  `paid` enum('Y','N') NOT NULL DEFAULT 'N',
  `paid_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `agent_payments`
--

INSERT INTO `agent_payments` (`id`, `agent`, `month`, `year`, `paid`, `paid_date`) VALUES
(64, 'tetova_turs', 7, 2011, 'Y', '2011-07-20'),
(63, 'gradec_turizam', 7, 2011, 'Y', '2011-07-18');

-- --------------------------------------------------------

--
-- Table structure for table `available_trips`
--

DROP TABLE IF EXISTS `available_trips`;
CREATE TABLE IF NOT EXISTS `available_trips` (
  `trip_id` int(11) NOT NULL AUTO_INCREMENT,
  `prej` varchar(255) NOT NULL,
  `deri` varchar(255) NOT NULL,
  `data` date NOT NULL,
  `vende` int(11) NOT NULL,
  PRIMARY KEY (`trip_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `available_trips`
--

INSERT INTO `available_trips` (`trip_id`, `prej`, `deri`, `data`, `vende`) VALUES
(1, 'Tetov', 'Berlin', '2011-07-27', 50);

-- --------------------------------------------------------

--
-- Table structure for table `costs`
--

DROP TABLE IF EXISTS `costs`;
CREATE TABLE IF NOT EXISTS `costs` (
  `cost_id` int(11) NOT NULL AUTO_INCREMENT,
  `prej` varchar(255) NOT NULL,
  `deri` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cost` int(11) NOT NULL,
  `return_cost` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cost_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `costs`
--

INSERT INTO `costs` (`cost_id`, `prej`, `deri`, `cost`, `return_cost`, `date`) VALUES
(32, 'Tetov', 'Stuttgart', 100, 180, '2011-07-12 05:59:11'),
(31, 'Berlin', 'Tetov', 160, 300, '2011-07-12 05:59:41'),
(35, 'Hamburg', 'Tetov', 180, 320, '2011-07-12 06:00:00'),
(30, 'Tetov', 'Berlin', 160, 300, '2011-07-12 05:59:41'),
(36, 'Gostivar', 'Berlin', 200, 320, '2011-07-12 06:00:19'),
(37, 'Berlin', 'Gostivar', 200, 320, '2011-07-12 06:00:19'),
(33, 'Stuttgart', 'Tetov', 100, 180, '2011-07-12 05:59:11'),
(34, 'Tetov', 'Hamburg', 180, 320, '2011-07-12 06:00:00'),
(38, 'Gostivar', 'Stuttgart', 110, 200, '2011-07-12 06:10:09'),
(39, 'Stuttgart', 'Gostivar', 110, 200, '2011-07-12 06:10:09'),
(40, 'Diber', 'Stuttgart', 150, 270, '2011-07-17 21:04:36'),
(41, 'Stuttgart', 'Diber', 150, 270, '2011-07-17 21:04:36'),
(42, 'Diber', 'Berlin', 200, 370, '2011-07-17 21:04:54'),
(43, 'Berlin', 'Diber', 200, 370, '2011-07-17 21:04:54'),
(53, 'Göttingen', 'Tetov', 100, 200, '2011-07-20 02:37:35'),
(45, 'Berlin', 'Strug', 160, 300, '2011-07-20 02:13:32'),
(52, 'Tetov', 'Göttingen', 100, 200, '2011-07-20 02:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
CREATE TABLE IF NOT EXISTS `destinations` (
  `dest_id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `direction` enum('1','2') NOT NULL,
  PRIMARY KEY (`dest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`dest_id`, `name`, `direction`) VALUES
(17, 'Tetov', '1'),
(3, 'Berlin', '2'),
(18, 'Gostivar', '1'),
(6, 'Stuttgart', '2'),
(19, 'Diber', '1'),
(9, 'Hamburg', '2'),
(21, 'Hannover', '2'),
(27, 'Beograd', '2'),
(28, 'Zagreb', '2'),
(29, 'Maribor', '2'),
(30, 'Graz', '2'),
(31, 'Wells', '2'),
(32, 'Passau', '2'),
(33, 'Regensburg', '2'),
(35, 'Fulda', '2'),
(36, 'Kircheim', '2'),
(37, 'Kassel', '2'),
(38, 'Göttingen', '2'),
(39, 'Bremen', '2');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `prej` varchar(255) NOT NULL,
  `deri` varchar(255) NOT NULL,
  `KthyesePrej` varchar(255) NOT NULL,
  `KthyeseDeri` varchar(255) NOT NULL,
  `persona` int(25) NOT NULL DEFAULT '1',
  `femij` int(25) NOT NULL,
  `date` date NOT NULL,
  `data_kthyese` date NOT NULL,
  `rezervues` varchar(255) NOT NULL,
  `cost` int(255) NOT NULL,
  `provision` decimal(20,2) NOT NULL,
  `cost_noprovision` int(255) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=187 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `name`, `surname`, `prej`, `deri`, `KthyesePrej`, `KthyeseDeri`, `persona`, `femij`, `date`, `data_kthyese`, `rezervues`, `cost`, `provision`, `cost_noprovision`) VALUES
(182, 'ccccc', 'cccccc', 'Diber', 'G&#65533;ttingen', 'G&#65533;ttingen', 'Diber', 1, 0, '2011-07-20', '2011-07-31', 'admin', 0, '0.00', 0),
(183, 'ccccc', 'cccccc', 'Diber', 'G&#65533;ttingen', 'G&#65533;ttingen', 'Diber', 1, 0, '2011-07-20', '2011-07-31', 'admin', 0, '0.00', 0),
(186, 'fff', 'ffff', 'Tetov', 'Göttingen', '', '', 1, 0, '2011-07-21', '0000-00-00', 'admin', 100, '10.00', 0),
(176, 'Shpetim', 'Islami', 'Tetov', 'Berlin', '', '', 1, 0, '2011-07-06', '0000-00-00', 'admin', 160, '16.00', 0),
(177, 'Sabri', 'Fejzullahu', 'Tetov', 'Berlin', '', '', 1, 0, '2011-07-06', '0000-00-00', 'gradec_turizam', 160, '28.80', 0),
(179, 'Shpetim', 'Islami', 'Tetov', 'Berlin', '', '', 1, 0, '2011-07-08', '0000-00-00', 'tetova_turs', 160, '19.20', 0),
(175, 'Sabri', 'Fejzullahu', 'Tetov', 'Berlin', 'Berlin', 'Tetov', 2, 0, '2011-07-04', '2011-07-31', 'gradec_turizam', 640, '115.20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET ucs2 NOT NULL,
  `status` enum('admin','agent') CHARACTER SET utf8 NOT NULL DEFAULT 'agent',
  `selected_provis` decimal(20,2) NOT NULL DEFAULT '0.10',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `address`, `username`, `password`, `status`, `selected_provis`) VALUES
(1, 'Shpetim', 'Islami', 'Tetov', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '0.10'),
(2, 'Shpetim', 'Islami', 'Gradec', 'gradec_turizam', '5d0f3c466d6d3a0d87ba175b0f2ef933', 'agent', '0.18'),
(3, 'Fatmir', 'Sejdiu', 'Tetov', 'tetova_turs', '9bd818c8b63c8769501bb5ee5893791d', 'agent', '0.12'),
(21, 'Test', 'Test', 'Test', 'test', 'd41d8cd98f00b204e9800998ecf8427e', 'agent', '0.10'),
(22, 'Shpetim', 'Islami', 'Gradec, 101 BB', 'admin2', 'c84258e9c39059a89ab77d846ddab909', 'admin', '0.00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
