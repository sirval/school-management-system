-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2021 at 10:09 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_afternoon`
--

CREATE TABLE `attendance_afternoon` (
  `id` int(4) NOT NULL,
  `mId` int(10) NOT NULL,
  `year` varchar(5) NOT NULL,
  `date` varchar(20) NOT NULL,
  `term` int(4) NOT NULL,
  `present` int(4) NOT NULL,
  `time` varchar(20) NOT NULL,
  `morningId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_afternoon`
--

INSERT INTO `attendance_afternoon` (`id`, `mId`, `year`, `date`, `term`, `present`, `time`, `morningId`) VALUES
(24, 40, '2021', '29-4-2021', 1, 1, '26-04-2021 12:26 PM', 150),
(25, 41, '2021', '29-4-2021', 1, 1, '26-04-2021 12:26 PM', 151),
(26, 40, '2021', '1-1-2021', 1, 0, '27-04-2021 08:32 AM', 152),
(27, 41, '2021', '1-1-2021', 1, 1, '27-04-2021 08:32 AM', 153);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_morning`
--

CREATE TABLE `attendance_morning` (
  `id` int(4) NOT NULL,
  `studentId` int(4) NOT NULL,
  `year` varchar(5) NOT NULL,
  `date` varchar(20) NOT NULL,
  `term` int(4) NOT NULL,
  `present` int(4) NOT NULL,
  `time` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_morning`
--

INSERT INTO `attendance_morning` (`id`, `studentId`, `year`, `date`, `term`, `present`, `time`, `phone`) VALUES
(225, 40, '2021', '1-1-2021', 1, 1, '10:03 AM', '08082646718'),
(226, 41, '2021', '1-1-2021', 1, 1, '10:03 AM', '0'),
(231, 40, '2021', '22-6-2021', 1, 1, '10:58 AM', '08082646718'),
(232, 41, '2021', '22-6-2021', 1, 0, '10:58 AM', '08104990228');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(4) NOT NULL,
  `classCode` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `classCode`, `name`) VALUES
(1, 'NUR 1', 'NURSERY ONE'),
(2, 'NUR 2', 'NURSERY TWO'),
(3, 'NUR 3', 'NURSERY THREE'),
(4, 'PRI 1', 'PRIMARY ONE'),
(5, 'PRI 2', 'PRIMARY TWO'),
(6, 'PRI 3', 'PRIMARY THREE'),
(7, 'PRI 4', 'PRIMARY FOUR'),
(8, 'PRI 5', 'PRIMARY FIVE'),
(9, 'PRI 6', 'PRIMARY SIX'),
(10, 'JSS 1', 'JUNIOR SECONDARY SCHOOL ONE'),
(11, 'JSS 2', 'JUNIOR SECONDARY SCHOOL TWO'),
(12, 'JSS 3', 'JUNIOR SECONDARY SCHOOL THREE'),
(13, 'SS 1', 'SENIOR SECONDARY SCHOOL ONE'),
(14, 'SS 2', 'SENIOR SECONDARY SCHOOL TWO'),
(15, 'SS 3', 'SENIOR SECONDARY SCHOOL THREE');

-- --------------------------------------------------------

--
-- Table structure for table `elapse_time`
--

CREATE TABLE `elapse_time` (
  `id` int(4) NOT NULL,
  `startDate` varchar(12) NOT NULL,
  `endDate` varchar(12) NOT NULL,
  `schoolId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `elapse_time`
--

INSERT INTO `elapse_time` (`id`, `startDate`, `endDate`, `schoolId`) VALUES
(6, '01-02-2021', '01-01-2023', 13),
(7, '28-04-2021', '01-01-2023', 6563);

-- --------------------------------------------------------

--
-- Table structure for table `examyear`
--

CREATE TABLE `examyear` (
  `id` int(11) NOT NULL,
  `year` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `examyear`
--

INSERT INTO `examyear` (`id`, `year`) VALUES
(1, '2020'),
(2, '2021');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(4) NOT NULL,
  `date` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `termId` int(4) NOT NULL,
  `product` varchar(100) NOT NULL,
  `qty` int(6) NOT NULL,
  `price` varchar(10) NOT NULL,
  `totalCost` varchar(10) NOT NULL,
  `authBy` varchar(50) NOT NULL,
  `purBy` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `date`, `time`, `termId`, `product`, `qty`, `price`, `totalCost`, `authBy`, `purBy`) VALUES
(11, '10-05-2021 Mon', '11:09:40 pm', 1, 'Exercise book ', 61, '200', '12200', 'John doe', 'Chika chukwu');

-- --------------------------------------------------------

--
-- Table structure for table `expenses_backup`
--

CREATE TABLE `expenses_backup` (
  `id` int(4) NOT NULL,
  `date` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `termId` int(4) NOT NULL,
  `product` varchar(100) NOT NULL,
  `qty` int(6) NOT NULL,
  `price` varchar(10) NOT NULL,
  `totalCost` varchar(10) NOT NULL,
  `authBy` varchar(50) NOT NULL,
  `purBy` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses_backup`
--

INSERT INTO `expenses_backup` (`id`, `date`, `time`, `termId`, `product`, `qty`, `price`, `totalCost`, `authBy`, `purBy`) VALUES
(11, '10-05-2021 Mon', '11:09:40 pm', 1, 'Exercise book ', 61, '200', '12200', 'John doe', 'Chika chukwu');

-- --------------------------------------------------------

--
-- Table structure for table `mnbvcxz`
--

CREATE TABLE `mnbvcxz` (
  `id` int(4) NOT NULL,
  `enrate` varchar(12) NOT NULL,
  `adminId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(4) NOT NULL,
  `activated` int(2) NOT NULL,
  `studentId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(4) NOT NULL,
  `parentFname` varchar(30) NOT NULL,
  `parentOthers` varchar(60) NOT NULL,
  `parentOccup` varchar(60) NOT NULL,
  `parentReligion` varchar(50) NOT NULL,
  `numChild` int(4) NOT NULL DEFAULT 1,
  `relationship` varchar(20) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `altPhone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `appActivation` int(4) NOT NULL,
  `term` int(5) DEFAULT 0,
  `regNum` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `parentFname`, `parentOthers`, `parentOccup`, `parentReligion`, `numChild`, `relationship`, `phone`, `altPhone`, `email`, `appActivation`, `term`, `regNum`) VALUES
(35, 'CHUKWUMA', 'JOHN DOE', 'teacher', 'christianity', 3, 'Parent', '08104990228', '08104990228', 'ohukaiv@gmail.com', 1, 0, '39'),
(36, 'JOHNSON', 'CHIDI', 'Plumber', 'christianity', 2, 'Parent', '08082646718', '08104997896', 'ohukaiv@gmail.com', 1, 1, '40'),
(37, 'OBAJI', 'KANU', 'Farmer', 'christianity', 1, 'Relative', '08104990228', '08104990447', 'ohukaiv@gmail.com', 1, 1, '41'),
(38, 'CHUKWUMA', 'OKORIE', 'teacher', 'christianity', 2, 'Guidian', '08104990099', '08104990890', 'ohukaiv@gmail.com', 1, 0, '42'),
(39, 'AWODELE', 'AYO', 'teacher', 'christianity', 1, 'Parent', '09083945786', '07038939493', 'awodele@gmail.com', 1, 1, '50'),
(40, 'INIOLUWA', 'OGUNRIDE', 'Civil Servant', 'christianity', 1, 'Parent', '09134567890', '09145467897', 'inioluwa@gmail.com', 1, 1, '57'),
(41, 'JOHN', 'OKIYI', 'Politician', 'christianity', 2, 'Parent', '08034699783', '08104990228', 'ohukaio@gmail.com', 1, 1, '56'),
(42, 'AWODELE', 'JAMES', 'teacher', 'christianity', 1, 'Parent', '09876543213', '', 'ohukauv@gmail.com', 1, 1, '55'),
(43, 'OKORIE', 'KALU', 'lawyer', 'christianity', 1, 'Guidian', '08104990245', '08104995789', 'ohukaiv@gmail.com', 1, 1, '53'),
(44, 'JOHNSON', 'OKORO', 'Civil Servant', 'christianity', 1, 'Guidian', '08082646118', '8976666788', 'ohukaiv@gmail.com', 0, 1, '54'),
(45, 'AKOMOLOFE', 'AYO', 'teacher', 'christianity', 3, 'Parent', '08104990289', '', 'ohukaiv@gmail.com', 1, 1, '58'),
(46, 'SAM', 'DOE', 'teacher', 'christianity', 1, 'Parent', '09038383939', '', 'samdoe@gmail.com', 1, 1, '59'),
(47, 'JOHN', 'KALU', 'lawyer', 'christianity', 1, 'Guidian', '08038392838', '', 'johnkalu@gmail.com', 1, 1, '60');

-- --------------------------------------------------------

--
-- Table structure for table `parent_user`
--

CREATE TABLE `parent_user` (
  `id` int(4) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `stud_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pin`
--

CREATE TABLE `pin` (
  `id` int(6) NOT NULL,
  `pin` varchar(15) NOT NULL,
  `validity` tinyint(2) NOT NULL DEFAULT 0,
  `genDate` varchar(25) NOT NULL,
  `studentId` varchar(40) DEFAULT NULL,
  `sch` int(5) DEFAULT NULL,
  `dtime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pin`
--

INSERT INTO `pin` (`id`, `pin`, `validity`, `genDate`, `studentId`, `sch`, `dtime`) VALUES
(82, '56728977665', 1, '25-04-2121 09:39:43 PM', '40', 13, '2021-05-01 03:46:15'),
(83, '90373643027', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(84, '70732110421', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(85, '72979425174', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(86, '36005115563', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(87, '16964517384', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(88, '66703757022', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(89, '94954968245', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(90, '72304371222', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(91, '15785058010', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(92, '15797889321', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(93, '56698787962', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(94, '54501517666', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(95, '6603888877', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(96, '8876835212', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(97, '81864491480', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(98, '57534667249', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(99, '37266099726', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(100, '43606471545', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06'),
(101, '64885272496', 0, '25-04-2121 09:39:43 PM', NULL, 0, '2021-04-25 11:40:06');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(4) NOT NULL,
  `roleName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `roleName`) VALUES
(1, 'Owner'),
(2, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(8) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL,
  `motto` varchar(500) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `code` varchar(10) NOT NULL,
  `logo` text NOT NULL,
  `schPhone` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `motto`, `address`, `code`, `logo`, `schPhone`) VALUES
(13, 'OUTSMART INTERNATIONAL SCHOOL', 'Education for Technological Freedom', '64 Ikot Ekpene Road Ogbor Hill, Aba Abia State', 'MHIS', 'schools_MHIS_602b4316618b8_LOGO.png', '08082646718'),
(4057, 'OHUKA IKENNA VALENTINE', 'Education for Technological Freedom', '50/54 Ikot Ekpene Road Ogbor Hill, Aba Abia State', 'OSIS', 'schools_OSIS_608c256a0a18f_LOGO.jpg', '08082646718');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(4) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `othernames` varchar(60) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `address` varchar(250) NOT NULL,
  `ailment` varchar(4) NOT NULL,
  `ailmentDes` varchar(2000) NOT NULL,
  `admDate` varchar(20) NOT NULL,
  `admTime` varchar(20) NOT NULL,
  `class` varchar(4) NOT NULL,
  `school` int(8) NOT NULL,
  `studPics` text NOT NULL,
  `regNum` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `surname`, `othernames`, `dob`, `gender`, `address`, `ailment`, `ailmentDes`, `admDate`, `admTime`, `class`, `school`, `studPics`, `regNum`) VALUES
(39, 'ANAGOR', 'DIVINE', '01-01-2000', 'Male', '50/54 Ikot Ekpene Road Ogbor Hill, Aba Abia State', 'No', '', '20-02-2021 Sat', '01:41:17 am', '3', 13, 'SMARTSCHOOL_ANAGOR_DIVINE_d41d8cd98f_20-02-2021.jpg', '001/NUR3/2021'),
(40, 'CHIDI', 'BRIGHT', '01-02-2005', 'Male', '50/54 Ikot Ekpene Road Ogbor Hill, Aba Abia State', 'No', '', '20-02-2021 Sat', '02:38:37 pm', '1', 13, 'SMARTSCHOOL_CHIDI_BRIGHT_d41d8cd98f_20-02-2021.jpg', '002/NUR1/2021'),
(41, 'SAMUEL', 'CHIAMAKA N ', '01-01-2009', 'Female', 'kilometer 5 ikot ekpene road aba off ukpakiri market, obingwa', 'No', '', '20-02-2021 Sat', '02:51:35 pm', '1', 13, 'SMARTSCHOOL_SAMUEL_CHIAMAKA N _60846dd6584f8_24-04-2021.jpg', '003/NUR1/2021'),
(42, 'ANAGOR', 'BRIGHT', '01-02-2008', 'Male', 'agbama housing estate', 'No', '', '20-02-2021 Sat', '02:56:15 pm', '10', 13, 'SMARTSCHOOL_ANAGOR_BRIGHT_6031154b9e_20-02-2021.jpg', '001/JSS1/2021'),
(50, 'OKORO', 'JOHNSON', '23-04-2021', 'Male', 'Iyin road', 'No', '', '24-04-2021 Sat', '3:00 PM', '3', 13, 'SMARTSCHOOL_OKORO_JOHNSON_60847c6a0e569_24-04-2021.jpg', '007/2021/Nur3'),
(53, 'SAMUEL', 'JANE', '31-01-2002', 'Female', 'Awele', 'No', '', '23-4-2021 Sat', '1:11 PM', '3', 13, 'SMARTSCHOOL_SAMUEL_JANE_6090a70be1440_04-05-2021.jpg', '008/Nur3/2021'),
(54, 'JOHN', 'DOE', '29-02-2007', 'Male', 'Ayodele', 'Yes', 'Malaria', '23-4-2021 Sat', '2:11 PM', '2', 13, 'SMARTSCHOOL_JOHN_DOE_6090a85c9ec8d_04-05-2021.jpg', '008/Nur2/2021'),
(55, 'SAMUEL', 'JANE', '31-01-2002', 'Female', 'Awele', 'No', '', '23-4-2021 Sat', '1:11 PM', '3', 13, 'SMARTSCHOOL_SAMUEL_JANE_6090a63a3e736_04-05-2021.jpg', '009/Nur3/2021'),
(56, 'JOHN', 'DOE', '29-02-2007', 'Male', 'Ayodele', 'No', '', '23-4-2021 Sat', '2:11 PM', '2', 13, 'SMARTSCHOOL_JOHN_DOE_6090a3471d9c7_04-05-2021.jpg', '009/Nur2/2021'),
(57, 'ONIPEDE', 'INIOLUWA', '01-01-2000', 'Male', 'Ile Aanu Qtrs', 'No', '', '01-05-2021 Sat', '01:11:08 pm', '10', 13, 'SMARTSCHOOL_ONIPEDE_INIOLUWA_608d37d54bc7f_01-05-2021.jpg', '2021/JSS1/01'),
(58, 'AKOMOLEFE', 'PROSPER', '5-4-2015', 'Female', 'Georgies', 'No', '', '14-05-2021 Fri', '01:18:49 am', '5', 13, 'SMARTSCHOOL_AKOMOLEFE_PROSPER_609dc69aa34c7_14-05-2021.jpg', '2021/09/2345/PRI2'),
(59, 'SAM', 'OJA', '18-6-2000', 'Male', 'agbama housing estate', 'No', '', '18-06-2021 Fri', '05:53:21 pm', '1', 13, 'SMARTSCHOOL_SAM_OJA_60ccc1ee49e9c_18-06-2021.jpg', '004/NUR1/2021'),
(60, 'JOHN', 'JANE', '16-12-2003', 'Female', ' aba ', 'Yes', 'Sickle Cell', '18-06-2021 Fri', '06:00:32 pm', '1', 13, 'SMARTSCHOOL_JOHN_JANE_60ccc3733e38f_18-06-2021.jpg', '005/NUR1/2021');

-- --------------------------------------------------------

--
-- Table structure for table `student_fees`
--

CREATE TABLE `student_fees` (
  `id` int(5) NOT NULL,
  `amountPaid` varchar(10) NOT NULL,
  `currentPayment` int(10) NOT NULL,
  `balance` varchar(10) NOT NULL,
  `paymentMode` varchar(50) NOT NULL,
  `pop` text NOT NULL,
  `datePaid` varchar(20) NOT NULL,
  `payTerm` varchar(20) NOT NULL,
  `studentId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_fees`
--

INSERT INTO `student_fees` (`id`, `amountPaid`, `currentPayment`, `balance`, `paymentMode`, `pop`, `datePaid`, `payTerm`, `studentId`) VALUES
(14, '20000', 20000, '10000', '', '', '29-04-2021 05:25:24', '1st Term', 50),
(15, '30000', 0, '0', 'Cash', '', '02-05-2021 05:03:13', '1st Term', 40);

-- --------------------------------------------------------

--
-- Table structure for table `student_fees_backup`
--

CREATE TABLE `student_fees_backup` (
  `id` int(5) NOT NULL,
  `amountPaid` varchar(10) NOT NULL,
  `balance` varchar(10) NOT NULL,
  `paymentMode` varchar(50) NOT NULL,
  `pop` text NOT NULL,
  `datePaid` varchar(20) NOT NULL,
  `payTerm` varchar(20) NOT NULL,
  `studentId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_fees_backup`
--

INSERT INTO `student_fees_backup` (`id`, `amountPaid`, `balance`, `paymentMode`, `pop`, `datePaid`, `payTerm`, `studentId`) VALUES
(25, '20000', '10000', '', '', '29-04-2021 05:25:24', '1st Term', 50),
(26, '15000', '15000', 'Cash', '', '02-05-2021 04:55:11', '1st Term', 40);

-- --------------------------------------------------------

--
-- Table structure for table `student_ranking`
--

CREATE TABLE `student_ranking` (
  `id` int(4) NOT NULL,
  `examYear` int(6) NOT NULL,
  `examTerm` int(4) NOT NULL,
  `studentId` int(4) NOT NULL,
  `gTotal` int(10) NOT NULL,
  `totsubject` int(4) NOT NULL,
  `average` double NOT NULL,
  `position` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_result`
--

CREATE TABLE `student_result` (
  `resId` int(5) NOT NULL,
  `examYear` varchar(5) NOT NULL,
  `examTerm` varchar(10) NOT NULL,
  `studentId` int(6) NOT NULL,
  `classId` int(4) NOT NULL,
  `subjectId` int(4) NOT NULL,
  `cat` int(4) NOT NULL,
  `exam` int(4) NOT NULL,
  `total` int(5) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `remark` varchar(30) NOT NULL,
  `position` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_result`
--

INSERT INTO `student_result` (`resId`, `examYear`, `examTerm`, `studentId`, `classId`, `subjectId`, `cat`, `exam`, `total`, `grade`, `remark`, `position`) VALUES
(155, '2021', '1', 40, 1, 1, 30, 59, 89, 'A1', 'Excellent', '0'),
(156, '2021', '1', 41, 1, 1, 40, 58, 98, 'A1', 'Excellent', ''),
(157, '2021', '1', 59, 1, 1, 21, 39, 60, 'C4', 'Credit', ''),
(158, '2021', '1', 60, 1, 1, 18, 33, 51, 'C6', 'Credit', '');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(4) NOT NULL,
  `subjectname` varchar(100) NOT NULL,
  `classId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subjectname`, `classId`) VALUES
(1, 'English Language', 1),
(2, 'Mathematics', 1),
(3, 'Social Studies', 1),
(4, 'Science activities', 1),
(5, 'C.R.K', 1),
(6, 'Health habit/Health Education', 1),
(7, 'Music & Rhymes', 1),
(8, 'Handwriting', 1),
(9, 'Creative Art', 1),
(10, 'Phonics', 1),
(11, 'Rhymes', 1),
(12, 'Nigerian Language', 1),
(13, 'English Language', 2),
(14, 'Mathematics', 2),
(15, 'Social Studies', 2),
(16, 'Science activities', 2),
(17, 'C.R.K', 2),
(18, 'Health habit/Health Education', 2),
(19, 'Music & Rhymes', 2),
(20, 'Handwriting', 2),
(21, 'Creative Art', 2),
(22, 'Phonics', 2),
(23, 'Rhymes', 2),
(24, 'Nigerian Language', 2),
(25, 'English Language', 3),
(26, 'Mathemathics', 3),
(27, 'Social Studies', 3),
(28, 'Science activities', 3),
(29, 'C.R.K', 3),
(30, 'Health habit/Health Education', 3),
(31, 'Music & Rhymes', 3),
(32, 'Handwriting', 3),
(33, 'Creative Art', 3),
(34, 'Phonics', 3),
(35, 'Rhymes', 3),
(36, 'Nigerian Language', 3),
(37, 'Basic Science and Technology', 4),
(38, 'Civic Education', 4),
(39, 'Computer Studies', 4),
(40, 'Cultural and Creative Art', 4),
(41, 'English Studies', 4),
(42, 'Mathematics', 4),
(43, 'Physical and Health Education', 4),
(44, 'Social Studies', 4),
(45, 'Nigerian Language', 4),
(46, 'Christian Religious knowledge', 4),
(47, 'Agricultural Science', 4),
(48, 'Home-Economics', 4),
(49, 'Quantitative', 4),
(50, 'Verbal', 4),
(51, 'Writing', 4),
(52, 'French', 4),
(53, 'Music', 4),
(54, 'Literature', 4),
(55, 'Basic Science and Technology', 5),
(56, 'Civic Education', 5),
(57, 'Computer Studies', 5),
(58, 'Cultural and Creative Art', 5),
(59, 'English Studies', 5),
(60, 'Mathematics', 5),
(61, 'Physical and Health Education', 5),
(62, 'Social Studies', 5),
(63, 'Nigerian Language', 5),
(64, 'Christian Religious knowledge', 5),
(65, 'Agricultural Science', 5),
(66, 'Home-Economics', 5),
(67, 'Quantitative', 5),
(68, 'Verbal', 5),
(69, 'Writing', 5),
(70, 'French', 5),
(71, 'Music', 5),
(72, 'Literature', 5),
(73, 'Basic Science and Technology', 6),
(74, 'Civic Education', 6),
(75, 'Computer Studies', 6),
(76, 'Cultural and Creative Art', 6),
(77, 'English Studies', 6),
(78, 'Mathematics', 6),
(79, 'Physical and Health Education', 6),
(80, 'Social Studies', 6),
(81, 'Nigerian Language', 6),
(82, 'Christian Religious knowledge', 6),
(83, 'Agricultural Science', 6),
(84, 'Home-Economics', 6),
(85, 'Quantitative', 6),
(86, 'Verbal', 6),
(87, 'Writing', 6),
(88, 'French', 6),
(89, 'Music', 6),
(90, 'Literature', 6),
(91, 'Basic Science and Technology', 7),
(92, 'Civic Education', 7),
(93, 'Computer Studies', 7),
(94, 'Cultural and Creative Art', 7),
(95, 'English Studies', 7),
(96, 'Mathematics', 7),
(97, 'Physical and Health Education', 7),
(98, 'Social Studies', 7),
(99, 'Nigerian Language', 7),
(100, 'Christian Religious knowledge', 7),
(101, 'Agricultural Science', 7),
(102, 'Home-Economics', 7),
(103, 'Quantitative', 7),
(104, 'Verbal', 7),
(105, 'Writing', 7),
(106, 'French', 7),
(107, 'Music', 7),
(108, 'Literature', 7),
(109, 'Basic Science and Technology', 8),
(110, 'Civic Education', 8),
(111, 'Computer Studies', 8),
(112, 'Cultural and Creative Art', 8),
(113, 'English Studies', 8),
(114, 'Mathematics', 8),
(115, 'Physical and Health Education', 8),
(116, 'Social Studies', 8),
(117, 'Nigerian Language', 8),
(118, 'Christian Religious knowledge', 8),
(119, 'Agricultural Science', 8),
(120, 'Home-Economics', 8),
(121, 'Quantitative', 8),
(122, 'Verbal', 8),
(123, 'Writing', 8),
(124, 'French', 8),
(125, 'Music', 8),
(126, 'Literature', 8),
(127, 'Basic Science and Technology', 9),
(128, 'Civic Education', 9),
(129, 'Computer Studies', 9),
(130, 'Cultural and Creative Art', 9),
(131, 'English Studies', 9),
(132, 'Mathematics', 9),
(133, 'Physical and Health Education', 9),
(134, 'Social Studies', 9),
(135, 'Nigerian Language', 9),
(136, 'Christian Religious knowledge', 9),
(137, 'Agricultural Science', 9),
(138, 'Home-Economics', 9),
(139, 'Quantitative', 9),
(140, 'Verbal', 9),
(141, 'French', 9),
(142, 'Music', 9),
(143, 'Literature', 9),
(144, 'Mathematics', 10),
(145, 'English Language', 10),
(146, 'Nigerian Language', 10),
(147, 'Basic Science', 10),
(148, 'Social Studies', 10),
(149, 'Fine Arts/Creative Art', 10),
(150, 'Agricultural Science', 10),
(151, 'Civic Education', 10),
(152, 'Christian Religious Studies', 10),
(153, 'Physical and Health Education', 10),
(154, 'Business Studies', 10),
(155, 'French', 10),
(156, 'Computer Studies', 10),
(157, 'Home Economics', 10),
(158, 'Music', 10),
(159, 'Basic Technology', 10),
(160, 'Mathematics', 11),
(161, 'English Language', 11),
(162, 'Nigerian Language', 11),
(163, 'Basic Science', 11),
(164, 'Social Studies', 11),
(165, 'Fine Arts/Creative Art', 11),
(166, 'Agricultural Science', 11),
(167, 'Civic Education', 11),
(168, 'Christian Religious Studies', 11),
(169, 'Physical and Health Education', 11),
(170, 'Business Studies', 11),
(171, 'French', 11),
(172, 'Computer Studies', 11),
(173, 'Home Economics', 11),
(174, 'Music', 11),
(175, 'Basic Technology', 11),
(176, 'Mathematics', 12),
(177, 'English Language', 12),
(178, 'Nigerian Language', 12),
(179, 'Basic Science', 12),
(180, 'Social Studies', 12),
(181, 'Fine Arts/Creative Art', 12),
(182, 'Agricultural Science', 12),
(183, 'Civic Education', 12),
(184, 'Christian Religious Studies', 12),
(185, 'Physical and Health Education', 12),
(186, 'Business Studies', 12),
(187, 'French', 12),
(188, 'Computer Studies', 12),
(189, 'Home Economics', 12),
(190, 'Music', 12),
(191, 'Basic Technology', 12),
(192, 'English Language', 13),
(193, 'Mathematics', 13),
(194, 'Civic Education', 13),
(195, 'Biology', 13),
(196, 'Physics', 13),
(197, 'Chemistry', 13),
(198, 'Further Mathematics', 13),
(199, 'Health and Physical Education', 13),
(200, 'Computer Science', 13),
(201, 'Technical Drawing', 13),
(202, 'Food and Nutrition', 13),
(203, 'Agricultural Science', 13),
(204, 'Financial Account', 13),
(205, 'Book Keeping ', 13),
(206, 'Typewriting ', 13),
(207, 'Office Practice ', 13),
(208, 'Commerce ', 13),
(209, 'Data Processing ', 13),
(210, 'Economics', 13),
(211, 'Government', 13),
(212, 'Literature –in- English', 13),
(213, 'Christian Religion Knowledge', 13),
(214, 'Fine Art/Creative Art', 13),
(215, 'French', 13),
(216, 'Geography', 13),
(217, 'Nigerian Language', 13),
(218, 'English Language', 14),
(219, 'Mathematics', 14),
(220, 'Civic Education', 14),
(221, 'Biology', 14),
(222, 'Physics', 14),
(223, 'Chemistry', 14),
(224, 'Further Mathematics', 14),
(225, 'Health and Physical Education', 14),
(226, 'Computer Science', 14),
(227, 'Technical Drawing', 14),
(228, 'Food and Nutrition', 14),
(229, 'Agricultural Science', 14),
(230, 'Financial Account', 14),
(231, 'Book Keeping ', 14),
(232, 'Typewriting ', 14),
(233, 'Office Practice ', 14),
(234, 'Commerce ', 14),
(235, 'Data Processing ', 14),
(236, 'Economics', 14),
(237, 'Government', 14),
(238, 'Literature – in- English', 14),
(239, 'Christian Religion Knowledge', 14),
(240, 'Fine Art/Creative Art', 14),
(241, 'French', 14),
(242, 'Geography', 14),
(243, 'Nigerian Language', 14),
(244, 'English Language', 15),
(245, 'Mathematics', 15),
(246, 'Civic Education', 15),
(247, 'Biology', 15),
(248, 'Physics', 15),
(249, 'Chemistry', 15),
(250, 'Further Mathematics', 15),
(251, 'Health and Physical Education', 15),
(252, 'Computer Science', 15),
(253, 'Technical Drawing', 15),
(254, 'Food and Nutrition', 15),
(255, 'Agricultural Science', 15),
(256, 'Financial Account', 15),
(257, 'Book Keeping ', 15),
(258, 'Typewriting ', 15),
(259, 'Office Practice ', 15),
(260, 'Commerce ', 15),
(261, 'Data Processing ', 15),
(262, 'Economics', 15),
(263, 'Government', 15),
(264, 'Literature – in- English', 15),
(265, 'Christian Religion Knowledge', 15),
(266, 'Fine Art/Creative Art', 15),
(267, 'French', 15),
(268, 'Geography', 15),
(269, 'Nigerian Language', 15);

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `id` int(4) NOT NULL,
  `termName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `term`
--

INSERT INTO `term` (`id`, `termName`) VALUES
(1, '1st Term'),
(2, '2nd Term'),
(3, '3rd Term');

-- --------------------------------------------------------

--
-- Table structure for table `transterm`
--

CREATE TABLE `transterm` (
  `id` int(4) NOT NULL,
  `payTerm` varchar(20) NOT NULL,
  `amount` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transterm`
--

INSERT INTO `transterm` (`id`, `payTerm`, `amount`) VALUES
(5, 'All Payment', ''),
(6, 'Part Payment', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `roleId` int(4) NOT NULL,
  `schoolId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `roleId`, `schoolId`) VALUES
(22, 'Owner', 'Owner', 1, 13),
(23, 'Staff', 'Staff', 2, 13),
(25, 'Owner', 'Owner', 1, 6563);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_afternoon`
--
ALTER TABLE `attendance_afternoon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_morning`
--
ALTER TABLE `attendance_morning`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elapse_time`
--
ALTER TABLE `elapse_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examyear`
--
ALTER TABLE `examyear`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses_backup`
--
ALTER TABLE `expenses_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mnbvcxz`
--
ALTER TABLE `mnbvcxz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_user`
--
ALTER TABLE `parent_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pin`
--
ALTER TABLE `pin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_fees`
--
ALTER TABLE `student_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_fees_backup`
--
ALTER TABLE `student_fees_backup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_ranking`
--
ALTER TABLE `student_ranking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_result`
--
ALTER TABLE `student_result`
  ADD PRIMARY KEY (`resId`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classid_fkey` (`classId`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transterm`
--
ALTER TABLE `transterm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_afternoon`
--
ALTER TABLE `attendance_afternoon`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `attendance_morning`
--
ALTER TABLE `attendance_morning`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `elapse_time`
--
ALTER TABLE `elapse_time`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `examyear`
--
ALTER TABLE `examyear`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `expenses_backup`
--
ALTER TABLE `expenses_backup`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mnbvcxz`
--
ALTER TABLE `mnbvcxz`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `parent_user`
--
ALTER TABLE `parent_user`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pin`
--
ALTER TABLE `pin`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `student_fees`
--
ALTER TABLE `student_fees`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `student_fees_backup`
--
ALTER TABLE `student_fees_backup`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `student_ranking`
--
ALTER TABLE `student_ranking`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_result`
--
ALTER TABLE `student_result`
  MODIFY `resId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `term`
--
ALTER TABLE `term`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transterm`
--
ALTER TABLE `transterm`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `classid_fkey` FOREIGN KEY (`classId`) REFERENCES `class` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
