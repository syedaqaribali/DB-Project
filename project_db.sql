-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2022 at 04:14 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`) VALUES
('admin@nu.edu.pk', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `alert`
--

CREATE TABLE `alert` (
  `driverID` int(11) NOT NULL,
  `rollNo` varchar(20) NOT NULL,
  `stopName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alert`
--

INSERT INTO `alert` (`driverID`, `rollNo`, `stopName`) VALUES
(1, '20K-0351', 'Malir Halt');

-- --------------------------------------------------------

--
-- Table structure for table `bus`
--

CREATE TABLE `bus` (
  `NoPlate` varchar(20) NOT NULL,
  `BusNo` varchar(20) NOT NULL,
  `Seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus`
--

INSERT INTO `bus` (`NoPlate`, `BusNo`, `Seats`) VALUES
('ABC-123', '1A', 27),
('ABC-321', '2A', 25),
('DEF-067', '2B', 26),
('BDL-348', '3C', 48),
('BCE-394', '5B', 60);

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `contactNo` varchar(20) NOT NULL,
  `cnic` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `busNo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `Name`, `contactNo`, `cnic`, `email`, `password`, `busNo`) VALUES
(1, 'Asad', '03001234567', '4220000123000', 'asad@nu.edu.pk', 'asad', '1A');

-- --------------------------------------------------------

--
-- Table structure for table `gps_track`
--

CREATE TABLE `gps_track` (
  `id` int(11) NOT NULL,
  `track_lng` decimal(11,0) NOT NULL,
  `track_lat` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stop`
--

CREATE TABLE `stop` (
  `Name` varchar(20) NOT NULL,
  `time` varchar(20) DEFAULT NULL,
  `BusNo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stop`
--

INSERT INTO `stop` (`Name`, `time`, `BusNo`) VALUES
('DC Office', '6.55', '3C'),
('Farooq e Azam', '6.52', '2A'),
('Johar', '6.55', '5B'),
('Malir Halt', '7.19', '1A'),
('Serena', '6.50', '2A');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `rollNo` varchar(20) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `contactNo` varchar(20) NOT NULL,
  `Stop` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`rollNo`, `Name`, `contactNo`, `Stop`, `email`, `password`) VALUES
('20K-0234', 'Mannahil Miftah', '3145327822', 'Serena', 'k200234@nu.edu.pk', 'k200234'),
('20K-0351', 'Alishba Subhani', '3029449444', 'Malir Halt', 'k200351@nu.edu.pk', 'k200351'),
('22K-4777', 'Amna mudabbir', '3145489376', 'Serena', 'k224777@nu.edu.pk', 'k224777');

--
-- Triggers `student`
--
DELIMITER $$
CREATE TRIGGER `decrementSeats` AFTER INSERT ON `student` FOR EACH ROW BEGIN
    UPDATE bus
    SET bus.Seats = bus.Seats - 1
    WHERE bus.BusNo IN (SELECT stop.BusNo FROM stop WHERE 							stop.Name IN(SELECT new.Stop FROM student));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `deleteSeat` AFTER DELETE ON `student` FOR EACH ROW BEGIN
UPDATE bus
SET bus.Seats = bus.Seats + 1
WHERE bus.BusNo IN (SELECT stop.BusNo FROM stop WHERE
                   stop.Name IN (SELECT old.Stop FROM student));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateOldSeat` AFTER UPDATE ON `student` FOR EACH ROW BEGIN
UPDATE bus
SET bus.Seats = bus.Seats - 1
WHERE bus.BusNo IN (SELECT stop.BusNo
                    FROM stop
                    WHERE stop.Name
                    IN (SELECT old.Stop from student));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `updateSeat` AFTER UPDATE ON `student` FOR EACH ROW BEGIN
UPDATE bus
SET bus.Seats = bus.Seats - 1
WHERE bus.BusNo IN(SELECT stop.BusNo FROM stop 
                   WHERE stop.Name IN (SELECT new.Stop FROM student));
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `alert`
--
ALTER TABLE `alert`
  ADD PRIMARY KEY (`driverID`,`rollNo`,`stopName`),
  ADD KEY `rollNoFK` (`rollNo`),
  ADD KEY `stopNameFK` (`stopName`);

--
-- Indexes for table `bus`
--
ALTER TABLE `bus`
  ADD PRIMARY KEY (`BusNo`),
  ADD UNIQUE KEY `NoPlate` (`NoPlate`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contactNo` (`contactNo`),
  ADD UNIQUE KEY `cnic` (`cnic`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `busNo` (`busNo`);

--
-- Indexes for table `gps_track`
--
ALTER TABLE `gps_track`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `stop`
--
ALTER TABLE `stop`
  ADD PRIMARY KEY (`Name`) USING BTREE,
  ADD KEY `busFKStop` (`BusNo`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`rollNo`),
  ADD UNIQUE KEY `contactNo` (`contactNo`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `stopFKS` (`Stop`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alert`
--
ALTER TABLE `alert`
  ADD CONSTRAINT `driverIDFK` FOREIGN KEY (`driverID`) REFERENCES `driver` (`id`),
  ADD CONSTRAINT `rollNoFK` FOREIGN KEY (`rollNo`) REFERENCES `student` (`rollNo`),
  ADD CONSTRAINT `stopNameFK` FOREIGN KEY (`stopName`) REFERENCES `stop` (`Name`);

--
-- Constraints for table `driver`
--
ALTER TABLE `driver`
  ADD CONSTRAINT `BusNoFK` FOREIGN KEY (`busNo`) REFERENCES `bus` (`BusNo`);

--
-- Constraints for table `gps_track`
--
ALTER TABLE `gps_track`
  ADD CONSTRAINT `driverIDFKS` FOREIGN KEY (`id`) REFERENCES `driver` (`id`);

--
-- Constraints for table `stop`
--
ALTER TABLE `stop`
  ADD CONSTRAINT `busFKStop` FOREIGN KEY (`BusNo`) REFERENCES `bus` (`BusNo`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `stopFKS` FOREIGN KEY (`Stop`) REFERENCES `stop` (`Name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
