-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 08:08 AM
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
-- Database: `purchase_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `organization_assets`

--
CREATE TABLE organization (
    organization_name VARCHAR(100) NOT NULL,
    organization_manager VARCHAR(100) NOT NULL,
    organization_email VARCHAR(100) NOT NULL,
    organization_tel VARCHAR(15) NOT NULL
);


CREATE TABLE USERS (
    User_id INT NOT NULL PRIMARY KEY,
    User_name VARCHAR(100) NOT NULL,
    User_position VARCHAR(100) NOT NULL,
    User_organization VARCHAR(100) NOT NULL,
    User_email VARCHAR(100) NOT NULL
);


CREATE TABLE `organization_assets` (
  `id` int(11) NOT NULL,
  `device_type` varchar(50) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `specifications` varchar(255) NOT NULL,
  `warranty` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization_assets`
--

INSERT INTO `organization_assets` (`id`, `device_type`, `brand`, `model`, `specifications`, `warranty`) VALUES
(1, 'Laptop', 'Dell', 'Latitude', 'Intel Core i5, 8GB RAM, 256GB SSD', '2years'),
(2, 'Printer', 'HP', 'LaserJet', 'Monochrome, Duplex, Wireless', '2years'),
(3, 'Laptop', 'Dell', 'opticlecore', 'Intel Core i5, 8GB RAM, 256GB SSD', '2years'),
(5, 'Desktop', 'HP', 'Pavilion', 'Intel Core i7, 16GB RAM, 512GB SSD', '3years'),
(6, 'Keyboard', 'Logitech', 'K780', 'Wireless, Multi-device', '1year'),
(7, 'Mouse', 'Microsoft', 'Wireless Mobile Mouse 1850', 'Optical, Wireless', '1year'),
(8, 'Headset', 'Sennheiser', 'HD 280 PRO', 'Over-Ear, Closed-Back', '2years'),
(9, 'Laptop Bag', 'Samsonite', 'Classic Business 3-Gusset', 'Fits up to 15.6\" laptop', '5years'),
(10, 'Flash Drive', 'SanDisk', 'Ultra USB 3.0', '128GB, USB 3.0', '5years');

-- --------------------------------------------------------


--



-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `company_name` varchar(255) DEFAULT NULL,
  `company_managers` varchar(255) DEFAULT NULL,
  `company_licenses` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`company_name`, `company_managers`, `company_licenses`, `company_email`, `points`) VALUES
('Company1', 'Manager1', 'License1', 'company1@example.com', NULL),
('Company2', 'Manager2', 'License2', 'company2@example.com', NULL),
('Company3', 'Manager3', 'License3', 'company3@example.com', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organization_assets`
--
ALTER TABLE `organization_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_form_data`
--
ALTER TABLE `purchase_form_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organization_assets`
--
ALTER TABLE `organization_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_form_data`
--
ALTER TABLE `purchase_form_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
