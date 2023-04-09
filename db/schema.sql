-- Host: localhost    Database: weather

--
-- Table structure for table `data`
--
DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `battery_ok` int(11) NOT NULL,
  `temperature_C` decimal(10,3) NOT NULL,
  `humidity` decimal(10,2) NOT NULL,
  `rain_mm` decimal(10,2) NOT NULL,
  `wind_dir_deg` int(11) NOT NULL,
  `wind_avg_m_s` decimal(10,2) NOT NULL,
  `wind_max_m_s` decimal(10,2) NOT NULL,
  `pressure` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4382 DEFAULT CHARSET=latin1;

--
-- Table structure for table `rawdata`
--
DROP TABLE IF EXISTS `rawdata`;
CREATE TABLE `rawdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jsondata` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=latin1;
