# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.16-log
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-12-09 11:44:47
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for atletica_valsesia
DROP DATABASE IF EXISTS `atletica_valsesia`;
CREATE DATABASE IF NOT EXISTS `atletica_valsesia` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `atletica_valsesia`;


# Dumping structure for table atletica_valsesia.atleta
DROP TABLE IF EXISTS `atleta`;
CREATE TABLE IF NOT EXISTS `atleta` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `COGNOME` varchar(100) NOT NULL,
  `SESSO` varchar(1) NOT NULL,
  `DATA_NASCITA` date NOT NULL,
  `CREATED` datetime DEFAULT NULL,
  `MODIFIED` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NOME_COGNOME_SESSO_DATA_NASCITA` (`NOME`,`COGNOME`,`SESSO`,`DATA_NASCITA`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.atleta: ~12 rows (approximately)
DELETE FROM `atleta`;
/*!40000 ALTER TABLE `atleta` DISABLE KEYS */;
INSERT INTO `atleta` (`ID`, `NOME`, `COGNOME`, `SESSO`, `DATA_NASCITA`, `CREATED`, `MODIFIED`) VALUES
	(1, 'Sergio', 'Belli', 'M', '1981-07-18', '2011-11-30 17:32:21', '2011-11-30 17:32:22'),
	(2, 'Francesca', 'Ravarotto', 'F', '2011-11-30', '2011-11-30 17:32:45', '2011-11-30 17:32:45'),
	(3, 'Fulvia', 'Demattei', 'F', '2011-11-30', '2011-11-30 17:33:03', '2011-11-30 17:33:03'),
	(4, 'Danilo', 'Belli', 'M', '1951-06-02', '2011-12-03 16:08:14', '2011-12-03 16:08:17'),
	(10, 'Valeria', 'Viano', 'F', '1977-03-16', '2011-12-05 01:38:09', '2011-12-05 01:38:09'),
	(11, 'Fausto', 'Agliotti', 'M', '1949-01-01', '2011-12-05 01:38:49', '2011-12-05 01:38:49'),
	(12, 'Edoardo', 'Lamanna', 'M', '1971-07-09', '2011-12-05 01:37:52', '2011-12-05 01:37:52'),
	(14, 'Andrea', 'Bertarello', 'M', '1973-01-01', '2011-12-05 01:39:11', '2011-12-05 01:39:11'),
	(15, 'Ivan', 'Delgrosso', 'M', '0000-00-00', '2011-12-03 00:00:00', '2011-12-03 00:00:00'),
	(17, 'Damiana', 'Facchinetti', 'F', '0000-00-00', '2011-12-03 03:27:36', '2011-12-03 03:27:36'),
	(18, 'Sofia', 'Canetta', 'F', '1986-01-01', '2011-12-09 08:52:25', '2011-12-09 08:52:25'),
	(38, 'SCOSTUMATO', 'ABBABBIONE', 'M', '1971-07-09', '2011-12-09 10:05:59', '2011-12-09 10:05:59');
/*!40000 ALTER TABLE `atleta` ENABLE KEYS */;


# Dumping structure for table atletica_valsesia.gara
DROP TABLE IF EXISTS `gara`;
CREATE TABLE IF NOT EXISTS `gara` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(200) NOT NULL,
  `CAMPIONATO` varchar(255) DEFAULT NULL,
  `LOCALITA` varchar(200) NOT NULL,
  `DATA` date NOT NULL,
  `CREATED` datetime NOT NULL,
  `MODIFIED` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NOME_LOCALITA_DATA` (`NOME`,`LOCALITA`,`DATA`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.gara: ~4 rows (approximately)
DELETE FROM `gara`;
/*!40000 ALTER TABLE `gara` DISABLE KEYS */;
INSERT INTO `gara` (`ID`, `NOME`, `CAMPIONATO`, `LOCALITA`, `DATA`, `CREATED`, `MODIFIED`) VALUES
	(1, 'Maratonina Terre d&#39;Acqua', 'Grand Prix BI-VC', 'Trino', '2011-11-27', '2011-12-05 02:28:58', '2011-12-05 02:28:58'),
	(2, 'Cross di Piatto', 'Cross Provinciale', 'Piatto', '2011-12-11', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 'Cross del Panettone', NULL, 'Prato Sesia', '2011-12-25', '2011-12-05 02:28:20', '2011-12-05 02:28:20'),
	(16, 'Ammazzainverno', 'Ammazzainverno', 'Invorio Superiore', '2011-12-08', '2011-12-09 10:12:08', '2011-12-09 10:12:08'),
	(18, 'Ammazzainverno', 'Ammazzainverno', 'Cavaglio d&#39;Agogna', '2011-11-11', '2011-12-09 10:29:49', '2011-12-09 10:29:49');
/*!40000 ALTER TABLE `gara` ENABLE KEYS */;


# Dumping structure for table atletica_valsesia.login
DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(255) NOT NULL DEFAULT '0',
  `PASSWORD` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.login: ~1 rows (approximately)
DELETE FROM `login`;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` (`ID`, `USERNAME`, `PASSWORD`) VALUES
	(1, 'sergio.belli', '18ser07gio81');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;


# Dumping structure for table atletica_valsesia.presenza
DROP TABLE IF EXISTS `presenza`;
CREATE TABLE IF NOT EXISTS `presenza` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_ATLETA` bigint(20) NOT NULL,
  `ID_GARA` bigint(20) NOT NULL,
  `ID_STAGIONE` bigint(20) NOT NULL,
  `CREATED` datetime NOT NULL,
  `MODIFIED` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_ATLETA_ID_GARA_ID_STAGIONE` (`ID_ATLETA`,`ID_GARA`,`ID_STAGIONE`),
  KEY `FK_ATLETA` (`ID_ATLETA`),
  KEY `FK_GARA` (`ID_GARA`),
  KEY `FK_STAGIONE` (`ID_STAGIONE`),
  CONSTRAINT `FK_ATLETA` FOREIGN KEY (`ID_ATLETA`) REFERENCES `atleta` (`ID`),
  CONSTRAINT `FK_GARA` FOREIGN KEY (`ID_GARA`) REFERENCES `gara` (`ID`),
  CONSTRAINT `FK_STAGIONE` FOREIGN KEY (`ID_STAGIONE`) REFERENCES `stagione` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.presenza: ~9 rows (approximately)
DELETE FROM `presenza`;
/*!40000 ALTER TABLE `presenza` DISABLE KEYS */;
INSERT INTO `presenza` (`ID`, `ID_ATLETA`, `ID_GARA`, `ID_STAGIONE`, `CREATED`, `MODIFIED`) VALUES
	(2, 1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 2, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(4, 3, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(5, 1, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(6, 15, 3, 1, '2011-12-05 06:37:44', '2011-12-05 06:37:44'),
	(7, 11, 3, 1, '2011-12-05 02:03:15', '2011-12-05 02:03:15'),
	(8, 11, 1, 1, '2011-12-05 02:03:35', '2011-12-05 02:03:35'),
	(10, 11, 2, 1, '2011-12-05 02:05:23', '2011-12-05 02:05:23'),
	(11, 38, 1, 1, '2011-12-09 10:06:19', '2011-12-09 10:06:19');
/*!40000 ALTER TABLE `presenza` ENABLE KEYS */;


# Dumping structure for table atletica_valsesia.stagione
DROP TABLE IF EXISTS `stagione`;
CREATE TABLE IF NOT EXISTS `stagione` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ANNO` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.stagione: ~1 rows (approximately)
DELETE FROM `stagione`;
/*!40000 ALTER TABLE `stagione` DISABLE KEYS */;
INSERT INTO `stagione` (`ID`, `ANNO`) VALUES
	(1, '2012');
/*!40000 ALTER TABLE `stagione` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
