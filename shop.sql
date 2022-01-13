-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2022 at 10:56 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Description` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(6, 'Hand Made', 'Hand Made Items', 0, 1, 0, 0, 0),
(7, 'Computers', 'Computers Item', 0, 2, 0, 0, 0),
(8, 'Cell phones', 'Cell phones Items', 0, 3, 0, 0, 0),
(9, 'Clothing', 'Clothing and Fashion', 0, 4, 0, 0, 0),
(10, 'Tools', 'Home Tools', 0, 5, 0, 0, 0),
(11, 'Nokia', 'Nokia phone', 8, 2, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(4, 'very nice', 1, '2021-12-14', 12, 16),
(8, 'it is the perfect product', 1, '2022-01-03', 11, 11),
(9, 'very nice this is the secound comment', 1, '2022-01-03', 12, 16);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`) VALUES
(9, 'Speaker', 'Very Good Speaker', '$10', '2021-12-05', 'China', '', '1', 0, 0, 7, 1, ''),
(10, 'Yeti Blue Mice', 'Very Good Microphone', '$108', '2021-12-05', 'USA', '', '1', 0, 0, 7, 9, ''),
(11, 'iPHone 6s', 'Apple iPHone 6s', '$300', '2021-12-05', 'USA', '', '2', 0, 0, 8, 11, ''),
(12, 'Magic Mouse', 'Apple Magic Mouse', '$150', '2021-12-05', 'USA', '', '1', 0, 1, 7, 16, ''),
(13, 'Network Cable', 'Cat 6 Magic Mouse', '$100', '2021-12-05', 'USA', '', '1', 0, 0, 7, 16, ''),
(14, 'Game ', 'test Game', '30', '2022-01-02', 'USA', '', '3', 0, 1, 8, 16, ''),
(15, 'GAME', 'test Game', '30', '2022-01-02', 'syria', '', '1', 0, 1, 6, 16, ''),
(17, 'ARI', 'ARI NEW GAME', '100', '2022-01-02', 'syria', '', '1', 0, 1, 9, 16, ''),
(18, 'ARI', 'ARI NEW GAME', '100', '2022-01-02', 'syria', '', '1', 0, 0, 9, 16, ''),
(19, 'my item', 'my new descripion', '140', '2022-01-11', 'lebanon', '', 'lebanon', 0, 1, 7, 16, 'sava,coun'),
(20, 'wooden game', 'a good wooden game', '100', '2022-01-12', 'USA', '', '1', 0, 1, 6, 11, 'elzero,hand,discound,gurantee'),
(21, 'Diablo |||', 'Good playstation 4 game', '70', '2022-01-12', 'USA', '', '1', 0, 1, 7, 16, 'Rpg,online ,game');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `TrustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `RStatus` int(11) NOT NULL DEFAULT 0,
  `Date` date DEFAULT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RStatus`, `Date`, `avatar`) VALUES
(1, 'beyan', '601f1889667efaebb33b8c12572835da3f027f78', 'beyan12345@gmail.com', 'bayan errahim', 1, 0, 1, '2013-10-08', ''),
(9, 'hind', '916695792dafb05eb597dad7dac9370829a052b9', 'hind@gmail.com', 'hind ada', 0, 0, 1, '2021-10-31', ''),
(11, 'ahmad', '14ee8629b606b872db7b27a48f41dfc82dcc10c7', 'ahmad22@gmail.com', 'ahmad errahim', 0, 0, 1, '2021-12-05', ''),
(12, 'husam', '848d6a80a47d9f81de0a1dd6e80a53c853129604', 'husam677@gmail.com', 'husam nur', 0, 0, 1, '2021-12-05', ''),
(15, 'muhammed', '601f1889667efaebb33b8c12572835da3f027f78', 'muhammed@gmail.com', 'muhammed  fares', 0, 0, 0, '2021-12-06', ''),
(16, 'khalid', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'khalid@gmail.com', 'khalid ahmed', 0, 0, 1, '2021-12-08', ''),
(17, 'turki', '601f1889667efaebb33b8c12572835da3f027f78', 'turki@gmail.com', '', 0, 0, 0, '2021-12-11', ''),
(18, ',mnmknli', '62d09c74c290aa6b2a4ec09fdb839b34ad0ce325', 'maha@gmail.com', 'nknkl mm', 0, 0, 1, '2022-01-13', '958971_3adım.jpg'),
(20, 'njkj', '1d8da6c866a54159e00ce662ab5de23a4bb0e8b0', 'fatma@gmail.com', 'bbn hgg', 0, 0, 1, '2022-01-13', '262591_f8.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`) USING HASH;

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD KEY `Cat_ID` (`Cat_ID`),
  ADD KEY `Member_ID` (`Member_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
