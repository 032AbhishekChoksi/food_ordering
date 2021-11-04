-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 04, 2021 at 10:19 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `email`) VALUES
(1, 'Admin', 'admin', 'admin', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `heading` varchar(500) NOT NULL,
  `sub_heading` varchar(500) NOT NULL,
  `link` varchar(100) NOT NULL,
  `link_txt` varchar(100) NOT NULL,
  `order_number` int NOT NULL,
  `added_on` datetime NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image`, `heading`, `sub_heading`, `link`, `link_txt`, `order_number`, `added_on`, `status`) VALUES
(1, '540851464_slider-1.jpg', 'Drink & Heathy Food', 'Fresh Heathy and Organic.', 'shop', 'Order Now', 1, '2021-08-28 07:47:49', 1),
(2, '860175038_slider-2.jpg', 'Drink & Heathy Food', 'Fresh Heathy and Organic.', 'shop', 'Order Now', 2, '2021-08-28 08:28:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `order_number` int NOT NULL,
  `status` int NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`, `order_number`, `status`, `added_on`) VALUES
(1, 'Chart & Snacks', 1, 1, '2021-07-23 06:57:14'),
(2, 'Chinese', 2, 1, '2021-07-23 06:57:33'),
(3, 'South Indian', 3, 1, '2021-07-23 06:58:08'),
(4, 'Desserts', 4, 1, '2021-07-23 06:58:26'),
(9, 'Murg', 5, 1, '2021-10-03 11:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `mobile`, `subject`, `message`, `added_on`) VALUES
(1, 'Choksi Abhishek Premalkumar', '19bmiit032@gmail.com', '7874376579', 'Testing Subject', 'Testing Message', '2021-08-28 12:39:11'),
(3, 'Parth Kher', '19bmiitbscit015@gmail.com', '9812575435', 'Demo Display', 'Helloooo.....', '2021-08-31 10:55:42'),
(4, 'Deep Shah', '19bmiit032@gmail.com', '7874376579', 'About Chinese', 'Veg or Non veg', '2021-10-27 05:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_code`
--

DROP TABLE IF EXISTS `coupon_code`;
CREATE TABLE IF NOT EXISTS `coupon_code` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(20) NOT NULL,
  `coupon_type` enum('P','F') NOT NULL,
  `coupon_value` int NOT NULL,
  `cart_min_value` int NOT NULL,
  `expired_on` date NOT NULL,
  `status` int NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupon_code`
--

INSERT INTO `coupon_code` (`id`, `coupon_code`, `coupon_type`, `coupon_value`, `cart_min_value`, `expired_on`, `status`, `added_on`) VALUES
(6, 'FIRST50', 'F', 50, 50, '2021-12-01', 1, '2021-10-25 17:52:44'),
(7, 'Monday', 'P', 10, 60, '2021-10-20', 1, '2021-10-25 04:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy`
--

DROP TABLE IF EXISTS `delivery_boy`;
CREATE TABLE IF NOT EXISTS `delivery_boy` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_boy`
--

INSERT INTO `delivery_boy` (`id`, `name`, `mobile`, `password`, `status`, `added_on`) VALUES
(1, 'Kevin Patel', '9825443278', 'kevin', 1, '2021-07-30 01:22:29'),
(2, 'Deep Shah', '9681234561', 'deep', 1, '2021-07-30 02:01:41'),
(3, 'ABHI CHOKSI', '7874376579', 'a', 1, '2021-10-30 02:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

DROP TABLE IF EXISTS `dish`;
CREATE TABLE IF NOT EXISTS `dish` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `dish` varchar(100) NOT NULL,
  `dish_detail` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `type` enum('veg','non-veg') NOT NULL,
  `status` int NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`id`, `category_id`, `dish`, `dish_detail`, `image`, `type`, `status`, `added_on`) VALUES
(1, 4, 'Gulab Jamun', 'Gulab Jamun', '977945963_862169053_gulab-jamun.jpg', 'veg', 1, '2021-08-11 10:43:59'),
(2, 1, 'Raj Kachori', 'Raj Kachori', '495788285_325195312_raj-kachori.jpg', 'veg', 1, '2021-08-11 10:46:06'),
(3, 2, 'Chow mein', 'Chow mein', '836724175_Chowmein.jpg', 'veg', 1, '2021-08-11 10:47:26'),
(4, 4, 'Ice Cream', 'Chocolate Scoop', '123403715_ice_cream.jpg', 'veg', 1, '2021-09-28 11:08:35'),
(74, 2, 'Noodels', 'Non-Veg chinese item', '768342928_chinese_non_veg.jpg', 'non-veg', 1, '2021-10-03 11:01:13'),
(75, 9, 'Butter Chicken', 'Butter Chicken or murgh makhani is a curry of chicken in a spiced tomato, butter and cream sauce.', '373591432_Butter-Chicken.jpg', 'non-veg', 1, '2021-10-03 11:08:55'),
(76, 3, 'Idle', 'Ideli with sambar and  Coccnut Chatni', '231207756_Idle.jpg', 'veg', 0, '2021-10-24 01:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `dish_cart`
--

DROP TABLE IF EXISTS `dish_cart`;
CREATE TABLE IF NOT EXISTS `dish_cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `dish_detail_id` int NOT NULL,
  `qty` int NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dish_details`
--

DROP TABLE IF EXISTS `dish_details`;
CREATE TABLE IF NOT EXISTS `dish_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dish_id` int NOT NULL,
  `attribute` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `status` int NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dish_details`
--

INSERT INTO `dish_details` (`id`, `dish_id`, `attribute`, `price`, `status`, `added_on`) VALUES
(1, 3, 'Full', 300, 1, '2021-08-11 10:43:59'),
(2, 3, 'Half', 170, 1, '2020-06-19 10:49:45'),
(6, 1, 'Per Piece', 40, 1, '2021-08-11 10:46:06'),
(7, 2, 'Per Piece', 110, 1, '2021-08-11 10:47:26'),
(8, 73, 'Per Piece', 40, 1, '2021-09-28 11:08:35'),
(9, 74, 'Half', 200, 1, '2021-10-03 11:01:13'),
(10, 74, 'Full', 350, 1, '2021-10-03 11:01:13'),
(11, 75, 'Half', 250, 1, '2021-10-03 11:08:55'),
(13, 4, 'Per Piece ', 20, 1, '2021-10-04 05:04:20'),
(15, 75, 'Full', 450, 1, '2021-10-24 01:49:48'),
(16, 76, 'Full', 20, 1, '2021-10-24 01:58:36'),
(17, 76, 'Half', 10, 0, '2021-10-24 01:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE IF NOT EXISTS `order_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `dish_details_id` int NOT NULL,
  `price` float NOT NULL,
  `qty` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `dish_details_id`, `price`, `qty`) VALUES
(1, 1, 13, 20, 3),
(2, 2, 1, 300, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_master`
--

DROP TABLE IF EXISTS `order_master`;
CREATE TABLE IF NOT EXISTS `order_master` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `total_price` float NOT NULL,
  `final_price` float NOT NULL,
  `coupon_code` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `zipcode` int NOT NULL,
  `delivery_boy_id` int NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `payment_type` varchar(10) NOT NULL,
  `payment_id` varchar(100) NOT NULL,
  `order_status` int NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_master`
--

INSERT INTO `order_master` (`id`, `user_id`, `name`, `email`, `mobile`, `address`, `total_price`, `final_price`, `coupon_code`, `zipcode`, `delivery_boy_id`, `payment_status`, `payment_type`, `payment_id`, `order_status`, `added_on`) VALUES
(1, 6, 'Abhi Choksi', 'a.p.choksi420@gmail.com', '7874376579', 'BMIIT, UTU', 60, 60, '', 394006, 0, 'pending', 'cod', '', 1, '2021-11-04 10:10:35'),
(2, 2, 'Abhishek Choksi', '19bmiit032@gmail.com', '9825445283', '348 Laxmi Villa, Opp. Rang Avdhut Temple, Dhamdod Road, Bardoli', 300, 250, 'FIRST50', 394005, 3, 'success', 'paytm', '20211104111212800110168734303146290', 4, '2021-11-04 10:13:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `order_status`) VALUES
(1, 'Pending'),
(2, 'Cooking'),
(3, 'On the Way'),
(4, 'Delivered'),
(5, 'Cancel');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

DROP TABLE IF EXISTS `rating`;
CREATE TABLE IF NOT EXISTS `rating` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_id` int NOT NULL,
  `dish_detail_id` int NOT NULL,
  `rating` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `order_id`, `dish_detail_id`, `rating`) VALUES
(1, 2, 2, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cart_min_price` int NOT NULL,
  `cart_min_price_msg` varchar(250) NOT NULL,
  `website_close` int NOT NULL,
  `website_close_msg` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `cart_min_price`, `cart_min_price_msg`, `website_close`, `website_close_msg`) VALUES
(1, 30, 'Cart min price will be 30 Rs', 0, 'Website Closed for today');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `email_verify` int NOT NULL,
  `rand_str` varchar(20) NOT NULL,
  `added_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `mobile`, `password`, `status`, `email_verify`, `rand_str`, `added_on`) VALUES
(2, 'Abhishek Choksi', '19bmiit032@gmail.com', '9825445283', '$2y$10$onnpLJBoZCHCZnbvOuTSs.9EkR1l/quAINci.mQZYfBQ0OugMj.Ry', 1, 1, 'oruvcbmuekjpwms', '2021-10-03 08:58:30'),
(3, 'harsh', '19bmiit103@gmail.com', '9512768979', '$2y$10$Oh0Qe.ncAWIbAF1sZB7QYONWOD4VLfmTKNcl7tfW0.xSFY.9oMGfS', 0, 1, 'mvedywkbetlgpxq', '2021-10-08 08:24:47'),
(6, 'Abhi Choksi', 'a.p.choksi420@gmail.com', '7874376579', '$2y$10$HOvgg00N0vQNLmDGpgF.5./QRbmKMtx03RLLfh5dVd7q9tc.W8pgy', 1, 1, 'nstykrouydapbkw', '2021-10-08 02:55:54');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
