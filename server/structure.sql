-- MySQL dump 10.11
--
-- Host: mysql.hcs.harvard.edu    Database: scas
-- ------------------------------------------------------
-- Server version	5.0.96-0ubuntu3-log

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
-- Table structure for table `Answers`
--

DROP TABLE IF EXISTS `Answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Answers` (
  `AnswerID` int(4) NOT NULL default '0',
  `ParentQuestion` varchar(4) default NULL,
  `ChildQuestion` varchar(4) default NULL,
  `AnswerHTML` blob,
  PRIMARY KEY  (`AnswerID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Gloss`
--

DROP TABLE IF EXISTS `Gloss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Gloss` (
  `DefID` varchar(4) NOT NULL default '',
  `DefWord` varchar(40) default NULL,
  `DefText` blob,
  PRIMARY KEY  (`DefID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Questions`
--

DROP TABLE IF EXISTS `Questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Questions` (
  `QuestionID` varchar(4) NOT NULL default '',
  `QuestionHTML` blob,
  PRIMARY KEY  (`QuestionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_Appointments`
--

DROP TABLE IF EXISTS `db_Appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Appointments` (
  `CaseInfoID` int(11) default NULL,
  `Date` datetime default NULL,
  `MetWith` char(1) default NULL,
  KEY `CaseInfoID` (`CaseInfoID`),
  KEY `Date` (`Date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_CaseInfo`
--

DROP TABLE IF EXISTS `db_CaseInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_CaseInfo` (
  `CaseInfoID` int(11) NOT NULL auto_increment,
  `ClientID` int(11) NOT NULL default '0',
  `CaseTypeID` int(11) NOT NULL default '0',
  `Date` datetime default NULL,
  `CategoryID` int(11) NOT NULL default '0',
  `CaseSide` varchar(16) default NULL,
  `Opposing` varchar(64) default NULL,
  `OpposingCorp` char(1) default NULL,
  `Notes` longtext,
  `RecAction` longtext,
  `CreateBy` int(11) NOT NULL default '0',
  `LastEditBy` int(11) NOT NULL default '0',
  `OfficeID` int(11) NOT NULL default '0',
  `ReferredTo` int(11) NOT NULL default '0',
  `LastAccessed` char(1) NOT NULL default '0',
  `BilingualRef` char(1) NOT NULL default '0',
  PRIMARY KEY  (`CaseInfoID`),
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
-- Table structure for table `db_CaseTypes`
--

DROP TABLE IF EXISTS `db_CaseTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_CaseTypes` (
  `CaseTypeID` int(11) NOT NULL default '0',
  `Description` varchar(128) default NULL,
  `Deprecated` char(1) default '0',
  PRIMARY KEY  (`CaseTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_Categories`
--

DROP TABLE IF EXISTS `db_Categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Categories` (
  `CategoryID` int(11) NOT NULL auto_increment,
  `Description` varchar(64) default NULL,
  `SortKey` int(11) NOT NULL default '0',
  PRIMARY KEY  (`CategoryID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_Clients`
--

DROP TABLE IF EXISTS `db_Clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Clients` (
  `ClientID` int(11) NOT NULL auto_increment,
  `LastName` varchar(32) default NULL,
  `FirstName` varchar(32) default NULL,
  `Phone1AreaCode` char(3) default NULL,
  `Phone1Number` varchar(8) default NULL,
  `LongDistance1` char(1) default NULL,
  `Phone1Type` char(1) default NULL,
  `Phone2AreaCode` char(3) default NULL,
  `Phone2Number` varchar(8) default NULL,
  `LongDistance2` char(1) default NULL,
  `Phone2Type` char(1) default NULL,
  `Address1` varchar(64) default NULL,
  `Address2` varchar(64) default NULL,
  `City` varchar(32) default NULL,
  `State` char(2) default 'MA',
  `ZIP` varchar(5) default NULL,
  `Country` varchar(16) default 'USA',
  `Language` varchar(16) default 'English',
  `Notes` longtext,
  `DemosOK` char(1) NOT NULL default '0',
  `ReferralSource` text NOT NULL,
  `ReferralSpecify` text NOT NULL,
  `Email` varchar(100) default NULL,
  `CaseTypeID` int(11) NOT NULL default '0',
  `CategoryID` int(11) NOT NULL default '10',
  PRIMARY KEY  (`ClientID`)
) ENGINE=MyISAM AUTO_INCREMENT=16745 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_Contact`
--

DROP TABLE IF EXISTS `db_Contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Contact` (
  `ContactID` int(11) NOT NULL auto_increment,
  `ClientID` int(11) NOT NULL default '0',
  `CaseInfoID` int(11) NOT NULL default '0',
  `UserID` int(11) NOT NULL default '0',
  `GroupID` int(11) NOT NULL default '0',
  `Date` datetime default NULL,
  `ContactTypeID` int(11) default NULL,
  PRIMARY KEY  (`ContactID`),
  KEY `ClientID` (`ClientID`),
  KEY `UserID` (`UserID`),
  KEY `CaseInfoID` (`CaseInfoID`)
) ENGINE=MyISAM AUTO_INCREMENT=47856 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_ContactTypes`
--

DROP TABLE IF EXISTS `db_ContactTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_ContactTypes` (
  `ContactTypeID` int(11) NOT NULL default '0',
  `Description` varchar(64) default NULL,
  `Visible` char(1) default NULL,
  PRIMARY KEY  (`ContactTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_CourtInfo`
--

DROP TABLE IF EXISTS `db_CourtInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_CourtInfo` (
  `CourtID` int(11) NOT NULL auto_increment,
  `County` varchar(12) default NULL,
  `Name` varchar(60) default NULL,
  `Ordinal` varchar(4) default NULL,
  `Phone` varchar(100) default NULL,
  `EXT` varchar(9) default NULL,
  `Address1` varchar(32) default NULL,
  `Address2` varchar(32) default NULL,
  `City` varchar(16) default NULL,
  `ZIP` varchar(5) default NULL,
  PRIMARY KEY  (`CourtID`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_CourtTown`
--

DROP TABLE IF EXISTS `db_CourtTown`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_CourtTown` (
  `TownID` int(11) NOT NULL auto_increment,
  `Name` varchar(16) default NULL,
  `CourtID` int(11) NOT NULL default '0',
  PRIMARY KEY  (`TownID`),
  KEY `CourtID` (`CourtID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_Demographics`
--

DROP TABLE IF EXISTS `db_Demographics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Demographics` (
  `RecordID` int(11) NOT NULL auto_increment,
  `ZIP` varchar(5) default NULL,
  `SizeHousehold` int(11) default NULL,
  `HouseholdIncome` int(11) default NULL,
  `Race` varchar(32) default NULL,
  `Occupation` varchar(32) default NULL,
  `Gender` char(1) default NULL,
  `Age` int(11) default NULL,
  `PublicAssist` char(1) default NULL,
  `PublicAssistType` varchar(64) default NULL,
  `ReferralSource` varchar(64) default NULL,
  `Notes` text,
  `DATE` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `SourceReferral` int(11) default NULL,
  `PrimaryLanguage` int(2) unsigned NOT NULL,
  PRIMARY KEY  (`RecordID`)
) ENGINE=MyISAM AUTO_INCREMENT=1276 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_Flags`
--

DROP TABLE IF EXISTS `db_Flags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Flags` (
  `FlagID` int(11) NOT NULL auto_increment,
  `CaseInfoID` int(11) NOT NULL default '0',
  `ClientID` int(11) NOT NULL default '0',
  `UserID` int(11) NOT NULL default '0',
  `Date` datetime default NULL,
  `FlagText` text,
  PRIMARY KEY  (`FlagID`),
  KEY `CaseInfoID` (`CaseInfoID`),
  KEY `ClientID` (`ClientID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_LocalAC`
--

DROP TABLE IF EXISTS `db_LocalAC`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_LocalAC` (
  `AC` char(3) NOT NULL default '',
  `Local` char(1) default '1',
  PRIMARY KEY  (`AC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_TownExchanges`
--

DROP TABLE IF EXISTS `db_TownExchanges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_TownExchanges` (
  `AreaCode` int(3) default NULL,
  `Exchange` int(3) default NULL,
  `Town` varchar(30) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_TownToCourtID`
--

DROP TABLE IF EXISTS `db_TownToCourtID`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_TownToCourtID` (
  `Town` varchar(30) default NULL,
  `CourtID` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dbi4_Contacts`
--

DROP TABLE IF EXISTS `dbi4_Contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbi4_Contacts` (
  `ContactID` int(11) NOT NULL auto_increment,
  `ClientID` int(11) NOT NULL,
  `UserAddedID` int(11) NOT NULL,
  `UserEditID` int(11) NOT NULL,
  `ContactDate` datetime NOT NULL,
  `ContactEditDate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP COMMENT 'Last time somebody edited the contact',
  `ContactTypeID` int(11) NOT NULL,
  `ContactSummary` longtext,
  PRIMARY KEY  (`ContactID`),
  KEY `ClientID` (`ClientID`,`UserAddedID`),
  KEY `UserEditID` (`UserEditID`)
) ENGINE=MyISAM AUTO_INCREMENT=1251 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dbi4_Priority`
--

DROP TABLE IF EXISTS `dbi4_Priority`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbi4_Priority` (
  `ClientID` int(11) NOT NULL,
  `CaseTypeID` int(11) NOT NULL,
  PRIMARY KEY  (`ClientID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `example`
--

DROP TABLE IF EXISTS `example`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `example` (
  `id` int(11) default NULL,
  `data` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fl_Info`
--

DROP TABLE IF EXISTS `fl_Info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fl_Info` (
  `QuestionID` int(11) NOT NULL default '0',
  `CaseInfoID` int(11) NOT NULL default '0',
  `QuestionText` blob,
  `ClientName` varchar(64) default NULL,
  `UserID_Submit` int(11) NOT NULL default '0',
  `UserID_Reply` int(11) NOT NULL default '0',
  `Time_Submit` datetime default NULL,
  `ReplyDone` char(1) NOT NULL default '0',
  `Time_Reply` datetime default NULL,
  `ReplyText` blob,
  `ReplyApproved` char(1) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Admins`
--

DROP TABLE IF EXISTS `i3_Admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Admins` (
  `UserID` int(11) NOT NULL,
  PRIMARY KEY  (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Announce`
--

DROP TABLE IF EXISTS `i3_Announce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Announce` (
  `AnnounceID` int(11) NOT NULL auto_increment,
  `UserID` int(11) default NULL,
  `Name` varchar(128) default NULL,
  `Description` text,
  `Date` date default NULL,
  `Time` time default NULL,
  `Start` date default NULL,
  `End` date default NULL,
  `Committee` varchar(32) default NULL,
  PRIMARY KEY  (`AnnounceID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Apps`
--

DROP TABLE IF EXISTS `i3_Apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Apps` (
  `AppID` int(11) NOT NULL auto_increment,
  `AppName` varchar(50) default NULL,
  `Description` text,
  `AppDir` varchar(32) default NULL,
  `Password` varchar(16) default NULL,
  `SortKey` int(11) default NULL,
  `Committee` varchar(64) default NULL,
  PRIMARY KEY  (`AppID`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Calendar`
--

DROP TABLE IF EXISTS `i3_Calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Calendar` (
  `CalID` int(11) NOT NULL auto_increment,
  `Begin` datetime default NULL,
  `End` datetime default NULL,
  `User1ID` char(5) default NULL,
  `User2ID` char(5) default NULL,
  `User3ID` char(5) default NULL,
  `isWorkgroup` char(1) default NULL,
  `OfficeID` char(1) default NULL,
  PRIMARY KEY  (`CalID`)
) ENGINE=MyISAM AUTO_INCREMENT=1543 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Committees`
--

DROP TABLE IF EXISTS `i3_Committees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Committees` (
  `CommitteeID` int(11) NOT NULL auto_increment,
  `DirName` varchar(24) default NULL,
  `ShortName` varchar(24) NOT NULL default '',
  `LongName` varchar(64) default NULL,
  PRIMARY KEY  (`CommitteeID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Log`
--

DROP TABLE IF EXISTS `i3_Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Log` (
  `LogID` int(11) NOT NULL auto_increment,
  `UserID` int(11) NOT NULL default '0',
  `GroupID` int(11) NOT NULL default '0',
  `OfficeID` int(11) default NULL,
  `Login` datetime default NULL,
  `Logout` datetime default NULL,
  `IP` varchar(15) default NULL,
  PRIMARY KEY  (`LogID`)
) ENGINE=MyISAM AUTO_INCREMENT=14069 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Passwords`
--

DROP TABLE IF EXISTS `i3_Passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Passwords` (
  `UserID` int(11) NOT NULL,
  `hash` varchar(60) NOT NULL,
  PRIMARY KEY  (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Quotes`
--

DROP TABLE IF EXISTS `i3_Quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Quotes` (
  `quote` varchar(200) NOT NULL,
  PRIMARY KEY  (`quote`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i3_Users`
--

DROP TABLE IF EXISTS `i3_Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Users` (
  `UserID` int(10) unsigned NOT NULL auto_increment,
  `UserName` varchar(50) default NULL,
  `Email` varchar(32) default NULL,
  `YOG` int(11) default NULL,
  `Comper` char(1) NOT NULL default '0',
  `GroupID` int(11) default '0',
  `LegalResearch` char(1) NOT NULL default '0',
  `LegalResearchDir` char(1) NOT NULL default '0',
  `Communications` char(1) NOT NULL default '0',
  `CommunicationsDir` char(1) NOT NULL default '0',
  `Finance` char(1) NOT NULL default '0',
  `FinanceDir` char(1) NOT NULL default '0',
  `Training` char(1) NOT NULL default '0',
  `TrainingDir` char(1) NOT NULL default '0',
  `TrainingWGL` char(1) NOT NULL default '0',
  `BostonOffice` char(1) NOT NULL default '0',
  `BostonOfficeDir` char(1) NOT NULL default '0',
  `CommunityOutreach` char(1) NOT NULL default '0',
  `CommunityOutreachDir` char(1) NOT NULL default '0',
  `CourthouseRelations` char(1) NOT NULL default '0',
  `CourthouseRelationsDir` char(1) NOT NULL default '0',
  `LawReform` char(1) NOT NULL default '0',
  `LawReformDir` char(1) NOT NULL default '0',
  `PBHOffice` char(1) NOT NULL default '0',
  `PBHOfficeDir` char(1) NOT NULL default '0',
  `Admin` char(1) NOT NULL default '0',
  `Hidden` char(1) NOT NULL default '0',
  `Bilingual` char(1) NOT NULL default '0',
  `BilingualDir` char(1) NOT NULL default '0',
  `Chinatown` char(1) default '0',
  `ChinatownDir` char(1) default '0',
  PRIMARY KEY  (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=1743 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lr_Questions`
--

DROP TABLE IF EXISTS `lr_Questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lr_Questions` (
  `QuestionID` int(11) NOT NULL auto_increment,
  `CaseInfoID` int(11) NOT NULL default '0',
  `QuestionText` blob,
  `ClientName` varchar(64) default NULL,
  `UserID_Submit` int(11) NOT NULL default '0',
  `UserID_Reply` int(11) NOT NULL default '0',
  `Time_Submit` datetime default NULL,
  `ReplyDone` char(1) NOT NULL default '0',
  `Time_Reply` datetime default NULL,
  `ReplyText` blob,
  `ReplyApproved` char(1) NOT NULL default '0',
  PRIMARY KEY  (`QuestionID`),
  KEY `CaseInfoID` (`CaseInfoID`)
) ENGINE=MyISAM AUTO_INCREMENT=407 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lr_Resources`
--

DROP TABLE IF EXISTS `lr_Resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lr_Resources` (
  `ResourceID` int(11) NOT NULL auto_increment,
  `Name` varchar(128) default NULL,
  `URL` varchar(255) default NULL,
  `Description` text,
  `CategoryID` int(11) default NULL,
  `Rating` tinyint(4) default NULL,
  PRIMARY KEY  (`ResourceID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_bug_file_table`
--

DROP TABLE IF EXISTS `mantis_bug_file_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_bug_file_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bug_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `diskfile` varchar(250) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `folder` varchar(250) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `file_type` varchar(250) NOT NULL default '',
  `date_added` datetime NOT NULL default '1970-01-01 00:00:01',
  `content` longblob NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_bug_file_bug_id` (`bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_bug_history_table`
--

DROP TABLE IF EXISTS `mantis_bug_history_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_bug_history_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `bug_id` int(10) unsigned NOT NULL default '0',
  `date_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `field_name` varchar(32) NOT NULL default '',
  `old_value` varchar(128) NOT NULL default '',
  `new_value` varchar(128) NOT NULL default '',
  `type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_bug_history_bug_id` (`bug_id`),
  KEY `idx_history_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_bug_monitor_table`
--

DROP TABLE IF EXISTS `mantis_bug_monitor_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_bug_monitor_table` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `bug_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_bug_relationship_table`
--

DROP TABLE IF EXISTS `mantis_bug_relationship_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_bug_relationship_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `source_bug_id` int(10) unsigned NOT NULL default '0',
  `destination_bug_id` int(10) unsigned NOT NULL default '0',
  `relationship_type` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_relationship_source` (`source_bug_id`),
  KEY `idx_relationship_destination` (`destination_bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_bug_table`
--

DROP TABLE IF EXISTS `mantis_bug_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_bug_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `reporter_id` int(10) unsigned NOT NULL default '0',
  `handler_id` int(10) unsigned NOT NULL default '0',
  `duplicate_id` int(10) unsigned NOT NULL default '0',
  `priority` smallint(6) NOT NULL default '30',
  `severity` smallint(6) NOT NULL default '50',
  `reproducibility` smallint(6) NOT NULL default '10',
  `status` smallint(6) NOT NULL default '10',
  `resolution` smallint(6) NOT NULL default '10',
  `projection` smallint(6) NOT NULL default '10',
  `category` varchar(64) NOT NULL default '',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_updated` datetime NOT NULL default '1970-01-01 00:00:01',
  `eta` smallint(6) NOT NULL default '10',
  `bug_text_id` int(10) unsigned NOT NULL default '0',
  `os` varchar(32) NOT NULL default '',
  `os_build` varchar(32) NOT NULL default '',
  `platform` varchar(32) NOT NULL default '',
  `version` varchar(64) NOT NULL default '',
  `fixed_in_version` varchar(64) NOT NULL default '',
  `build` varchar(32) NOT NULL default '',
  `profile_id` int(10) unsigned NOT NULL default '0',
  `view_state` smallint(6) NOT NULL default '10',
  `summary` varchar(128) NOT NULL default '',
  `sponsorship_total` int(11) NOT NULL default '0',
  `sticky` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_bug_sponsorship_total` (`sponsorship_total`),
  KEY `idx_bug_fixed_in_version` (`fixed_in_version`),
  KEY `idx_bug_status` (`status`),
  KEY `idx_project` (`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_bug_text_table`
--

DROP TABLE IF EXISTS `mantis_bug_text_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_bug_text_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `description` text NOT NULL,
  `steps_to_reproduce` text NOT NULL,
  `additional_information` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_bugnote_table`
--

DROP TABLE IF EXISTS `mantis_bugnote_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_bugnote_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bug_id` int(10) unsigned NOT NULL default '0',
  `reporter_id` int(10) unsigned NOT NULL default '0',
  `bugnote_text_id` int(10) unsigned NOT NULL default '0',
  `view_state` smallint(6) NOT NULL default '10',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `note_type` int(11) default '0',
  `note_attr` varchar(250) default '',
  PRIMARY KEY  (`id`),
  KEY `idx_bug` (`bug_id`),
  KEY `idx_last_mod` (`last_modified`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_bugnote_text_table`
--

DROP TABLE IF EXISTS `mantis_bugnote_text_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_bugnote_text_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `note` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_config_table`
--

DROP TABLE IF EXISTS `mantis_config_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_config_table` (
  `config_id` varchar(64) NOT NULL,
  `project_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `access_reqd` int(11) default '0',
  `type` int(11) default '90',
  `value` text NOT NULL,
  PRIMARY KEY  (`config_id`,`project_id`,`user_id`),
  KEY `idx_config` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_custom_field_project_table`
--

DROP TABLE IF EXISTS `mantis_custom_field_project_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_custom_field_project_table` (
  `field_id` int(11) NOT NULL default '0',
  `project_id` int(10) unsigned NOT NULL default '0',
  `sequence` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`field_id`,`project_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_custom_field_string_table`
--

DROP TABLE IF EXISTS `mantis_custom_field_string_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_custom_field_string_table` (
  `field_id` int(11) NOT NULL default '0',
  `bug_id` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`field_id`,`bug_id`),
  KEY `idx_custom_field_bug` (`bug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_custom_field_table`
--

DROP TABLE IF EXISTS `mantis_custom_field_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_custom_field_table` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `type` smallint(6) NOT NULL default '0',
  `possible_values` varchar(255) NOT NULL default '',
  `default_value` varchar(255) NOT NULL default '',
  `valid_regexp` varchar(255) NOT NULL default '',
  `access_level_r` smallint(6) NOT NULL default '0',
  `access_level_rw` smallint(6) NOT NULL default '0',
  `length_min` int(11) NOT NULL default '0',
  `length_max` int(11) NOT NULL default '0',
  `advanced` tinyint(4) NOT NULL default '0',
  `require_report` tinyint(4) NOT NULL default '0',
  `require_update` tinyint(4) NOT NULL default '0',
  `display_report` tinyint(4) NOT NULL default '1',
  `display_update` tinyint(4) NOT NULL default '1',
  `require_resolved` tinyint(4) NOT NULL default '0',
  `display_resolved` tinyint(4) NOT NULL default '0',
  `display_closed` tinyint(4) NOT NULL default '0',
  `require_closed` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_custom_field_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_filters_table`
--

DROP TABLE IF EXISTS `mantis_filters_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_filters_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `project_id` int(11) NOT NULL default '0',
  `is_public` tinyint(4) default NULL,
  `name` varchar(64) NOT NULL default '',
  `filter_string` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_news_table`
--

DROP TABLE IF EXISTS `mantis_news_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_news_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `poster_id` int(10) unsigned NOT NULL default '0',
  `date_posted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_modified` datetime NOT NULL default '1970-01-01 00:00:01',
  `view_state` smallint(6) NOT NULL default '10',
  `announcement` tinyint(4) NOT NULL default '0',
  `headline` varchar(64) NOT NULL default '',
  `body` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_project_category_table`
--

DROP TABLE IF EXISTS `mantis_project_category_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_project_category_table` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `category` varchar(64) NOT NULL default '',
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`project_id`,`category`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_project_file_table`
--

DROP TABLE IF EXISTS `mantis_project_file_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_project_file_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `diskfile` varchar(250) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `folder` varchar(250) NOT NULL default '',
  `filesize` int(11) NOT NULL default '0',
  `file_type` varchar(250) NOT NULL default '',
  `date_added` datetime NOT NULL default '1970-01-01 00:00:01',
  `content` longblob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_project_hierarchy_table`
--

DROP TABLE IF EXISTS `mantis_project_hierarchy_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_project_hierarchy_table` (
  `child_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_project_table`
--

DROP TABLE IF EXISTS `mantis_project_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_project_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(128) NOT NULL default '',
  `status` smallint(6) NOT NULL default '10',
  `enabled` tinyint(4) NOT NULL default '1',
  `view_state` smallint(6) NOT NULL default '10',
  `access_min` smallint(6) NOT NULL default '10',
  `file_path` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_project_name` (`name`),
  KEY `idx_project_id` (`id`),
  KEY `idx_project_view` (`view_state`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_project_user_list_table`
--

DROP TABLE IF EXISTS `mantis_project_user_list_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_project_user_list_table` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `access_level` smallint(6) NOT NULL default '10',
  PRIMARY KEY  (`project_id`,`user_id`),
  KEY `idx_project_user` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_project_version_table`
--

DROP TABLE IF EXISTS `mantis_project_version_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_project_version_table` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `version` varchar(64) NOT NULL default '',
  `date_order` datetime NOT NULL default '1970-01-01 00:00:01',
  `description` text NOT NULL,
  `released` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_project_version` (`project_id`,`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_sponsorship_table`
--

DROP TABLE IF EXISTS `mantis_sponsorship_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_sponsorship_table` (
  `id` int(11) NOT NULL auto_increment,
  `bug_id` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL default '0',
  `amount` int(11) NOT NULL default '0',
  `logo` varchar(128) NOT NULL default '',
  `url` varchar(128) NOT NULL default '',
  `paid` tinyint(4) NOT NULL default '0',
  `date_submitted` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_updated` datetime NOT NULL default '1970-01-01 00:00:01',
  PRIMARY KEY  (`id`),
  KEY `idx_sponsorship_bug_id` (`bug_id`),
  KEY `idx_sponsorship_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_tokens_table`
--

DROP TABLE IF EXISTS `mantis_tokens_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_tokens_table` (
  `id` int(11) NOT NULL auto_increment,
  `owner` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `expiry` datetime default NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_user_pref_table`
--

DROP TABLE IF EXISTS `mantis_user_pref_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_user_pref_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `project_id` int(10) unsigned NOT NULL default '0',
  `default_profile` int(10) unsigned NOT NULL default '0',
  `default_project` int(10) unsigned NOT NULL default '0',
  `advanced_report` tinyint(4) NOT NULL default '0',
  `advanced_view` tinyint(4) NOT NULL default '0',
  `advanced_update` tinyint(4) NOT NULL default '0',
  `refresh_delay` int(11) NOT NULL default '0',
  `redirect_delay` tinyint(4) NOT NULL default '0',
  `bugnote_order` varchar(4) NOT NULL default 'ASC',
  `email_on_new` tinyint(4) NOT NULL default '0',
  `email_on_assigned` tinyint(4) NOT NULL default '0',
  `email_on_feedback` tinyint(4) NOT NULL default '0',
  `email_on_resolved` tinyint(4) NOT NULL default '0',
  `email_on_closed` tinyint(4) NOT NULL default '0',
  `email_on_reopened` tinyint(4) NOT NULL default '0',
  `email_on_bugnote` tinyint(4) NOT NULL default '0',
  `email_on_status` tinyint(4) NOT NULL default '0',
  `email_on_priority` tinyint(4) NOT NULL default '0',
  `email_on_priority_min_severity` smallint(6) NOT NULL default '10',
  `email_on_status_min_severity` smallint(6) NOT NULL default '10',
  `email_on_bugnote_min_severity` smallint(6) NOT NULL default '10',
  `email_on_reopened_min_severity` smallint(6) NOT NULL default '10',
  `email_on_closed_min_severity` smallint(6) NOT NULL default '10',
  `email_on_resolved_min_severity` smallint(6) NOT NULL default '10',
  `email_on_feedback_min_severity` smallint(6) NOT NULL default '10',
  `email_on_assigned_min_severity` smallint(6) NOT NULL default '10',
  `email_on_new_min_severity` smallint(6) NOT NULL default '10',
  `email_bugnote_limit` smallint(6) NOT NULL default '0',
  `language` varchar(32) NOT NULL default 'english',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_user_print_pref_table`
--

DROP TABLE IF EXISTS `mantis_user_print_pref_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_user_print_pref_table` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `print_pref` varchar(27) NOT NULL default '',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_user_profile_table`
--

DROP TABLE IF EXISTS `mantis_user_profile_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_user_profile_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `platform` varchar(32) NOT NULL default '',
  `os` varchar(32) NOT NULL default '',
  `os_build` varchar(32) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mantis_user_table`
--

DROP TABLE IF EXISTS `mantis_user_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mantis_user_table` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(32) NOT NULL default '',
  `realname` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `date_created` datetime NOT NULL default '1970-01-01 00:00:01',
  `last_visit` datetime NOT NULL default '1970-01-01 00:00:01',
  `enabled` tinyint(4) NOT NULL default '1',
  `protected` tinyint(4) NOT NULL default '0',
  `access_level` smallint(6) NOT NULL default '10',
  `login_count` int(11) NOT NULL default '0',
  `lost_password_request_count` smallint(6) NOT NULL default '0',
  `failed_login_count` smallint(6) NOT NULL default '0',
  `cookie_string` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `idx_user_cookie_string` (`cookie_string`),
  UNIQUE KEY `idx_user_username` (`username`),
  KEY `idx_enable` (`enabled`),
  KEY `idx_access` (`access_level`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rf_Agencies`
--

DROP TABLE IF EXISTS `rf_Agencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rf_Agencies` (
  `AgencyID` int(11) NOT NULL auto_increment,
  `CategoryID` int(11) NOT NULL default '0',
  `Name` varchar(128) NOT NULL default '',
  `Phone` varchar(14) NOT NULL default '',
  `Email` varchar(128) NOT NULL default '',
  `URL` varchar(255) NOT NULL default '',
  `Notes` text,
  `Rating` char(1) default NULL,
  PRIMARY KEY  (`AgencyID`),
  KEY `CategoryID` (`CategoryID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scas_Projects`
--

DROP TABLE IF EXISTS `scas_Projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scas_Projects` (
  `ProjID` int(11) NOT NULL auto_increment,
  `Description` longblob,
  `Goals` longblob,
  `UserID` int(11) default NULL,
  `Begin` date default NULL,
  `End` date default NULL,
  `Progress` int(11) default NULL,
  `Name` text,
  `isProj` tinyint(1) default '1',
  PRIMARY KEY  (`ProjID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scas_Projects_Status`
--

DROP TABLE IF EXISTS `scas_Projects_Status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scas_Projects_Status` (
  `StatusID` tinyint(4) default NULL,
  `Status` varchar(30) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scas_Projects_ToDo`
--

DROP TABLE IF EXISTS `scas_Projects_ToDo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scas_Projects_ToDo` (
  `ToDoID` int(11) NOT NULL auto_increment,
  `ProjID` int(11) NOT NULL default '0',
  `UserID` int(11) NOT NULL default '0',
  `Description` text,
  `Progress` int(11) NOT NULL default '0',
  `Begin` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `End` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ToDoID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scas_Projects_Updates`
--

DROP TABLE IF EXISTS `scas_Projects_Updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scas_Projects_Updates` (
  `UpdateID` int(11) NOT NULL auto_increment,
  `UpdateUserID` int(11) NOT NULL default '0',
  `ProjID` int(11) default NULL,
  `UpdateDescription` longblob,
  `UpdateTime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`UpdateID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scas_Projects_Volunteers`
--

DROP TABLE IF EXISTS `scas_Projects_Volunteers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scas_Projects_Volunteers` (
  `ProjID` int(11) NOT NULL default '0',
  `UserID` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tr_Comp`
--

DROP TABLE IF EXISTS `tr_Comp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_Comp` (
  `UserID` int(11) NOT NULL auto_increment,
  `Week1` char(1) default '0',
  `Week2` char(1) default '0',
  `Week3` char(1) default '0',
  `Week4` char(1) default '0',
  `Week5` char(1) default '0',
  `Week6` char(1) default '0',
  `Week7` char(1) default '0',
  `Week8` char(1) default '0',
  `TestScore` char(3) default '0',
  PRIMARY KEY  (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=2147483648 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tr_Workgroups`
--

DROP TABLE IF EXISTS `tr_Workgroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tr_Workgroups` (
  `GroupID` int(11) NOT NULL auto_increment,
  `DayOfWeek` varchar(9) default NULL,
  `Time` datetime default NULL,
  PRIMARY KEY  (`GroupID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-11-25 11:17:55
