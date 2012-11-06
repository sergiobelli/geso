-- 
-- Struttura della tabella `login`
-- 

CREATE TABLE `login` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(255) NOT NULL DEFAULT '0',
  `PASSWORD` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `USERNAME_PASSWORD` (`USERNAME`,`PASSWORD`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;