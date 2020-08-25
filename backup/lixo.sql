--
-- Table structure for table `posicionamento`
--

CREATE TABLE IF NOT EXISTS `posicionamento` (
  `argumentador_idargumentador` int(11) NOT NULL,
  `tese_idtese` int(11) NOT NULL,
  `posicionamentofinal` text collate utf8_unicode_ci,
  PRIMARY KEY  (`tese_idtese`,`argumentador_idargumentador`),
  KEY `fk_posicionamento_tese1` (`tese_idtese`),
  KEY `fk_posicionamento_argumentador1` (`argumentador_idargumentador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED;



CREATE TABLE IF NOT EXISTS `conograma` (
  `idconograma` int(11) unsigned NOT NULL auto_increment,
  `tese` date default NULL,
  `argumento` date default NULL,
  `revisao` date default NULL,
  `replica` date default NULL,
  `posfinal` date default NULL,
  `grupo_idgrupo` int(11) unsigned NOT NULL,
  `teseini` date NOT NULL,
  `argumentoini` date NOT NULL,
  `revisaoini` date NOT NULL,
  `replicaini` date NOT NULL,
  `posfinalini` date NOT NULL,
  `reflexao` date NOT NULL,
  `apresentacao` date NOT NULL,
  PRIMARY KEY  (`idconograma`),
  KEY `FK_conograma_1` (`grupo_idgrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1242 ;

