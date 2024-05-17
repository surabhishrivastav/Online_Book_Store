-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mountranger.cwpy0xn4dko1.ap-south-1.rds.amazonaws.com
-- Generation Time: Apr 18, 2024 at 07:46 PM
-- Server version: 8.0.35
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int NOT NULL,
  `city_id` int DEFAULT NULL COMMENT 'city id',
  `name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'locality name',
  `added_on` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `updated_on` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `city_id`, `name`, `added_on`, `updated_on`, `status`) VALUES
(1, 1, 'Inderpuri', '2024-04-17 18:17:41', '2024-04-17 18:17:41', 'active'),
(2, 1, 'Minal', '2024-04-17 18:17:41', '2024-04-17 18:17:41', 'active'),
(3, 1, 'Narela', '2024-04-17 18:17:41', '2024-04-17 18:17:41', 'active'),
(4, 1, 'Ayodhya Bypass', '2024-04-17 18:17:41', '2024-04-17 18:17:41', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'author name',
  `about` varchar(1000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `added_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL COMMENT 'product id which is being added',
  `user_id` int DEFAULT NULL COMMENT 'user id who adds',
  `cart_type` varchar(30) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'purchase / swap / rent',
  `added_on` timestamp NULL DEFAULT NULL COMMENT 'added on date',
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active' COMMENT 'active / deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL COMMENT 'parent category id for child category\r\nblank if parent',
  `added_on` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `updated_on` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active' COMMENT 'active / deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `image`, `parent_id`, `added_on`, `updated_on`, `status`) VALUES
(7, 'Horror', '2024-02-05-05-48-15_65c0d207664c3-category.jpg', NULL, '2024-02-05 17:48:15', '2024-02-06 09:13:13', 'active'),
(11, 'Fantasy', '2024-02-06-06-50-22_65c2321683535-category.jpeg', NULL, '2024-02-06 18:50:22', '2024-02-06 18:50:22', 'active'),
(12, 'Adventure', '2024-02-06-06-51-59_65c23277130be-category.jpg', NULL, '2024-02-06 18:51:59', '2024-02-06 18:51:59', 'active'),
(13, 'Non Fiction', '2024-02-06-06-52-41_65c232a1c8c6b-category.jpeg', NULL, '2024-02-06 18:52:41', '2024-02-06 18:52:41', 'active'),
(14, 'Classics', '2024-02-06-06-54-04_65c232f442ab9-category.jpg', NULL, '2024-02-06 18:54:04', '2024-02-06 18:54:04', 'active'),
(15, 'Thrillers', '2024-02-06-06-56-40_65c2339024498-category.jpg', NULL, '2024-02-06 18:56:40', '2024-02-06 18:56:40', 'active'),
(16, 'Academic book', '2024-02-06-07-01-55_65c234cb41479-category.jpg', NULL, '2024-02-06 18:57:52', '2024-02-06 19:01:55', 'active'),
(17, 'Short stories', '2024-02-06-06-59-35_65c2343f66650-category.jpg', NULL, '2024-02-06 18:59:35', '2024-02-06 18:59:35', 'active'),
(19, 'science', '2024-02-07-10-43-25_65c3ba35217e2-category.jpg', NULL, '2024-02-07 22:14:46', '2024-02-07 22:43:25', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int NOT NULL,
  `state_id` int DEFAULT NULL COMMENT 'state id',
  `name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'city name',
  `added_on` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `updated_on` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `state_id`, `name`, `added_on`, `updated_on`, `status`) VALUES
(1, 1, 'Bhopal', '2024-04-17 18:17:41', '2024-04-17 18:17:41', 'active'),
(2, 1, 'Indore', '2024-04-17 18:17:41', '2024-04-17 18:17:41', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `order_id` varchar(40) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'unique order id',
  `user_id` int DEFAULT NULL COMMENT 'user id who orders',
  `product_id` int DEFAULT NULL COMMENT 'product which is being orderd',
  `purchase_type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'sale / rent / swap',
  `mrp` float DEFAULT NULL COMMENT 'purchase mrp',
  `selling_price` float DEFAULT NULL COMMENT 'purchase price',
  `order_name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_cont` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_address1` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_address2` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_area_id` int DEFAULT NULL,
  `order_landmark` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_pincode` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `swap_product_id` int DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending' COMMENT 'pending / ordered / cancelled / delivered',
  `added_on` timestamp NULL DEFAULT NULL,
  `updated_on` timestamp NULL DEFAULT NULL,
  `cancelled_by` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'user / admin',
  `cancellation_reason` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'cancellation reason'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `user_id`, `product_id`, `purchase_type`, `mrp`, `selling_price`, `order_name`, `order_cont`, `order_address1`, `order_address2`, `order_area_id`, `order_landmark`, `order_pincode`, `swap_product_id`, `status`, `added_on`, `updated_on`, `cancelled_by`, `cancellation_reason`) VALUES
(1, 'OD-45997-67860-92390', 2, 8, 'sale', 350, 300, 'John', '9874587448', 'Address 1', 'Address 2', 4, 'Bypass', '462021', NULL, 'pending', '2024-04-18 10:18:13', '2024-04-18 10:18:13', NULL, NULL),
(2, 'OD-12351-73298-62455', 2, 8, 'sale', 350, 300, 'John', '9874587448', 'Address 1', 'Address 2', 4, 'Bypass', '462021', NULL, 'pending', '2024-04-18 10:29:10', '2024-04-18 10:29:10', NULL, NULL),
(3, 'OD-18256-13962-99900', 2, 8, 'sale', 350, 300, 'John', '9874587448', 'Address 1', 'Address 2', 4, 'Bypass', '462021', NULL, 'pending', '2024-04-18 10:31:53', '2024-04-18 10:31:53', NULL, NULL),
(4, 'OD-08166-09587-44404', 2, 8, 'sale', 350, 300, 'John', '9874587448', 'Address 1', 'Address 2', 4, 'Bypass', '462021', NULL, 'pending', '2024-04-18 10:32:19', '2024-04-18 10:32:19', NULL, NULL),
(5, 'OD-98241-76115-85723', 2, 6, 'sale', 250, 175, 'John', '9874587458', 'address 1', 'address 2', 1, 'Bypass', '462011', NULL, 'cancelled', '2024-04-18 12:03:08', '2024-04-18 16:25:55', '1', 'test'),
(6, 'OD-59440-88146-43988', 3, 8, 'rent', 20, 15, 'Surabhi', '9858745877', 'karamveer nagar', 'gt road', 4, '', '123456', NULL, 'pending', '2024-04-18 20:02:14', '2024-04-18 20:02:14', NULL, NULL),
(7, 'OD-17967-04210-14188', 3, 5, 'swap', 349, 279, 'Surabhi', '9858745877', 'karamveer nagar', 'gt road', 2, '', '123420', NULL, 'pending', '2024-04-18 20:06:57', '2024-04-18 20:06:57', NULL, NULL),
(8, 'OD-34167-53727-81621', 3, 5, 'swap', 349, 279, 'Surabhi', '9858745877', 'karamveer nagar', 'gt road', 4, '', '462022', NULL, 'ordered', '2024-04-18 20:07:56', '2024-04-18 20:07:56', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'product name',
  `generic_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'book generic name',
  `publisher` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'publisher',
  `author` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `edition` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'first edition / second edition',
  `language` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Hindi / English',
  `short_description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'short description',
  `long_description` varchar(3000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'long description',
  `no_of_pages` int DEFAULT NULL COMMENT 'number of pages',
  `weight` float DEFAULT NULL COMMENT 'weight in gram',
  `country_of_origin` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Like India / United Kingdo',
  `book_condition` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'New / Old',
  `for_purchase` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false' COMMENT 'true / false',
  `for_rent` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false' COMMENT 'true / false',
  `for_swapping` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false' COMMENT 'true / false',
  `available_qty` int NOT NULL DEFAULT '1',
  `mrp` float DEFAULT NULL,
  `selling_price` float DEFAULT NULL,
  `rent_mrp` float DEFAULT NULL,
  `rent_sp` float DEFAULT NULL,
  `swap_mrp` float DEFAULT NULL,
  `swap_sp` float DEFAULT NULL,
  `total_ratting` float NOT NULL DEFAULT '0' COMMENT 'total ratting ',
  `users_ratted` int NOT NULL DEFAULT '0' COMMENT 'total number of users ratted',
  `views` int NOT NULL DEFAULT '0',
  `orders` int NOT NULL DEFAULT '0',
  `added_on` timestamp NOT NULL COMMENT 'timestamp',
  `added_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'user / admin',
  `added_by_id` int DEFAULT NULL COMMENT 'adding user id',
  `updated_on` timestamp NOT NULL COMMENT 'timestamp',
  `updated_by` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'user / admin',
  `updated_by_id` int DEFAULT NULL COMMENT 'updating user id',
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending' COMMENT 'pending / active / deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `generic_name`, `publisher`, `author`, `edition`, `language`, `short_description`, `long_description`, `no_of_pages`, `weight`, `country_of_origin`, `book_condition`, `for_purchase`, `for_rent`, `for_swapping`, `available_qty`, `mrp`, `selling_price`, `rent_mrp`, `rent_sp`, `swap_mrp`, `swap_sp`, `total_ratting`, `users_ratted`, `views`, `orders`, `added_on`, `added_by`, `added_by_id`, `updated_on`, `updated_by`, `updated_by_id`, `status`) VALUES
(4, 13, 'Shatter Me: A beautiful hardback exclusive collector’s edition of the first book in the TikTok sensation Shatter Me series', 'Shatter me', 'lectric Monkey; Special Collectors edition', 'Tahereh Mafi', 'first edition', 'English', 'Discover the romantic, addictive and thrilling world of Tahereh Mafi’s fantasy Shatter Me series. This stunning hardback collector’s edition with its exclusive design and gold reading ribbon is the perfect gift for fans and new readers alike', '<p><span>A fragile young teenage girl is held captive. Locked in a cell \r\nby The Reestablishment – a harsh dictatorship in charge of a crumbling \r\nworld. This is no ordinary teenager. Juliette is a threat to The \r\nReestablishment\'s power. A touch from her can kill – one touch is all it\r\n takes. But not only is she a threat, she is potentially the most \r\npowerful weapon they could have. Juliette has never fought for herself \r\nbefore but when she’s reunited with the one person who ever cared about \r\nher, the depth of the emotion and the power within her become explosive …</span></p><p><span>\"Addictive,\r\n intense, and oozing with romance. I’m envious. I couldn’t put it down.…\r\n – Lauren Kate, New York Times bestselling author of </span><span class=\"a-text-italic\">Fallen</span></p><p><span>\'Dangerous, sexy, romantic and intense. I dare you to stop reading!\' – Kami Garcia, bestselling author of the </span><span class=\"a-text-italic\">Beautiful Creatures</span><span> series</span></p><span>Tahereh\r\n Mafi is the New York Times bestselling author of the Shatter Me series \r\nwhich has been published in over 30 languages around the world. She was \r\nborn in a small city somewhere in Connecticut and currently resides in \r\nSanta Monica, California, with her husband, Ransom Riggs, fellow \r\nbestselling author of Miss Peregrine\'s Home For Peculiar Children, and \r\ntheir young daughter. She can usually be found overcaffeinated and stuck\r\n in a book.</span><p></p>', 352, 0.42, 'US', 'New', 'true', 'false', 'true', 15, 1599, 899, NULL, NULL, 1599, 899, 0, 0, 0, 0, '2024-02-08 02:17:54', 'admin', NULL, '2024-02-08 02:17:54', 'admin', NULL, 'active'),
(5, 14, 'I Hear You: Most expectant mothers talk to their unborn. But what if the unborn starts to respond? | A psychological thriller with jaw-dropping ... expectant mothers talk to their unborn baby ', 'I Hear You', ' ‎ Penguin Ebury Press', 'Nidhi Upadhyay', 'first edition', 'English', 'Most expectant mothers talk to their unborn. But what if the unborn starts to respond? ', '<p><span>Mahika is hoping that a baby will breathe new life into her dead \r\nmarriage. But all her pregnancies meet the same fate, because no baby is\r\n perfect for Shivam, her genius geneticist husband. Until there is one. \r\nRudra, the world\'s first genetically altered foetus, is Shivam\'s perfect\r\n creation and Mahika\'s last hope. The six-week-pregnant Mahika has just \r\nwalked into her fertility clinic when she discovers an anonymous note \r\nthat discloses the ugly truth behind her pregnancy. Before Mahika can \r\ncome to terms with the fact that her husband\'s quest for perfection has \r\nmarked its territory in her womb, she finds herself locked in her own \r\nhouse. But then she discovers that her unborn son has extraordinary \r\npowers. As weeks pass by, Rudra calibrates and recalibrates his powers \r\nwith one aim-Mahika\'s freedom. But Rudra needs more than his newly \r\nacquired powers to free his mother. He needs to betray his creator, his \r\nfather. And he must do it before it\'s too late.</span></p>', 288, 0.3, 'India', 'New', 'true', 'true', 'true', 1, 349, 279, 18, 16, 349, 279, 0, 0, 0, 0, '2024-02-08 02:38:32', 'admin', NULL, '2024-02-08 02:38:32', 'admin', NULL, 'active'),
(6, 17, 'Who Will Cry When You Die?', 'Who Will Cry When You Die?', 'Jaico Publishing House; First Edition', 'Robin Sharma', 'first edition', 'English', 'Robin Sharma is a globally respected humanitarian. Widely considered one of the world’s top leadership and personal optimization advisors, his clients include famed billionaires, professional sports superstars, and many Fortune 100 companies. The author’s #1 bestsellers, such as The Monk Who Sold His Ferrari, The Greatness Guide and The Leader Who Had No Title are in over 92 languages, making him one of the most broadly read writers alive today. Go to robinsharma.com for more inspiration + valuable resources to upgrade your life.', '<p><span>Life Lessons From The Monk Who Sold His Ferrari Do You Feel that \r\nlife is slipping by so fast that you might never get the chance to live \r\nwith the meaning, happiness and joy you know you deserve? If so, then \r\nthis book will be the guiding light that leads you to a brilliant new \r\nway of living. In this easy-to-read yet wisdom-rich manual, the author \r\noffers 101 simple solutions to life’s most complex problems, ranging \r\nfrom a little-known method for beating stress and worry to a powerful \r\nway to enjoy the journey while you create a legacy that lasts. “When You\r\n Were Born, You Cried While The World Rejoiced. Live Your Life In Such A\r\n Way That When You Die, The World Cries While You Rejoice.” Ancient \r\nSanskrit Saying</span></p>', 256, 0.1, 'India', 'New', 'true', 'true', 'false', 15, 250, 175, 15, 12, NULL, NULL, 0, 0, 0, 0, '2024-02-08 02:44:14', 'admin', NULL, '2024-02-08 02:44:14', 'admin', NULL, 'active'),
(8, 14, 'The Hidden Hindu', 'The Hidden Hindu', 'Penguin eBury Press', 'Akshat Gupta', 'first edition', 'Hindi', 'Prithvi, a twenty-one-year-old, is searching for a mysterious middle-aged aghori (Shiva devotee), Om Shastri, who was traced more than 200 years ago before he was captured and transported to a high-tech facility on an isolated Indian island. When the aghori was drugged and hypnotized for interrogation by a team of specialists, he claimed to have witnessed all four yugas (the epochs in Hinduism) and even participated in both Ramayana and Mahabharata. Om\'s revelations of his incredible past that defied the nature of mortality left everyone baffled. The team also discovers that Om had been in search of the other immortals from every yuga. These bizarre secrets could shake up the ancient beliefs of the present and alter the course of the future. So who is Om Shastri? Why was he captured? Board the boat of Om Shastri\'s secrets, Prithvi\'s pursuit and adventures of other enigmatic immortals of Hindu mythology in this exciting and revealing jou', '<p><span>Prithvi, a twenty-one-year-old, is searching for a mysterious \r\nmiddle-aged aghori (Shiva devotee), Om Shastri, who was traced more than\r\n 200 years ago before he was captured and transported to a high-tech \r\nfacility on an isolated Indian island. When the aghori was drugged and \r\nhypnotized for interrogation by a team of specialists, he claimed to \r\nhave witnessed all four yugas (the epochs in Hinduism) and even \r\nparticipated in both Ramayana and Mahabharata. Om\'s revelations of his \r\nincredible past that defied the nature of mortality left everyone \r\nbaffled. The team also discovers that Om had been in search of the other\r\n immortals from every yuga. These bizarre secrets could shake up the \r\nancient beliefs of the present and alter the course of the future. So \r\nwho is Om Shastri? Why was he captured? Board the boat of Om Shastri\'s \r\nsecrets, Prithvi\'s pursuit and adventures of other enigmatic immortals \r\nof Hindu mythology in this exciting and revealing journey.</span></p>', 256, 0.2, 'India', 'New', 'true', 'true', 'true', 10, 350, 300, 20, 15, 350, 300, 0, 0, 0, 0, '2024-04-16 17:55:55', 'admin', NULL, '2024-04-16 17:55:55', 'admin', NULL, 'active'),
(9, 14, 'Vikram & Betal - Life Lessons for Our Times by Neelam Kumar � English | Classics Tales for Children | Beautiful Illustrations with Clear Text | Personal Development Activities | Ancient Wisdom for our Contemporary Lives | Gold Foiling on Hardcover | ', 'Vikram & Betal', 'Wonder House Books', 'Neelam', 'first edition', 'Hindi', 'This classic retelling of the adventures of Vikram and Betal combines the old with the new. It takes an insightful, refreshing look at the fascinating encounters between King Vikramaditya and the playful ghost Betal. Each thought-provoking tale brims with wisdom, wit, and critical thinking. And to captivate the reader further, each ancient tale ends with a Life Skills Nugget, thus combining the wisdom of the past with vital tools necessary for our digital age. Whatever your age, dip into these ancient tales, suspend your judgment and simply enjoy. This illustrated book is a must-have for all children! • Child-friendly content • The stories will instill life-skill lessons in children • Brings them closer to Indian traditional tales • Develops reading skills • Comprises stunning illustrations ', '<p><span>This classic retelling of the adventures of Vikram and Betal \r\ncombines the old with the new. It takes an insightful, refreshing look \r\nat the fascinating encounters between King Vikramaditya and the playful \r\nghost Betal. Each thought-provoking tale brims with wisdom, wit, and \r\ncritical thinking. And to captivate the reader further, each ancient \r\ntale ends with a Life Skills Nugget, thus combining the wisdom of the \r\npast with vital tools necessary for our digital age. Whatever your age, \r\ndip into these ancient tales, suspend your judgment and simply enjoy. \r\nThis illustrated book is a must-have for all children! • Child-friendly \r\ncontent • The stories will instill life-skill lessons in children • \r\nBrings them closer to Indian traditional tales • Develops reading skills\r\n • Comprises stunning illustrations </span></p>', 80, 0.4, 'India', 'New', 'false', 'true', 'false', 10, 1, 1, 25, 20, 1, 1, 0, 0, 0, 0, '2024-04-16 18:01:55', 'admin', NULL, '2024-04-16 18:01:55', 'admin', NULL, 'active'),
(12, 16, 'test title', 'generic test name', 'publisher', 'author', 'first edition', 'Hindi', 'short description ', 'long description', 260, 0.5, 'India', 'New', 'true', 'false', 'true', 10, 250, 200, 0, 0, 250, 200, 0, 0, 0, 0, '2024-04-18 17:57:00', 'user', 2, '2024-04-18 17:57:00', 'user', 2, 'pending'),
(13, 11, 'The Cruel Prince', 'TCP', 'ac', 'Henry', 'first edition', 'English', 'It is a good book', 'it is a fan fiction', 244, 0.5, 'India', 'Old', 'true', 'false', 'false', 1, 300, 200, 0, 0, 0, 0, 0, 0, 0, 0, '2024-04-18 20:55:17', 'user', 3, '2024-04-18 20:55:17', 'user', 3, 'pending'),
(14, 16, 'Swap Book', 'Swap Book', 'Surabhi', 'Surabhi', 'first edition', 'English', 'short', 'long', 250, 0.2, 'India', 'New', 'false', 'false', 'true', 1, 0, 0, 0, 0, 250, 200, 0, 0, 0, 0, '2024-04-18 22:06:58', 'user', 3, '2024-04-18 22:06:58', 'user', 3, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `image_name` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'product image name',
  `product_id` int DEFAULT NULL COMMENT 'product id',
  `sequence_no` int DEFAULT NULL COMMENT 'sequence number',
  `added_on` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active' COMMENT 'active / deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image_name`, `product_id`, `sequence_no`, `added_on`, `status`) VALUES
(5, '2024-02-08-02-17-54_65c3ec7a0bcf51-book.jpg', 4, NULL, '2024-02-08 02:17:54', 'active'),
(6, '2024-02-08-02-38-32_65c3f15021bdf1-book.jpeg', 5, NULL, '2024-02-08 02:38:32', 'active'),
(7, '2024-02-08-02-38-32_65c3f15021bdf2-book.jpg', 5, NULL, '2024-02-08 02:38:32', 'active'),
(8, '2024-02-08-02-44-14_65c3f2a68258a1-book.jpg', 6, NULL, '2024-02-08 02:44:14', 'active'),
(11, '2024-04-16-05-55-55_661e6e5303cb41-book.jpg', 8, NULL, '2024-04-16 17:55:55', 'active'),
(12, '2024-04-16-05-55-55_661e6e5303cb42-book.jpg', 8, NULL, '2024-04-16 17:55:55', 'active'),
(13, '2024-04-16-06-01-55_661e6fbb31a291-book.jpg', 9, NULL, '2024-04-16 18:01:55', 'active'),
(14, '2024-04-16-06-01-55_661e6fbb31a292-book.jpg', 9, NULL, '2024-04-16 18:01:55', 'active'),
(15, '2024-04-16-06-01-55_661e6fbb31a293-book.jpg', 9, NULL, '2024-04-16 18:01:55', 'active'),
(16, '2024-04-16-06-01-55_661e6fbb31a294-book.jpg', 9, NULL, '2024-04-16 18:01:55', 'active'),
(19, '2024-04-18-05-57-00_66211194af16e1-book.jpg', 12, NULL, '2024-04-18 17:57:00', 'active'),
(20, '2024-04-18-08-55-17_66213b5d149ed1-book.jpg', 13, NULL, '2024-04-18 20:55:17', 'active'),
(21, '2024-04-18-10-06-58_66214c2a7ccc41-book.jpg', 14, NULL, '2024-04-18 22:06:58', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `product_rattings`
--

CREATE TABLE `product_rattings` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ratting title',
  `message` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ratting message',
  `image` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ratting image',
  `product_id` int DEFAULT NULL COMMENT 'linked product id',
  `ratting` int DEFAULT NULL COMMENT 'like 1 / 2 / 3 / 4 / 5',
  `added_by_id` int DEFAULT NULL COMMENT 'user id who added ratting',
  `added_on` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `added_on` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active' COMMENT 'active / deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `name`, `added_on`, `status`) VALUES
(1, 'Madhya Pradesh', '2024-04-17 18:17:41', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'User Name',
  `role` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user' COMMENT 'admin / user',
  `email` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_no` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pro_pic` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reg_on` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `last_login` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `updated_on` timestamp NULL DEFAULT NULL COMMENT 'timestamp',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active' COMMENT 'active / deleted',
  `is_verified` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false' COMMENT 'true / false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `contact_no`, `pro_pic`, `password`, `reg_on`, `last_login`, `updated_on`, `status`, `is_verified`) VALUES
(1, 'Demo Admin', 'admin', 'demo@demo.com', '9876543214', NULL, 'demo', '2023-10-14 22:06:43', NULL, '2023-10-14 22:06:43', 'active', 'false'),
(2, 'John', 'user', 'test@test.com', NULL, NULL, '1234', '2024-02-06 11:59:00', NULL, NULL, 'active', 'true'),
(3, 'Surabhi', 'user', 'surabhi@gmail.com', NULL, NULL, '1234', '2024-02-07 22:11:15', NULL, NULL, 'active', 'true'),
(4, 'hello', 'user', 'hello@hello.com', NULL, NULL, '1234', '2024-04-18 12:04:30', NULL, NULL, 'active', 'false'),
(5, 'Sk ', 'user', 'arushyadav0229@gmail.com', NULL, NULL, 'arush@2003', '2024-04-18 12:31:43', NULL, NULL, 'active', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `user_doc`
--

CREATE TABLE `user_doc` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL COMMENT 'User Id',
  `file_name` varchar(300) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Document Number',
  `doc_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Adhar / Pan / Driving Licence / Voter Id',
  `status` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active' COMMENT 'active / deleted',
  `is_verified` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'false' COMMENT 'true / false',
  `added_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_doc`
--

INSERT INTO `user_doc` (`id`, `user_id`, `file_name`, `doc_number`, `doc_type`, `status`, `is_verified`, `added_on`) VALUES
(3, 2, '2024-04-17-06-17-41_661fc4ed1cb6d-user_document.jpeg', '212121', 'Aadhar Card', 'active', 'true', '2024-04-17 18:17:41'),
(4, 2, '2024-04-17-06-36-53_661fc96de31d0-user_document.png', 'd4s5d45s', 'Aadhar Card', 'active', 'true', '2024-04-17 18:36:53'),
(5, 3, '2024-04-18-08-05-57_66212fcdcd813-user_document.jpg', '1234', 'Aadhar Card', 'active', 'true', '2024-04-18 20:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL COMMENT 'product id',
  `user_id` int DEFAULT NULL COMMENT 'user id who adds the product',
  `added_on` timestamp NULL DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active' COMMENT 'active / deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_area_city` (`city_id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_product` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_city_state` (`state_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_product` (`product_id`),
  ADD KEY `fk_order_user` (`user_id`),
  ADD KEY `fk_order_area` (`order_area_id`),
  ADD KEY `fk_order_prod_swap` (`swap_product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_images_product` (`product_id`);

--
-- Indexes for table `product_rattings`
--
ALTER TABLE `product_rattings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_rattings_product` (`product_id`),
  ADD KEY `fk_product_rattings_user` (`user_id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_doc`
--
ALTER TABLE `user_doc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_doc_user` (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_wishlist_product` (`product_id`),
  ADD KEY `fk_wishlist_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_rattings`
--
ALTER TABLE `product_rattings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_doc`
--
ALTER TABLE `user_doc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `fk_area_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `fk_city_state` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_area` FOREIGN KEY (`order_area_id`) REFERENCES `area` (`id`),
  ADD CONSTRAINT `fk_order_prod_swap` FOREIGN KEY (`swap_product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_order_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `fk_product_images_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_rattings`
--
ALTER TABLE `product_rattings`
  ADD CONSTRAINT `fk_product_rattings_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_product_rattings_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_doc`
--
ALTER TABLE `user_doc`
  ADD CONSTRAINT `fk_user_doc_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
