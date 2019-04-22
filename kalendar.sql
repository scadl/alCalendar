-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2019 at 04:55 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kalendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `dateindex`
--

CREATE TABLE `dateindex` (
  `id` int(11) NOT NULL,
  `thedate` date NOT NULL,
  `dateText` text NOT NULL,
  `dayprizn` text NOT NULL,
  `dayinfo` text NOT NULL,
  `stdate` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dateindex`
--

INSERT INTO `dateindex` (`id`, `thedate`, `dateText`, `dayprizn`, `dayinfo`, `stdate`) VALUES
(1, '2019-04-10', 'Здесь будут ев. четния или другой тексст связанный с датой', 'описание дня', 'информация о нем', 'дата по старому стилю'),
(3, '2018-10-15', 'sv test', 'ifno with\'apostrof', 'jaust info', 'old date');

-- --------------------------------------------------------

--
-- Table structure for table `datelinked`
--

CREATE TABLE `datelinked` (
  `id` int(11) NOT NULL,
  `thedate` date NOT NULL,
  `imgurl` varchar(200) NOT NULL,
  `thelife` text NOT NULL,
  `thename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `datelinked`
--

INSERT INTO `datelinked` (`id`, `thedate`, `imgurl`, `thelife`, `thename`) VALUES
(1, '2019-04-10', 'img/10apr_1.png', 'Жетие перше', 'Святой1'),
(2, '2019-04-10', 'img/10apr_2.png', 'Житие сконд', 'Другой Св.'),
(3, '2017-04-16', 'img/saint.jpg', 'the great saint', 'StName');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dateindex`
--
ALTER TABLE `dateindex`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dateindex_un` (`thedate`);

--
-- Indexes for table `datelinked`
--
ALTER TABLE `datelinked`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dateindex`
--
ALTER TABLE `dateindex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `datelinked`
--
ALTER TABLE `datelinked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
