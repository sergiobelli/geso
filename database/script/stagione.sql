-- 
-- Struttura della tabella `stagione`
-- 

CREATE TABLE `stagione` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ANNO` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ANNO` (`ANNO`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
