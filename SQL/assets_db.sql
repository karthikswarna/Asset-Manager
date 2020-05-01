-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2020 at 10:48 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assets_db`
--

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
('IITT-7-Chairs-1', 7, 1, NULL),
('IITT-7-Chairs-2', 7, 1, NULL),
('IITT-7-Chairs-3', 7, 1, NULL),
('IITT-7-Chairs-4', 7, 1, NULL),
('IITT-7-Chairs-5', 7, 1, NULL),
('IITT-HPPavilion-1', 1, 0, NULL),
('IITT-HPPavilion-2', 1, 0, NULL),
('IITT-HPPavilion-3', 1, 0, NULL),
('IITT-HPPavilion-4', 1, 1, NULL),
('IITT-QuickHeal-1', 3, 0, '2021-07-30'),
('IITT-Table-1', 2, 0, NULL),
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
(6, 'Chair');

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
(3, 1, 'IITT-HPPavilion-1', NULL, '2020-04-26 19:15:06'),
(4, 1, 'IITT-Table-1', NULL, '2020-04-26 19:16:20'),
(5, 2, 'IITT-HPPavilion-2', NULL, '2020-04-26 19:17:18'),
(6, 3, 'IITT-HPPavilion-3', NULL, '2020-04-27 20:12:27');

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
(12, 'Kedar Krishna', 'Mechanical engineering', 'me17b014@iittp.ac.in', '654-654', '6654831465', '20200501223825.jpg');

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
(7, 6, 'Chairs', 'Chairs to sit', 5, '20200501170258.jpg');

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
(2, 1, 7, '2020-05-01', 5, 2500);

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
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `checkouts`
--
ALTER TABLE `checkouts`
  MODIFY `Check_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `Employee_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `suppliedproduct`
--
ALTER TABLE `suppliedproduct`
  MODIFY `Supply_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
