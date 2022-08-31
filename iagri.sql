-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2021 at 08:02 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iagri`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phoneNum` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`lastName`, `firstName`, `username`, `email`, `address`, `phoneNum`, `password`, `usertype`, `id`) VALUES
('Valdez', 'Ronald', 'Ron', 'RonValdez@yahoo.com', 'Paranaque City', '09768262822', '2ron', 'Buyer', 1),
('Valdez', 'Ronald', 'Ron1', 'RonValdez@yahoo.com', 'Paranaque City', '09768262822', '2ron', 'Buyer', 2);

-- --------------------------------------------------------

--
-- Table structure for table `buyer_item`
--

CREATE TABLE `buyer_item` (
  `item_id` int(50) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `image` blob NOT NULL,
  `price` int(50) NOT NULL,
  `quantity` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phoneNum` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `lastName`, `firstName`, `username`, `email`, `phoneNum`, `password`, `usertype`) VALUES
(1, 'Camerino', 'Cedrick', 'Kons', 'cedrickslash92@gmail.com', '09282720484', '123!@#', 'Client'),
(2, 'Camerino', 'Cedrick', 'Kons2', 'cedrickslash92@gmail.com', '09282720484', '123!@#', 'Client');

-- --------------------------------------------------------

--
-- Table structure for table `discussion`
--

CREATE TABLE `discussion` (
  `id` int(11) NOT NULL,
  `parent_comment` varchar(500) NOT NULL,
  `student` varchar(1000) NOT NULL,
  `post` varchar(1000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discussion`
--

INSERT INTO `discussion` (`id`, `parent_comment`, `student`, `post`, `date`) VALUES
(138, '0', 'B1', 'any tips on how to prevent pests from your crops?', '2021-10-28 14:42:17'),
(137, '136', 'Juan', 'ehem... that would be me.', '2021-10-28 14:39:16'),
(133, '0', 'Pedro', 'hi', '2021-10-28 14:35:56'),
(134, '133', 'Juan', 'Hello', '2021-10-28 14:36:35'),
(136, '0', 'Browny', 'Can anyone recommend me to the which seller sells the best cabbages? ', '2021-10-28 14:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `exchange`
--

CREATE TABLE `exchange` (
  `id` int(11) NOT NULL,
  `buyer_username_from` varchar(50) DEFAULT NULL,
  `buyer_username_to` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'PENDING',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exchange`
--

INSERT INTO `exchange` (`id`, `buyer_username_from`, `buyer_username_to`, `status`, `created_at`) VALUES
(1, 'Kons', 'Kons2', 'PENDING', '2021-11-18 20:12:41'),
(2, 'Kons2', 'Kons', 'APPROVED', '2021-11-19 10:11:56'),
(3, 'Kons2', 'Kons', 'APPROVED', '2021-11-19 10:12:32'),
(4, 'Kons2', 'Kons', 'APPROVED', '2021-11-19 10:13:08'),
(5, 'Kons2', 'Kons', 'APPROVED', '2021-11-19 10:13:18'),
(6, 'Kons2', 'Kons', 'PENDING', '2021-11-19 10:13:39'),
(7, 'Kons2', 'Kons1', 'PENDING', '2021-11-19 10:14:03'),
(8, 'Kons', 'Kons2', 'PENDING', '2021-11-19 12:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `exchange_items`
--

CREATE TABLE `exchange_items` (
  `id` int(11) NOT NULL,
  `person_num` int(11) DEFAULT NULL,
  `exchange_id` int(11) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_unit` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exchange_items`
--

INSERT INTO `exchange_items` (`id`, `person_num`, `exchange_id`, `product_name`, `quantity`, `product_unit`) VALUES
(1, 1, 1, 'Cucumber', 4, NULL),
(2, 1, 2, 'QWEQW', 3, 'per Kilo'),
(3, 1, 2, 'QWEQ', 1, 'per Half Kilo'),
(4, 2, 2, 'FFF', 0, 'per Kilo'),
(5, 2, 2, 'DSS', 1, 'per Kilo'),
(6, 1, 3, 'QWEQW1', 3, 'per Kilo'),
(7, 1, 3, 'QWEQ1', 1, 'per Half Kilo'),
(8, 2, 3, 'FFF2', 0, 'per Kilo'),
(9, 2, 3, 'DSS2', 1, 'per Kilo'),
(10, 1, 4, '232', 0, 'per Kilo'),
(11, 2, 4, '2342', 0, 'per Kilo'),
(12, 1, 5, 'ERWE', 0, 'per Kilo'),
(13, 2, 5, 'FFF', 0, 'per Kilo'),
(14, 1, 6, 'qweq', 0, 'per Kilo'),
(15, 2, 6, 'qwe', 0, 'per Kilo'),
(16, 1, 7, 'qweqw', 0, 'per Kilo'),
(17, 2, 7, '1123', 0, 'per Kilo'),
(18, 1, 8, 'cucumber', 1, 'per Sack'),
(19, 1, 8, 'squash', 2, 'per Box'),
(20, 2, 8, 'okra', 5, 'per Box'),
(21, 2, 8, 'qwe', 4, 'per Kilo'),
(22, 2, 8, '13', 43, 'per Kilo'),
(23, 2, 8, '34', 3, 'per Kilo');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `name`, `price`, `quantity`, `created_at`) VALUES
(1, 'wrqwe', 2, 3, '2021-11-17 13:00:07'),
(2, 'qweqw', 321, 4, '2021-11-17 14:26:45'),
(3, 'qweqw', 12314, 123, '2021-11-18 17:51:22'),
(4, 'qweqw', 12314, 123, '2021-11-18 17:51:27'),
(5, 'qweqw', 123, 123, '2021-11-18 17:52:13'),
(6, '11', 1, 11, '2021-11-18 17:52:17'),
(7, 'NEW EXPENSE1', 312, 1, '2021-11-18 18:28:05'),
(8, 'WQERWER', 234, 23, '2021-11-18 18:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `buyer_username` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `order_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `buyer_username`, `item_id`, `quantity`, `price`, `created_at`, `order_id`) VALUES
(1, 'Ron', 1, NULL, NULL, '2021-11-16 14:11:50', 0),
(2, 'Ron', 4, NULL, NULL, '2021-11-16 14:11:50', 0),
(3, 'Ron', 6, NULL, NULL, '2021-11-16 14:11:50', 0),
(4, 'Ron', 1, 2, 160, '2021-11-16 14:13:30', 0),
(5, 'Ron', 4, 1, 100, '2021-11-16 14:13:31', 0),
(6, 'Ron', 6, 1, 125, '2021-11-16 14:13:31', 0),
(7, '', 4, 1, 100, '2021-11-17 02:01:25', 1),
(8, '', 5, 1, 299, '2021-11-17 02:01:25', 1),
(9, 'GUEST', 4, 1, 100, '2021-11-17 02:02:08', 2),
(10, 'GUEST', 5, 1, 299, '2021-11-17 02:02:08', 2),
(11, 'GUEST', 1, 1, 100, '2021-11-17 02:02:20', 3),
(12, 'GUEST', 6, 1, 299, '2021-01-17 02:02:20', 3),
(13, 'Kons', 14, 1, 90, '2021-11-17 14:24:34', 4),
(14, 'Kons', 14, 1, 90, '2021-11-17 14:24:54', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(50) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `name`, `image`, `price`, `quantity`, `sku`, `unit`, `created_at`) VALUES
(4, 'Tomato', 'img-tomato.png', 100.00, -19, 'TOM', 'per Sack', '2021-11-17 05:38:07'),
(5, 'Eggplant', '5.jpg', 299.00, -10, 'EGP', 'per Kilo', '2021-11-17 05:38:07'),
(6, 'Broccoli', '6.jpg', 125.00, -9, 'BRL', 'per Sack', '2021-11-17 05:38:07'),
(1, 'Cucumber', '1.jpg', 160.00, 12, '0', 'per Box', '2021-11-17 05:38:07'),
(7, 'qweq', '1.jpg', 0.00, 0, '0', 'per Kilo', '2021-11-17 05:41:26'),
(14, 'PPR3', 'img-pprod1.png', 90.00, 0, '0', 'per Half Kilo', '2021-11-17 12:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `usertype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`usertype`) VALUES
('Client'),
('Buyer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer_item`
--
ALTER TABLE `buyer_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discussion`
--
ALTER TABLE `discussion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchange`
--
ALTER TABLE `exchange`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exchange_items`
--
ALTER TABLE `exchange_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discussion`
--
ALTER TABLE `discussion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `exchange`
--
ALTER TABLE `exchange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `exchange_items`
--
ALTER TABLE `exchange_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
