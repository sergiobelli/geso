-- 
-- Struttura della tabella `tipologia_gara`
-- 

CREATE TABLE `tipologia_gara` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(200) NOT NULL DEFAULT '',
  `punteggio` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci' AUTO_INCREMENT=6 ;
