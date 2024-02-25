-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2024 at 03:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbq`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CTGY_ID` int(18) UNSIGNED NOT NULL,
  `CTGY_NAME` varchar(20) NOT NULL,
  `CTGY_ACTIVE` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CTGY_ID`, `CTGY_NAME`, `CTGY_ACTIVE`) VALUES
(1, 'BBQ', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CUS_ID` int(18) UNSIGNED NOT NULL,
  `PRSN_ID` int(18) NOT NULL,
  `CUS_CTGY` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `EMP_ID` int(18) UNSIGNED NOT NULL,
  `PRSN_ID` int(18) NOT NULL,
  `EMP_NAME` varchar(50) NOT NULL,
  `EMP_IMAGE` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EMP_ID`, `PRSN_ID`, `EMP_NAME`, `EMP_IMAGE`) VALUES
(5, 25, 'Fname Lname', 'EMP_IMAGE_Lname.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `FOOD_ID` int(18) UNSIGNED NOT NULL,
  `CTGY_ID` int(18) NOT NULL,
  `FOOD_NAME` varchar(20) NOT NULL,
  `FOOD_PRICE` decimal(10,2) NOT NULL,
  `FOOD_DESC` varchar(50) NOT NULL,
  `FOOD_IMG` varchar(255) NOT NULL,
  `FOOD_STOCK` int(20) NOT NULL,
  `FOOD_ACTIVE` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`FOOD_ID`, `CTGY_ID`, `FOOD_NAME`, `FOOD_PRICE`, `FOOD_DESC`, `FOOD_IMG`, `FOOD_STOCK`, `FOOD_ACTIVE`) VALUES
(1, 1, 'Barbeque', 25.00, 'Lorem ipsum dolor sit amet, consectetur adipiscing', 'barbeque.jpg', 20, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `in_order`
--

CREATE TABLE `in_order` (
  `IN_ORDER_ID` int(18) UNSIGNED NOT NULL,
  `FOOD_ID` int(18) NOT NULL,
  `CUS_ID` int(18) NOT NULL,
  `IN_ORDER_QUANTITY` int(11) NOT NULL,
  `IN_ORDER_TOTAL` decimal(10,2) NOT NULL,
  `IN_ORDER_STATUS` varchar(21) NOT NULL,
  `PLACED_ORDER_ID` int(18) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `in_order`
--

INSERT INTO `in_order` (`IN_ORDER_ID`, `FOOD_ID`, `CUS_ID`, `IN_ORDER_QUANTITY`, `IN_ORDER_TOTAL`, `IN_ORDER_STATUS`, `PLACED_ORDER_ID`) VALUES
(2, 1, 99, 1, 25.00, 'Ordered', NULL),
(3, 1, 15, 1, 25.00, 'Ordered', NULL),
(4, 1, 15, 1, 25.00, 'Ordered', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `PRSN_ID` int(18) UNSIGNED NOT NULL,
  `PRSN_NAME` varchar(20) NOT NULL,
  `PRSN_EMAIL` varchar(35) NOT NULL,
  `PRSN_PASSWORD` varchar(250) NOT NULL,
  `PRSN_PHONE` varchar(11) NOT NULL,
  `PRSN_ROLE` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`PRSN_ID`, `PRSN_NAME`, `PRSN_EMAIL`, `PRSN_PASSWORD`, `PRSN_PHONE`, `PRSN_ROLE`) VALUES
(15, 'User', 'user@gmail.com', '7dc715960b177f323db34eacd63048f7', '09123456789', 'Customer'),
(16, 'Admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '09123456789', 'Admin'),
(17, 'Employee', 'employee@gmail.com', 'fa5473530e4d1a5a1e1eb53d2fedb10c', '09123456789', 'Employee'),
(25, 'Test', 'test@gmail.com', '147538da338b770b61e592afc92b1ee6', '09123456789', 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `placed_order`
--

CREATE TABLE `placed_order` (
  `PLACED_ORDER_ID` int(18) UNSIGNED NOT NULL,
  `CUS_ID` int(18) NOT NULL,
  `CUS_NAME` varchar(20) NOT NULL,
  `CUS_NUMBER` varchar(11) NOT NULL,
  `CUS_EMAIL` varchar(35) NOT NULL,
  `PLACED_ORDER_DATE` varchar(50) NOT NULL,
  `PLACED_ORDER_TOTAL` decimal(10,2) NOT NULL,
  `DELIVERY_ADDRESS` varchar(255) NOT NULL,
  `DELIVERY_DATE` varchar(50) NOT NULL,
  `PLACED_ORDER_STATUS` varchar(50) NOT NULL,
  `PLACED_ORDER_CONFIRMATION` varchar(50) NOT NULL,
  `PLACED_ORDER_TRACKER` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `placed_order`
--

INSERT INTO `placed_order` (`PLACED_ORDER_ID`, `CUS_ID`, `CUS_NAME`, `CUS_NUMBER`, `CUS_EMAIL`, `PLACED_ORDER_DATE`, `PLACED_ORDER_TOTAL`, `DELIVERY_ADDRESS`, `DELIVERY_DATE`, `PLACED_ORDER_STATUS`, `PLACED_ORDER_CONFIRMATION`, `PLACED_ORDER_TRACKER`) VALUES
(13, 15, 'User', '09123456789', 'user@gmail.com', '2024-02-23 03:16:05pm', 75.00, 'Test Address', '2024-02-23 04:22', 'Approved', '', '432ab3662d43ef4f');

-- --------------------------------------------------------

--
-- Table structure for table `wholesaler`
--

CREATE TABLE `wholesaler` (
  `WHL_ID` int(18) UNSIGNED NOT NULL,
  `CUS_ID` int(18) NOT NULL,
  `WHL_DISC` decimal(2,2) NOT NULL,
  `ADD_INFO` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CTGY_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CUS_ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EMP_ID`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`FOOD_ID`);

--
-- Indexes for table `in_order`
--
ALTER TABLE `in_order`
  ADD PRIMARY KEY (`IN_ORDER_ID`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`PRSN_ID`);

--
-- Indexes for table `placed_order`
--
ALTER TABLE `placed_order`
  ADD PRIMARY KEY (`PLACED_ORDER_ID`);

--
-- Indexes for table `wholesaler`
--
ALTER TABLE `wholesaler`
  ADD PRIMARY KEY (`WHL_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CTGY_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CUS_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EMP_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `FOOD_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `in_order`
--
ALTER TABLE `in_order`
  MODIFY `IN_ORDER_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `PRSN_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `placed_order`
--
ALTER TABLE `placed_order`
  MODIFY `PLACED_ORDER_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wholesaler`
--
ALTER TABLE `wholesaler`
  MODIFY `WHL_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
