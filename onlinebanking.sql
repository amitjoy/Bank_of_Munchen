-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 19, 2014 at 09:41 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `onlinebanking`
--

-- --------------------------------------------------------

--
-- Table structure for table `ACCOUNTS`
--

CREATE TABLE IF NOT EXISTS `ACCOUNTS` (
`id` int(15) NOT NULL,
  `balance` text NOT NULL,
  `userId` text NOT NULL,
  `accountNo` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ACCOUNTS`
--

INSERT INTO `ACCOUNTS` (`id`, `balance`, `userId`, `accountNo`, `password`) VALUES
(1, '98766.00', 'bankofmuenchen@gmail.com', '283406616050', '3a3e165f4dfe0104cfe81240d56651e032923b8441491daf2cbbcdc3f652acb48478ded894a3f5c133971fca440cb72618d50152d6be21602455a8f428c63a8d'),
(2, '100000', 'pulakchakraborty.official@gmail.com', '618796075316', '850341478d68e8d7092257e8c3b95fadfe22bac026e5886d17ebb31710f5111fbb0fe3a749a72aa22672c11ca2a4266405a6fa3d519275f7bd9c9951e87514a8'),
(3, '100000', 'admin@amitinside.com', '695913644340', '3a3e165f4dfe0104cfe81240d56651e032923b8441491daf2cbbcdc3f652acb48478ded894a3f5c133971fca440cb72618d50152d6be21602455a8f428c63a8d'),
(5, '100000', 'amit_talkin@rocketmail.com', '861827841445', '3a3e165f4dfe0104cfe81240d56651e032923b8441491daf2cbbcdc3f652acb48478ded894a3f5c133971fca440cb72618d50152d6be21602455a8f428c63a8d');

-- --------------------------------------------------------

--
-- Table structure for table `ADDRESSES`
--

CREATE TABLE IF NOT EXISTS `ADDRESSES` (
`id` int(20) NOT NULL,
  `street` varchar(20) NOT NULL,
  `zipCode` int(5) NOT NULL,
  `city` varchar(10) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `userId` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TANS`
--

CREATE TABLE IF NOT EXISTS `TANS` (
`id` int(10) NOT NULL,
  `no` bigint(20) NOT NULL,
  `userId` text NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=401 ;

--
-- Dumping data for table `TANS`
--

INSERT INTO `TANS` (`id`, `no`, `userId`, `isActive`) VALUES
(1, 456928631837232, 'bankofmuenchen@gmail.com', 0),
(2, 456928631837233, 'bankofmuenchen@gmail.com', 1),
(3, 456928631837234, 'bankofmuenchen@gmail.com', 1),
(4, 456928631837235, 'bankofmuenchen@gmail.com', 1),
(5, 456928631837236, 'bankofmuenchen@gmail.com', 1),
(6, 456928631837237, 'bankofmuenchen@gmail.com', 1),
(7, 456928631837238, 'bankofmuenchen@gmail.com', 1),
(8, 456928631837239, 'bankofmuenchen@gmail.com', 1),
(9, 456928631837240, 'bankofmuenchen@gmail.com', 1),
(10, 456928631837241, 'bankofmuenchen@gmail.com', 1),
(11, 456928631837242, 'bankofmuenchen@gmail.com', 1),
(12, 456928631837243, 'bankofmuenchen@gmail.com', 1),
(13, 456928631837244, 'bankofmuenchen@gmail.com', 1),
(14, 456928631837245, 'bankofmuenchen@gmail.com', 1),
(15, 456928631837246, 'bankofmuenchen@gmail.com', 1),
(16, 456928631837247, 'bankofmuenchen@gmail.com', 1),
(17, 456928631837248, 'bankofmuenchen@gmail.com', 1),
(18, 456928631837249, 'bankofmuenchen@gmail.com', 1),
(19, 456928631837250, 'bankofmuenchen@gmail.com', 1),
(20, 456928631837251, 'bankofmuenchen@gmail.com', 1),
(21, 456928631837252, 'bankofmuenchen@gmail.com', 1),
(22, 456928631837253, 'bankofmuenchen@gmail.com', 1),
(23, 456928631837254, 'bankofmuenchen@gmail.com', 1),
(24, 456928631837255, 'bankofmuenchen@gmail.com', 1),
(25, 456928631837256, 'bankofmuenchen@gmail.com', 1),
(26, 456928631837257, 'bankofmuenchen@gmail.com', 1),
(27, 456928631837258, 'bankofmuenchen@gmail.com', 1),
(28, 456928631837259, 'bankofmuenchen@gmail.com', 1),
(29, 456928631837260, 'bankofmuenchen@gmail.com', 1),
(30, 456928631837261, 'bankofmuenchen@gmail.com', 1),
(31, 456928631837262, 'bankofmuenchen@gmail.com', 1),
(32, 456928631837263, 'bankofmuenchen@gmail.com', 1),
(33, 456928631837264, 'bankofmuenchen@gmail.com', 1),
(34, 456928631837265, 'bankofmuenchen@gmail.com', 1),
(35, 456928631837266, 'bankofmuenchen@gmail.com', 1),
(36, 456928631837267, 'bankofmuenchen@gmail.com', 1),
(37, 456928631837268, 'bankofmuenchen@gmail.com', 1),
(38, 456928631837269, 'bankofmuenchen@gmail.com', 1),
(39, 456928631837270, 'bankofmuenchen@gmail.com', 1),
(40, 456928631837271, 'bankofmuenchen@gmail.com', 1),
(41, 456928631837272, 'bankofmuenchen@gmail.com', 1),
(42, 456928631837273, 'bankofmuenchen@gmail.com', 1),
(43, 456928631837274, 'bankofmuenchen@gmail.com', 1),
(44, 456928631837275, 'bankofmuenchen@gmail.com', 1),
(45, 456928631837276, 'bankofmuenchen@gmail.com', 1),
(46, 456928631837277, 'bankofmuenchen@gmail.com', 1),
(47, 456928631837278, 'bankofmuenchen@gmail.com', 1),
(48, 456928631837279, 'bankofmuenchen@gmail.com', 1),
(49, 456928631837280, 'bankofmuenchen@gmail.com', 1),
(50, 456928631837281, 'bankofmuenchen@gmail.com', 1),
(51, 456928631837282, 'bankofmuenchen@gmail.com', 1),
(52, 456928631837283, 'bankofmuenchen@gmail.com', 1),
(53, 456928631837284, 'bankofmuenchen@gmail.com', 1),
(54, 456928631837285, 'bankofmuenchen@gmail.com', 1),
(55, 456928631837286, 'bankofmuenchen@gmail.com', 1),
(56, 456928631837287, 'bankofmuenchen@gmail.com', 1),
(57, 456928631837288, 'bankofmuenchen@gmail.com', 1),
(58, 456928631837289, 'bankofmuenchen@gmail.com', 1),
(59, 456928631837290, 'bankofmuenchen@gmail.com', 1),
(60, 456928631837291, 'bankofmuenchen@gmail.com', 1),
(61, 456928631837292, 'bankofmuenchen@gmail.com', 1),
(62, 456928631837293, 'bankofmuenchen@gmail.com', 1),
(63, 456928631837294, 'bankofmuenchen@gmail.com', 1),
(64, 456928631837295, 'bankofmuenchen@gmail.com', 1),
(65, 456928631837296, 'bankofmuenchen@gmail.com', 1),
(66, 456928631837297, 'bankofmuenchen@gmail.com', 1),
(67, 456928631837298, 'bankofmuenchen@gmail.com', 1),
(68, 456928631837299, 'bankofmuenchen@gmail.com', 1),
(69, 456928631837300, 'bankofmuenchen@gmail.com', 1),
(70, 456928631837301, 'bankofmuenchen@gmail.com', 1),
(71, 456928631837302, 'bankofmuenchen@gmail.com', 1),
(72, 456928631837303, 'bankofmuenchen@gmail.com', 1),
(73, 456928631837304, 'bankofmuenchen@gmail.com', 1),
(74, 456928631837305, 'bankofmuenchen@gmail.com', 1),
(75, 456928631837306, 'bankofmuenchen@gmail.com', 1),
(76, 456928631837307, 'bankofmuenchen@gmail.com', 1),
(77, 456928631837308, 'bankofmuenchen@gmail.com', 1),
(78, 456928631837309, 'bankofmuenchen@gmail.com', 1),
(79, 456928631837310, 'bankofmuenchen@gmail.com', 1),
(80, 456928631837311, 'bankofmuenchen@gmail.com', 1),
(81, 456928631837312, 'bankofmuenchen@gmail.com', 1),
(82, 456928631837313, 'bankofmuenchen@gmail.com', 1),
(83, 456928631837314, 'bankofmuenchen@gmail.com', 1),
(84, 456928631837315, 'bankofmuenchen@gmail.com', 1),
(85, 456928631837316, 'bankofmuenchen@gmail.com', 1),
(86, 456928631837317, 'bankofmuenchen@gmail.com', 1),
(87, 456928631837318, 'bankofmuenchen@gmail.com', 1),
(88, 456928631837319, 'bankofmuenchen@gmail.com', 1),
(89, 456928631837320, 'bankofmuenchen@gmail.com', 1),
(90, 456928631837321, 'bankofmuenchen@gmail.com', 1),
(91, 456928631837322, 'bankofmuenchen@gmail.com', 1),
(92, 456928631837323, 'bankofmuenchen@gmail.com', 1),
(93, 456928631837324, 'bankofmuenchen@gmail.com', 1),
(94, 456928631837325, 'bankofmuenchen@gmail.com', 1),
(95, 456928631837326, 'bankofmuenchen@gmail.com', 1),
(96, 456928631837327, 'bankofmuenchen@gmail.com', 1),
(97, 456928631837328, 'bankofmuenchen@gmail.com', 1),
(98, 456928631837329, 'bankofmuenchen@gmail.com', 1),
(99, 456928631837330, 'bankofmuenchen@gmail.com', 1),
(100, 456928631837331, 'bankofmuenchen@gmail.com', 1),
(101, 456928631837332, 'pulakchakraborty.official@gmail.com', 1),
(102, 456928631837333, 'pulakchakraborty.official@gmail.com', 1),
(103, 456928631837334, 'pulakchakraborty.official@gmail.com', 1),
(104, 456928631837335, 'pulakchakraborty.official@gmail.com', 1),
(105, 456928631837336, 'pulakchakraborty.official@gmail.com', 1),
(106, 456928631837337, 'pulakchakraborty.official@gmail.com', 1),
(107, 456928631837338, 'pulakchakraborty.official@gmail.com', 1),
(108, 456928631837339, 'pulakchakraborty.official@gmail.com', 1),
(109, 456928631837340, 'pulakchakraborty.official@gmail.com', 1),
(110, 456928631837341, 'pulakchakraborty.official@gmail.com', 1),
(111, 456928631837342, 'pulakchakraborty.official@gmail.com', 1),
(112, 456928631837343, 'pulakchakraborty.official@gmail.com', 1),
(113, 456928631837344, 'pulakchakraborty.official@gmail.com', 1),
(114, 456928631837345, 'pulakchakraborty.official@gmail.com', 1),
(115, 456928631837346, 'pulakchakraborty.official@gmail.com', 1),
(116, 456928631837347, 'pulakchakraborty.official@gmail.com', 1),
(117, 456928631837348, 'pulakchakraborty.official@gmail.com', 1),
(118, 456928631837349, 'pulakchakraborty.official@gmail.com', 1),
(119, 456928631837350, 'pulakchakraborty.official@gmail.com', 1),
(120, 456928631837351, 'pulakchakraborty.official@gmail.com', 1),
(121, 456928631837352, 'pulakchakraborty.official@gmail.com', 1),
(122, 456928631837353, 'pulakchakraborty.official@gmail.com', 1),
(123, 456928631837354, 'pulakchakraborty.official@gmail.com', 1),
(124, 456928631837355, 'pulakchakraborty.official@gmail.com', 1),
(125, 456928631837356, 'pulakchakraborty.official@gmail.com', 1),
(126, 456928631837357, 'pulakchakraborty.official@gmail.com', 1),
(127, 456928631837358, 'pulakchakraborty.official@gmail.com', 1),
(128, 456928631837359, 'pulakchakraborty.official@gmail.com', 1),
(129, 456928631837360, 'pulakchakraborty.official@gmail.com', 1),
(130, 456928631837361, 'pulakchakraborty.official@gmail.com', 1),
(131, 456928631837362, 'pulakchakraborty.official@gmail.com', 1),
(132, 456928631837363, 'pulakchakraborty.official@gmail.com', 1),
(133, 456928631837364, 'pulakchakraborty.official@gmail.com', 1),
(134, 456928631837365, 'pulakchakraborty.official@gmail.com', 1),
(135, 456928631837366, 'pulakchakraborty.official@gmail.com', 1),
(136, 456928631837367, 'pulakchakraborty.official@gmail.com', 1),
(137, 456928631837368, 'pulakchakraborty.official@gmail.com', 1),
(138, 456928631837369, 'pulakchakraborty.official@gmail.com', 1),
(139, 456928631837370, 'pulakchakraborty.official@gmail.com', 1),
(140, 456928631837371, 'pulakchakraborty.official@gmail.com', 1),
(141, 456928631837372, 'pulakchakraborty.official@gmail.com', 1),
(142, 456928631837373, 'pulakchakraborty.official@gmail.com', 1),
(143, 456928631837374, 'pulakchakraborty.official@gmail.com', 1),
(144, 456928631837375, 'pulakchakraborty.official@gmail.com', 1),
(145, 456928631837376, 'pulakchakraborty.official@gmail.com', 1),
(146, 456928631837377, 'pulakchakraborty.official@gmail.com', 1),
(147, 456928631837378, 'pulakchakraborty.official@gmail.com', 1),
(148, 456928631837379, 'pulakchakraborty.official@gmail.com', 1),
(149, 456928631837380, 'pulakchakraborty.official@gmail.com', 1),
(150, 456928631837381, 'pulakchakraborty.official@gmail.com', 1),
(151, 456928631837382, 'pulakchakraborty.official@gmail.com', 1),
(152, 456928631837383, 'pulakchakraborty.official@gmail.com', 1),
(153, 456928631837384, 'pulakchakraborty.official@gmail.com', 1),
(154, 456928631837385, 'pulakchakraborty.official@gmail.com', 1),
(155, 456928631837386, 'pulakchakraborty.official@gmail.com', 1),
(156, 456928631837387, 'pulakchakraborty.official@gmail.com', 1),
(157, 456928631837388, 'pulakchakraborty.official@gmail.com', 1),
(158, 456928631837389, 'pulakchakraborty.official@gmail.com', 1),
(159, 456928631837390, 'pulakchakraborty.official@gmail.com', 1),
(160, 456928631837391, 'pulakchakraborty.official@gmail.com', 1),
(161, 456928631837392, 'pulakchakraborty.official@gmail.com', 1),
(162, 456928631837393, 'pulakchakraborty.official@gmail.com', 1),
(163, 456928631837394, 'pulakchakraborty.official@gmail.com', 1),
(164, 456928631837395, 'pulakchakraborty.official@gmail.com', 1),
(165, 456928631837396, 'pulakchakraborty.official@gmail.com', 1),
(166, 456928631837397, 'pulakchakraborty.official@gmail.com', 1),
(167, 456928631837398, 'pulakchakraborty.official@gmail.com', 1),
(168, 456928631837399, 'pulakchakraborty.official@gmail.com', 1),
(169, 456928631837400, 'pulakchakraborty.official@gmail.com', 1),
(170, 456928631837401, 'pulakchakraborty.official@gmail.com', 1),
(171, 456928631837402, 'pulakchakraborty.official@gmail.com', 1),
(172, 456928631837403, 'pulakchakraborty.official@gmail.com', 1),
(173, 456928631837404, 'pulakchakraborty.official@gmail.com', 1),
(174, 456928631837405, 'pulakchakraborty.official@gmail.com', 1),
(175, 456928631837406, 'pulakchakraborty.official@gmail.com', 1),
(176, 456928631837407, 'pulakchakraborty.official@gmail.com', 1),
(177, 456928631837408, 'pulakchakraborty.official@gmail.com', 1),
(178, 456928631837409, 'pulakchakraborty.official@gmail.com', 1),
(179, 456928631837410, 'pulakchakraborty.official@gmail.com', 1),
(180, 456928631837411, 'pulakchakraborty.official@gmail.com', 1),
(181, 456928631837412, 'pulakchakraborty.official@gmail.com', 1),
(182, 456928631837413, 'pulakchakraborty.official@gmail.com', 1),
(183, 456928631837414, 'pulakchakraborty.official@gmail.com', 1),
(184, 456928631837415, 'pulakchakraborty.official@gmail.com', 1),
(185, 456928631837416, 'pulakchakraborty.official@gmail.com', 1),
(186, 456928631837417, 'pulakchakraborty.official@gmail.com', 1),
(187, 456928631837418, 'pulakchakraborty.official@gmail.com', 1),
(188, 456928631837419, 'pulakchakraborty.official@gmail.com', 1),
(189, 456928631837420, 'pulakchakraborty.official@gmail.com', 1),
(190, 456928631837421, 'pulakchakraborty.official@gmail.com', 1),
(191, 456928631837422, 'pulakchakraborty.official@gmail.com', 1),
(192, 456928631837423, 'pulakchakraborty.official@gmail.com', 1),
(193, 456928631837424, 'pulakchakraborty.official@gmail.com', 1),
(194, 456928631837425, 'pulakchakraborty.official@gmail.com', 1),
(195, 456928631837426, 'pulakchakraborty.official@gmail.com', 1),
(196, 456928631837427, 'pulakchakraborty.official@gmail.com', 1),
(197, 456928631837428, 'pulakchakraborty.official@gmail.com', 1),
(198, 456928631837429, 'pulakchakraborty.official@gmail.com', 1),
(199, 456928631837430, 'pulakchakraborty.official@gmail.com', 1),
(200, 456928631837431, 'pulakchakraborty.official@gmail.com', 1),
(201, 456928631837432, 'admin@amitinside.com', 1),
(202, 456928631837433, 'admin@amitinside.com', 1),
(203, 456928631837434, 'admin@amitinside.com', 1),
(204, 456928631837435, 'admin@amitinside.com', 1),
(205, 456928631837436, 'admin@amitinside.com', 1),
(206, 456928631837437, 'admin@amitinside.com', 1),
(207, 456928631837438, 'admin@amitinside.com', 1),
(208, 456928631837439, 'admin@amitinside.com', 1),
(209, 456928631837440, 'admin@amitinside.com', 1),
(210, 456928631837441, 'admin@amitinside.com', 1),
(211, 456928631837442, 'admin@amitinside.com', 1),
(212, 456928631837443, 'admin@amitinside.com', 1),
(213, 456928631837444, 'admin@amitinside.com', 1),
(214, 456928631837445, 'admin@amitinside.com', 1),
(215, 456928631837446, 'admin@amitinside.com', 1),
(216, 456928631837447, 'admin@amitinside.com', 1),
(217, 456928631837448, 'admin@amitinside.com', 1),
(218, 456928631837449, 'admin@amitinside.com', 1),
(219, 456928631837450, 'admin@amitinside.com', 1),
(220, 456928631837451, 'admin@amitinside.com', 1),
(221, 456928631837452, 'admin@amitinside.com', 1),
(222, 456928631837453, 'admin@amitinside.com', 1),
(223, 456928631837454, 'admin@amitinside.com', 1),
(224, 456928631837455, 'admin@amitinside.com', 1),
(225, 456928631837456, 'admin@amitinside.com', 1),
(226, 456928631837457, 'admin@amitinside.com', 1),
(227, 456928631837458, 'admin@amitinside.com', 1),
(228, 456928631837459, 'admin@amitinside.com', 1),
(229, 456928631837460, 'admin@amitinside.com', 1),
(230, 456928631837461, 'admin@amitinside.com', 1),
(231, 456928631837462, 'admin@amitinside.com', 1),
(232, 456928631837463, 'admin@amitinside.com', 1),
(233, 456928631837464, 'admin@amitinside.com', 1),
(234, 456928631837465, 'admin@amitinside.com', 1),
(235, 456928631837466, 'admin@amitinside.com', 1),
(236, 456928631837467, 'admin@amitinside.com', 1),
(237, 456928631837468, 'admin@amitinside.com', 1),
(238, 456928631837469, 'admin@amitinside.com', 1),
(239, 456928631837470, 'admin@amitinside.com', 1),
(240, 456928631837471, 'admin@amitinside.com', 1),
(241, 456928631837472, 'admin@amitinside.com', 1),
(242, 456928631837473, 'admin@amitinside.com', 1),
(243, 456928631837474, 'admin@amitinside.com', 1),
(244, 456928631837475, 'admin@amitinside.com', 1),
(245, 456928631837476, 'admin@amitinside.com', 1),
(246, 456928631837477, 'admin@amitinside.com', 1),
(247, 456928631837478, 'admin@amitinside.com', 1),
(248, 456928631837479, 'admin@amitinside.com', 1),
(249, 456928631837480, 'admin@amitinside.com', 1),
(250, 456928631837481, 'admin@amitinside.com', 1),
(251, 456928631837482, 'admin@amitinside.com', 1),
(252, 456928631837483, 'admin@amitinside.com', 1),
(253, 456928631837484, 'admin@amitinside.com', 1),
(254, 456928631837485, 'admin@amitinside.com', 1),
(255, 456928631837486, 'admin@amitinside.com', 1),
(256, 456928631837487, 'admin@amitinside.com', 1),
(257, 456928631837488, 'admin@amitinside.com', 1),
(258, 456928631837489, 'admin@amitinside.com', 1),
(259, 456928631837490, 'admin@amitinside.com', 1),
(260, 456928631837491, 'admin@amitinside.com', 1),
(261, 456928631837492, 'admin@amitinside.com', 1),
(262, 456928631837493, 'admin@amitinside.com', 1),
(263, 456928631837494, 'admin@amitinside.com', 1),
(264, 456928631837495, 'admin@amitinside.com', 1),
(265, 456928631837496, 'admin@amitinside.com', 1),
(266, 456928631837497, 'admin@amitinside.com', 1),
(267, 456928631837498, 'admin@amitinside.com', 1),
(268, 456928631837499, 'admin@amitinside.com', 1),
(269, 456928631837500, 'admin@amitinside.com', 1),
(270, 456928631837501, 'admin@amitinside.com', 1),
(271, 456928631837502, 'admin@amitinside.com', 1),
(272, 456928631837503, 'admin@amitinside.com', 1),
(273, 456928631837504, 'admin@amitinside.com', 1),
(274, 456928631837505, 'admin@amitinside.com', 1),
(275, 456928631837506, 'admin@amitinside.com', 1),
(276, 456928631837507, 'admin@amitinside.com', 1),
(277, 456928631837508, 'admin@amitinside.com', 1),
(278, 456928631837509, 'admin@amitinside.com', 1),
(279, 456928631837510, 'admin@amitinside.com', 1),
(280, 456928631837511, 'admin@amitinside.com', 1),
(281, 456928631837512, 'admin@amitinside.com', 1),
(282, 456928631837513, 'admin@amitinside.com', 1),
(283, 456928631837514, 'admin@amitinside.com', 1),
(284, 456928631837515, 'admin@amitinside.com', 1),
(285, 456928631837516, 'admin@amitinside.com', 1),
(286, 456928631837517, 'admin@amitinside.com', 1),
(287, 456928631837518, 'admin@amitinside.com', 1),
(288, 456928631837519, 'admin@amitinside.com', 1),
(289, 456928631837520, 'admin@amitinside.com', 1),
(290, 456928631837521, 'admin@amitinside.com', 1),
(291, 456928631837522, 'admin@amitinside.com', 1),
(292, 456928631837523, 'admin@amitinside.com', 1),
(293, 456928631837524, 'admin@amitinside.com', 1),
(294, 456928631837525, 'admin@amitinside.com', 1),
(295, 456928631837526, 'admin@amitinside.com', 1),
(296, 456928631837527, 'admin@amitinside.com', 1),
(297, 456928631837528, 'admin@amitinside.com', 1),
(298, 456928631837529, 'admin@amitinside.com', 1),
(299, 456928631837530, 'admin@amitinside.com', 1),
(300, 456928631837531, 'admin@amitinside.com', 1),
(301, 985249781049788, 'amit_talkin@rocketmail.com', 1),
(302, 940530337393283, 'amit_talkin@rocketmail.com', 1),
(303, 106552304700016, 'amit_talkin@rocketmail.com', 1),
(304, 253455792088061, 'amit_talkin@rocketmail.com', 1),
(305, 142316785175353, 'amit_talkin@rocketmail.com', 1),
(306, 291853994131088, 'amit_talkin@rocketmail.com', 1),
(307, 566459819674491, 'amit_talkin@rocketmail.com', 1),
(308, 172941772267222, 'amit_talkin@rocketmail.com', 1),
(309, 30630327295511, 'amit_talkin@rocketmail.com', 1),
(310, 574730811640620, 'amit_talkin@rocketmail.com', 1),
(311, 803192537743598, 'amit_talkin@rocketmail.com', 1),
(312, 502550045028328, 'amit_talkin@rocketmail.com', 1),
(313, 14198031276464, 'amit_talkin@rocketmail.com', 1),
(314, 777748292312026, 'amit_talkin@rocketmail.com', 1),
(315, 502549312077462, 'amit_talkin@rocketmail.com', 1),
(316, 18664686474949, 'amit_talkin@rocketmail.com', 1),
(317, 393078700639307, 'amit_talkin@rocketmail.com', 1),
(318, 839208391495049, 'amit_talkin@rocketmail.com', 1),
(319, 910020367708057, 'amit_talkin@rocketmail.com', 1),
(320, 523331197910010, 'amit_talkin@rocketmail.com', 1),
(321, 436401973944157, 'amit_talkin@rocketmail.com', 1),
(322, 215721246320754, 'amit_talkin@rocketmail.com', 1),
(323, 631759214680641, 'amit_talkin@rocketmail.com', 1),
(324, 754510501865297, 'amit_talkin@rocketmail.com', 1),
(325, 455004374030977, 'amit_talkin@rocketmail.com', 1),
(326, 267766640521585, 'amit_talkin@rocketmail.com', 1),
(327, 727458214852958, 'amit_talkin@rocketmail.com', 1),
(328, 145773977506905, 'amit_talkin@rocketmail.com', 1),
(329, 916946647688746, 'amit_talkin@rocketmail.com', 1),
(330, 983174987137317, 'amit_talkin@rocketmail.com', 1),
(331, 255560677498579, 'amit_talkin@rocketmail.com', 1),
(332, 902196428738534, 'amit_talkin@rocketmail.com', 1),
(333, 923705324996262, 'amit_talkin@rocketmail.com', 1),
(334, 362112982664257, 'amit_talkin@rocketmail.com', 1),
(335, 155652220826596, 'amit_talkin@rocketmail.com', 1),
(336, 66022110171616, 'amit_talkin@rocketmail.com', 1),
(337, 653966976795345, 'amit_talkin@rocketmail.com', 1),
(338, 722112040501087, 'amit_talkin@rocketmail.com', 1),
(339, 238963882438838, 'amit_talkin@rocketmail.com', 1),
(340, 684597304090857, 'amit_talkin@rocketmail.com', 1),
(341, 296842852607369, 'amit_talkin@rocketmail.com', 1),
(342, 42156420182436, 'amit_talkin@rocketmail.com', 1),
(343, 187147349119186, 'amit_talkin@rocketmail.com', 1),
(344, 311040883883833, 'amit_talkin@rocketmail.com', 1),
(345, 819904712960124, 'amit_talkin@rocketmail.com', 1),
(346, 689696661196649, 'amit_talkin@rocketmail.com', 1),
(347, 329705570358783, 'amit_talkin@rocketmail.com', 1),
(348, 212983413599431, 'amit_talkin@rocketmail.com', 1),
(349, 528905052691698, 'amit_talkin@rocketmail.com', 1),
(350, 239725938066840, 'amit_talkin@rocketmail.com', 1),
(351, 736314611509442, 'amit_talkin@rocketmail.com', 1),
(352, 965307026635855, 'amit_talkin@rocketmail.com', 1),
(353, 455447184387594, 'amit_talkin@rocketmail.com', 1),
(354, 368073826190084, 'amit_talkin@rocketmail.com', 1),
(355, 719817528966814, 'amit_talkin@rocketmail.com', 1),
(356, 910451558418572, 'amit_talkin@rocketmail.com', 1),
(357, 635840466711670, 'amit_talkin@rocketmail.com', 1),
(358, 447275743819773, 'amit_talkin@rocketmail.com', 1),
(359, 56225535925477, 'amit_talkin@rocketmail.com', 1),
(360, 552787114400416, 'amit_talkin@rocketmail.com', 1),
(361, 430450731422752, 'amit_talkin@rocketmail.com', 1),
(362, 311786213889718, 'amit_talkin@rocketmail.com', 1),
(363, 454983543138951, 'amit_talkin@rocketmail.com', 1),
(364, 354156056419014, 'amit_talkin@rocketmail.com', 1),
(365, 673899196553975, 'amit_talkin@rocketmail.com', 1),
(366, 610635764431208, 'amit_talkin@rocketmail.com', 1),
(367, 420178166590631, 'amit_talkin@rocketmail.com', 1),
(368, 327866173349320, 'amit_talkin@rocketmail.com', 1),
(369, 332747804932296, 'amit_talkin@rocketmail.com', 1),
(370, 659142049495130, 'amit_talkin@rocketmail.com', 1),
(371, 12463477440178, 'amit_talkin@rocketmail.com', 1),
(372, 629590657539665, 'amit_talkin@rocketmail.com', 1),
(373, 701298469677567, 'amit_talkin@rocketmail.com', 1),
(374, 199610826559364, 'amit_talkin@rocketmail.com', 1),
(375, 940631541423499, 'amit_talkin@rocketmail.com', 1),
(376, 521203182637691, 'amit_talkin@rocketmail.com', 1),
(377, 889307487756013, 'amit_talkin@rocketmail.com', 1),
(378, 270337111782282, 'amit_talkin@rocketmail.com', 1),
(379, 734186596237123, 'amit_talkin@rocketmail.com', 1),
(380, 418212540447711, 'amit_talkin@rocketmail.com', 1),
(381, 510063049849122, 'amit_talkin@rocketmail.com', 1),
(382, 470501207746565, 'amit_talkin@rocketmail.com', 1),
(383, 383519567083567, 'amit_talkin@rocketmail.com', 1),
(384, 965510234702378, 'amit_talkin@rocketmail.com', 1),
(385, 838575033936649, 'amit_talkin@rocketmail.com', 1),
(386, 103337096050381, 'amit_talkin@rocketmail.com', 1),
(387, 875961793120950, 'amit_talkin@rocketmail.com', 1),
(388, 474415501113981, 'amit_talkin@rocketmail.com', 1),
(389, 550612840335816, 'amit_talkin@rocketmail.com', 1),
(390, 932187329512089, 'amit_talkin@rocketmail.com', 1),
(391, 27202615514397, 'amit_talkin@rocketmail.com', 1),
(392, 981063571758568, 'amit_talkin@rocketmail.com', 1),
(393, 243973543401807, 'amit_talkin@rocketmail.com', 1),
(394, 482186159119010, 'amit_talkin@rocketmail.com', 1),
(395, 335219628177583, 'amit_talkin@rocketmail.com', 1),
(396, 917872739955782, 'amit_talkin@rocketmail.com', 1),
(397, 92821923550218, 'amit_talkin@rocketmail.com', 1),
(398, 755397794768214, 'amit_talkin@rocketmail.com', 1),
(399, 245738913305103, 'amit_talkin@rocketmail.com', 1),
(400, 425569728482514, 'amit_talkin@rocketmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `TRANSACTIONS`
--

CREATE TABLE IF NOT EXISTS `TRANSACTIONS` (
`id` int(20) NOT NULL,
  `date` datetime NOT NULL,
  `iban` text NOT NULL,
  `bic` text NOT NULL,
  `amount` text NOT NULL,
  `closingBalance` text NOT NULL,
  `userId` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `TRANSACTIONS`
--

INSERT INTO `TRANSACTIONS` (`id`, `date`, `iban`, `bic`, `amount`, `closingBalance`, `userId`, `type`, `isActive`) VALUES
(1, '2014-11-14 18:35:34', '12345678901234', '123456', '1234', '100000', 'bankofmuenchen@gmail.com', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
`id` int(10) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `createdDate` datetime NOT NULL,
  `mobileNo` bigint(11) NOT NULL,
  `firstName` text NOT NULL,
  `middleName` text,
  `lastName` text NOT NULL,
  `emailId` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`id`, `isAdmin`, `isActive`, `createdDate`, `mobileNo`, `firstName`, `middleName`, `lastName`, `emailId`) VALUES
(1, 1, 1, '2014-10-27 19:38:19', 12345678901, 'Admin', '', 'User', 'bankofmuenchen@gmail.com'),
(2, 1, 1, '2014-11-14 18:25:09', 12345678912, 'pulak', '', 'chakraborty', 'pulakchakraborty.official@gmail.com'),
(3, 1, 1, '2014-11-16 19:34:14', 17680815427, 'Amit', 'Kumar', 'Mondal', 'admin@amitinside.com'),
(5, 0, 1, '2014-11-19 02:05:58', 17680815427, 'Anit', 'Kumar', 'Mondal', 'amit_talkin@rocketmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ACCOUNTS`
--
ALTER TABLE `ACCOUNTS`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ADDRESSES`
--
ALTER TABLE `ADDRESSES`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TANS`
--
ALTER TABLE `TANS`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `TRANSACTIONS`
--
ALTER TABLE `TRANSACTIONS`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ACCOUNTS`
--
ALTER TABLE `ACCOUNTS`
MODIFY `id` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ADDRESSES`
--
ALTER TABLE `ADDRESSES`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `TANS`
--
ALTER TABLE `TANS`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=401;
--
-- AUTO_INCREMENT for table `TRANSACTIONS`
--
ALTER TABLE `TRANSACTIONS`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
