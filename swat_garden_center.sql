-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2026 at 10:03 PM
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
-- Database: `swat_garden_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `expense_date` datetime DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `expense_date`, `amount`, `description`) VALUES
(1, '2026-05-07 23:53:28', 800.00, 'food'),
(3, '2026-05-08 21:15:39', 1000.00, 'rent'),
(4, '2026-05-06 21:16:23', 3000.00, 'fertilizer');

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE `plants` (
  `plant_id` int(11) NOT NULL,
  `plant_name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `light_requirement` varchar(100) DEFAULT NULL,
  `water_frequency` varchar(100) DEFAULT NULL,
  `temp_min` int(11) DEFAULT NULL,
  `temp_max` int(11) DEFAULT NULL,
  `maintenance_level` varchar(50) DEFAULT NULL,
  `growth_rate` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `expert_score` decimal(3,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`plant_id`, `plant_name`, `category`, `type`, `light_requirement`, `water_frequency`, `temp_min`, `temp_max`, `maintenance_level`, `growth_rate`, `price`, `stock_quantity`, `expert_score`) VALUES
(1, 'Ficus pumilo (bag)', 'outdoor', 'Creeper', 'medium', '2days', 2, 45, 'low', 'medium', 100.00, 100, 10.0),
(2, 'Golden Shower plant 12\"', 'outdoor', 'Creeper', 'medium', '3days', 5, 45, 'medum', 'medium', 1200.00, 5, 10.0),
(3, 'Virginia creeper', 'outdoor', 'Creeper', 'medium', '3days', 5, 45, 'medum', 'medium', 500.00, 5, 10.0),
(4, 'Orange flower creeper', 'outdoor', 'Creeper', 'medium', '3days', 5, 45, 'medum', 'medium', 1200.00, 5, 10.0),
(5, 'Rose/gulab (bag)', 'outdoor', 'Creeper', 'high', '3days', 2, 45, 'medum', 'medium', 150.00, 100, 9.0),
(6, 'Rose/gulab 12 inch pot', 'outdoor', 'Creeper', 'high', '3days', 2, 45, 'medum', 'medium', 800.00, 100, 9.0),
(7, 'Lantana creeper', 'outdoor', 'Creeper', 'high', '3days', 2, 45, 'medum', 'medium', 150.00, 100, 9.0),
(8, 'Ficus pumilo pot creeper', 'outdoor', 'Creeper', 'medium', '3days', 2, 45, 'medum', 'medium', 250.00, 100, 9.0),
(9, 'Jasmine grandiflora creeper', 'outdoor', 'Creeper', 'high', '3days', 2, 45, 'medum', 'medium', 150.00, 100, 9.0),
(10, 'Yucca large', 'outdoor & indoor', 'Desert plant', 'medium', '7days', 8, 50, 'low', 'low', 2500.00, 20, 10.0),
(11, 'Yucca small (6inch)', 'outdoor & indoor', 'Desert plant', 'medium', '7days', 8, 50, 'low', 'low', 300.00, 20, 10.0),
(12, 'Amaryllis lily flower large', 'outdoor', 'flowers', 'medium', '3days', 2, 40, 'low', 'medium', 300.00, 30, 9.0),
(13, 'Amaryllis lily flower small', 'outdoor', 'flowers', 'medium', '3days', 2, 40, 'low', 'medium', 200.00, 30, 9.0),
(14, 'Diathus/carnation flower', 'outdoor', 'Flowers', 'high', '2days', 8, 45, 'medum', 'medium', 50.00, 100, 10.0),
(15, 'Celocia mix color', 'outdoor', 'Flowers', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(16, 'Pansy', 'outdoor', 'Flowers', 'high', '2days', 8, 45, 'medum', 'medium', 50.00, 100, 10.0),
(17, 'Petunia', 'outdoor', 'Flowers', 'high', '2days', 8, 45, 'medum', 'medium', 50.00, 100, 10.0),
(18, 'Ranancolus', 'outdoor', 'Flowers', 'high', '2days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(19, 'Gazania', 'outdoor', 'Flowers', 'high', '2days', 8, 45, 'medum', 'medium', 60.00, 100, 10.0),
(20, 'vinca', 'outdoor', 'Flowers', 'high', '2days', 8, 45, 'medum', 'medium', 80.00, 100, 10.0),
(21, 'Rubinia/keekar (3-5 feet)', 'outdoor', 'Forest', 'high', '7days', 5, 45, 'low', 'medium', 30.00, 100, 10.0),
(22, 'Rubinia/keekar (3-5 feet)', 'outdoor', 'Forest', 'high', '7days', 5, 45, 'low', 'medium', 30.00, 100, 10.0),
(23, 'Draik/Shandai (3-5 feet)', 'outdoor', 'Forest', 'high', '7days', 5, 40, 'low', 'medium', 30.00, 100, 10.0),
(24, 'Chinar (3-5 feet)', 'outdoor', 'Forest', 'high', '7days', 5, 40, 'low', 'medium', 150.00, 100, 10.0),
(25, 'Chinar (5-8 feet)', 'outdoor', 'Forest', 'high', '7days', 5, 40, 'low', 'medium', 500.00, 40, 10.0),
(26, 'Oak/Drawa (1-1.5 feet)', 'outdoor', 'Forest', 'high', '7days', 2, 40, 'low', 'medium', 60.00, 100, 10.0),
(27, 'Oak/Drawa (2-4 feet)', 'outdoor', 'Forest', 'high', '7days', 2, 40, 'low', 'medium', 190.00, 100, 10.0),
(28, 'Ailanthus (3-5feet)', 'outdoor', 'Forest', 'high', '7days', 5, 45, 'low', 'medium', 40.00, 100, 10.0),
(29, 'Sufaida delta (small and large)', 'outdoor', 'Forest', 'high', '7days', 5, 45, 'low', 'medium', 40.00, 500, 10.0),
(30, 'Sufaida normal  (small and large)', 'outdoor', 'Forest', 'high', '7days', 5, 45, 'low', 'medium', 40.00, 500, 10.0),
(31, 'Lychee', 'outdoor', 'Fruit', 'high', '3days', 5, 45, 'medum', 'medium', 2000.00, 5, 10.0),
(32, 'Zaitoon/Olive (bag) small', 'outdoor', 'Fruit', 'high', '3days', 2, 45, 'low', 'medium', 300.00, 10, 10.0),
(33, 'Zaitoon/Olive (bag) large', 'outdoor', 'Fruit', 'high', '7days', 2, 45, 'low', 'medium', 700.00, 10, 10.0),
(34, 'Plum/Alocha (early beauty,fazli manani)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 180.00, 100, 10.0),
(35, 'Pear/Nashpati ', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'medum', 'medium', 180.00, 100, 10.0),
(36, 'Peach/aro (earlygrand, floridaking, 8 No.)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'high', 'medium', 190.00, 100, 10.0),
(37, 'Pomegranate/Anar (Qandahari, turnab gulabi)', 'outdoor', 'Fruit', 'high', '7days', 2, 45, 'medum', 'medium', 180.00, 100, 10.0),
(38, 'Fig/enjeer (Black, White, sheikh zayedi)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 250.00, 100, 10.0),
(39, 'Guava/amrud (white, red, round, thai)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 200.00, 100, 10.0),
(40, 'Khubani/apricot (Badami, yellow)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'medum', 'medium', 260.00, 100, 10.0),
(41, 'Malta/red blood oranges (Palai)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 250.00, 100, 10.0),
(42, 'Lemon (danedar)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 700.00, 100, 10.0),
(43, 'Lemon (China/kaghazi, seedless, lisban)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 280.00, 100, 10.0),
(44, 'Lemon/norangi', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 700.00, 100, 10.0),
(45, 'Kamquat (small)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 250.00, 100, 10.0),
(46, 'Kamquat (danedar)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 1000.00, 100, 10.0),
(47, 'Mango (Chonsa, shane khuda)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'medum', 'medium', 1500.00, 100, 10.0),
(48, 'Banana ', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'medum', 'medium', 350.00, 100, 10.0),
(49, 'Lougat (Grafted)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 350.00, 100, 10.0),
(50, 'Lougat (Seedling)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 200.00, 100, 10.0),
(51, 'Walnut/akhroot (grafted)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 350.00, 100, 10.0),
(52, 'Walnut/akhroot (seedling)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 150.00, 100, 10.0),
(53, 'Apple (Goldern, franci, ana)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 200.00, 100, 10.0),
(54, 'Amlook/persimon', 'outdoor', 'Fruit', 'high', '7days', 5, 40, 'low', 'medium', 260.00, 100, 10.0),
(55, 'Almond/Badam', 'outdoor', 'Fruit', 'high', '7days', 5, 40, 'low', 'medium', 350.00, 100, 10.0),
(56, 'Pecan (grafted)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 700.00, 100, 10.0),
(57, 'Pecan (seedling)', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 150.00, 100, 10.0),
(58, 'Litchi (gola)', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 700.00, 100, 10.0),
(59, 'Kino', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(60, 'Galgal', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 700.00, 100, 10.0),
(61, 'Fruiter', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 350.00, 100, 9.0),
(62, 'Meetha', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 350.00, 100, 9.0),
(63, 'Chakutra', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'low', 'medium', 700.00, 100, 10.0),
(64, 'Grapes (Sundarkhani, Seedless, Blacknar, china)', 'outdoor', 'Fruit', 'high', '7days', 10, 45, 'medum', 'medium', 200.00, 100, 10.0),
(65, 'Papaya/papeeta', 'outdoor', 'Fruit', 'high', '7days', 5, 45, 'medum', 'medium', 500.00, 100, 10.0),
(66, 'Avocado (small)', 'outdoor', 'Fruit', 'high', '7days', 5, 40, 'low', 'medium', 500.00, 100, 10.0),
(67, 'Avocado (large)', 'outdoor', 'Fruit', 'high', '7days', 5, 40, 'low', 'medium', 1200.00, 100, 10.0),
(68, 'Dragon fruit', 'outdoor', 'Fruit', 'high', '7days', 5, 45, 'medum', 'medium', 700.00, 100, 10.0),
(69, 'Pista', 'outdoor', 'Fruit', 'high', '7days', 5, 40, 'medum', 'medium', 700.00, 100, 9.0),
(70, 'Cashew net/Kajo', 'outdoor', 'Fruit', 'high', '7days', 5, 45, 'medum', 'medium', 700.00, 100, 10.0),
(71, 'Blackberry', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 500.00, 100, 10.0),
(72, 'Elaichi', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 3500.00, 100, 10.0),
(73, 'Rasberry', 'outdoor', 'Fruit', 'high', '7days', 2, 40, 'low', 'medium', 500.00, 100, 9.0),
(74, 'Passion fruit', 'outdoor', 'Fruit', 'high', '7days', 5, 45, 'medum', 'medium', 250.00, 100, 10.0),
(75, 'Kewi', 'outdoor', 'Fruit', 'high', '7days', 5, 45, 'medum', 'medium', 400.00, 100, 9.0),
(76, 'Cheko large growbag/pot', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'medum', 'medium', 3500.00, 100, 10.0),
(77, 'Cheko small', 'outdoor', 'Fruit', 'high', '7days', 8, 45, 'medum', 'medium', 700.00, 100, 10.0),
(78, 'Cherry', 'outdoor', 'Fruit', 'high', '7days', 2, 45, 'medum', 'medium', 350.00, 100, 10.0),
(79, 'Ruellia (bag)', 'outdoor', 'ground cover', 'high', '1day', 5, 40, 'medum', 'medium', 80.00, 50, 9.0),
(80, 'Ruellia (pot)', 'outdoor', 'ground cover', 'high', '1day', 5, 40, 'medum', 'medium', 300.00, 50, 9.0),
(81, 'Gazania bag', 'outdoor', 'ground cover', 'high', '1day', 2, 40, 'medum', 'high', 40.00, 100, 10.0),
(82, 'Gazania pot', 'outdoor', 'ground cover', 'high', '1day', 2, 40, 'medum', 'high', 80.00, 100, 10.0),
(83, 'Cophea (vinca) ground cover like duranta', 'outdoor', 'ground cover', 'high', '2days', 8, 45, 'medum', 'medium', 50.00, 100, 10.0),
(84, 'Ribbon grass (mix design)', 'outdoor', 'ground cover', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 10.0),
(85, 'Asparagus', 'outdoor', 'ground cover', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(86, 'Stevia', 'outdoor', 'ground cover', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 10.0),
(87, 'Tradescantia/hanging', 'outdoor', 'ground cover', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(88, 'wedalia, hanging yellow flower', 'outdoor', 'ground cover', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(89, 'Spider plant', 'outdoor', 'ground cover', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 10.0),
(90, 'Rosemary (bag)', 'outdoor', 'Herbal', 'medium', '3days', 2, 40, 'medum', 'medium', 130.00, 100, 10.0),
(91, 'Rosemary (pot)', 'outdoor', 'Herbal', 'medium', '3days', 2, 40, 'medum', 'medium', 250.00, 100, 10.0),
(92, 'Phoenix palm (12\" pot)', 'outdoor & indoor', 'Palm', 'medium', '3days', 5, 40, 'low', 'medium', 450.00, 40, 10.0),
(93, 'Phoenix palm(small pot)', 'outdoor & indoor', 'Palm', 'medium', '3days', 5, 45, 'low', 'medium', 250.00, 40, 10.0),
(94, 'Lady palm/Raphis 12\" pot', 'outdoor & indoor', 'Palm', 'medium', '3days', 5, 40, 'low', 'medium', 450.00, 40, 10.0),
(95, 'Phoenix palm large (concrete pot)', 'outdoor & indoor', 'Palm', 'medium', '3days', 5, 45, 'low', 'medium', 4500.00, 10, 10.0),
(96, 'Washingtonia large 3-5feet CT', 'outdoor', 'Palm', 'high', '5days', 5, 45, 'low', 'medium', 8000.00, 10, 10.0),
(97, 'Washingtonia large 5-8 feet CT', 'outdoor', 'Palm', 'high', '5days', 5, 45, 'low', 'medium', 14000.00, 10, 10.0),
(98, 'Washingtonia large12 inch pot', 'outdoor & indoor', 'Palm', 'high', '5days', 5, 45, 'low', 'medium', 300.00, 50, 10.0),
(99, 'Foxtail palm 2-4 feet CT', 'outdoor', 'Palm', 'medium', '5days', 5, 45, 'low', 'medium', 2500.00, 5, 8.0),
(100, 'Foxtail palm 4-6 feet CT', 'outdoor', 'Palm', 'medium', '5days', 5, 45, 'low', 'medium', 4500.00, 5, 8.0),
(101, 'Phoenix palm (bag)', 'outdoor & indoor', 'Palm', 'medium', '3days', 5, 45, 'low', 'medium', 200.00, 10, 10.0),
(102, 'Can palm 12inch', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 350.00, 100, 10.0),
(103, 'Alexandra palm 18inch', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 4500.00, 100, 10.0),
(104, 'Golden palm 12 inch', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 450.00, 100, 10.0),
(105, 'Cat palm 12 inch', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 500.00, 100, 10.0),
(106, 'Ravena palm 18 inch', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 4500.00, 100, 10.0),
(107, 'Areca palm 12 inch', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 500.00, 100, 10.0),
(108, 'Phonenix palm 10inch', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(109, 'Washingtonia small', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 200.00, 100, 10.0),
(110, 'Ravanela/banana palm', 'outdoor', 'Palm', 'high', '2days', 8, 45, 'medum', 'medium', 1500.00, 100, 10.0),
(111, 'Cestrum diurnam-Din ka raja (bag)', 'outdoor', 'Shrub', 'high', '2days', 2, 45, 'medum', 'medium', 50.00, 20, 6.0),
(112, 'Jasmine single creeper bag', 'outdoor', 'Shrub', 'high', '2days', 5, 45, 'low', 'medium', 100.00, 100, 9.0),
(113, 'Lemon grass (green tea bag)', 'outdoor', 'Shrub', 'high', '2days', 5, 45, 'low', 'high', 100.00, 100, 10.0),
(114, 'Lemon grass (green tea pot)', 'outdoor', 'Shrub', 'high', '2days', 5, 45, 'low', 'high', 150.00, 100, 10.0),
(115, 'Moon ficus dwarf', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'low', 200.00, 50, 10.0),
(116, 'Dracena Corn plant 12\"', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 35, 'low', 'low', 300.00, 50, 10.0),
(117, 'Murraya 12\" (marwa)', 'outdoor', 'Shrub', 'high', '3days', 5, 45, 'medum', 'high', 300.00, 50, 9.0),
(118, 'Eunonymus 12\" pot', 'outdoor & indoor', 'Shrub', 'medium', '5days', 2, 40, 'low', 'medium', 300.00, 40, 10.0),
(119, 'Eunonymus 6\"', 'outdoor & indoor', 'Shrub', 'medium', '5days', 2, 40, 'low', 'medium', 200.00, 40, 10.0),
(120, 'Gulab english', 'outdoor', 'Shrub', 'medium', '3days', 5, 45, 'medum', 'medium', 300.00, 50, 10.0),
(121, 'Asparagus 12\"', 'outdoor & indoor', 'Shrub', 'medium', '5days', 2, 40, 'low', 'medium', 300.00, 40, 10.0),
(122, 'Asparagus small', 'outdoor & indoor', 'Shrub', 'medium', '5days', 2, 40, 'low', 'medium', 150.00, 40, 10.0),
(123, 'Bougainvillea (bag)', 'outdoor', 'Shrub', 'maximum', '3days', 8, 45, 'medum', 'medium', 200.00, 20, 8.0),
(124, 'Ficus nittida 12 inch pot', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 350.00, 50, 10.0),
(125, 'Ficus nittida 6 inch pot', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 200.00, 50, 10.0),
(126, 'Ficus nittida growbag', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 1500.00, 10, 10.0),
(127, 'Jasmine sambac (motia 12\" pot)', 'outdoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 300.00, 50, 10.0),
(128, 'Jasmine sambac (motia small bag)', 'outdoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 100.00, 100, 10.0),
(129, 'Ficus dwarf small', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 300.00, 30, 10.0),
(130, 'Moon ficus 6\"', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 250.00, 50, 10.0),
(131, 'Melaleuca small', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 9.0),
(132, 'Melaleuca large', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 350.00, 100, 9.0),
(133, 'Ficus panda small', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 150.00, 50, 10.0),
(134, 'Ficus panda 12inch pot', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 350.00, 50, 10.0),
(135, 'Ficus panda 16inch pot', 'outdoor & indoor', 'Shrub', 'medium', '3days', 5, 45, 'low', 'medium', 2000.00, 30, 10.0),
(136, 'Osmanthus', 'outdoor', 'Shrub', 'high', '2days', 2, 40, 'low', 'medium', 1000.00, 20, 10.0),
(137, 'Morpank', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(138, 'Serva small', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(139, 'Serva  large', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(140, 'Night queen (Rat ki rani bag)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 130.00, 100, 10.0),
(141, 'Hibiscus (bag)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(142, 'Marwa (bag)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(143, 'Gardenia (khushbo wala) (bag)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 10.0),
(144, 'Juniper small pot', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 200.00, 100, 10.0),
(145, 'Tecomaria pot', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 400.00, 100, 10.0),
(146, 'Jasmine (motia) small bag', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(147, 'Jatropha 12inch', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 400.00, 100, 10.0),
(148, 'Jatropha small', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 10.0),
(149, 'Lagestromia red/black', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 450.00, 100, 10.0),
(150, 'Lagestromia green', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 350.00, 100, 10.0),
(151, 'Hibiscus tree', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 500.00, 100, 10.0),
(152, 'Lagestrum small', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 50.00, 100, 10.0),
(153, 'Duranta mix color large (green+yellow)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 60.00, 100, 10.0),
(154, 'Bougainvillea mix color', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 10.0),
(155, 'Duranta mix color small', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 30.00, 100, 10.0),
(156, 'Lemon grass', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 50.00, 100, 10.0),
(157, 'Rosemary', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(158, 'Panda step (2-3)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 3500.00, 100, 10.0),
(159, 'Aerocaria 12 inch', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 1200.00, 100, 10.0),
(160, 'Ficus hawai', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(161, 'Ficus pand/nitida (small)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 10.0),
(162, 'Cydonia', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 500.00, 100, 10.0),
(163, 'Xanthos (sheight zayed plant)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 1500.00, 100, 10.0),
(164, 'Hydrangia', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 3000.00, 100, 10.0),
(165, 'Esocaria small', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 200.00, 100, 10.0),
(166, 'Bird of paradize', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 1200.00, 100, 10.0),
(167, 'Rubar plant 12 inch ', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 500.00, 100, 10.0),
(168, 'Rubar plant 6 inch ', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(169, 'Tamrilo/tomato tree', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 600.00, 100, 10.0),
(170, 'Murraya (marwa) bag', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 150, 10.0),
(171, 'Leucophyllum (silvery) bag', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 150, 10.0),
(172, 'Murraya (marwa 12 inch pot)', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 150, 10.0),
(173, 'Safora', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 150, 10.0),
(174, 'Kari pata', 'outdoor', 'Shrub', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 150, 10.0),
(175, 'Piece lily 6inch pot', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 3500.00, 5, 10.0),
(176, 'Aglonema 12 inch pot', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 6000.00, 5, 10.0),
(177, 'Anthorium 6inch pot', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 7000.00, 5, 10.0),
(178, 'Phelodendrone 12 inch pot', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 3500.00, 5, 10.0),
(179, 'Bamboo ', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 4500.00, 5, 10.0),
(180, 'Deffenbachia 12inch pot', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 3500.00, 5, 10.0),
(181, 'Zamioculcus 6 inch pot', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 6500.00, 5, 10.0),
(182, 'croton small', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 150.00, 5, 10.0),
(183, 'croton large 12 inch', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 400.00, 5, 10.0),
(184, 'Aquba 12 inch', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 600.00, 5, 10.0),
(185, 'Dracena red', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 400.00, 5, 10.0),
(186, 'Dracena green', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 350.00, 5, 10.0),
(187, 'Dracena margina 12 inch', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 350.00, 5, 10.0),
(188, 'Dracena margina small', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 200.00, 5, 10.0),
(189, 'Dracena makai', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 600.00, 5, 10.0),
(190, 'Dracena (song of india)', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 700.00, 5, 10.0),
(191, 'Dracena dreco', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 1500.00, 5, 10.0),
(192, 'Scheflera small', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 250.00, 5, 10.0),
(193, 'Scheflera 12 inch', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 400.00, 5, 10.0),
(194, 'Money plant 12 inch', 'indoor', 'Shrub', 'low', '20days', 8, 32, 'low', 'low', 1200.00, 5, 10.0),
(195, 'Ficus nittida large potted', 'outdoor & indoor', 'specimen/shaped', 'medium', '3days', 5, 45, 'low', 'medium', 5000.00, 10, 10.0),
(196, 'Ficus panda large pot XL', 'outdoor & indoor', 'specimen/shaped', 'medium', '3days', 5, 45, 'low', 'medium', 4500.00, 20, 10.0),
(197, 'Ficus neteda vase shape', 'outdoor', 'specimen/shaped', 'high', '3days', 8, 45, 'medum', 'medium', 4500.00, 150, 10.0),
(198, 'String of pearls (tasbeeh dane)', 'outdoor', 'succulents', 'high', '2days', 8, 45, 'medum', 'medium', 500.00, 100, 10.0),
(199, 'Aptenia(ice plant) hanging', 'outdoor', 'succulents', 'high', '2days', 8, 45, 'medum', 'medium', 350.00, 100, 10.0),
(200, 'lampranthus/hanging', 'outdoor', 'succulents', 'high', '2days', 8, 45, 'medum', 'medium', 100.00, 100, 10.0),
(201, 'Elephantis ', 'outdoor', 'succulents', 'high', '2days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(202, 'cactus grafted various types', 'outdoor', 'succulents', 'high', '2days', 8, 45, 'medum', 'medium', 2000.00, 100, 10.0),
(203, 'Pedilanthus/nagan', 'outdoor', 'succulents', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 100, 10.0),
(204, 'Aloe vera 12\"', 'outdoor & indoor', 'succulents', 'medium', '5days', 8, 45, 'low', 'medium', 300.00, 50, 10.0),
(205, 'Aloe vera small', 'outdoor & indoor', 'succulents', 'medium', '5days', 8, 45, 'low', 'medium', 150.00, 30, 10.0),
(206, 'Succulents', 'outdoor & indoor', 'succulents', 'medium', '5days', 8, 45, 'low', 'medium', 150.00, 80, 10.0),
(207, 'Moringa tree', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 500.00, 100, 10.0),
(208, 'Amaltus/cassia fistola tree 4-8 feet', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 350.00, 100, 10.0),
(209, 'Karak champta', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 500.00, 100, 10.0),
(210, 'Jacaranda 5-8 feet', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(211, 'silveroak 5-8 feet', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 250.00, 100, 10.0),
(212, 'Melaloka small', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 350.00, 100, 10.0),
(213, 'Melaloka 12 inch', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 600.00, 100, 10.0),
(214, 'Chinar tree large', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 600.00, 100, 10.0),
(215, 'Chinar tree small', 'outdoor', 'Tree', 'high', '2days', 8, 45, 'medum', 'medium', 150.00, 150, 10.0),
(216, 'Magnolia 12\"', 'outdoor', 'Tree', 'high', '3days', 2, 40, 'medum', 'medium', 1000.00, 100, 10.0),
(217, 'Sterculia', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 400.00, 100, 10.0),
(218, 'Pelcon tree small', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 500.00, 50, 10.0),
(219, 'Pelcon tree large (bag)', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 2000.00, 50, 10.0),
(220, 'Guli Nashtar (red flower)', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 600.00, 50, 10.0),
(221, 'Magnolia purple', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 3000.00, 50, 10.0),
(222, 'Lagerstroemia yellow/red/pink/purple', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 500.00, 50, 10.0),
(223, 'Rubber plant large growbag/pot', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 600.00, 50, 10.0),
(224, 'Chir/pine/Nakhtar (0.8-2feet)', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 30.00, 100, 10.0),
(225, 'Chir/pine/Nakhtar (2-3feet)', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 150.00, 100, 10.0),
(226, 'Chir/pine/Nakhtar (5-10feet) potted/grow bag)', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 3000.00, 100, 10.0),
(227, 'Diayr (0.8-2feet)', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 40.00, 100, 10.0),
(228, 'Diayr (2-3feet)', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 160.00, 100, 10.0),
(229, 'Diayr (5-10feet) potted/grow bag)', 'outdoor', 'Tree', 'high', '7days', 2, 40, 'low', 'medium', 3500.00, 100, 10.0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `sale_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'Cash'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `sale_date`, `total_amount`, `payment_method`) VALUES
(1, '2026-05-07 23:53:28', 6000.00, 'Daily Ledger'),
(3, '2026-05-08 21:15:39', 9000.00, 'Daily Ledger'),
(4, '2026-05-06 21:16:23', 7500.00, 'Daily Ledger');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `sale_item_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `plant_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_sale` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`plant_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`sale_item_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `plant_id` (`plant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `plant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `sale_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`plant_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
