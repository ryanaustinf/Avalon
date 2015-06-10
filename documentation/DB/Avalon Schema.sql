CREATE DATABASE  IF NOT EXISTS `avalon` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `avalon`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: avalon
-- ------------------------------------------------------
-- Server version	5.6.22-log

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
-- Table structure for table `ava_friend`
--

DROP TABLE IF EXISTS `ava_friend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ava_friend` (
  `fromMember` int(11) NOT NULL,
  `toMember` int(11) NOT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`fromMember`,`toMember`),
  KEY `friendfk_2_idx` (`toMember`),
  CONSTRAINT `friendfk_1` FOREIGN KEY (`fromMember`) REFERENCES `ava_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `friendfk_2` FOREIGN KEY (`toMember`) REFERENCES `ava_member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ava_game`
--

DROP TABLE IF EXISTS `ava_game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ava_game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host` int(11) DEFAULT NULL,
  `hosted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ended` datetime DEFAULT NULL,
  `ongoing` tinyint(1) NOT NULL DEFAULT '0',
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  `friendsOnly` tinyint(1) NOT NULL DEFAULT '0',
  `minPlayers` int(11) NOT NULL DEFAULT '5',
  `maxPlayers` int(11) NOT NULL DEFAULT '10',
  `targeting` tinyint(1) NOT NULL DEFAULT '0',
  `ladyOfTheLake` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `gamefk_1_idx` (`host`),
  CONSTRAINT `gamefk_1` FOREIGN KEY (`host`) REFERENCES `ava_member` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ava_gameplayers`
--

DROP TABLE IF EXISTS `ava_gameplayers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ava_gameplayers` (
  `gameId` int(11) NOT NULL,
  `memberId` int(11) NOT NULL,
  `character` varchar(32) DEFAULT NULL,
  `immuneToLady` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`gameId`,`memberId`),
  KEY `gamepfk_1_idx` (`memberId`),
  CONSTRAINT `gamepfk_1` FOREIGN KEY (`memberId`) REFERENCES `ava_member` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `gamepfk_2` FOREIGN KEY (`gameId`) REFERENCES `ava_game` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ava_member`
--

DROP TABLE IF EXISTS `ava_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ava_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `bio` varchar(512) DEFAULT NULL,
  `gamesPlayed` int(11) DEFAULT '0',
  `moder` bigint(11) NOT NULL DEFAULT '0',
  `admin` bigint(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-10 10:45:30
