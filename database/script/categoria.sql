CREATE TABLE `categoria` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CODICE` varchar(4) NOT NULL,
  `SESSO` varchar(1) NOT NULL,
  `DESCRIZIONE` varchar(250) NOT NULL,
  `DA` int(11) NOT NULL,
  `A` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci'