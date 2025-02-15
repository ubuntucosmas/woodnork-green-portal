-- Set SQL modes and transaction settings
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Ensure UTF-8 encoding
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `portal_db`

-- Table structure for table `stock`
CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_of_measure` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `users`
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `department` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample data for users
INSERT INTO `users` (`id`, `username`, `password`, `role`, `department`) VALUES
(1, 'Ictlead', '$2y$10$Xad638N/idGL8kVu1WM.keSxlElLYJA6ZirSkCeSC/byWAn7dO55e', 'admin', 'IT'),
(2, 'testuser', '$2y$10$CEscsAX6YtjghxNiWcbNHexlxcH4JhJije8J0hBwuhxojdvnL.n1S', 'user', 'stores'),
(3, 'stores', '$2y$10$9uX52V8pXxb4g.LpT2/DmedrVcmPeSqTjmHBukL7R87rpDoAMIRUa', 'store_manager', 'stores'),
(4, 'Procurement', '$2y$10$Akv1KNklxQXp313tJwAWzu5MJe8ZOOvHuJ9ufCbE/oVRK1F7RPAbO', 'procurement_officer', 'procurement');

COMMIT;
