CREATE TABLE `configurazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codice` varchar(50) NOT NULL,
  `valore` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci'