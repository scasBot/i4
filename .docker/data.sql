-- MySQL dump 10.13  Distrib 8.0.21, for macos10.15 (x86_64)
--
-- Host: localhost    Database: masmallc_scas
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE `masmallc_scas`;
USE `masmallc_scas`;

--
-- Table structure for table `db_CaseInfo`
--
DROP TABLE IF EXISTS `db_CaseInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_CaseInfo` (
  `CaseInfoID` int NOT NULL AUTO_INCREMENT,
  `ClientID` int NOT NULL DEFAULT '0',
  `CaseTypeID` int NOT NULL DEFAULT '0',
  `Date` datetime DEFAULT NULL,
  `CategoryID` int NOT NULL DEFAULT '0',
  `CaseSide` varchar(16) DEFAULT NULL,
  `Opposing` varchar(64) DEFAULT NULL,
  `OpposingCorp` char(1) DEFAULT NULL,
  `Notes` longtext,
  `RecAction` longtext,
  `CreateBy` int NOT NULL DEFAULT '0',
  `LastEditBy` int NOT NULL DEFAULT '0',
  `OfficeID` int NOT NULL DEFAULT '0',
  `ReferredTo` int NOT NULL DEFAULT '0',
  `LastAccessed` char(1) NOT NULL DEFAULT '0',
  `BilingualRef` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CaseInfoID`),
  KEY `ClientID` (`ClientID`),
  KEY `CaseTypeID` (`CaseTypeID`),
  KEY `CreateBy` (`CreateBy`),
  KEY `LastEditBy` (`LastEditBy`),
  KEY `CategoryID` (`CategoryID`),
  KEY `OfficeID` (`OfficeID`),
  KEY `ReferredTo` (`ReferredTo`)
) ENGINE=MyISAM AUTO_INCREMENT=11009 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_CaseInfo`
--

LOCK TABLES `db_CaseInfo` WRITE;
/*!40000 ALTER TABLE `db_CaseInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_CaseInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_CaseTypes`
--

DROP TABLE IF EXISTS `db_CaseTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_CaseTypes` (
  `CaseTypeID` int NOT NULL DEFAULT '0',
  `Description` varchar(128) DEFAULT NULL,
  `Deprecated` char(1) DEFAULT '0',
  PRIMARY KEY (`CaseTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_CaseTypes`
--

LOCK TABLES `db_CaseTypes` WRITE;
/*!40000 ALTER TABLE `db_CaseTypes` DISABLE KEYS */;
INSERT INTO `db_CaseTypes` VALUES (99,'Case complete','1'),(20,'Case Pending','1'),(51,'Case referred (external)','0'),(52,'Case referred (Legal Research)','0'),(1,'Urgent','1'),(21,'Never been contacted','0'),(9,'Legal Research reply received','0'),(90,'Cannot contact','0'),(60,'Client assisted, likely to call again','1'),(98,'Client assisted, not likely to call again','1'),(11,'Phone tag','0'),(22,'1 message left','0'),(23,'2 messages left','0'),(24,'3+ messages left','0'),(15,'Needs to be contacted','1'),(61,'Client assisted','0'),(97,'Assistance not required','0'),(10,'Upcoming Appointment','0'),(25,'Voicemail, Helped','0'),(12,'Email Tag','0'),(0,'Undefined','0'),(96,'Timed Out','0'),(100,'Urgent, foreign language','0'),(101,'Urgent, time sensitive','0'),(102,'Urgent, upcoming court date','0');
/*!40000 ALTER TABLE `db_CaseTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_Categories`
--

DROP TABLE IF EXISTS `db_Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_Categories` (
  `CategoryID` int NOT NULL AUTO_INCREMENT,
  `Description` varchar(64) DEFAULT NULL,
  `SortKey` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`CategoryID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_Categories`
--

LOCK TABLES `db_Categories` WRITE;
/*!40000 ALTER TABLE `db_Categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_Clients`
--

DROP TABLE IF EXISTS `db_Clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_Clients` (
  `ClientID` int NOT NULL AUTO_INCREMENT,
  `LastName` varchar(32) DEFAULT NULL,
  `FirstName` varchar(32) DEFAULT NULL,
  `Phone1AreaCode` char(3) DEFAULT NULL,
  `Phone1Number` varchar(8) DEFAULT NULL,
  `LongDistance1` char(1) DEFAULT NULL,
  `Phone1Type` char(1) DEFAULT NULL,
  `Phone2AreaCode` char(3) DEFAULT NULL,
  `Phone2Number` varchar(8) DEFAULT NULL,
  `LongDistance2` char(1) DEFAULT NULL,
  `Phone2Type` char(1) DEFAULT NULL,
  `Address1` varchar(64) DEFAULT NULL,
  `Address2` varchar(64) DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  `State` char(2) DEFAULT 'MA',
  `ZIP` varchar(5) DEFAULT NULL,
  `Country` varchar(16) DEFAULT 'USA',
  `Language` varchar(16) DEFAULT 'English',
  `Notes` longtext,
  `DemosOK` char(1) NOT NULL DEFAULT '0',
  `ReferralSource` text,
  `ReferralSpecify` text NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `CaseTypeID` int NOT NULL DEFAULT '0',
  `CategoryID` int NOT NULL DEFAULT '10',
  `LastEditTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time of Last Edit, Auto-MYSQL Updated',
  `CourtDate` date DEFAULT NULL,
  PRIMARY KEY (`ClientID`)
) ENGINE=MyISAM AUTO_INCREMENT=19072 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_Clients`
--

LOCK TABLES `db_Clients` WRITE;
/*!40000 ALTER TABLE `db_Clients` DISABLE KEYS */;
INSERT INTO `db_Clients` VALUES (19067,'o','i','123','456-7890',NULL,NULL,'','-',NULL,NULL,'',NULL,'','MA','','USA','English','','0','','','',21,0,'2020-11-07 00:35:40','0000-00-00'),(19068,'Client','Test','','-',NULL,NULL,'','-',NULL,NULL,'',NULL,'','MA','','USA','English','','0','','','',21,0,'2020-11-20 20:20:13','0000-00-00'),(19069,'Client','Test','','-',NULL,NULL,'','-',NULL,NULL,'',NULL,'','MA','','USA','English','','0','','','',21,0,'2020-11-20 20:20:53','0000-00-00'),(19070,'client','test','','-',NULL,NULL,'','-',NULL,NULL,'',NULL,'','MA','','USA','English','','0','','','',21,0,'2020-11-20 20:21:47','0000-00-00'),(19071,'client','test','','-',NULL,NULL,'','-',NULL,NULL,'',NULL,'','MA','','USA','English','','0','','','test@gmail.com',21,0,'2020-11-29 01:20:54','0000-00-00');
/*!40000 ALTER TABLE `db_Clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_Contact`
--

DROP TABLE IF EXISTS `db_Contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_Contact` (
  `ContactID` int NOT NULL AUTO_INCREMENT,
  `ClientID` int NOT NULL DEFAULT '0',
  `CaseInfoID` int NOT NULL DEFAULT '0',
  `UserID` int NOT NULL DEFAULT '0',
  `GroupID` int NOT NULL DEFAULT '0',
  `Date` datetime DEFAULT NULL,
  `ContactTypeID` int DEFAULT NULL,
  PRIMARY KEY (`ContactID`),
  KEY `ClientID` (`ClientID`),
  KEY `UserID` (`UserID`),
  KEY `CaseInfoID` (`CaseInfoID`)
) ENGINE=MyISAM AUTO_INCREMENT=47856 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_Contact`
--

LOCK TABLES `db_Contact` WRITE;
/*!40000 ALTER TABLE `db_Contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_Contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_ContactTypes`
--

DROP TABLE IF EXISTS `db_ContactTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_ContactTypes` (
  `ContactTypeID` int NOT NULL DEFAULT '0',
  `Description` varchar(64) DEFAULT NULL,
  `Visible` char(1) DEFAULT NULL,
  PRIMARY KEY (`ContactTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_ContactTypes`
--

LOCK TABLES `db_ContactTypes` WRITE;
/*!40000 ALTER TABLE `db_ContactTypes` DISABLE KEYS */;
INSERT INTO `db_ContactTypes` VALUES (1,'Create client record','1'),(2,'Create new case record','0'),(10,'Called, left message','1'),(11,'Called, no answer','1'),(12,'Called, helped by phone','1'),(13,'Called, wrong number','1'),(90,'Case referred to external agency','0'),(20,'Call received, helped by phone','1'),(21,'Voicemail received','1'),(91,'Case referred to GBLS Office','0'),(92,'Case referred to Legal Research','1'),(99,'Case marked complete','0'),(93,'Case referred to PBH Office','0'),(24,'Legal Research replied to question','0'),(30,'Met with client','1'),(97,'Assistance not required','1'),(31,'Appointment scheduled','1'),(15,'Email Received','1'),(16,'Email, Response Sent','1'),(14,'Called, number not in service','1'),(3,'Survey: Administered over phone','1'),(4,'Survey: Sent email','1'),(5,'Survey: Emailed survey completed','1');
/*!40000 ALTER TABLE `db_ContactTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_Demographics`
--

DROP TABLE IF EXISTS `db_Demographics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_Demographics` (
  `RecordID` int NOT NULL AUTO_INCREMENT,
  `ZIP` varchar(5) DEFAULT NULL,
  `SizeHousehold` int DEFAULT NULL,
  `HouseholdIncome` int DEFAULT NULL,
  `Race` varchar(32) DEFAULT NULL,
  `Occupation` varchar(32) DEFAULT NULL,
  `Gender` char(1) DEFAULT NULL,
  `Age` int DEFAULT NULL,
  `PublicAssist` char(1) DEFAULT NULL,
  `PublicAssistType` varchar(64) DEFAULT NULL,
  `ReferralSource` varchar(64) DEFAULT NULL,
  `Notes` text,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SourceReferral` int DEFAULT NULL,
  `PrimaryLanguage` int unsigned NOT NULL,
  PRIMARY KEY (`RecordID`)
) ENGINE=MyISAM AUTO_INCREMENT=1276 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_Demographics`
--

LOCK TABLES `db_Demographics` WRITE;
/*!40000 ALTER TABLE `db_Demographics` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_Demographics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_Emails`
--

DROP TABLE IF EXISTS `db_Emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_Emails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isAssigned` tinyint(1) NOT NULL,
  `ClientID` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_Emails`
--

LOCK TABLES `db_Emails` WRITE;
/*!40000 ALTER TABLE `db_Emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_Emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_ReferralSources`
--

DROP TABLE IF EXISTS `db_ReferralSources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_ReferralSources` (
  `ReferralSourceID` int NOT NULL AUTO_INCREMENT,
  `Description` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `SortKey` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ReferralSourceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_ReferralSources`
--

LOCK TABLES `db_ReferralSources` WRITE;
/*!40000 ALTER TABLE `db_ReferralSources` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_ReferralSources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbi4_Contacts`
--

DROP TABLE IF EXISTS `dbi4_Contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dbi4_Contacts` (
  `ContactID` int NOT NULL AUTO_INCREMENT,
  `ClientID` int NOT NULL,
  `UserAddedID` int NOT NULL,
  `UserEditID` int NOT NULL,
  `ContactDate` datetime NOT NULL,
  `ContactEditDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last time somebody edited the contact',
  `ContactTypeID` int NOT NULL,
  `ContactSummary` longtext,
  PRIMARY KEY (`ContactID`),
  KEY `ClientID` (`ClientID`,`UserAddedID`),
  KEY `UserEditID` (`UserEditID`)
) ENGINE=MyISAM AUTO_INCREMENT=7442 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dbi4_Contacts`
--

LOCK TABLES `dbi4_Contacts` WRITE;
/*!40000 ALTER TABLE `dbi4_Contacts` DISABLE KEYS */;
INSERT INTO `dbi4_Contacts` VALUES (7413,19071,1872,1872,'2020-11-20 14:53:29','2020-11-20 20:53:40',15,'<p>Test</p>'),(7414,19071,1872,1872,'2020-11-20 14:53:46','2020-11-20 20:53:56',5,'<p>Test</p>'),(7415,19071,1872,1872,'2020-11-20 14:55:35','2020-11-20 20:55:41',16,'<p>Test</p>'),(7416,19071,1872,1872,'2020-11-20 14:57:35','2020-11-20 20:57:48',1,'<p>Test 2</p>'),(7417,19071,1872,1872,'2020-11-20 14:59:22','2020-11-20 20:59:27',15,'<p>test again</p>'),(7418,19071,1872,1872,'2020-11-20 14:59:33','2020-11-20 20:59:43',16,'<p>rwts</p>'),(7419,19071,1872,1872,'2020-11-20 15:00:50','2020-11-20 21:00:54',15,'<p>Hi</p>'),(7420,19071,1872,1872,'2020-11-20 15:01:21','2020-11-20 21:01:27',15,'<p>Hey</p>'),(7421,19071,1872,1872,'2020-11-20 15:01:32','2020-11-20 21:01:38',4,'<p>Hey</p>'),(7422,19071,1872,1872,'2020-11-20 15:02:16','2020-11-20 21:02:22',1,'<p>Hello</p>'),(7423,19071,1872,1872,'2020-11-20 15:02:27','2020-11-20 21:02:34',4,'<p>Hello theree</p>'),(7424,19071,1872,1872,'2020-11-20 16:21:54','2020-11-20 22:22:02',21,'<p>Blah</p>'),(7425,19071,1872,1872,'2020-11-20 16:39:04','2020-11-20 22:39:11',21,'<p>test</p>'),(7426,19071,1872,1872,'2020-11-20 16:39:53','2020-11-20 22:39:57',21,'<p>st</p>'),(7427,19071,1872,1872,'2020-11-20 16:42:52','2020-11-20 22:42:58',3,'<p>Hiihbsdknj</p>'),(7428,19071,1872,1872,'2020-11-28 18:21:12','2020-11-29 00:21:17',21,'<p>Heller</p>'),(7429,19071,1872,1872,'2020-11-28 18:48:14','2020-11-29 00:48:28',5,'<p>\"Test\" ’test’ &lt;woah&gt;</p>'),(7430,19071,1872,1872,'2020-11-28 18:51:45','2020-11-29 00:51:51',21,'<p>&lt;testing tags&gt;</p>'),(7431,19071,1872,1872,'2020-11-28 18:52:43','2020-11-29 00:52:48',21,'<p>’hello’</p>'),(7432,19071,1872,1872,'2020-11-28 18:53:03','2020-11-29 00:53:08',21,'<p>\"test\"</p>'),(7433,19071,1872,1872,'2020-11-28 18:53:12','2020-11-29 00:53:22',5,'<p>\"Test\"</p>'),(7434,19071,1872,1872,'2020-11-28 18:55:43','2020-11-29 00:55:51',5,'<p>\"Test\"</p>'),(7435,19071,1872,1872,'2020-11-28 18:56:41','2020-11-29 00:56:46',13,'<p>test</p>'),(7436,19071,1872,1872,'2020-11-28 19:14:44','2020-11-29 01:14:57',12,'<p>Lalalla</p>'),(7437,19071,1872,1872,'2020-11-28 19:16:20','2020-11-29 01:16:26',15,'<p>Llalal</p>'),(7438,19071,1872,1872,'2020-11-28 19:16:36','2020-11-29 01:16:40',15,'<p>Test.</p>'),(7439,19071,1872,1872,'2020-11-28 19:17:59','2020-11-29 01:18:05',16,'<p>Hi there</p>'),(7440,19071,1872,1872,'2020-11-28 19:20:49','2020-11-29 02:42:57',2,'<p>blah blah</p>'),(7441,19069,1872,1872,'2020-10-28 20:30:54','2020-10-29 01:30:59',15,'<p>Blah</p>');
/*!40000 ALTER TABLE `dbi4_Contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i3_Admins`
--

DROP TABLE IF EXISTS `i3_Admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `i3_Admins` (
  `UserID` int NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i3_Admins`
--

LOCK TABLES `i3_Admins` WRITE;
/*!40000 ALTER TABLE `i3_Admins` DISABLE KEYS */;
/*!40000 ALTER TABLE `i3_Admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i3_Announce`
--

DROP TABLE IF EXISTS `i3_Announce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `i3_Announce` (
  `AnnounceID` int NOT NULL AUTO_INCREMENT,
  `UserID` int DEFAULT NULL,
  `Name` varchar(128) DEFAULT NULL,
  `Description` text,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `Start` date DEFAULT NULL,
  `End` date DEFAULT NULL,
  `Committee` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`AnnounceID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i3_Announce`
--

LOCK TABLES `i3_Announce` WRITE;
/*!40000 ALTER TABLE `i3_Announce` DISABLE KEYS */;
/*!40000 ALTER TABLE `i3_Announce` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i3_Calendar`
--

DROP TABLE IF EXISTS `i3_Calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `i3_Calendar` (
  `CalID` int NOT NULL AUTO_INCREMENT,
  `Begin` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `User1ID` char(5) DEFAULT NULL,
  `User2ID` char(5) DEFAULT NULL,
  `User3ID` char(5) DEFAULT NULL,
  `isWorkgroup` char(1) DEFAULT NULL,
  `OfficeID` char(1) DEFAULT NULL,
  PRIMARY KEY (`CalID`)
) ENGINE=MyISAM AUTO_INCREMENT=1543 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i3_Calendar`
--

LOCK TABLES `i3_Calendar` WRITE;
/*!40000 ALTER TABLE `i3_Calendar` DISABLE KEYS */;
/*!40000 ALTER TABLE `i3_Calendar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i3_Log`
--

DROP TABLE IF EXISTS `i3_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `i3_Log` (
  `LogID` int NOT NULL AUTO_INCREMENT,
  `UserID` int NOT NULL DEFAULT '0',
  `GroupID` int NOT NULL DEFAULT '0',
  `OfficeID` int DEFAULT NULL,
  `Login` datetime DEFAULT NULL,
  `LastAction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Logout` datetime DEFAULT NULL,
  `IP` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`LogID`)
) ENGINE=MyISAM AUTO_INCREMENT=26256 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i3_Log`
--

LOCK TABLES `i3_Log` WRITE;
/*!40000 ALTER TABLE `i3_Log` DISABLE KEYS */;
INSERT INTO `i3_Log` VALUES (17684,1872,0,NULL,'2020-10-10 00:22:40','2020-11-13 03:14:28','2020-10-10 09:59:36','::1'),(17685,1872,0,NULL,'2020-10-10 10:00:05','2020-11-13 03:14:28',NULL,'::1'),(17686,1872,0,NULL,'2020-10-10 10:00:56','2020-11-13 03:14:28','2020-10-10 14:59:47','::1'),(17687,1872,0,NULL,'2020-10-10 18:16:40','2020-11-13 03:14:28',NULL,'::1'),(17688,1872,0,NULL,'2020-10-10 18:16:41','2020-11-13 03:14:28','2020-10-10 18:19:11','::1'),(17689,1872,0,NULL,'2020-10-10 18:19:23','2020-11-13 03:14:28',NULL,'::1'),(17690,1872,0,NULL,'2020-10-22 15:42:45','2020-11-13 03:14:28','2020-10-22 16:45:53','::1'),(17691,1872,0,NULL,'2020-10-22 17:20:35','2020-11-13 03:14:28',NULL,'::1'),(17692,1872,0,NULL,'2020-11-05 17:02:39','2020-11-13 03:14:28','2020-11-06 17:10:48','::1'),(17693,1872,0,NULL,'2020-11-06 17:10:57','2020-11-13 03:14:28',NULL,'::1'),(17694,1872,0,NULL,'2020-11-06 18:34:57','2020-11-13 03:14:28',NULL,'::1'),(17695,1872,0,NULL,'2020-11-06 18:35:10','2020-11-13 03:14:28',NULL,'::1'),(17696,1872,0,NULL,'2020-11-12 20:38:09','2020-11-13 03:14:28',NULL,'127.0.0.1'),(17697,1872,0,NULL,'2020-11-12 20:40:04','2020-11-13 03:53:25',NULL,'127.0.0.1'),(22707,1872,0,NULL,'2018-10-18 13:12:04','2020-11-13 03:14:28',NULL,'65.112.8.133'),(23063,1872,0,NULL,'2018-11-29 13:16:48','2020-11-13 03:14:28','2018-12-01 11:24:30','65.112.8.26'),(23088,1872,0,NULL,'2018-12-01 11:24:35','2020-11-13 03:14:28',NULL,'65.112.8.143'),(23116,1872,0,NULL,'2018-12-04 19:20:59','2020-11-13 03:14:28',NULL,'65.112.8.20'),(23132,1872,0,NULL,'2018-12-08 11:30:52','2020-11-13 03:14:28',NULL,'65.112.8.141'),(23166,1872,0,NULL,'2019-01-17 14:08:25','2020-11-13 03:14:28',NULL,'172.58.99.139'),(23183,1872,0,NULL,'2019-02-03 11:34:33','2020-11-13 03:14:28','2019-02-03 15:06:15','65.112.8.25'),(23185,1872,0,NULL,'2019-02-03 15:06:18','2020-11-13 03:14:28',NULL,'65.112.8.25'),(23202,1872,0,NULL,'2019-02-10 12:51:38','2020-11-13 03:14:28',NULL,'65.112.8.55'),(23230,1872,0,NULL,'2019-02-12 17:45:59','2020-11-13 03:14:28',NULL,'65.112.8.54'),(23266,1872,0,NULL,'2019-02-16 09:25:32','2020-11-13 03:14:28','2019-02-16 15:53:40','172.58.216.191'),(23311,1872,0,NULL,'2019-02-21 15:15:42','2020-11-13 03:14:28','2019-02-22 14:43:02','65.112.8.27'),(23326,1872,0,NULL,'2019-02-23 11:40:57','2020-11-13 03:14:28','2019-02-24 10:46:10','65.112.8.141'),(23331,1872,0,NULL,'2019-02-24 10:46:13','2020-11-13 03:14:28',NULL,'65.112.8.141'),(23334,1872,0,NULL,'2019-02-24 13:59:15','2020-11-13 03:14:28',NULL,'65.112.8.27'),(23372,1872,0,NULL,'2019-02-28 00:01:06','2020-11-13 03:14:28','2019-02-28 14:12:57','65.112.8.27'),(23382,1872,0,NULL,'2019-02-28 14:13:13','2020-11-13 03:14:28','2019-02-28 16:45:52','65.112.8.201'),(23384,1872,0,NULL,'2019-02-28 16:45:58','2020-11-13 03:14:28','2019-03-02 12:40:29','65.112.8.27'),(23401,1872,0,NULL,'2019-03-02 12:40:35','2020-11-13 03:14:28','2019-03-02 13:42:39','65.112.8.27'),(23402,1872,0,NULL,'2019-03-02 13:42:48','2020-11-13 03:14:28',NULL,'65.112.8.27'),(23458,1872,0,NULL,'2019-03-07 19:40:55','2020-11-13 03:14:28','2019-03-07 22:11:29','65.112.8.27'),(23459,1872,0,NULL,'2019-03-07 22:11:42','2020-11-13 03:14:28','2019-03-08 12:30:00','65.112.8.27'),(23467,1872,0,NULL,'2019-03-08 12:30:11','2020-11-13 03:14:28','2019-03-08 12:36:16','65.112.8.135'),(23469,1872,0,NULL,'2019-03-08 12:39:39','2020-11-13 03:14:28',NULL,'65.112.8.203'),(23470,1872,0,NULL,'2019-03-08 12:39:49','2020-11-13 03:14:28',NULL,'65.112.8.135'),(23471,1872,0,NULL,'2019-03-08 12:39:49','2020-11-13 03:14:28',NULL,'65.112.8.135'),(23472,1872,0,NULL,'2019-03-08 12:39:50','2020-11-13 03:14:28','2019-03-08 12:44:41','65.112.8.135'),(23489,1872,0,NULL,'2019-03-09 11:48:51','2020-11-13 03:14:28','2019-03-09 12:54:18','65.112.8.27'),(23497,1872,0,NULL,'2019-03-09 12:54:21','2020-11-13 03:14:28','2019-03-10 12:04:58','65.112.8.27'),(23664,1872,0,NULL,'2019-03-30 13:43:38','2020-11-13 03:14:28',NULL,'65.112.8.56'),(23786,1872,0,NULL,'2019-04-06 13:32:45','2020-11-13 03:14:28',NULL,'65.112.8.56'),(23903,1872,0,NULL,'2019-04-14 13:53:41','2020-11-13 03:14:28',NULL,'65.112.8.18'),(24008,1872,0,NULL,'2019-04-20 13:54:26','2020-11-13 03:14:28',NULL,'65.112.8.18'),(24140,1872,0,NULL,'2019-05-02 17:03:12','2020-11-13 03:14:28',NULL,'65.112.8.22'),(24247,1872,0,NULL,'2019-06-22 09:40:42','2020-11-13 03:14:28','2019-06-22 09:41:52','65.112.8.28'),(24392,1872,0,NULL,'2019-07-12 15:31:01','2020-11-13 03:14:28',NULL,'104.132.1.75'),(24403,1872,0,NULL,'2019-07-14 12:25:22','2020-11-13 03:14:28',NULL,'69.124.221.165'),(24541,1872,0,NULL,'2019-08-06 19:28:36','2020-11-13 03:14:28',NULL,'69.124.221.210'),(24548,1872,0,NULL,'2019-08-10 11:52:24','2020-11-13 03:14:28',NULL,'69.124.221.210'),(24567,1872,0,NULL,'2019-09-08 08:25:59','2020-11-13 03:14:28',NULL,'65.112.8.1'),(24596,1872,0,NULL,'2019-09-16 18:17:39','2020-11-13 03:14:28',NULL,'65.112.8.143'),(24600,1872,0,NULL,'2019-09-16 21:34:48','2020-11-13 03:14:28',NULL,'65.112.8.29'),(24601,1872,0,NULL,'2019-09-16 22:30:30','2020-11-13 03:14:28',NULL,'65.112.8.4'),(24652,1872,0,NULL,'2019-09-20 17:50:53','2020-11-13 03:14:28',NULL,'65.112.8.11'),(24658,1872,0,NULL,'2019-09-21 12:35:49','2020-11-13 03:14:28',NULL,'65.112.8.3'),(24730,1872,0,NULL,'2019-09-28 13:00:20','2020-11-13 03:14:28',NULL,'65.112.8.53'),(24820,1872,0,NULL,'2019-10-06 10:08:58','2020-11-13 03:14:28',NULL,'65.112.8.24'),(24895,1872,0,NULL,'2019-10-12 15:59:53','2020-11-13 03:14:28',NULL,'65.112.8.25'),(24901,1872,0,NULL,'2019-10-15 09:29:42','2020-11-13 03:14:28',NULL,'65.112.8.10'),(24941,1872,0,NULL,'2019-10-19 22:43:38','2020-11-13 03:14:28',NULL,'67.134.204.5'),(24942,1872,0,NULL,'2019-10-20 10:15:14','2020-11-13 03:14:28',NULL,'65.112.8.25'),(25035,1872,0,NULL,'2019-10-26 15:26:38','2020-11-13 03:14:28',NULL,'65.112.8.22'),(25098,1872,0,NULL,'2019-10-30 16:44:40','2020-11-13 03:14:28',NULL,'65.112.8.11'),(25124,1872,0,NULL,'2019-11-02 15:09:12','2020-11-13 03:14:28',NULL,'65.112.8.22'),(25128,1872,0,NULL,'2019-11-02 18:15:19','2020-11-13 03:14:28',NULL,'65.112.8.4'),(25159,1872,0,NULL,'2019-11-04 10:17:14','2020-11-13 03:14:28',NULL,'65.112.8.22'),(25185,1872,0,NULL,'2019-11-05 17:37:38','2020-11-13 03:14:28',NULL,'65.112.8.22'),(25228,1872,0,NULL,'2019-11-09 14:59:37','2020-11-13 03:14:28','2019-11-09 15:34:03','65.112.8.22'),(25231,1872,0,NULL,'2019-11-09 15:50:05','2020-11-13 03:14:28',NULL,'65.112.8.22'),(25233,1872,0,NULL,'2019-11-10 09:16:12','2020-11-13 03:14:28',NULL,'65.112.8.1'),(25281,1872,0,NULL,'2019-11-13 15:47:25','2020-11-13 03:14:28',NULL,'65.112.8.22'),(25283,1872,0,NULL,'2019-11-13 17:34:01','2020-11-13 03:14:28',NULL,'65.112.8.2'),(25329,1872,0,NULL,'2019-11-17 10:14:27','2020-11-13 03:14:28',NULL,'65.112.8.2'),(25330,1872,0,NULL,'2019-11-17 10:43:15','2020-11-13 03:14:28',NULL,'65.112.8.2'),(25334,1872,0,NULL,'2019-11-17 11:23:36','2020-11-13 03:14:28',NULL,'65.112.8.2'),(25337,1872,0,NULL,'2019-11-17 14:24:27','2020-11-13 03:14:28',NULL,'65.112.8.25'),(25342,1872,0,NULL,'2019-11-17 15:11:06','2020-11-13 03:14:28',NULL,'65.112.8.25'),(25369,1872,0,NULL,'2019-11-17 16:38:21','2020-11-13 03:14:28',NULL,'65.112.8.25'),(25387,1872,0,NULL,'2019-11-18 15:31:38','2020-11-13 03:14:28',NULL,'65.112.8.25'),(25480,1872,0,NULL,'2019-12-08 12:58:57','2020-11-13 03:14:28',NULL,'65.112.8.5'),(25482,1872,0,NULL,'2019-12-11 14:57:00','2020-11-13 03:14:28',NULL,'65.112.8.5'),(25483,1872,0,NULL,'2019-12-12 16:57:36','2020-11-13 03:14:28',NULL,'65.112.8.59'),(25486,1872,0,NULL,'2019-12-19 12:18:53','2020-11-13 03:14:28',NULL,'172.58.99.160'),(25502,1872,0,NULL,'2020-01-05 19:08:36','2020-11-13 03:14:28',NULL,'172.58.99.222'),(25515,1872,0,NULL,'2020-01-07 21:03:06','2020-11-13 03:14:28',NULL,'172.58.102.223'),(25624,1872,0,NULL,'2020-02-10 16:30:37','2020-11-13 03:14:28',NULL,'65.112.8.6'),(25691,1872,0,NULL,'2020-02-16 13:11:10','2020-11-13 03:14:28',NULL,'65.112.8.10'),(25803,1872,0,NULL,'2020-02-28 09:03:21','2020-11-13 03:14:28',NULL,'65.112.8.24'),(25810,1872,0,NULL,'2020-02-29 09:04:30','2020-11-13 03:14:28',NULL,'65.112.8.24'),(25820,1872,0,NULL,'2020-03-01 13:13:47','2020-11-13 03:14:28',NULL,'65.112.8.1'),(25846,1872,0,NULL,'2020-03-02 19:42:59','2020-11-13 03:14:28',NULL,'65.112.8.13'),(25892,1872,0,NULL,'2020-03-07 09:00:48','2020-11-13 03:14:28',NULL,'65.112.8.24'),(25899,1872,0,NULL,'2020-03-07 15:14:27','2020-11-13 03:14:28',NULL,'65.112.8.24'),(25959,1872,0,NULL,'2020-04-17 10:26:19','2020-11-13 03:14:28',NULL,'107.77.80.84'),(25962,1872,0,NULL,'2020-04-24 09:57:33','2020-11-13 03:14:28',NULL,'104.11.206.31'),(25971,1872,0,NULL,'2020-05-15 22:14:47','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26038,1872,0,NULL,'2020-08-06 19:19:34','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26041,1872,0,NULL,'2020-08-08 17:05:30','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26042,1872,0,NULL,'2020-08-08 18:42:03','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26044,1872,0,NULL,'2020-08-10 11:15:11','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26045,1872,0,NULL,'2020-08-10 19:41:01','2020-11-13 03:14:28',NULL,'107.77.72.85'),(26047,1872,0,NULL,'2020-08-12 15:43:34','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26056,1872,0,NULL,'2020-08-19 09:28:00','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26086,1872,0,NULL,'2020-09-12 15:14:38','2020-11-13 03:14:28',NULL,'24.130.148.109'),(26111,1872,0,NULL,'2020-09-28 13:19:24','2020-11-13 03:14:28',NULL,'24.130.148.109'),(26150,1872,0,NULL,'2020-10-10 13:07:11','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26151,1872,0,NULL,'2020-10-10 17:11:42','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26152,1872,0,NULL,'2020-10-10 18:09:32','2020-11-13 03:14:28','2020-10-10 18:22:36','104.11.206.31'),(26153,1872,0,NULL,'2020-10-10 18:31:07','2020-11-13 03:14:28',NULL,'104.11.206.31'),(26154,1872,0,NULL,'2020-10-10 19:13:03','2020-11-13 03:14:28',NULL,'174.240.6.67'),(26164,1872,0,NULL,'2020-10-13 19:11:40','2020-11-13 03:14:28',NULL,'174.235.4.225'),(26186,1872,0,NULL,'2020-10-22 14:31:30','2020-11-13 03:14:28',NULL,'174.235.4.225'),(26223,1872,0,NULL,'2020-11-05 15:50:30','2020-11-13 03:14:28',NULL,'174.235.2.87'),(26228,1872,0,NULL,'2020-11-06 16:14:53','2020-11-13 03:14:28',NULL,'174.235.2.87'),(26229,1872,0,NULL,'2020-11-07 13:21:39','2020-11-13 03:14:28',NULL,'174.235.6.232'),(26241,1872,0,NULL,'2020-11-10 19:39:57','2020-11-13 03:14:28',NULL,'174.235.9.199'),(26249,1872,0,NULL,'2020-11-12 15:24:29','2020-11-13 03:14:28',NULL,'174.240.2.110'),(26250,1872,0,NULL,'2020-11-12 19:31:14','2020-11-13 03:14:28',NULL,'174.240.2.110'),(26251,1872,0,NULL,'2020-11-19 15:38:49','2020-11-19 21:38:55','2020-11-19 17:23:36','::1'),(26252,1872,0,NULL,'2020-11-19 17:23:48','2020-11-19 23:23:49','2020-11-20 13:55:10','::1'),(26253,1872,0,NULL,'2020-11-20 13:55:21','2020-11-20 22:42:58',NULL,'::1'),(26254,1872,0,NULL,'2020-11-28 17:50:40','2020-11-29 02:45:25','2020-11-29 10:20:38','::1'),(26255,1872,0,NULL,'2020-11-29 10:20:47','2020-11-29 16:57:16',NULL,'::1');
/*!40000 ALTER TABLE `i3_Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i3_Passwords`
--

DROP TABLE IF EXISTS `i3_Passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `i3_Passwords` (
  `UserID` int NOT NULL,
  `hash` varchar(60) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i3_Passwords`
--

LOCK TABLES `i3_Passwords` WRITE;
/*!40000 ALTER TABLE `i3_Passwords` DISABLE KEYS */;
INSERT INTO `i3_Passwords` VALUES (1872,'$1$lY4gAXb8$XSasmifG6g1vuiekAhyLp/');
/*!40000 ALTER TABLE `i3_Passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i3_Quotes`
--

DROP TABLE IF EXISTS `i3_Quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `i3_Quotes` (
  `quote` varchar(200) NOT NULL,
  PRIMARY KEY (`quote`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i3_Quotes`
--

LOCK TABLES `i3_Quotes` WRITE;
/*!40000 ALTER TABLE `i3_Quotes` DISABLE KEYS */;
/*!40000 ALTER TABLE `i3_Quotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `i3_Users`
--

DROP TABLE IF EXISTS `i3_Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `i3_Users` (
  `UserID` int unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) DEFAULT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `YOG` int DEFAULT NULL,
  `Comper` char(1) NOT NULL DEFAULT '0',
  `GroupID` int DEFAULT '0',
  `LegalResearch` char(1) NOT NULL DEFAULT '0',
  `LegalResearchDir` char(1) NOT NULL DEFAULT '0',
  `Communications` char(1) NOT NULL DEFAULT '0',
  `CommunicationsDir` char(1) NOT NULL DEFAULT '0',
  `Finance` char(1) NOT NULL DEFAULT '0',
  `FinanceDir` char(1) NOT NULL DEFAULT '0',
  `Training` char(1) NOT NULL DEFAULT '0',
  `TrainingDir` char(1) NOT NULL DEFAULT '0',
  `TrainingWGL` char(1) NOT NULL DEFAULT '0',
  `BostonOffice` char(1) NOT NULL DEFAULT '0',
  `BostonOfficeDir` char(1) NOT NULL DEFAULT '0',
  `CommunityOutreach` char(1) NOT NULL DEFAULT '0',
  `CommunityOutreachDir` char(1) NOT NULL DEFAULT '0',
  `CourthouseRelations` char(1) NOT NULL DEFAULT '0',
  `CourthouseRelationsDir` char(1) NOT NULL DEFAULT '0',
  `LawReform` char(1) NOT NULL DEFAULT '0',
  `LawReformDir` char(1) NOT NULL DEFAULT '0',
  `PBHOffice` char(1) NOT NULL DEFAULT '0',
  `PBHOfficeDir` char(1) NOT NULL DEFAULT '0',
  `Admin` char(1) NOT NULL DEFAULT '0',
  `Hidden` char(1) NOT NULL DEFAULT '0',
  `Bilingual` char(1) NOT NULL DEFAULT '0',
  `BilingualDir` char(1) NOT NULL DEFAULT '0',
  `Chinatown` char(1) DEFAULT '0',
  `ChinatownDir` char(1) DEFAULT '0',
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=1875 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `i3_Users`
--

LOCK TABLES `i3_Users` WRITE;
/*!40000 ALTER TABLE `i3_Users` DISABLE KEYS */;
INSERT INTO `i3_Users` VALUES (1872,'Test User','test@college.harvard.edu',2022,'0',0,'0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','1','0','0','0','0','0');
/*!40000 ALTER TABLE `i3_Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-03 12:40:16
