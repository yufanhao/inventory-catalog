-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 27, 2025 at 06:14 PM
-- Server version: 5.0.27
-- PHP Version: 5.2.1
-- 
-- Database: `inventory_db`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `items`
-- 

CREATE TABLE `items` (
  `id` int(11) NOT NULL auto_increment,
  `expiration` date NOT NULL,
  `location_id` int(11) NOT NULL,
  `serial_number` varchar(25) character set utf8 NOT NULL,
  `model_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=248 ;

-- 
-- Dumping data for table `items`
-- 

INSERT INTO `items` (`id`, `expiration`, `location_id`, `serial_number`, `model_id`) VALUES 
(1, '2025-06-26', 5, '', 1),
(4, '0000-00-00', 5, '2238-383793', 6),
(5, '0000-00-00', 5, '2238-280871', 6),
(6, '0000-00-00', 5, '2239-699396', 6),
(7, '0000-00-00', 5, '2239-699448', 6),
(8, '0000-00-00', 5, '2238-397751', 6),
(9, '0000-00-00', 5, '1845-966246', 7),
(10, '0000-00-00', 5, '', 8),
(11, '0000-00-00', 5, '', 8),
(12, '0000-00-00', 5, '', 8),
(13, '0000-00-00', 5, '', 8),
(14, '0000-00-00', 5, '', 8),
(15, '0000-00-00', 5, '', 8),
(16, '0000-00-00', 5, '', 8),
(17, '0000-00-00', 5, '', 8),
(18, '0000-00-00', 5, '', 8),
(19, '0000-00-00', 5, '', 8),
(20, '0000-00-00', 5, '', 8),
(21, '0000-00-00', 6, 'T801', 9),
(22, '0000-00-00', 6, '', 10),
(23, '0000-00-00', 6, '', 10),
(24, '0000-00-00', 6, '', 10),
(25, '0000-00-00', 6, '', 10),
(26, '0000-00-00', 6, '', 10),
(27, '0000-00-00', 6, '', 10),
(28, '0000-00-00', 6, '', 10),
(29, '0000-00-00', 6, '', 10),
(30, '0000-00-00', 6, '', 10),
(31, '0000-00-00', 6, '', 10),
(32, '0000-00-00', 6, '', 10),
(33, '0000-00-00', 6, '', 11),
(34, '0000-00-00', 6, '', 11),
(35, '0000-00-00', 6, '', 11),
(36, '0000-00-00', 6, '', 11),
(37, '0000-00-00', 6, '', 11),
(38, '0000-00-00', 6, '', 11),
(39, '0000-00-00', 6, '', 11),
(40, '0000-00-00', 6, '', 12),
(41, '0000-00-00', 6, '', 13),
(42, '0000-00-00', 6, '', 13),
(43, '0000-00-00', 6, '', 14),
(44, '0000-00-00', 6, '', 10),
(45, '0000-00-00', 6, '', 10),
(46, '0000-00-00', 6, '', 10),
(47, '0000-00-00', 6, '', 10),
(48, '0000-00-00', 6, '', 10),
(49, '0000-00-00', 6, '', 15),
(50, '0000-00-00', 6, '', 15),
(51, '0000-00-00', 6, '1727626', 15),
(52, '0000-00-00', 6, '1727595', 15),
(53, '0000-00-00', 6, '1727542', 15),
(54, '0000-00-00', 6, '1727624', 15),
(55, '0000-00-00', 6, '1727513', 15),
(56, '0000-00-00', 6, '1420016', 15),
(57, '0000-00-00', 6, '', 16),
(58, '0000-00-00', 6, '', 17),
(59, '0000-00-00', 6, '2239694182', 6),
(60, '0000-00-00', 6, '852003566', 18),
(61, '0000-00-00', 6, '852003565', 18),
(62, '0000-00-00', 6, '', 19),
(63, '0000-00-00', 6, '', 19),
(64, '0000-00-00', 6, '', 19),
(65, '0000-00-00', 6, '', 19),
(66, '0000-00-00', 6, '', 19),
(67, '0000-00-00', 6, '', 19),
(91, '0000-00-00', 7, 'EDSZ1-2429-00054', 21),
(92, '0000-00-00', 7, 'EDSZ1-2429-00050', 21),
(95, '0000-00-00', 7, 'EDSZ1-2429-00048	', 21),
(101, '0000-00-00', 7, '', 22),
(102, '0000-00-00', 7, '', 22),
(103, '0000-00-00', 7, '', 23),
(104, '0000-00-00', 7, '', 23),
(105, '0000-00-00', 7, '', 23),
(106, '0000-00-00', 7, '', 24),
(107, '0000-00-00', 7, '', 24),
(108, '0000-00-00', 7, '', 24),
(109, '0000-00-00', 7, '', 24),
(110, '0000-00-00', 7, '', 24),
(111, '0000-00-00', 7, '', 24),
(112, '0000-00-00', 7, '', 24),
(113, '0000-00-00', 7, '', 25),
(114, '0000-00-00', 7, '', 25),
(115, '0000-00-00', 7, '', 26),
(116, '0000-00-00', 7, '', 27),
(117, '0000-00-00', 7, '', 28),
(118, '0000-00-00', 7, '', 29),
(119, '0000-00-00', 7, '', 29),
(120, '0000-00-00', 7, '', 30),
(121, '0000-00-00', 7, '', 31),
(122, '0000-00-00', 7, '', 30),
(123, '0000-00-00', 7, '', 30),
(124, '0000-00-00', 7, '', 30),
(125, '0000-00-00', 7, '', 30),
(126, '0000-00-00', 7, '', 30),
(127, '0000-00-00', 7, '', 29),
(128, '0000-00-00', 7, '', 32),
(129, '0000-00-00', 7, '', 34),
(130, '0000-00-00', 7, '', 35),
(131, '0000-00-00', 7, '', 36),
(132, '0000-00-00', 7, '', 36),
(133, '0000-00-00', 7, '', 36),
(134, '0000-00-00', 7, '', 37),
(135, '0000-00-00', 7, '', 37),
(136, '0000-00-00', 7, '', 38),
(137, '0000-00-00', 7, '', 38),
(138, '0000-00-00', 7, '', 39),
(139, '0000-00-00', 7, '', 39),
(140, '0000-00-00', 7, '', 39),
(141, '0000-00-00', 7, '', 39),
(142, '0000-00-00', 7, '', 39),
(143, '0000-00-00', 7, '', 40),
(144, '0000-00-00', 7, '', 40),
(145, '0000-00-00', 7, '', 41),
(146, '0000-00-00', 7, '', 42),
(147, '0000-00-00', 7, '', 43),
(148, '0000-00-00', 7, 'SN-9', 44),
(149, '0000-00-00', 7, '', 45),
(150, '0000-00-00', 7, '', 46),
(151, '0000-00-00', 7, '', 47);

-- --------------------------------------------------------

-- 
-- Table structure for table `locations`
-- 

CREATE TABLE `locations` (
  `id` int(11) NOT NULL auto_increment,
  `number` varchar(50) character set utf8 NOT NULL,
  `type` varchar(50) character set utf8 NOT NULL,
  `description` text character set utf8 NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `locations`
-- 

INSERT INTO `locations` (`id`, `number`, `type`, `description`, `parent_id`) VALUES 
(1, '1', 'floor', '', 0),
(2, '2', 'floor', '', 0),
(3, '3', 'floor', '', 0),
(4, '3', 'cabinet', '', 2),
(5, '1', 'box', '', 4),
(6, '2', 'box', '', 4),
(7, '3', 'box', '', 4);

-- --------------------------------------------------------

-- 
-- Table structure for table `models`
-- 

CREATE TABLE `models` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) character set utf8 NOT NULL,
  `category` varchar(100) character set utf8 NOT NULL,
  `image_url` text character set utf8 NOT NULL,
  `serial_number` varchar(25) character set utf8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

-- 
-- Dumping data for table `models`
-- 

INSERT INTO `models` (`id`, `name`, `category`, `image_url`, `serial_number`) VALUES 
(1, 'DLN-4ME Multiprotocol Master Adapter', 'Adapter', '', ''),
(6, 'Aardvark I2C/SPI', 'I2C Dongle', '', ''),
(7, 'Analog Devices I2C Host Adapter', 'I2C Dongle', '', ''),
(8, 'Bus Pirate V4', 'Bus Pirate', '', ''),
(9, 'Tigerboard', 'Tigerboard', '', ''),
(10, 'JTAG to SWD Adapter Jumper', 'Jumper Cable', '', ''),
(11, 'JTag to SWD Adapter', 'Adapter', '', ''),
(12, 'Cypress', 'I2C', '', ''),
(13, 'Silicon Labs USB Debug Adapter', 'Debug Adapter', '', ''),
(14, 'STMICRO', 'STLINK-V3SET', '', ''),
(15, 'Keil ULINK-ME', '', '', 'ULA-0006B'),
(16, 'ST-LINK/V2', 'Debug Dongle', '', ''),
(17, 'NUCLEO-G0B1RE', '', '', ''),
(18, 'J-Link Compact Debug Probe', 'Debug Dongle', '', ''),
(19, 'LPC-Link 2', 'SEGGER J-LINK', '', ''),
(21, 'AsteraLabs Daughter Card', 'MCP Board', '', 'PCA-00023-03 01'),
(22, 'QSFP-DD SMT PCB-L205', 'MCP Board', '', ''),
(23, 'CXP Flash-Programmer PCB-L319', 'MCP Board', '', ''),
(24, 'Loopback Card PCB-L159', 'MCP Board', '', ''),
(25, 'QSFP PCB-L279', 'MCP Board', '', ''),
(26, 'CXP MCB Diff Pair PCB-L210', 'MCP Board', '', ''),
(27, 'SMP9 17DB LOSS PCB-L185', 'MCP Board', '', ''),
(28, 'QSFP-DD PCB-L287', 'MCP Board', '', ''),
(29, 'UltraPort QSFP PCB-L82', 'MCP Board', '', ''),
(30, 'OSFP SMT PCB-L203', 'MCP Board', '', ''),
(31, 'XCEDE PCB-L50', 'MCP Board', '', ''),
(32, 'QSFP-DD PCB-L456', 'MCP Board', '', ''),
(34, 'SFP PCB-L248', 'MCP Board', '', ''),
(35, 'Ultraport QSFP PCB-L243', 'MCP Board', '', ''),
(36, 'UltraPort QSFP PCB-L137', 'MCP Board', '', ''),
(37, 'Cal Trace PCB-L247', 'MCP Board', '', ''),
(38, 'OSFP-XD PCB-L570', 'MCP Board', '', ''),
(39, 'EQSFP MCB Test', 'MCP Board', '', ''),
(40, 'SMp9 LoopBack PCB-023-9060-002', 'MCP Board', '', ''),
(41, 'SFP 598440005', 'MCP Board', '', ''),
(42, 'PHY-SI 410-00180-101', 'MCP Board', '', ''),
(43, 'AVAS 101398', 'MCP Board', '', ''),
(44, 'TF1915', 'Aardvark?', '', ''),
(45, 'LPC-Link2', 'Debug Probe', '', ''),
(46, 'Si5392J-A-EB', 'MCP Board', '', ''),
(47, 'Sub-20', 'I2C Dongle', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(20) character set utf8 NOT NULL,
  `email` varchar(50) character set utf8 NOT NULL,
  `password` varchar(40) character set utf8 NOT NULL,
  `clearance` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `email`, `password`, `clearance`) VALUES 
(1, 'AHamiroune', 'ayhamiroune@wpi.edu', '12345', 1);
