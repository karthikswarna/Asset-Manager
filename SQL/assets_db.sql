-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2020 at 06:30 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
SET GLOBAL TRANSACTION ISOLATION LEVEL READ COMMITTED;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assets_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `checkoutAsset` (IN `barcode` VARCHAR(50), IN `employee_id` INT)  BEGIN
     UPDATE asset
     SET Availability = false
     WHERE Barcode = barcode;
     
     INSERT INTO checkouts(Employee_ID, Barcode, checkin_date, checkout_date)
     VALUES (employee_id, barcode, NULL, now());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectAsset` (IN `product_id` INT)  BEGIN
     SELECT Barcode
     FROM asset
     WHERE Product_ID = product_id AND Availability = true
     LIMIT 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `asset`
--

CREATE TABLE `asset` (
  `Barcode` varchar(50) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Availability` tinyint(1) NOT NULL,
  `Expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asset`
--

INSERT INTO `asset` (`Barcode`, `Product_ID`, `Availability`, `Expiry_date`) VALUES
('IITT-13-Water Bottle-1', 13, 1, NULL),
('IITT-13-Water Bottle-2', 13, 1, NULL),
('IITT-13-Water Bottle-3', 13, 1, NULL),
('IITT-13-Water Bottle-4', 13, 1, NULL),
('IITT-13-Water Bottle-5', 13, 1, NULL),
('IITT-7-Chairs-1', 7, 0, NULL),
('IITT-7-Chairs-2', 7, 1, NULL),
('IITT-7-Chairs-3', 7, 1, NULL),
('IITT-7-Chairs-4', 7, 1, NULL),
('IITT-7-Chairs-5', 7, 1, NULL),
('IITT-HPPavilion-1', 1, 0, NULL),
('IITT-HPPavilion-2', 1, 0, NULL),
('IITT-HPPavilion-3', 1, 1, NULL),
('IITT-HPPavilion-4', 1, 0, NULL),
('IITT-QuickHeal-1', 3, 0, '2021-07-30'),
('IITT-Table-1', 2, 1, NULL),
('IITT-Table-10', 2, 1, NULL),
('IITT-Table-2', 2, 1, NULL),
('IITT-Table-3', 2, 1, NULL),
('IITT-Table-4', 2, 1, NULL),
('IITT-Table-5', 2, 1, NULL),
('IITT-Table-6', 2, 1, NULL),
('IITT-Table-7', 2, 1, NULL),
('IITT-Table-8', 2, 1, NULL),
('IITT-Table-9', 2, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_ID` int(11) NOT NULL,
  `Category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_ID`, `Category_name`) VALUES
(1, 'computers'),
(2, 'tables'),
(3, 'software'),
(6, 'Chair'),
(7, 'Movable'),
(8, 'Immovable'),
(9, 'Utensils');

-- --------------------------------------------------------

--
-- Table structure for table `checkouts`
--

CREATE TABLE `checkouts` (
  `Check_ID` int(11) NOT NULL,
  `Employee_ID` int(11) NOT NULL,
  `Barcode` varchar(50) DEFAULT NULL,
  `checkin_date` datetime DEFAULT NULL,
  `checkout_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checkouts`
--

INSERT INTO `checkouts` (`Check_ID`, `Employee_ID`, `Barcode`, `checkin_date`, `checkout_date`) VALUES
(2, 2, 'IITT-QuickHeal-1', NULL, '2020-04-26 14:06:49'),
(3, 1, 'IITT-HPPavilion-1', '2020-05-08 01:22:02', '2020-04-26 19:15:06'),
(4, 1, 'IITT-Table-1', '2020-05-13 09:23:46', '2020-04-26 19:16:20'),
(5, 2, 'IITT-HPPavilion-2', '2020-05-10 20:42:52', '2020-04-26 19:17:18'),
(6, 3, 'IITT-HPPavilion-3', '2020-05-07 23:48:47', '2020-04-27 20:12:27'),
(7, 12, 'IITT-7-Chairs-1', '2020-05-07 23:27:40', '2020-05-07 18:55:35'),
(8, 12, 'IITT-7-Chairs-2', '2020-05-07 23:23:44', '2020-05-07 23:23:38'),
(9, 12, 'IITT-HPPavilion-4', NULL, '2020-05-07 23:48:26'),
(10, 12, 'IITT-HPPavilion-1', '2020-05-08 09:25:02', '2020-05-08 01:29:25'),
(11, 1, 'IITT-Table-10', '2020-05-08 09:23:12', '2020-05-08 09:22:53'),
(12, 3, 'IITT-7-Chairs-1', NULL, '2020-05-08 09:24:37'),
(13, 2, 'IITT-Table-10', '2020-05-13 09:16:33', '2020-05-10 23:03:26'),
(14, 2, 'IITT-HPPavilion-1', NULL, '2020-05-11 16:03:52'),
(15, 1, 'IITT-HPPavilion-2', NULL, '2020-05-12 19:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Employee_ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Work_phone` varchar(20) NOT NULL,
  `Personal_phone` varchar(20) DEFAULT NULL,
  `Image` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Employee_ID`, `Name`, `Department`, `Email`, `Work_phone`, `Personal_phone`, `Image`) VALUES
(1, 'Dheeraj', 'Computer Science', 'cs17b028@iittp.ac.in', '408-369', NULL, NULL),
(2, 'Karthik Chandra', 'Computer Science', 'cs17b026@iittp.ac.in', '408-370', NULL, NULL),
(3, 'Rohith', 'Electrical engineering', 'ee17b024@iittp.ac.in', '156-547', '7984658942', NULL),
(12, 'Kedar Krishna', 'Mechanical engineering', 'me17b014@iittp.ac.in', '654-654', '6654831465', '20200501223825.jpg'),
(20, 'Pavan', 'Electrical Engineering', 'EE17B003@iittp.ac.in', '80746-254-707', '7895641231', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL,
  `Category_ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Total_quantity` int(11) NOT NULL,
  `Image` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Category_ID`, `Name`, `Description`, `Total_quantity`, `Image`) VALUES
(1, 1, 'HP Pavilion Laptop', 'HP Pavilion Laptop with 1TB storage and 16GB RAM', 4, 'HPPavilion.jpg'),
(2, 2, 'Damro Table', 'A Table provided by Damro furnitures made up of teak', 10, 'Table.jpg'),
(3, 3, 'Quick Heal Pro', 'An Anti-virus program to protect the computers from viruses', 1, 'QuickHealPro.jpg'),
(7, 6, 'Chairs', 'Chairs to sit', 5, '20200501170258.jpg'),
(13, 9, 'Water Bottle', 'Drink water in this', 5, '20200513180326.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `suppliedproduct`
--

CREATE TABLE `suppliedproduct` (
  `Supply_ID` int(11) NOT NULL,
  `Supplier_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Date_supplied` date NOT NULL,
  `Quantity_supplied` int(11) NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliedproduct`
--

INSERT INTO `suppliedproduct` (`Supply_ID`, `Supplier_ID`, `Product_ID`, `Date_supplied`, `Quantity_supplied`, `Price`) VALUES
(2, 1, 7, '2020-05-01', 5, 2500),
(8, 1, 13, '2020-05-13', 5, 500);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `Supplier_ID` int(11) NOT NULL,
  `Supplier_name` varchar(50) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`Supplier_ID`, `Supplier_name`, `Email`, `Phone_number`) VALUES
(1, 'Kader Enterprises', 'kaderrr@gmail.com', '7463821937');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_name` varchar(50) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_name`, `Name`, `Password`) VALUES
('admin', 'administrator', '$2y$10$sdYhdhYHH/YhI/DrnVvEku09g2I9bZ4q8fbYmyaW8pdvqBrTk98Kq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asset`
--
ALTER TABLE `asset`
  ADD PRIMARY KEY (`Barcode`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD PRIMARY KEY (`Check_ID`),
  ADD KEY `Employee_ID` (`Employee_ID`),
  ADD KEY `Barcode` (`Barcode`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`Employee_ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- Indexes for table `suppliedproduct`
--
ALTER TABLE `suppliedproduct`
  ADD PRIMARY KEY (`Supply_ID`),
  ADD KEY `Supplier_ID` (`Supplier_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Supplier_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `checkouts`
--
ALTER TABLE `checkouts`
  MODIFY `Check_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `Employee_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `suppliedproduct`
--
ALTER TABLE `suppliedproduct`
  MODIFY `Supply_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Supplier_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asset`
--
ALTER TABLE `asset`
  ADD CONSTRAINT `asset_ibfk_1` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);

--
-- Constraints for table `checkouts`
--
ALTER TABLE `checkouts`
  ADD CONSTRAINT `checkouts_ibfk_1` FOREIGN KEY (`Employee_ID`) REFERENCES `employee` (`Employee_ID`),
  ADD CONSTRAINT `checkouts_ibfk_2` FOREIGN KEY (`Barcode`) REFERENCES `asset` (`Barcode`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`Category_ID`) REFERENCES `category` (`Category_ID`);

--
-- Constraints for table `suppliedproduct`
--
ALTER TABLE `suppliedproduct`
  ADD CONSTRAINT `suppliedproduct_ibfk_1` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`Supplier_ID`),
  ADD CONSTRAINT `suppliedproduct_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `product` (`Product_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
