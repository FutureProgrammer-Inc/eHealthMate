-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2023 at 08:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_emedrec_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_med_inventory`
--

CREATE TABLE `tbl_med_inventory` (
  `id` int(11) NOT NULL,
  `medicine_item` varchar(22) NOT NULL,
  `curr_total` int(11) NOT NULL,
  `add_med_item` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `id` int(11) NOT NULL,
  `f_name` varchar(22) NOT NULL,
  `m_name` varchar(22) NOT NULL,
  `l_name` varchar(22) NOT NULL,
  `stud_no` int(11) NOT NULL,
  `course` varchar(22) NOT NULL,
  `year` int(1) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `f_name`, `m_name`, `l_name`, `stud_no`, `course`, `year`, `height`, `weight`) VALUES
(0, 'niel', 'madriaga', 'andoy', 2000070, 'BSIT', 1, 192, 86);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `f_name` varchar(11) NOT NULL,
  `m_name` varchar(22) NOT NULL,
  `last_name` varchar(22) NOT NULL,
  `email` varchar(22) NOT NULL,
  `employee_no` varchar(11) NOT NULL,
  `username` varchar(22) NOT NULL,
  `password` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `f_name`, `m_name`, `last_name`, `email`, `employee_no`, `username`, `password`) VALUES
(0, 'cars', 'kotse', 'sasakyan', 'carskotse@gmail.com', '29_0000', 'cars', 12345);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_med_inventory`
--
ALTER TABLE `tbl_med_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
