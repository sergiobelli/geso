-- 
-- Struttura della tabella `certificato_medico`
-- 

CREATE TABLE `certificato_medico` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_atleta` bigint(20) NOT NULL,
  `data_scadenza` date NOT NULL,
  `agonistico` binary(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_atleta` (`id_atleta`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;
