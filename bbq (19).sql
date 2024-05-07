-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 03:43 PM
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
(80, 'May 29 2024', 'closed');

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
(999, 16, '', 'Admin', '', '85686', 'Active');

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
  `FOOD_TYPE` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`FOOD_ID`, `CTGY_ID`, `FOOD_NAME`, `FOOD_PRICE`, `FOOD_DESC`, `FOOD_IMG`, `FOOD_STOCK`, `FOOD_ACTIVE`, `FOOD_TYPE`) VALUES
(60, 0, 'Barbeque', 25.50, 'BBQ', 'FOOD_IMAGE_Barbeque.jpg', 150, 'Yes', 'Customer'),
(61, 0, 'Isaw', 5.00, 'Isaw ng manok', 'FOOD_IMAGE_Isaw.jpg', 100, 'Yes', 'Customer');

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
  `GUEST_ORDER_IDENTIFIER` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `in_order`
--

INSERT INTO `in_order` (`IN_ORDER_ID`, `FOOD_ID`, `MENU_ID`, `PRSN_ID`, `IN_ORDER_QUANTITY`, `IN_ORDER_TOTAL`, `IN_ORDER_STATUS`, `PLACED_ORDER_ID`, `GUEST_ORDER_IDENTIFIER`) VALUES
(182, 60, 0, 15, 10, 255.00, 'Ordered', 89, ''),
(183, 60, 0, 15, 15, 375.00, 'Ordered', 90, ''),
(186, 60, 11, 15, 3, 75.00, 'Ordered', 91, ''),
(187, 60, 11, 15, 1, 25.50, 'Ordered', 92, ''),
(189, 60, 13, 15, 10, 255.00, 'Ordered', 93, ''),
(190, 61, 12, 15, 10, 50.00, 'Ordered', 93, '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `MENU_ID` int(18) NOT NULL,
  `FOOD_ID` int(18) NOT NULL,
  `MENU_STOCK` int(18) NOT NULL,
  `MENU_START` varchar(50) NOT NULL,
  `MENU_END` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`MENU_ID`, `FOOD_ID`, `MENU_STOCK`, `MENU_START`, `MENU_END`) VALUES
(12, 61, 90, 'May 05, 2024 07:07:00 pm', 'May 10, 2024 07:08:00 pm'),
(13, 60, 40, 'May 05, 2024 07:16:00 pm', 'May 08, 2024 07:16:00 pm');

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
(83, 'Admin Two', 'Admin2', 'd41d8cd98f00b204e9800998ecf8427e', '09123456789', 'Employee'),
(84, 'Employee Employee', 'Employee', 'd3d73db423372e0bea89ca659ea9d115', '09123456789', 'Employee'),
(85, 'WhNew WhNew', 'WhNew', '7503d4ae5f2684f8d09e30657bfc5809', '09123456789', 'Wholesaler'),
(86, 'Wholesaler Wholesale', 'Wholesaler', '4ff918a8bde60d5bda668f617164af08', '09123456789', 'Wholesaler'),
(90, 'dsd', 'asfdsf@gmail.com', '046c8fbd148b6243fc629390ee3aa349', '09123456789', 'Customer');

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
(89, 15, 'Fname Lname', '09123456789', 'user@gmail.com', '2024-05-01 02:58:23pm', 255.00, 'National Capital Region (NCR), City Of Manila, Binondo, Barangay 288, StreetTest', '2024-05-30 14:58', 'Currently Preparing', 'Confirmed', 'e466b452178783d4', '', '1232132132324', ''),
(90, 15, 'Fname Lname', '09123456789', 'user@gmail.com', '2024-05-05 05:17:31pm', 375.00, 'National Capital Region (NCR), City Of Manila, Binondo, Barangay 287, StreetTest', '2024-05-06 13:17', 'Currently Preparing', '', '0b83d74f86c293bf', '', '', ''),
(91, 15, 'Fname Lname', '09123456789', 'user@gmail.com', '2024-05-05 06:11:28pm', 75.00, 'National Capital Region (NCR), City Of Manila, Binondo, Barangay 287, StreetTest', '2024-05-06 14:11', 'Placed', '', 'f045d8a2b76b9abe', '', '', ''),
(92, 15, 'Fname Lname', '09123456789', 'user@gmail.com', '2024-05-05 06:25:15pm', 25.50, 'National Capital Region (NCR), City Of Manila, Binondo, Barangay 291, StreetTest', '2024-05-06 14:25', 'Placed', '', '0fa5232641a4fe56', '', '', ''),
(93, 15, 'Fname Lname', '09123456789', 'user@gmail.com', '2024-05-05 07:17:57pm', 305.00, 'National Capital Region (NCR), City Of Manila, Binondo, Barangay 287, StreetTest', '2024-05-06 15:17', 'Placed', '', '6a4f1cf108cd2e7a', '', '', '');

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
(17, 85, 'WhNew', 'WhNew', 'WHL_IMAGE_WhNew.jpg', 'Inactive'),
(18, 86, 'Wholesaler', 'Wholesaler', 'WHL_IMAGE_Wholesaler.jpg', 'Active');

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
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MENU_ID`);

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
  MODIFY `CALENDAR_ID` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

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
  MODIFY `EMP_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `FOOD_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `in_order`
--
ALTER TABLE `in_order`
  MODIFY `IN_ORDER_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `MENU_ID` int(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `PRSN_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `placed_order`
--
ALTER TABLE `placed_order`
  MODIFY `PLACED_ORDER_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `wholesaler`
--
ALTER TABLE `wholesaler`
  MODIFY `WHL_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
