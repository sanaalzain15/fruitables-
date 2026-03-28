-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2025 at 01:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebus`
--

-- --------------------------------------------------------

--
-- Table structure for table `products_db`
--

CREATE TABLE `products_db` (
  `category` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `id` int(11) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products_db`
--

INSERT INTO `products_db` (`category`, `name`, `description`, `id`, `price`, `image`) VALUES
('Fruits', 'Grapes', 'Sweet and juicy green grapes perfect for snacking.', 1, 2, 'best-product-5.jpg'),
('Fruits', 'Apricots', 'Soft and ripe apricots full of flavor.', 2, 3, 'best-product-4.jpg'),
('Fruits', 'Banana', 'Organic bananas rich in potassium and energy.', 3, 2, 'best-product-3.jpg'),
('Fruits', 'Oranges', 'Citrusy and refreshing oranges loaded with vitamin C.', 4, 5, 'best-product-1.jpg'),
('Fruits', 'Raspberries', 'Fresh red raspberries great for desserts.', 5, 10, 'best-product-2.jpg'),
('Fruits', 'Strawberries', 'Bright red strawberries, perfect for smoothies.', 11, 4, 'featur-2.jpg'),
('Fruits', 'Apples', 'Crisp red apples full of fiber.', 12, 1, 'best-product-6.jpg'),
('Fruits', 'Mangoes', 'Tropical mangoes rich in flavor and color.', 13, 6, 'mango.jpg'),
('Vegetables', 'Carrots', 'Crunchy orange carrots great for juicing or salads.', 14, 3, 'carrots.jpg'),
('Vegetables', 'Broccoli', 'Fresh broccoli heads packed with vitamins.', 15, 4, 'broccoli.jpg'),
('Vegetables', 'Cucumber', 'Cool and refreshing cucumbers.', 16, 1, 'cucumber.jpg'),
('Vegetables', 'Lettuce', 'Green and crisp lettuce leaves.', 17, 3, 'lettuce.jpg'),
('Vegetables', 'Tomatoes', 'Juicy red tomatoes for cooking or salads.', 18, 3, 'tomatoes.jpg'),
('Vegetables', 'Zucchini', 'Mild and tender zucchini.', 21, 6, 'zucchini.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `hash_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `hash_password`) VALUES
(6, 'sana@fruitable ', 'fruit123', ''),
(12, 'sara@fruitable', 'fruit123', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products_db`
--
ALTER TABLE `products_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products_db`
--
ALTER TABLE `products_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
