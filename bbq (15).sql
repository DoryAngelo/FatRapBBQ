-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 06:01 PM
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
(53, 'April 24 2024', 'available'),
(56, 'April 30 2024', 'available'),
(58, 'April 22 2024', 'fullybooked'),
(71, 'April 18 2024', 'available');

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
(21, 78, 'NewEmployeee', 'NewEmployeee', 'EMP_IMAGE_NewEmployee3jpg', 'NewEmployee2', ''),
(22, 81, 'TestEmployee', 'TestEmployee', '', 'TestEmployee', ''),
(24, 83, 'Admin', 'Two', 'EMP_IMAGE_Admin2.jpg', 'AdminTwo', 'Active'),
(25, 84, 'Hi', 'Hello', 'EMP_IMAGE_Hello.jpg', 'HiHello', 'Active');

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
(49, 0, 'Barbeque', 1000.00, 'NewProduct', 'FOOD_IMAGE_Barbeque.jpg', -50, 'Yes', 'Customer'),
(50, 0, 'Test', 25.50, 'testttttttttt', 'FOOD_IMAGE_Test.jpg', 100, 'Yes', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `in_order`
--

CREATE TABLE `in_order` (
  `IN_ORDER_ID` int(18) UNSIGNED NOT NULL,
  `FOOD_ID` int(18) NOT NULL,
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

INSERT INTO `in_order` (`IN_ORDER_ID`, `FOOD_ID`, `PRSN_ID`, `IN_ORDER_QUANTITY`, `IN_ORDER_TOTAL`, `IN_ORDER_STATUS`, `PLACED_ORDER_ID`, `GUEST_ORDER_IDENTIFIER`) VALUES
(150, 49, 15, 10, 10000.00, 'Ordered', 73, ''),
(151, 50, 15, 5, 127.50, 'Ordered', NULL, '');

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
(25, 'Employee', 'employee@gmail.com', 'd3d73db423372e0bea89ca659ea9d115', '09123456789', 'Employee'),
(48, 'New', 'new@gmail.com', '70efb8810172bcaceb5b475652600ed0', '09123456789', 'Customer'),
(54, 'Number', 'number@gmail.com', 'a7f9f337591ea4d7acbd0073e1ca35d8', '09123456789', 'Customer'),
(78, 'NewEmployeee NewEmpl', 'NewEmployee4', 'c99fa75e153df5703c89509b6adc1031', '09123456789', 'Employee'),
(79, 'WholesalerNew Wholes', 'TestUsernamee', 'cf25540a1a154f6186fa94ee08a28744', '09123456789', 'Wholesaler'),
(80, 'FnameW LaNameW', 'UnameWn', 'bb651e59451b9b47e28f98cbf4f5854e', '09123456789', 'Wholesaler'),
(81, 'TestEmployee TestEmp', 'dsadsads', '673141b80f19724c65ec23e80d81a5ba', '09123456789', 'Employee'),
(83, 'Admin Two', 'Admin2', 'd41d8cd98f00b204e9800998ecf8427e', '09123456789', 'Employee'),
(84, 'Hi Hello', 'HiHello', 'ef9ec02399a356803e21b09f0e786c64', '09123456789', 'Employee'),
(85, 'WhNew WhNew', 'WhNew', '7503d4ae5f2684f8d09e30657bfc5809', '09123456789', 'Wholesaler');

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
(73, 15, 'Fname Lname', '09123456789', 'user@gmail.com', '2024-04-14 10:12:34pm', 10000.00, 'RegionTest, ProvinceTest, CityTest, BarangayTest, StreetTest', '2024-04-15 10:16', 'Cancelled', 'Confirmed', '78d000624a38e703', 'sdsdsads', '1321', '');

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
(15, 79, 'WholesalerNew', 'WholesalerNew', 'WHL_IMAGE_WholesalerNew Wholesjpg', ''),
(16, 80, 'FnameW', 'LaNameW', 'WHL_IMAGE_UnameWn.jpg', ''),
(17, 85, 'WhNew', 'WhNew', 'WHL_IMAGE_WhNew.jpg', 'Inactive');

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
  MODIFY `CALENDAR_ID` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
  MODIFY `EMP_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `FOOD_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `in_order`
--
ALTER TABLE `in_order`
  MODIFY `IN_ORDER_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `PRSN_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `placed_order`
--
ALTER TABLE `placed_order`
  MODIFY `PLACED_ORDER_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `wholesaler`
--
ALTER TABLE `wholesaler`
  MODIFY `WHL_ID` int(18) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
