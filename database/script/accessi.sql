CREATE TABLE `accessi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(20) NOT NULL DEFAULT '',
  `ip` varchar(15) DEFAULT NULL,
  `host` varchar(255) NOT NULL DEFAULT 'NULL',
  `pagina` varchar(255) DEFAULT 'NULL',
  `operazione` varchar(50) DEFAULT 'NULL',
  `data` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci'