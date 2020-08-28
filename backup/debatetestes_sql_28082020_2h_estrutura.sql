-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: localhost    Database: debate6
-- ------------------------------------------------------
-- Server version	5.7.31-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `apresentacao`
--

DROP TABLE IF EXISTS `apresentacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apresentacao` (
  `idapresentacao` int(11) NOT NULL,
  `apresentacao` text,
  `debate_iddebate` int(11) NOT NULL,
  `argumentador_idargumentador` int(11) NOT NULL,
  PRIMARY KEY (`idapresentacao`),
  KEY `FK1` (`debate_iddebate`),
  KEY `FK2` (`argumentador_idargumentador`),
  CONSTRAINT `FK1` FOREIGN KEY (`debate_iddebate`) REFERENCES `debate` (`iddebate`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK2` FOREIGN KEY (`argumentador_idargumentador`) REFERENCES `argumentador` (`idargumentador`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `argumentador`
--

DROP TABLE IF EXISTS `argumentador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `argumentador` (
  `idargumentador` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_idusuario` int(11) NOT NULL,
  `debate_iddebate` int(11) NOT NULL,
  PRIMARY KEY (`idargumentador`),
  KEY `fk_argumentador_usuario1` (`usuario_idusuario`),
  KEY `fk_argumentador_debate1` (`debate_iddebate`),
  CONSTRAINT `fk_argumentador_debate1` FOREIGN KEY (`debate_iddebate`) REFERENCES `debate` (`iddebate`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_argumentador_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1358 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPRESSED COMMENT='autor/aluno';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `argumento`
--

DROP TABLE IF EXISTS `argumento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `argumento` (
  `idargumento` int(11) NOT NULL AUTO_INCREMENT,
  `argumento` text COLLATE utf8_unicode_ci,
  `argumentador_idargumentador` int(11) NOT NULL,
  `tese_idtese` int(11) NOT NULL,
  `posicionamentoinicial` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idargumento`),
  KEY `fk_argumento_argumentador1` (`argumentador_idargumentador`),
  KEY `fk_argumento_tese1` (`tese_idtese`),
  CONSTRAINT `fk_argumento_argumentador1` FOREIGN KEY (`argumentador_idargumentador`) REFERENCES `argumentador` (`idargumentador`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_argumento_tese1` FOREIGN KEY (`tese_idtese`) REFERENCES `tese` (`idtese`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3080 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conograma`
--

DROP TABLE IF EXISTS `conograma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conograma` (
  `idconograma` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tese` date DEFAULT NULL,
  `argumento` date DEFAULT NULL,
  `revisao` date DEFAULT NULL,
  `replica` date DEFAULT NULL,
  `posfinal` date DEFAULT NULL,
  `grupo_idgrupo` int(10) unsigned NOT NULL,
  `teseini` date NOT NULL,
  `argumentoini` date NOT NULL,
  `revisaoini` date NOT NULL,
  `replicaini` date NOT NULL,
  `posfinalini` date NOT NULL,
  `reflexao` date NOT NULL,
  `apresentacao` date NOT NULL,
  PRIMARY KEY (`idconograma`),
  KEY `FK_conograma_1` (`grupo_idgrupo`),
  CONSTRAINT `FK_conograma_1` FOREIGN KEY (`grupo_idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1247 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cronogramaindividual`
--

DROP TABLE IF EXISTS `cronogramaindividual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cronogramaindividual` (
  `idcronogramaindividual` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tese` date NOT NULL,
  `argumento` date NOT NULL,
  `revisao` date NOT NULL,
  `replica` date NOT NULL,
  `posfinal` date NOT NULL,
  `debate_iddebate` int(10) unsigned NOT NULL,
  `teseini` date NOT NULL,
  `argumentoini` date NOT NULL,
  `revisaoini` date NOT NULL,
  `replicaini` date NOT NULL,
  `posfinalini` date NOT NULL,
  `reflexao` date NOT NULL,
  `apresentacao` date NOT NULL,
  PRIMARY KEY (`idcronogramaindividual`),
  KEY `debate_iddebate` (`debate_iddebate`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `debate`
--

DROP TABLE IF EXISTS `debate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debate` (
  `iddebate` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `grupo_idgrupo` int(10) unsigned NOT NULL,
  `cronogramagrupo` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`iddebate`),
  KEY `FK_debate_grupo` (`grupo_idgrupo`),
  CONSTRAINT `FK_debate_grupo` FOREIGN KEY (`grupo_idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1411 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPRESSED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `idgrupo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ativo` tinyint(3) unsigned NOT NULL,
  `dataini` date NOT NULL,
  `datafim` date NOT NULL,
  `idusuario` int(11) NOT NULL COMMENT 'usuario criador do grupo',
  `datacriacao` datetime NOT NULL,
  `publico` tinyint(1) NOT NULL DEFAULT '1',
  `blind` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idgrupo`),
  KEY `FK_usuario_grupo` (`idusuario`),
  CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1103 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hora` datetime NOT NULL,
  `log` text COLLATE utf8_unicode_ci NOT NULL,
  `idgrupo` int(10) unsigned DEFAULT NULL,
  `idusuario` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6390 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mediador`
--

DROP TABLE IF EXISTS `mediador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mediador` (
  `idmediador` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_idusuario` int(11) NOT NULL,
  `debate_iddebate` int(11) NOT NULL,
  PRIMARY KEY (`idmediador`),
  KEY `fk_mediador_usuario1` (`usuario_idusuario`),
  KEY `fk_mediador_debate` (`debate_iddebate`),
  CONSTRAINT `FK_mediador_debate` FOREIGN KEY (`debate_iddebate`) REFERENCES `debate` (`iddebate`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mediador_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1478 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `participantes`
--

DROP TABLE IF EXISTS `participantes`;
/*!50001 DROP VIEW IF EXISTS `participantes`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `participantes` AS SELECT 
 1 AS `nomecompleto`,
 1 AS `idusuario`,
 1 AS `email`,
 1 AS `idgrupo`,
 1 AS `iddebate`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `posicionamento`
--

DROP TABLE IF EXISTS `posicionamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posicionamento` (
  `argumentador_idargumentador` int(11) NOT NULL,
  `tese_idtese` int(11) NOT NULL,
  `posicionamentofinal` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`tese_idtese`,`argumentador_idargumentador`),
  KEY `fk_posicionamento_tese1` (`tese_idtese`),
  KEY `fk_posicionamento_argumentador1` (`argumentador_idargumentador`),
  CONSTRAINT `fk_posicionamento_argumentador1` FOREIGN KEY (`argumentador_idargumentador`) REFERENCES `argumentador` (`idargumentador`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_posicionamento_tese1` FOREIGN KEY (`tese_idtese`) REFERENCES `tese` (`idtese`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reflexao`
--

DROP TABLE IF EXISTS `reflexao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reflexao` (
  `idreflexao` int(11) NOT NULL AUTO_INCREMENT,
  `reflexao` text,
  `argumentador_idargumentador` int(11) NOT NULL,
  `debate_iddebate` int(11) NOT NULL,
  PRIMARY KEY (`idreflexao`,`argumentador_idargumentador`,`debate_iddebate`),
  KEY `fk_reflexao_argumentador1` (`argumentador_idargumentador`),
  KEY `fk_reflexao_debate1` (`debate_iddebate`),
  CONSTRAINT `fk_reflexao_argumentador1` FOREIGN KEY (`argumentador_idargumentador`) REFERENCES `argumentador` (`idargumentador`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_reflexao_debate1` FOREIGN KEY (`debate_iddebate`) REFERENCES `debate` (`iddebate`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `replica`
--

DROP TABLE IF EXISTS `replica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replica` (
  `argumentador_idargumentador` int(11) NOT NULL,
  `revisao_idrevisao` int(11) NOT NULL,
  `replica` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`argumentador_idargumentador`,`revisao_idrevisao`),
  KEY `fk_replica_argumentador1` (`argumentador_idargumentador`),
  KEY `fk_replica_revisao1` (`revisao_idrevisao`),
  CONSTRAINT `fk_replica_argumentador1` FOREIGN KEY (`argumentador_idargumentador`) REFERENCES `argumentador` (`idargumentador`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_replica_revisao1` FOREIGN KEY (`revisao_idrevisao`) REFERENCES `revisao` (`idrevisao`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revisao`
--

DROP TABLE IF EXISTS `revisao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revisao` (
  `idrevisao` int(11) NOT NULL AUTO_INCREMENT,
  `revisao` text COLLATE utf8_unicode_ci,
  `revisor_idrevisor` int(11) NOT NULL,
  `argumento_idargumento` int(11) NOT NULL,
  PRIMARY KEY (`idrevisao`),
  KEY `fk_Revisao_revisor1` (`revisor_idrevisor`),
  KEY `fk_revisao_argumento1` (`argumento_idargumento`),
  CONSTRAINT `fk_Revisao_revisor1` FOREIGN KEY (`revisor_idrevisor`) REFERENCES `revisor` (`idrevisor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_revisao_argumento1` FOREIGN KEY (`argumento_idargumento`) REFERENCES `argumento` (`idargumento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4824 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revisor`
--

DROP TABLE IF EXISTS `revisor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revisor` (
  `idrevisor` int(11) NOT NULL AUTO_INCREMENT,
  `debate_iddebate` int(11) NOT NULL,
  `usuario_idusuario` int(11) NOT NULL,
  `ordem` int(11) NOT NULL COMMENT 'ordem dos revisores',
  PRIMARY KEY (`idrevisor`),
  KEY `fk_revisor_debate1` (`debate_iddebate`),
  KEY `fk_revisor_usuario1` (`usuario_idusuario`),
  CONSTRAINT `fk_revisor_debate1` FOREIGN KEY (`debate_iddebate`) REFERENCES `debate` (`iddebate`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_revisor_usuario1` FOREIGN KEY (`usuario_idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1442 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tese`
--

DROP TABLE IF EXISTS `tese`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tese` (
  `idtese` int(11) NOT NULL AUTO_INCREMENT,
  `tese` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `debate_iddebate` int(11) DEFAULT NULL,
  `grupo_idgrupo` int(10) unsigned DEFAULT NULL,
  `alias` varchar(20) DEFAULT 'padrao',
  PRIMARY KEY (`idtese`),
  KEY `fk_mediador_has_debate_debate1` (`debate_iddebate`),
  KEY `FK_tese_grupo` (`grupo_idgrupo`),
  CONSTRAINT `FK_tese_grupo` FOREIGN KEY (`grupo_idgrupo`) REFERENCES `grupo` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_mediador_has_debate_debate1` FOREIGN KEY (`debate_iddebate`) REFERENCES `debate` (`iddebate`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=1514 DEFAULT CHARSET=utf8 COMMENT='permissao de postagem falta\npara revisao, replica , ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `primeironome` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `sobrenome` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '12345',
  `grupo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=1418 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `participantes`
--

/*!50001 DROP VIEW IF EXISTS `participantes`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `participantes` AS select concat(`u`.`primeironome`,_utf8' ',`u`.`sobrenome`) AS `nomecompleto`,`u`.`idusuario` AS `idusuario`,`u`.`email` AS `email`,`g`.`idgrupo` AS `idgrupo`,`d`.`iddebate` AS `iddebate` from (((`usuario` `u` join `debate` `d`) join `grupo` `g`) join `argumentador` `a`) where ((`g`.`idgrupo` = `d`.`grupo_idgrupo`) and (`d`.`iddebate` = `a`.`debate_iddebate`) and (`a`.`usuario_idusuario` = `u`.`idusuario`) and (`u`.`idusuario` = `u`.`idusuario`)) order by concat(`u`.`primeironome`,_utf8' ',`u`.`sobrenome`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-28  3:15:13
