-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2019 at 05:28 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `praktika`
--

-- --------------------------------------------------------

--
-- Table structure for table `miestas`
--

CREATE TABLE `miestas` (
  `ID` int(6) NOT NULL,
  `Miestas` varchar(70) COLLATE utf8_lithuanian_ci NOT NULL,
  `SalisId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `miestas`
--

INSERT INTO `miestas` (`ID`, `Miestas`, `SalisId`) VALUES
(15, 'Ryga', 3),
(16, 'Liepoja', 3),
(17, 'Valmiera', 3),
(18, 'Labasdas', 3),
(19, 'Tukumas', 3),
(21, 'Maskva', 4),
(22, 'Omskas', 4),
(23, 'Samara', 4),
(24, 'Volgogradas', 4),
(25, 'Ufa', 4),
(26, 'Norilskas', 4),
(27, 'Kuldyga', 3),
(30, 'Kaunas', 2),
(34, 'Uolainas', 3),
(35, 'Vilnius', 2);

-- --------------------------------------------------------

--
-- Table structure for table `salis`
--

CREATE TABLE `salis` (
  `ID` int(5) NOT NULL,
  `Salis` varchar(50) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `salis`
--

INSERT INTO `salis` (`ID`, `Salis`) VALUES
(2, 'Lietuva'),
(3, 'Latvija'),
(4, 'Rusija'),
(5, 'Ispanija'),
(6, 'Kanada'),
(7, 'Rumunija');

--
-- Indexes for table `miestas`
--
ALTER TABLE `miestas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SalisId` (`SalisId`);

--
-- Indexes for table `salis`
--
ALTER TABLE `salis`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for table `miestas`
--
ALTER TABLE `miestas`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `salis`
--
ALTER TABLE `salis`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for table `miestas`
--
ALTER TABLE `miestas`
  ADD CONSTRAINT `miestas_ibfk_1` FOREIGN KEY (`SalisId`) REFERENCES `salis` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
