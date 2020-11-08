-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2020 at 03:02 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invpos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `catid` int(11) NOT NULL,
  `category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`catid`, `category`) VALUES
(1, 'Electronics'),
(5, 'Food'),
(7, 'new ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(11) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `order_date` date NOT NULL,
  `subtotal` double NOT NULL,
  `tax` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`invoice_id`, `customer_name`, `order_date`, `subtotal`, `tax`, `discount`, `total`, `paid`, `due`, `payment_type`) VALUES
(10, 'Mayank', '2020-11-01', 77998, 6239.84, 0, 84237.84, 0, 84237.84, 'Check'),
(11, 'Prateek', '2020-10-31', 65099, 5207.92, 0, 70306.92, 0, 70306.92, 'Card'),
(13, 'Shelly', '2020-11-02', 160108, 12808.64, 0, 172916.64, 100000, 72916.64, 'Check'),
(14, 'Shreya', '2020-09-02', 28999, 2319.92, 0, 31318.92, 0, 31318.92, 'Card'),
(15, 'vaibhav', '2020-08-02', 241998, 19359.84, 0, 261357.84, 100000, 161357.84, 'Cash'),
(16, 'xyz', '2020-11-03', 242018, 19361.44, 100, 261279.44, 100000, 161279.44, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_details`
--

CREATE TABLE `tbl_invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_invoice_details`
--

INSERT INTO `tbl_invoice_details` (`id`, `invoice_id`, `product_id`, `product_name`, `quantity`, `price`, `order_date`) VALUES
(12, 10, 6, 'Oneplus 6T', 2, 38999, '2020-11-01'),
(13, 11, 9, 'IPhone 11', 1, 64999, '2020-10-31'),
(14, 11, 4, 'Hershey', 5, 20, '2020-10-31'),
(19, 13, 6, 'Oneplus 6T', 1, 38999, '2020-11-02'),
(20, 13, 10, 'Macbook Pro', 1, 120999, '2020-11-02'),
(21, 13, 5, 'Amul Icecream', 1, 110, '2020-11-02'),
(22, 14, 7, 'OnePlus Nord', 1, 28999, '2020-09-02'),
(23, 15, 10, 'Macbook Pro', 2, 120999, '2020-08-02'),
(24, 16, 10, 'Macbook Pro', 2, 120999, '2020-11-03'),
(25, 16, 4, 'Hershey', 1, 20, '2020-11-03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pid` int(11) NOT NULL,
  `pname` varchar(200) NOT NULL,
  `pcategory` varchar(200) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL,
  `pstock` int(11) NOT NULL,
  `pdescription` varchar(300) NOT NULL,
  `pimage` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pid`, `pname`, `pcategory`, `purchaseprice`, `saleprice`, `pstock`, `pdescription`, `pimage`) VALUES
(4, 'Hershey', 'Food', 10, 20, 3, 'HERSHEY\'S COOKIES \'N\' CREME Snack Size Candy Bars, 17.1 oz bag', '5f801af9396c6.jpg'),
(5, 'Amul Icecream', 'Food', 100, 110, 20, 'Amul Vanilla Ice Cream 2Ltr', '5f801b861a219.jpg'),
(6, 'Oneplus 6T', 'Electronics', 35999, 38999, 147, '6GB + 64GB\r\n6GB + 128GB\r\n8GB + 128GB', '5f9e8e4da31b8.jpg'),
(7, 'OnePlus Nord', 'Electronics', 25999, 28999, 250, '8GB  + 128GB\r\n10GB + 256 GB', '5f9e8eb0e1d9f.jpg'),
(8, 'OnePlus Buds', 'Electronics', 4599, 4999, 300, 'Noise Cancellation\r\nTruly Wireless', '5f9e8f3698980.jpg'),
(9, 'IPhone 11', 'Electronics', 59999, 64999, 199, 'A14 Bionic Chip', '5f9e8f71c4e89.jpg'),
(10, 'Macbook Pro', 'Electronics', 112999, 120999, 70, 'TouchScreen Available', '5f9e8fbb36978.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `useremail`, `password`, `role`) VALUES
(1, 'Mayank Kilhor', 'mayank@gmail.com', '1234', 'Admin'),
(14, 'Prateek ', 'xyz@gmail.com', '1234', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
