-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2025 at 05:06 PM
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
-- Database: `car_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `fuel_type` enum('Petrol','Diesel','Electric','Hybrid') DEFAULT 'Petrol',
  `color` varchar(50) DEFAULT NULL,
  `seats` tinyint(4) DEFAULT 5,
  `transmission` enum('Manual','Automatic') DEFAULT 'Manual',
  `horsepower` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `name`, `brand`, `model`, `price`, `fuel_type`, `color`, `seats`, `transmission`, `horsepower`, `description`, `images`, `created_at`, `updated_at`) VALUES
(6, 'Golf', 'volswagen', 'GTD', 4000.00, 'Petrol', 'gray', 5, 'Manual', 400, 'best cars in fleet', '[\"car_69120750ae520.png\",\"car_69120765bdbcf.png\"]', '2025-11-10 15:40:00', '2025-11-10 15:40:21'),
(7, 'Volkswagen Touareg R-Line', 'Volkswagen', 'Touareg 2024', 850000.00, 'Diesel', 'Black Sapphire', 5, 'Automatic', 286, 'توارج R-Line فاخرة مع سقف بانورامي ونظام صوت Dynaudio - مثالية للطرق المغربية من الدار البيضاء إلى مراكش', '[\"touareg1.jpg\",\"touareg2.jpg\",\"touareg3.jpg\",\"touareg4.jpg\",\"touareg5.jpg\"]', '2025-11-10 16:05:56', '2025-11-10 16:05:56'),
(8, 'BMW 420d Pack M Convertible', 'BMW', '420d 2025', 920000.00, 'Diesel', 'Portimao Blue', 4, 'Automatic', 190, 'بي إم دبليو 420d كشف مع باك M كامل - متعة القيادة على كورنيش الرباط أو طريق أكادير', '[\"bmw420_1.jpg\",\"bmw420_2.jpg\",\"bmw420_3.jpg\",\"bmw420_4.jpg\",\"bmw420_5.jpg\"]', '2025-11-10 16:05:56', '2025-11-10 16:05:56'),
(9, 'Volkswagen T-Roc R', 'Volkswagen', 'T-Roc 2024', 480000.00, 'Petrol', 'Kings Red', 5, 'Automatic', 300, 'تي روك R رياضية 300 حصان - شبابية وسريعة لشوارع فاس وطنجة', '[\"troc1.jpg\",\"troc2.jpg\",\"troc3.jpg\",\"troc4.jpg\"]', '2025-11-10 16:05:56', '2025-11-10 16:05:56'),
(10, 'Volkswagen Golf 8 GTI', 'Volkswagen', 'Golf 8 2025', 520000.00, 'Petrol', 'Pure White', 5, 'Automatic', 245, 'غولف 8 GTI الأسطورية - أيقونة الشباب المغربي في الدار البيضاء', '[\"golf8_1.jpg\",\"golf8_2.jpg\",\"golf8_3.jpg\",\"golf8_4.jpg\",\"golf8_5.jpg\"]', '2025-11-10 16:05:56', '2025-11-10 16:05:56'),
(11, 'Toyota Land Cruiser Prado TXL', 'Toyota', 'Land Cruiser 2025', 1150000.00, 'Diesel', 'Attitude Black', 7, 'Automatic', 201, 'لاند كروزر برادو - ملك الطرق الوعرة في الأطلس والصحراء المغربية', '[\"landcruiser1.jpg\",\"landcruiser2.jpg\",\"landcruiser3.jpg\",\"landcruiser4.jpg\",\"landcruiser5.jpg\",\"landcruiser6.jpg\"]', '2025-11-10 16:05:56', '2025-11-10 16:05:56'),
(12, 'Renault Mégane 4 RS Trophy', 'Renault', 'Mégane 4 2024', 585000.00, 'Petrol', 'Orange Tonic', 5, 'Automatic', 300, 'ميغان 4 RS تروفي - الرياضية الفرنسية الأقوى في المغرب - 300 حصان من الدار البيضاء إلى أكادير', '[\"megane1.jpg\",\"megane2.jpg\",\"megane3.jpg\",\"megane4.jpg\",\"megane5.jpg\"]', '2025-11-10 16:05:56', '2025-11-10 16:05:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
