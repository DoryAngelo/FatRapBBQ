-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 09:27 PM
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
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `CALENDAR_ID` int(16) UNSIGNED NOT NULL,
  `CALENDAR_DATE` varchar(50) NOT NULL,
  `DATE_STATUS` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`CALENDAR_ID`, `CALENDAR_DATE`, `DATE_STATUS`) VALUES
(81, 'May 29 2024', 'fullybooked');

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
(1, 'BBQ', 'Yes'),
(2, 'CAT2', 'Yes'),
(3, 'CAT3', 'Yes'),
(4, 'CAT4', 'No');

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
  `EMP_FNAME` varchar(50) NOT NULL,
  `EMP_LNAME` varchar(50) NOT NULL,
  `EMP_IMAGE` varchar(250) NOT NULL,
  `EMP_BRANCH` varchar(50) NOT NULL,
  `EMP_STATUS` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EMP_ID`, `PRSN_ID`, `EMP_FNAME`, `EMP_LNAME`, `EMP_IMAGE`, `EMP_BRANCH`, `EMP_STATUS`) VALUES
(11, 38, '', '', 'EMP_IMAGE_.jpg', '', ''),
(18, 52, 'NewUpdate', 'NewUpdate', 'EMP_IMAGE_NewUpdate.png', 'NewUpdate', ''),
(24, 83, 'Admin', 'Two', 'EMP_IMAGE_Admin Two_6620a0b1034dd.jpg', 'AdminTwo', 'Active'),
(25, 84, 'Employee', 'Employee', 'EMP_IMAGE_Hi Hello_6620a0d64df55.jpg', 'Employee', 'Active'),
(999, 16, '', 'Admin', '', '85686', 'Active'),
(1000, 92, 'Dummy', 'Dummy', 'EMP_IMAGE_Dummy.jpg', 'Dummy2', 'Active');

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
  `FOOD_ACTIVE` varchar(10) NOT NULL,
  `FOOD_TYPE` varchar(16) NOT NULL,
  `HOURLY_CAP` int(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`FOOD_ID`, `CTGY_ID`, `FOOD_NAME`, `FOOD_PRICE`, `FOOD_DESC`, `FOOD_IMG`, `FOOD_STOCK`, `FOOD_ACTIVE`, `FOOD_TYPE`, `HOURLY_CAP`) VALUES
(60, 0, 'Barbeque', 25.50, 'BBQ', 'FOOD_IMAGE_Barbeque.jpg', 14820, 'Yes', 'Customer', 50);

-- --------------------------------------------------------

--
-- Table structure for table `in_order`
--

CREATE TABLE `in_order` (
  `IN_ORDER_ID` int(18) UNSIGNED NOT NULL,
  `FOOD_ID` int(18) NOT NULL,
  `MENU_ID` int(18) NOT NULL,
  `PRSN_ID` int(18) NOT NULL,
  `IN_ORDER_QUANTITY` int(11) NOT NULL,
  `IN_ORDER_TOTAL` decimal(10,2) NOT NULL,
  `IN_ORDER_STATUS` varchar(21) NOT NULL,
  `PLACED_ORDER_ID` int(18) UNSIGNED DEFAULT NULL,
  `GUEST_ORDER_IDENTIFIER` varchar(50) NOT NULL,
  `DELIVERY_DATE` varchar(50) NOT NULL,
  `DELIVERY_HOUR` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `in_order`
--

INSERT INTO `in_order` (`IN_ORDER_ID`, `FOOD_ID`, `MENU_ID`, `PRSN_ID`, `IN_ORDER_QUANTITY`, `IN_ORDER_TOTAL`, `IN_ORDER_STATUS`, `PLACED_ORDER_ID`, `GUEST_ORDER_IDENTIFIER`, `DELIVERY_DATE`, `DELIVERY_HOUR`) VALUES
(320, 60, 0, 15, 20, 510.00, 'Ordered', 144, '', 'May 17 2024', '16');

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
(15, 'User', 'user@gmail.com', '4792487cdd9c183bfab5e48780837552', '09123456789', 'Customer'),
(16, 'Admin', 'Test', '2cdcf3ae8d662d2141f8f4b0d5f0465c', '09123456789', 'Admin'),
(48, 'New', 'new@gmail.com', '70efb8810172bcaceb5b475652600ed0', '09123456789', 'Customer'),
(54, 'Number', 'number@gmail.com', 'a7f9f337591ea4d7acbd0073e1ca35d8', '09123456789', 'Customer'),
(83, 'Admin Two', 'Admin2', 'd41d8cd98f00b204e9800998ecf8427e', '09123649997', 'Employee'),
(84, 'Employee Employee', 'Employee', 'd3d73db423372e0bea89ca659ea9d115', '09123456789', 'Employee'),
(85, 'WhNew WhNew', 'WhNew', '7503d4ae5f2684f8d09e30657bfc5809', '09123456789', 'Wholesaler'),
(86, 'Wholesaler Wholesale', 'Wholesaler', '4ff918a8bde60d5bda668f617164af08', '09123456789', 'Wholesaler'),
(90, 'dsd', 'asfdsf@gmail.com', '046c8fbd148b6243fc629390ee3aa349', '09123456789', 'Customer'),
(91, 'Fname Lname', 'TestUsername', '6b37efdb7b7992b81e0874158e6c02fe', '09999990999', 'Wholesaler'),
(92, 'Dummy Dummy', 'Dummy2', 'f21844a3568173d5d628868e9dc51751', '09173456789', 'Employee'),
(93, 'Dummy2Dummy2 ', '', 'd41d8cd98f00b204e9800998ecf8427e', '', 'Wholesaler'),
(94, 'TestNew TestNew', 'TestNew', '12f3716656a41d874e63bd71382d58d0', '09823456789', 'Wholesaler');

-- --------------------------------------------------------

--
-- Table structure for table `placed_order`
--

CREATE TABLE `placed_order` (
  `PLACED_ORDER_ID` int(18) UNSIGNED NOT NULL,
  `PRSN_ID` int(18) NOT NULL,
  `CUS_NAME` varchar(20) NOT NULL,
  `CUS_NUMBER` varchar(11) NOT NULL,
  `CUS_EMAIL` varchar(35) NOT NULL,
  `PLACED_ORDER_DATE` varchar(50) NOT NULL,
  `PLACED_ORDER_TOTAL` decimal(10,2) NOT NULL,
  `DELIVERY_ADDRESS` varchar(255) NOT NULL,
  `DELIVERY_DATE` varchar(50) NOT NULL,
  `PLACED_ORDER_STATUS` varchar(50) NOT NULL,
  `PLACED_ORDER_CONFIRMATION` varchar(50) NOT NULL,
  `PLACED_ORDER_TRACKER` varchar(16) NOT NULL,
  `PLACED_ORDER_NOTE` varchar(50) NOT NULL,
  `REFERENCE_NUMBER` varchar(50) NOT NULL,
  `GUEST_ORDER_IDENTIFIER` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `placed_order`
--

INSERT INTO `placed_order` (`PLACED_ORDER_ID`, `PRSN_ID`, `CUS_NAME`, `CUS_NUMBER`, `CUS_EMAIL`, `PLACED_ORDER_DATE`, `PLACED_ORDER_TOTAL`, `DELIVERY_ADDRESS`, `DELIVERY_DATE`, `PLACED_ORDER_STATUS`, `PLACED_ORDER_CONFIRMATION`, `PLACED_ORDER_TRACKER`, `PLACED_ORDER_NOTE`, `REFERENCE_NUMBER`, `GUEST_ORDER_IDENTIFIER`) VALUES
(144, 15, 'Fname Lname', '09123456789', 'user@gmail.com', '2024-05-17 03:26:35am', 510.00, ', , , , StreetTest', 'May 17 2024 4:25 pm', 'Placed', '', 'c239f8a1773bc74e', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `wholesaler`
--

CREATE TABLE `wholesaler` (
  `WHL_ID` int(18) UNSIGNED NOT NULL,
  `PRSN_ID` int(18) NOT NULL,
  `WHL_FNAME` varchar(20) NOT NULL,
  `WHL_LNAME` varchar(20) NOT NULL,
  `WHL_IMAGE` varchar(250) NOT NULL,
  `WHL_STATUS` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wholesaler`
--

INSERT INTO `wholesaler` (`WHL_ID`, `PRSN_ID`, `WHL_FNAME`, `WHL_LNAME`, `WHL_IMAGE`, `WHL_STATUS`) VALUES
(19, 91, 'Fname', 'Lname', 'WHL_IMAGE_Lname.jpg', 'Active'),
(20, 93, 'Dummy2Dummy2', '', '', 'Active'),
(21, 94, 'TestNew', 'TestNew', 'WHL_IMAGE_TestNew.jpg', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`CALENDAR_ID`);

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
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `CALENDAR_ID` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CTGY_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CUS_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `EMP_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `FOOD_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `in_order`
--
ALTER TABLE `in_order`
  MODIFY `IN_ORDER_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `PRSN_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `placed_order`
--
ALTER TABLE `placed_order`
  MODIFY `PLACED_ORDER_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `wholesaler`
--
ALTER TABLE `wholesaler`
  MODIFY `WHL_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
