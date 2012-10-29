# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.16-log
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2012-03-06 10:18:04
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
  `DATA_TESSERAMENTO` date NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NOME_COGNOME_SESSO_DATA_NASCITA` (`NOME`,`COGNOME`,`SESSO`,`DATA_NASCITA`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.atleta: ~40 rows (approximately)
DELETE FROM `atleta`;
/*!40000 ALTER TABLE `atleta` DISABLE KEYS */;
INSERT INTO `atleta` (`ID`, `NOME`, `COGNOME`, `SESSO`, `DATA_NASCITA`, `CREATED`, `MODIFIED`) VALUES
	(1, 'Sergio', 'Belli', 'M', '1981-07-18', '2011-12-13 05:01:06', '2011-12-13 05:01:06'),
	(2, 'Francesca', 'Ravarotto', 'F', '2011-11-30', '2011-11-30 17:32:45', '2011-11-30 17:32:45'),
	(3, 'Fulvia', 'Demattei', 'F', '2011-11-30', '2011-11-30 17:33:03', '2011-11-30 17:33:03'),
	(4, 'Danilo', 'Belli', 'M', '1951-06-02', '2011-12-03 16:08:14', '2011-12-03 16:08:17'),
	(10, 'Valeria', 'Viano', 'F', '1977-03-16', '2011-12-05 01:38:09', '2011-12-05 01:38:09'),
	(11, 'Fausto', 'Agliotti', 'M', '1949-01-01', '2011-12-05 01:38:49', '2011-12-05 01:38:49'),
	(12, 'Edoardo', 'Lamanna', 'M', '1971-07-09', '2011-12-05 01:37:52', '2011-12-05 01:37:52'),
	(14, 'Andrea', 'Bertarello', 'M', '1972-01-01', '2011-12-13 04:49:00', '2011-12-13 04:49:00'),
	(15, 'Ivan', 'Delgrosso', 'M', '1961-01-01', '2011-12-09 04:17:58', '2011-12-09 04:17:58'),
	(17, 'Enrico', 'Moschini', 'M', '1975-01-01', '2011-12-13 04:45:43', '2011-12-13 04:45:43'),
	(18, 'Sofia', 'Canetta', 'F', '1986-01-01', '2011-12-09 08:52:25', '2011-12-09 08:52:25'),
	(42, 'Ermes', 'Zonca', 'M', '1990-01-01', '2011-12-13 04:27:41', '2011-12-13 04:27:41'),
	(43, 'Silvano', 'Zonca', 'M', '1954-01-01', '2011-12-13 04:27:52', '2011-12-13 04:27:52'),
	(44, 'Lino', 'Roncali', 'M', '1940-01-01', '2011-12-13 04:41:45', '2011-12-13 04:41:45'),
	(45, 'Giovanna', 'Botturi', 'F', '1940-01-01', '2011-12-13 04:42:18', '2011-12-13 04:42:18'),
	(46, 'Paolo', 'Quattrocchi', 'M', '1962-01-01', '2011-12-13 04:42:39', '2011-12-13 04:42:39'),
	(47, 'Manuela', 'Trevisan', 'F', '1965-01-01', '2011-12-13 04:42:54', '2011-12-13 04:42:54'),
	(48, 'Gianfranco', 'Re', 'M', '1942-01-01', '2011-12-13 04:43:14', '2011-12-13 04:43:14'),
	(49, 'Cesare', 'Roberto', 'M', '1946-01-01', '2011-12-13 04:43:26', '2011-12-13 04:43:26'),
	(50, 'Claudia', 'Bonola', 'F', '1941-01-01', '2011-12-13 04:43:42', '2011-12-13 04:43:42'),
	(51, 'Monica', 'Rosa', 'F', '1999-01-01', '2011-12-13 04:43:57', '2011-12-13 04:43:57'),
	(52, 'Rita', 'Pareti', 'F', '1962-01-01', '2011-12-13 04:44:12', '2011-12-13 04:44:12'),
	(53, 'Claudio', 'Rodighiero', 'M', '1962-01-01', '2011-12-13 04:44:52', '2011-12-13 04:44:52'),
	(54, 'Damiana', 'Facchinetti', 'F', '1959-01-01', '2011-12-13 04:46:13', '2011-12-13 04:46:13'),
	(55, 'Enzo', 'Marchesini', 'M', '1962-01-01', '2011-12-13 04:46:40', '2011-12-13 04:46:40'),
	(56, 'Antonio', 'Nicolino', 'M', '1982-01-01', '2011-12-13 04:47:01', '2011-12-13 04:47:01'),
	(57, 'Alberto', 'Ballarini', 'M', '1975-01-01', '2011-12-13 04:47:33', '2011-12-13 04:47:33'),
	(58, 'Aldo', 'Mina', 'M', '1952-01-01', '2011-12-13 04:47:45', '2011-12-13 04:47:45'),
	(59, 'Vito', 'Amoruso', 'M', '1949-01-01', '2011-12-13 04:47:55', '2011-12-13 04:47:55'),
	(60, 'Roberto', 'Roncali', 'M', '1964-01-01', '2011-12-13 04:48:11', '2011-12-13 04:48:11'),
	(61, 'Andrea', 'Brumana', 'M', '1988-01-01', '2011-12-13 04:48:23', '2011-12-13 04:48:23'),
	(62, 'Matteo', 'Brumana', 'M', '1992-01-01', '2011-12-13 04:48:33', '2011-12-13 04:48:33'),
	(63, 'Alessandro', 'Curacanova', 'M', '1957-01-01', '2011-12-13 04:48:45', '2011-12-13 04:48:45'),
	(64, 'Elvio', 'Vinzio', 'M', '1969-01-01', '2011-12-13 04:49:31', '2011-12-13 04:49:31'),
	(65, 'Maria', 'Galantina', 'F', '1964-01-01', '2011-12-13 04:49:43', '2011-12-13 04:49:43'),
	(66, 'Andrea', 'Montanarelli', 'M', '1960-01-01', '2011-12-13 04:49:55', '2011-12-13 04:49:55'),
	(67, 'Attilio', 'Galli', 'M', '1955-01-01', '2011-12-13 04:50:13', '2011-12-13 04:50:13'),
	(68, 'Ugo', 'Vinzio', 'M', '1959-01-01', '2011-12-13 04:50:26', '2011-12-13 04:50:26'),
	(69, 'Massimiliano', 'Ferrari', 'M', '1972-01-01', '2011-12-13 04:50:41', '2011-12-13 04:50:41'),
	(70, 'Andrea', 'Bandi', 'M', '1974-01-01', '2011-12-13 04:50:53', '2011-12-13 04:50:53');
/*!40000 ALTER TABLE `atleta` ENABLE KEYS */;


# Dumping structure for table atletica_valsesia.gara
DROP TABLE IF EXISTS `gara`;
CREATE TABLE IF NOT EXISTS `gara` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `CODICE` varchar(15) NOT NULL,
  `NOME` varchar(200) NOT NULL,
  `CAMPIONATO` varchar(255) DEFAULT NULL,
  `LOCALITA` varchar(200) NOT NULL,
  `DATA` date NOT NULL,
  `CREATED` datetime NOT NULL,
  `MODIFIED` datetime NOT NULL,
  `NOSTRA` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `NOME_CAMPIONATO_LOCALITA_DATA` (`NOME`,`CAMPIONATO`,`LOCALITA`,`DATA`,`CODICE`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.gara: ~5 rows (approximately)
DELETE FROM `gara`;
/*!40000 ALTER TABLE `gara` DISABLE KEYS */;
INSERT INTO `gara` (`ID`, `CODICE`, `NOME`, `CAMPIONATO`, `LOCALITA`, `DATA`, `CREATED`, `MODIFIED`, `NOSTRA`) VALUES
	(1, '1', 'Maratonina Terre d&#39;Acqua', 'Grand Prix BI-VC', 'Trino', '2011-11-27', '2011-12-05 02:28:58', '2011-12-05 02:28:58', '0'),
	(2, '2', 'Cross di Piatto', 'Cross Provinciale', 'Piatto', '2011-12-11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0'),
	(3, 'Cross del Panettone', NULL, 'Prato Sesia', '2011-12-25', '2011-12-05 02:28:20', '2011-12-05 02:28:20'),
	(16, '3', 'Ammazzainverno', 'Ammazzainverno', 'Invorio Superiore', '2011-12-08', '2011-12-09 10:12:08', '2011-12-09 10:12:08', '0'),
	(18, '4', 'Ammazzainverno', 'Ammazzainverno', 'Cavaglio d&#39;Agogna', '2011-11-11', '2011-12-09 10:29:49', '2011-12-09 10:29:49', '0'),
	(19, '5', 'Cross di Quarona', 'n.d.', 'Quarona', '2012-01-02', '2012-01-02 23:17:13', '0000-00-00 00:00:00', '1'),
	(23, 'm6bewtrk1jzboba', 'qqqq', 'qqqq', 'qqqq', '2011-12-26', '2012-01-24 05:46:18', '2012-01-24 05:46:18', '0'),
	(24, '56e7uvvr5wb0xzt', 'wwww', 'wwww', 'wwww', '2011-12-26', '2012-01-24 05:46:58', '2012-01-24 05:46:58', '0'),
	(25, '3n8mvrrmd2tp0hq', 'eeee', 'eeee', 'eeee', '2011-12-26', '2012-01-24 05:47:11', '2012-01-24 05:47:11', '0'),
	(26, 'nslcqq1cyol9tch', 'rrrr', 'rrrr', 'rrrr', '2011-12-26', '2012-01-24 05:57:17', '2012-01-24 05:57:17', 'S'),
	(27, 'uq2rc34zxf5gqji', 'xxxx', 'xxxx', 'xxxx', '2011-11-11', '2012-03-05 06:52:26', '2012-03-05 06:52:26', 'S'),
	(28, 'kosh69ipn81vw21', 'xxxx', 'xxxx', 'xxxx', '2011-11-11', '2012-03-05 06:52:39', '2012-03-05 06:52:39', 'N'),
	(29, 'kmrzr6c0ojlloz6', 'xxxxx', 'xxxxx', 'xxxxx', '2011-11-11', '2012-03-05 06:53:00', '2012-03-05 06:53:00', 'N');
/*!40000 ALTER TABLE `gara` ENABLE KEYS */;


# Dumping structure for table atletica_valsesia.iscrizioni_societa
DROP TABLE IF EXISTS `iscrizioni_societa`;
CREATE TABLE IF NOT EXISTS `iscrizioni_societa` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '0',
  `cognome` varchar(255) NOT NULL DEFAULT '0',
  `sesso` varchar(1) NOT NULL DEFAULT '0',
  `data_nascita` date NOT NULL,
  `luogo_nascita` varchar(255) NOT NULL DEFAULT '0',
  `indirizzo_residenza` varchar(255) NOT NULL DEFAULT '0',
  `comune_residenza` varchar(255) NOT NULL DEFAULT '0',
  `provincia_residenza` varchar(2) NOT NULL DEFAULT '0',
  `numero_telefono` varchar(20) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT '0',
  `data_inserimento` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.iscrizioni_societa: ~2 rows (approximately)
DELETE FROM `iscrizioni_societa`;
/*!40000 ALTER TABLE `iscrizioni_societa` DISABLE KEYS */;
INSERT INTO `iscrizioni_societa` (`id`, `nome`, `cognome`, `sesso`, `data_nascita`, `luogo_nascita`, `indirizzo_residenza`, `comune_residenza`, `provincia_residenza`, `numero_telefono`, `email`, `data_inserimento`) VALUES
	(1, 'sergio', 'belli', 'M', '0000-00-00', 'Varallo', 'via barazze 6', 'Cossato', 'BI', '1234567890', 'sergiobelli81@gmail.com', '2012-02-21 03:25:35'),
	(2, 'sergio', 'belli', 'M', '1981-07-18', 'Varallo', 'via barazze 6', 'Cossato', 'BI', '1234567890', 'sergiobelli81@gmail.com', '2012-02-21 03:26:43');
/*!40000 ALTER TABLE `iscrizioni_societa` ENABLE KEYS */;


# Dumping structure for table atletica_valsesia.login
DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(255) NOT NULL DEFAULT '0',
  `PASSWORD` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `USERNAME_PASSWORD` (`USERNAME`,`PASSWORD`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.login: ~1 rows (approximately)
DELETE FROM `login`;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` (`ID`, `USERNAME`, `PASSWORD`) VALUES
	(1, 'sergio.belli', '18ser07gio81');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;


# Dumping structure for table atletica_valsesia.preiscrizioni
DROP TABLE IF EXISTS `preiscrizioni`;
CREATE TABLE IF NOT EXISTS `preiscrizioni` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NOME_ATLETA` varchar(255) NOT NULL,
  `COGNOME_ATLETA` varchar(255) NOT NULL,
  `SESSO_ATLETA` varchar(1) NOT NULL,
  `ANNO_NASCITA_ATLETA` varchar(4) DEFAULT NULL,
  `CATEGORIA_ATLETA` varchar(10) DEFAULT NULL,
  `CODICE_FIDAL_ATLETA` varchar(10) DEFAULT NULL,
  `NOME_SOCIETA` varchar(255) NOT NULL,
  `CODICE_SOCIETA` varchar(5) DEFAULT NULL,
  `EMAIL_ATLETA` varchar(255) DEFAULT NULL,
  `ID_GARA` bigint(20) NOT NULL,
  `CODICE_GARA` varchar(15) NOT NULL,
  `CREATED` datetime DEFAULT NULL,
  `MODIFIED` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNIQUE_ATLETA_GARA` (`NOME_ATLETA`,`COGNOME_ATLETA`,`SESSO_ATLETA`,`ANNO_NASCITA_ATLETA`,`CODICE_FIDAL_ATLETA`,`ID_GARA`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.preiscrizioni: ~3 rows (approximately)
DELETE FROM `preiscrizioni`;
/*!40000 ALTER TABLE `preiscrizioni` DISABLE KEYS */;
INSERT INTO `preiscrizioni` (`ID`, `NOME_ATLETA`, `COGNOME_ATLETA`, `SESSO_ATLETA`, `ANNO_NASCITA_ATLETA`, `CATEGORIA_ATLETA`, `CODICE_FIDAL_ATLETA`, `NOME_SOCIETA`, `CODICE_SOCIETA`, `EMAIL_ATLETA`, `ID_GARA`, `CODICE_GARA`, `CREATED`, `MODIFIED`) VALUES
	(2, 'Sergio', 'Belli', 'M', '1981', 'SM', 'AH015011', 'Atletica Valsesia', 'VC045', 'xxx', 18, '4', '2012-01-02 10:05:44', '2012-01-02 10:05:44'),
	(3, 'Danilo', 'Belli', 'M', '1951', 'MM60', 'AH015012', 'Atletica Valsesia', 'VC045', 'xxx', 19, '5', '2012-01-02 10:26:27', '2012-01-02 10:26:27'),
	(4, 'Sergio', 'Belli', 'M', '1981', 'SM', 'AH015011', 'Atletica Valsesia', 'VC045', 'xxx', 19, '5', '2012-01-02 10:30:07', '2012-01-02 10:30:07');
/*!40000 ALTER TABLE `preiscrizioni` ENABLE KEYS */;


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
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ANNO` (`ANNO`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table atletica_valsesia.stagione: ~1 rows (approximately)
DELETE FROM `stagione`;
/*!40000 ALTER TABLE `stagione` DISABLE KEYS */;
INSERT INTO `stagione` (`ID`, `ANNO`) VALUES
	(2, '2011'),
	(1, '2012');
/*!40000 ALTER TABLE `stagione` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
