-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2018 at 01:59 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cr11_primoz_babsek_php_car_rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_name` varchar(55) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `car_type` varchar(100) NOT NULL,
  `fk_office_id` int(11) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_name`, `image_url`, `car_type`, `fk_office_id`, `latitude`, `longitude`) VALUES
(1, 'Seat Ibiza 2.0', 'https://cdn.euroncap.com/media/29352/seat-ibiza-359-235.jpg', 'sports car', 1, NULL, NULL),
(2, 'Nissan Leaf', 'https://www.nissan-cdn.net/content/dam/Nissan/nissan_europe/vehicles/leaf/B12P/pre-sell/18tdieulhd-leafhelios001.jpg.ximg.l_full_m.smart.jpg', 'family ', 1, NULL, NULL),
(3, 'Volvo XC60', 'https://images.derstandard.at/img/2017/12/11/Volvo-xc60-001.jpg?tc=e704&s=bb10d9bce5ddc2580cd13b3d592ba8c7', 'suv, family car', 1, '48.2078430', '16.4377690'),
(4, 'Honda Accord 2.2', 'https://media.ed.edmunds-media.com/honda/accord/2018/oem/2018_honda_accord_sedan_touring_fq_oem_7_1280.jpg', 'sports car', 1, NULL, NULL),
(5, 'Renaul Megane', 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/2016_Renault_Megane_IV_fl.jpg/1200px-2016_Renault_Megane_IV_fl.jpg', 'family car', 2, NULL, NULL),
(6, 'BMW X3', 'https://www.autocar.co.uk/sites/autocar.co.uk/files/styles/gallery_slide/public/bmw-x3_0.jpg?itok=yv0Vadp3', 'suv, sports car', 2, NULL, NULL),
(7, 'Honda Odyssey', 'https://res.cloudinary.com/carsguide/image/upload/f_auto,fl_lossy,q_auto,t_cg_hero_large/v1/editorial/honda-odyssey-vti-l-2017-silver-%283%29.jpg', 'family car', 2, NULL, NULL),
(8, 'Cadillac Escalade', 'http://www.cadillaccanada.ca/content/dam/Cadillac/northamerica/ca/nscwebsite/en/home/vehicles/crossovers_and_suvs/2018_vehicles/2018_Escalade/Model_Overview/Shopping_Tools/CA-2018-escalade-baseball-511x311.png', 'suv, luxury', 2, NULL, NULL),
(9, 'Ford Edge', 'https://www.ford.com/cmslibs/content/dam/vdm_ford/live/en_us/ford/nameplate/edge/2017/collections/highlights/3-2/SUV-Awards-5Star-17Edge-2160x1440.jpg/_jcr_content/renditions/cq5dam.web.1280.1280.jpeg', 'family car', 3, NULL, NULL),
(10, 'Honda CR-V', 'https://file.kbb.com/kbb/vehicleimage/evoxseo/cp/l/11813/2017-honda-cr-v-front_11813_032_640x480_wa.png', 'family car, suv', 3, NULL, NULL),
(11, 'Lincoln MKX', 'https://www.lincoln.com/cmslibs/content/dam/vdm_ford/live/en_us/lincoln/nameplate/mkx/2018/collections/adplanner/thumb_navigation_18mkx.jpg', 'family car', 4, NULL, NULL),
(12, 'Mercedes AMG S3', 'http://st.motortrend.com/uploads/sites/5/2013/03/2014-Mercedes-Benz-CLA45-AMG-front-three-quarter11.jpg?interpolation=lanczos-none&fit=around|660:412', 'sports car, luxury', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `email` varchar(55) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`email`, `first_name`, `last_name`, `password`) VALUES
('primoz2@gmail.com', 'primozsecond', 'babseksecond', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92'),
('primoz@gmail.com', 'primoz', 'babsek', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL,
  `office_name` varchar(100) DEFAULT NULL,
  `office_location` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`office_id`, `office_name`, `office_location`, `latitude`, `longitude`) VALUES
(1, 'first PHP office', 'Keplerplatz 3,\r\n1100 Wien', '48.1780470', '16.3753880'),
(2, 'second PHP office', 'Gudrunstrasse 199,\r\n1100 Wien', '48.1787610', '16.3619680'),
(3, 'third PHP office', 'Martinstrasse 84,\r\n1180 Wien', '48.2252020', '16.3422030'),
(4, 'fourth PHP office', 'Praterstrasse 45,\r\n1020 Wien', '48.2159560', '16.3859900');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `fk_email` varchar(100) DEFAULT NULL,
  `fk_car_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `fk_email`, `fk_car_id`, `start_date`, `return_date`) VALUES
(1, 'primoz@gmail.com', 9, '2018-01-08', '2018-01-10'),
(2, 'primoz2@gmail.com', 3, '2018-02-13', '2018-02-14'),
(3, 'primoz@gmail.com', 3, '2018-02-17', '2018-02-25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `fk_office_id` (`fk_office_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_email` (`fk_email`),
  ADD KEY `fk_car_id` (`fk_car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`fk_office_id`) REFERENCES `offices` (`office_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`fk_email`) REFERENCES `customers` (`email`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`fk_car_id`) REFERENCES `cars` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
