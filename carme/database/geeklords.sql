-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 13, 2023 at 03:05 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geeklords`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `fullname`, `email`, `username`, `password`) VALUES
(123, 'Natalie Sia ', 'carme.geeklords@gmail.com', 'natsia', 'Welcome123?');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `book_ID` int(11) NOT NULL,
  `mem_ID` int(11) NOT NULL,
  `car` varchar(25) NOT NULL,
  `pick_up_date` date NOT NULL,
  `drop_off_date` date NOT NULL,
  `location` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`book_ID`, `mem_ID`, `car`, `pick_up_date`, `drop_off_date`, `location`) VALUES
(1, 1, 'QAA5678', '2023-01-09', '2023-01-10', 'KIA'),
(2, 2, 'QAK3333', '2023-02-02', '2023-02-03', 'KIA'),
(3, 3, 'QSA1234', '2023-01-21', '2023-01-22', 'SA');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `carplate` varchar(15) NOT NULL,
  `type` varchar(15) NOT NULL,
  `brand` varchar(55) NOT NULL,
  `model` varchar(55) NOT NULL,
  `seater` int(11) NOT NULL,
  `price` float NOT NULL,
  `location` varchar(250) DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`carplate`, `type`, `brand`, `model`, `seater`, `price`, `location`, `image`) VALUES
('QAA5678', 'Hatchback', 'Perodua', 'Myvi', 5, 109, 'KIA', 'perodua-myvi.png'),
('QAK3333', 'Sedan', 'Proton', 'Saga', 5, 119, 'KIA', 'proton-saga.png'),
('QAL4444', 'SUV', 'Proton', 'X50', 5, 259, 'KIA', 'ProtonX50.png'),
('QAS2222', 'SUV', 'Perodua', 'Aruz', 7, 309, 'KIA', 'perodua-aruz.png'),
('QAX1234', 'Hatchback', 'Perodua', 'Axia', 5, 99, 'KIA', 'perodua-Axia.png'),
('QAY1111', 'Sedan', 'Perodua', 'Bezza', 5, 129, 'KIA', 'perodua-bezza.png'),
('QSA1234', 'Hatchback', 'Perodua', 'Axia', 5, 99, 'SA', 'perodua-Axia.png'),
('QSB4321', 'Hatchback', 'Perodua', 'Myvi', 5, 109, 'SA', 'perodua-myvi.png'),
('QSC5643', 'Sedan', 'Proton', 'Saga', 5, 119, 'SA', 'proton-saga.png'),
('QSD7890', 'Sedan', 'Perodua', 'Bezza', 5, 129, 'SA', 'perodua-bezza.png'),
('QSE9965', 'SUV', 'Proton', 'X50', 5, 259, 'SA', 'ProtonX50.png'),
('QSF3345', 'SUV', 'Perodua', 'Aruz', 7, 309, 'SA', 'perodua-aruz.png');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `subscription_id` int(10) NOT NULL,
  `email` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`subscription_id`, `email`) VALUES
(1, 'test@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `memberID` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `confirmpw` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`memberID`, `fullname`, `username`, `email`, `password`, `confirmpw`) VALUES
(1, 'Thanish Jay', 'nish', 'than@example.com', 'Yooo9090??', 'Yooo9090??'),
(2, 'yanting', 'xyz123', 'test@example.com', 'Abcd123??', 'Abcd123??'),
(3, 'Athira Azman', 'athirazm', 'athr@example.com', 'Ra123??', 'Ra123??');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `trans_ID` int(11) NOT NULL,
  `booking_ID` int(11) NOT NULL,
  `pay_type` set('Credit') NOT NULL,
  `pay_amount` decimal(15,2) NOT NULL,
  `pay_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`trans_ID`, `booking_ID`, `pay_type`, `pay_amount`, `pay_date`) VALUES
(1, 1, 'Credit', '109.00', '2023-01-08'),
(2, 2, 'Credit', '119.00', '2023-02-01'),
(3, 3, 'Credit', '79.20', '2023-01-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`book_ID`),
  ADD KEY `mem_ID` (`mem_ID`),
  ADD KEY `car` (`car`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`carplate`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`memberID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`trans_ID`),
  ADD KEY `booking_ID` (`booking_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `book_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `subscription_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `memberID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `trans_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
