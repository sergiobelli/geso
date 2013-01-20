-- 
-- Struttura della tabella `iscrizioni_societa`
-- 

CREATE TABLE `iscrizioni_societa` (
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
  `codice_fidal` varchar(8) DEFAULT NULL,
  `data_inserimento` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
