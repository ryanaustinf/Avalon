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
-- Dumping data for table `ava_friend`
--

LOCK TABLES `ava_friend` WRITE;
/*!40000 ALTER TABLE `ava_friend` DISABLE KEYS */;
INSERT INTO `ava_friend` VALUES (1,2,1,1,'2015-06-10 02:40:55'),(1,3,0,1,'2015-06-10 02:40:55'),(1,4,0,1,'2015-06-10 02:40:55'),(1,6,0,1,'2015-06-10 02:40:55'),(2,1,1,1,'2015-06-10 02:40:55'),(2,3,1,1,'2015-06-10 02:40:55'),(2,4,1,1,'2015-06-10 02:40:55'),(2,5,1,1,'2015-06-10 02:40:55'),(2,6,0,1,'2015-06-10 02:40:55'),(2,7,1,1,'2015-06-10 02:40:55'),(2,8,1,1,'2015-06-10 02:40:55'),(2,9,1,1,'2015-06-10 02:40:55'),(2,10,1,1,'2015-06-10 02:40:55'),(3,2,1,1,'2015-06-10 02:40:55'),(3,4,1,1,'2015-06-10 02:40:55'),(4,2,1,1,'2015-06-10 02:40:55'),(4,3,1,1,'2015-06-10 02:40:55'),(5,2,1,1,'2015-06-10 02:40:55'),(7,2,1,1,'2015-06-10 02:40:55'),(8,2,1,1,'2015-06-10 02:40:55'),(9,2,1,1,'2015-06-10 02:40:55'),(10,2,1,1,'2015-06-10 02:40:55');
/*!40000 ALTER TABLE `ava_friend` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `ava_game`
--

LOCK TABLES `ava_game` WRITE;
/*!40000 ALTER TABLE `ava_game` DISABLE KEYS */;
INSERT INTO `ava_game` VALUES (1,2,'2015-05-12 13:03:24',NULL,1,1,1,5,10,0,0,1,'2015-06-10 02:32:29'),(2,1,'2015-05-12 14:41:00',NULL,0,0,0,8,9,0,0,1,'2015-06-10 02:32:29'),(3,3,'2015-05-12 15:12:54',NULL,0,0,0,10,10,0,0,1,'2015-06-10 02:32:29'),(4,6,'2015-05-13 16:33:46',NULL,0,0,1,5,8,0,0,1,'2015-06-10 02:32:29'),(5,4,'2015-05-13 17:28:33',NULL,0,1,1,9,10,0,0,1,'2015-06-10 02:32:29'),(6,10,'2015-06-04 14:50:49',NULL,0,0,0,5,7,0,0,1,'2015-06-10 02:32:29');
/*!40000 ALTER TABLE `ava_game` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `ava_gameplayers`
--

LOCK TABLES `ava_gameplayers` WRITE;
/*!40000 ALTER TABLE `ava_gameplayers` DISABLE KEYS */;
INSERT INTO `ava_gameplayers` VALUES (2,2,'Servant of Arthur 3',0,1,'2015-06-10 02:21:23'),(2,4,'Minion of Mordred 2',0,1,'2015-06-10 02:21:23'),(2,5,'Servant of Arthur 1',0,1,'2015-06-10 02:21:23'),(2,7,'Servant of Arthur 2',0,1,'2015-06-10 02:21:23'),(2,8,'Minion of Mordred 1',0,1,'2015-06-10 02:21:23'),(2,9,'Servant of Arthur 4',0,1,'2015-06-10 02:21:23'),(3,1,NULL,0,1,'2015-06-10 02:21:23'),(6,10,NULL,0,1,'2015-06-10 02:21:23');
/*!40000 ALTER TABLE `ava_gameplayers` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Dumping data for table `ava_member`
--

LOCK TABLES `ava_member` WRITE;
/*!40000 ALTER TABLE `ava_member` DISABLE KEYS */;
INSERT INTO `ava_member` VALUES (1,'Tyrion','Lannister','TheImp','9729c2816c2916e45a5636cf2d28734e','Smart Dwarf',0,1,0,1,'2015-06-09 07:08:02'),(2,'Ryan Austin','Fernandez','ryanaustinf','a5cb21ea5314bef0fd32666adafb82c1','DLSU Student<br/>Loves Avalon',0,1,1,1,'2015-06-09 07:08:02'),(3,'Test','Account','Test','d740bf38687f3904af2dd0bb004c6b3e','I am a test account',0,0,0,1,'2015-06-09 07:08:02'),(4,'Test','Account II','Test2','d740bf38687f3904af2dd0bb004c6b3e','I am another test account',0,0,0,1,'2015-06-09 07:08:02'),(5,'Ivan Alfonso','Chan','Chaos','31adfd4ffafc839d0d9d4f68c778b7e1','',0,0,0,1,'2015-06-09 07:08:02'),(6,'Test','Account III','Test3','d740bf38687f3904af2dd0bb004c6b3e','I like pie\r<br />\r<br />I really do\r<br />\r<br />Pie is beauty',0,0,0,1,'2015-06-09 07:08:02'),(7,'Test','Account IV','Test4','d740bf38687f3904af2dd0bb004c6b3e','',0,0,0,1,'2015-06-09 07:08:02'),(8,'Test','Account V','Test5','d740bf38687f3904af2dd0bb004c6b3e','',0,0,0,1,'2015-06-09 07:08:02'),(9,'Test','Account VI','Test6','d740bf38687f3904af2dd0bb004c6b3e','',0,0,0,1,'2015-06-09 07:08:02'),(10,'Clarisse','Poblete','cheese','95c9334d6cbdd218c24182983210f1f5','Hi',0,0,0,1,'2015-06-09 07:08:02'),(11,'Test','Test','Test7','126fee315187680008601ccb17177264','I am Test 7',0,0,0,1,'2015-06-09 07:08:02'),(12,'Test','Test IX','Test9','d740bf38687f3904af2dd0bb004c6b3e','',0,0,0,1,'2015-06-09 07:08:02'),(13,'Test','Test X','Test10','d740bf38687f3904af2dd0bb004c6b3e','',0,0,0,1,'2015-06-09 07:08:02');
/*!40000 ALTER TABLE `ava_member` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-10 10:45:30
