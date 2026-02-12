-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql102.infinityfree.com
-- Generation Time: Feb 11, 2026 at 09:58 PM
-- Server version: 11.4.10-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41133223_healthsync_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_addresses`
--

CREATE TABLE `tbl_addresses` (
  `add_id` bigint(15) NOT NULL,
  `usact_id` bigint(15) DEFAULT NULL,
  `add_fName` varchar(50) NOT NULL,
  `add_mName` varchar(50) DEFAULT NULL,
  `add_sName` varchar(50) NOT NULL,
  `add_phone` varchar(20) NOT NULL,
  `add_street_addr` varchar(100) NOT NULL,
  `add_postal_code` varchar(10) NOT NULL,
  `add_barangay` varchar(50) NOT NULL,
  `add_city` varchar(50) NOT NULL,
  `add_province` varchar(50) NOT NULL,
  `add_region` varchar(50) NOT NULL,
  `add_is_default` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_addresses`
--

INSERT INTO `tbl_addresses` (`add_id`, `usact_id`, `add_fName`, `add_mName`, `add_sName`, `add_phone`, `add_street_addr`, `add_postal_code`, `add_barangay`, `add_city`, `add_province`, `add_region`, `add_is_default`) VALUES
(1, 1, 'franz', 'wala', 'sambrano ', '9949494646', 'payatas', '1119', 'payatas', 'qc', 'metro manila', 'ncr', 1),
(2, 3, 'Lizette', '', 'Ylagan', '9624082691', 'b3 l6', '1117', 'Santa Monica', 'Quezon City', 'Metro Manila', 'NCR', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` bigint(15) NOT NULL,
  `admin_fName` varchar(50) NOT NULL,
  `admin_mName` varchar(50) DEFAULT NULL,
  `admin_sName` varchar(50) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_fName`, `admin_mName`, `admin_sName`, `admin_email`, `admin_password`, `deleted_at`) VALUES
(1, 'Liz', 'Sy', 'Ylagan', 'liz12@admin.com', 'liz123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_activity`
--

CREATE TABLE `tbl_admin_activity` (
  `activity_id` bigint(15) NOT NULL,
  `admin_id` bigint(15) DEFAULT NULL,
  `action_type` varchar(50) DEFAULT NULL,
  `target_table` varchar(50) DEFAULT NULL,
  `target_id` bigint(15) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `activity_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_history`
--

CREATE TABLE `tbl_admin_history` (
  `history_id` bigint(15) NOT NULL,
  `admin_id` bigint(15) DEFAULT NULL,
  `table_name` varchar(100) NOT NULL COMMENT 'Target table modified',
  `record_id` bigint(15) NOT NULL COMMENT 'ID of modified record',
  `action` varchar(50) NOT NULL COMMENT 'INSERT/UPDATE/SOFT_DELETE',
  `old_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Pre-change state (JSON)',
  `new_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Post-change state (JSON)',
  `change_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Detailed audit trail of admin data modifications';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` bigint(15) NOT NULL,
  `usact_id` bigint(15) NOT NULL,
  `prod_id` bigint(15) NOT NULL,
  `cart_quantity` int(11) DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` bigint(15) NOT NULL,
  `usact_id` bigint(15) NOT NULL,
  `usact_fname` varchar(100) NOT NULL,
  `usact_sname` varchar(100) NOT NULL,
  `add_id` bigint(15) NOT NULL,
  `order_address` text NOT NULL,
  `order_phone` varchar(20) NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `order_status` enum('Pending','Ready for Pickup','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `payment_status` enum('Unpaid','Paid','Refunded') DEFAULT 'Unpaid',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_id`, `usact_id`, `usact_fname`, `usact_sname`, `add_id`, `order_address`, `order_phone`, `order_total`, `order_status`, `payment_status`, `order_date`, `deleted_at`) VALUES
(1, 3, 'Lizette', 'Ylagan', 2, 'b3 l6, Santa Monica, Quezon City, Metro Manila, NCR, 1117 (Method: store_pickup)', '9624082691', '350.00', 'Delivered', 'Paid', '2026-02-12 02:21:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_items`
--

CREATE TABLE `tbl_order_items` (
  `order_item_id` bigint(15) NOT NULL,
  `order_id` bigint(15) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL,
  `total_item_price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_order_items`
--

INSERT INTO `tbl_order_items` (`order_item_id`, `order_id`, `prod_id`, `prod_name`, `quantity`, `price_at_purchase`, `total_item_price`) VALUES
(1, 1, 1, 'HealthSync Wearable Device V1.0', 1, '350.00', '350.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_methods`
--

CREATE TABLE `tbl_payment_methods` (
  `pay_id` bigint(15) NOT NULL,
  `usact_id` bigint(15) NOT NULL,
  `card_holder_name` varchar(150) NOT NULL,
  `card_number_masked` varchar(20) NOT NULL,
  `expiry_date` varchar(7) NOT NULL,
  `card_type` enum('Visa','Mastercard','JCB','Other') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `prod_id` bigint(15) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_description` text DEFAULT NULL,
  `prod_price` decimal(10,2) NOT NULL,
  `prod_quantity` int(11) NOT NULL,
  `prod_image` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`prod_id`, `prod_name`, `prod_description`, `prod_price`, `prod_quantity`, `prod_image`, `deleted_at`) VALUES
(1, 'HealthSync Wearable Device V1.0', 'A wearable device for hypersensitive individuals that detects environmental factors such as sound levels, light intensity, temperature, and user heart rate.', '350.00', 50, 'uploads/products/1770825235_device.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usact_history`
--

CREATE TABLE `tbl_usact_history` (
  `history_id` bigint(15) NOT NULL,
  `usact_id` bigint(15) DEFAULT NULL,
  `usact_fName` varchar(50) DEFAULT NULL,
  `usact_sName` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `changed_by_id` bigint(15) DEFAULT NULL,
  `changed_by_role` enum('Admin','User') DEFAULT NULL,
  `change_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_account`
--

CREATE TABLE `tbl_user_account` (
  `usact_id` bigint(15) NOT NULL,
  `usact_username` varchar(50) NOT NULL,
  `usact_fName` varchar(50) NOT NULL,
  `usact_mName` varchar(50) DEFAULT NULL,
  `usact_sName` varchar(50) NOT NULL,
  `usact_email` varchar(100) NOT NULL,
  `usact_password` varchar(255) NOT NULL,
  `usact_phone` varchar(20) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user_account`
--

INSERT INTO `tbl_user_account` (`usact_id`, `usact_username`, `usact_fName`, `usact_mName`, `usact_sName`, `usact_email`, `usact_password`, `usact_phone`, `deleted_at`) VALUES
(1, 'Yuki', 'ako', 'wala', 'Ako to', 'prans@fb.com', '$2y$10$Ah2F2v8Ac5E87MWtLUatz.XEqn.QIQeClBly8VavwSg0lyy0o5dvC', '', NULL),
(2, 'fergouser', 'Fergo Emson', 'Amante', 'Salalac', 'emsonsalalac@gmail.com', '$2y$10$Qq3BbVnkFNXnSUHr.n9P9e9XbQOcQStVK2X5pyEkamdUwiIwJD5pK', '', NULL),
(3, 'liz11', 'Lizzie', 'Sy', 'Ylagan', 'lizziexx02@gmail.com', '$2y$10$DQMwcIuvrywdw06padPnD.ZYr75ryzv95.09Q8hDEfVGHML5xz7by', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_addresses`
--
ALTER TABLE `tbl_addresses`
  ADD PRIMARY KEY (`add_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`);

--
-- Indexes for table `tbl_admin_activity`
--
ALTER TABLE `tbl_admin_activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `tbl_admin_history`
--
ALTER TABLE `tbl_admin_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `table_record` (`table_name`,`record_id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `usact_id` (`usact_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `tbl_orders_ibfk_1` (`usact_id`),
  ADD KEY `tbl_orders_ibfk_2` (`add_id`);

--
-- Indexes for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `tbl_payment_methods`
--
ALTER TABLE `tbl_payment_methods`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `usact_id` (`usact_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_usact_history`
--
ALTER TABLE `tbl_usact_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `usact_id` (`usact_id`),
  ADD KEY `changed_by_id` (`changed_by_id`);

--
-- Indexes for table `tbl_user_account`
--
ALTER TABLE `tbl_user_account`
  ADD PRIMARY KEY (`usact_id`),
  ADD UNIQUE KEY `usact_email` (`usact_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_addresses`
--
ALTER TABLE `tbl_addresses`
  MODIFY `add_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_admin_activity`
--
ALTER TABLE `tbl_admin_activity`
  MODIFY `activity_id` bigint(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin_history`
--
ALTER TABLE `tbl_admin_history`
  MODIFY `history_id` bigint(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  MODIFY `order_item_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_payment_methods`
--
ALTER TABLE `tbl_payment_methods`
  MODIFY `pay_id` bigint(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `prod_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_usact_history`
--
ALTER TABLE `tbl_usact_history`
  MODIFY `history_id` bigint(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_account`
--
ALTER TABLE `tbl_user_account`
  MODIFY `usact_id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admin_activity`
--
ALTER TABLE `tbl_admin_activity`
  ADD CONSTRAINT `fk_admin_activity_admin` FOREIGN KEY (`admin_id`) REFERENCES `tbl_admin` (`admin_id`) ON DELETE SET NULL;

--
-- Constraints for table `tbl_admin_history`
--
ALTER TABLE `tbl_admin_history`
  ADD CONSTRAINT `fk_admin_history_admin` FOREIGN KEY (`admin_id`) REFERENCES `tbl_admin` (`admin_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
