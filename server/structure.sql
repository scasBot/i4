/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_CaseInfo` (
  `CaseInfoID` int(11) NOT NULL AUTO_INCREMENT,
  `ClientID` int(11) NOT NULL DEFAULT '0',
  `CaseTypeID` int(11) NOT NULL DEFAULT '0',
  `Date` datetime DEFAULT NULL,
  `CategoryID` int(11) NOT NULL DEFAULT '0',
  `CaseSide` varchar(16) DEFAULT NULL,
  `Opposing` varchar(64) DEFAULT NULL,
  `OpposingCorp` char(1) DEFAULT NULL,
  `Notes` longtext,
  `RecAction` longtext,
  `CreateBy` int(11) NOT NULL DEFAULT '0',
  `LastEditBy` int(11) NOT NULL DEFAULT '0',
  `OfficeID` int(11) NOT NULL DEFAULT '0',
  `ReferredTo` int(11) NOT NULL DEFAULT '0',
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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_CaseTypes` (
  `CaseTypeID` int(11) NOT NULL DEFAULT '0',
  `Description` varchar(128) DEFAULT NULL,
  `Deprecated` char(1) DEFAULT '0',
  PRIMARY KEY (`CaseTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Categories` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(64) DEFAULT NULL,
  `SortKey` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CategoryID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Clients` (
  `ClientID` int(11) NOT NULL AUTO_INCREMENT,
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
  `ReferralSource` text DEFAULT NULL,
  `ReferralSpecify` text NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `CaseTypeID` int(11) NOT NULL DEFAULT '0',
  `CategoryID` int(11) NOT NULL DEFAULT '10',
  `LastEditTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time of Last Edit, Auto-MYSQL Updated',
  `CourtDate` date DEFAULT NULL,
  PRIMARY KEY (`ClientID`)
) ENGINE=MyISAM AUTO_INCREMENT=19067 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Contact` (
  `ContactID` int(11) NOT NULL AUTO_INCREMENT,
  `ClientID` int(11) NOT NULL DEFAULT '0',
  `CaseInfoID` int(11) NOT NULL DEFAULT '0',
  `UserID` int(11) NOT NULL DEFAULT '0',
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `Date` datetime DEFAULT NULL,
  `ContactTypeID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ContactID`),
  KEY `ClientID` (`ClientID`),
  KEY `UserID` (`UserID`),
  KEY `CaseInfoID` (`CaseInfoID`)
) ENGINE=MyISAM AUTO_INCREMENT=47856 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_ContactTypes` (
  `ContactTypeID` int(11) NOT NULL DEFAULT '0',
  `Description` varchar(64) DEFAULT NULL,
  `Visible` char(1) DEFAULT NULL,
  PRIMARY KEY (`ContactTypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Demographics` (
  `RecordID` int(11) NOT NULL AUTO_INCREMENT,
  `ZIP` varchar(5) DEFAULT NULL,
  `SizeHousehold` int(11) DEFAULT NULL,
  `HouseholdIncome` int(11) DEFAULT NULL,
  `Race` varchar(32) DEFAULT NULL,
  `Occupation` varchar(32) DEFAULT NULL,
  `Gender` char(1) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `PublicAssist` char(1) DEFAULT NULL,
  `PublicAssistType` varchar(64) DEFAULT NULL,
  `ReferralSource` varchar(64) DEFAULT NULL,
  `Notes` text,
  `DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SourceReferral` int(11) DEFAULT NULL,
  `PrimaryLanguage` int(2) unsigned NOT NULL,
  PRIMARY KEY (`RecordID`)
) ENGINE=MyISAM AUTO_INCREMENT=1276 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_Emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isAssigned` tinyint(1) NOT NULL,
  `ClientID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbi4_Contacts` (
  `ContactID` int(11) NOT NULL AUTO_INCREMENT,
  `ClientID` int(11) NOT NULL,
  `UserAddedID` int(11) NOT NULL,
  `UserEditID` int(11) NOT NULL,
  `ContactDate` datetime NOT NULL,
  `ContactEditDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last time somebody edited the contact',
  `ContactTypeID` int(11) NOT NULL,
  `ContactSummary` longtext,
  PRIMARY KEY (`ContactID`),
  KEY `ClientID` (`ClientID`,`UserAddedID`),
  KEY `UserEditID` (`UserEditID`)
) ENGINE=MyISAM AUTO_INCREMENT=7413 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Admins` (
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Announce` (
  `AnnounceID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Calendar` (
  `CalID` int(11) NOT NULL AUTO_INCREMENT,
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
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Log` (
  `LogID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL DEFAULT '0',
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `OfficeID` int(11) DEFAULT NULL,
  `Login` datetime DEFAULT NULL,
  `LastAction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Logout` datetime DEFAULT NULL,
  `IP` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`LogID`)
) ENGINE=MyISAM AUTO_INCREMENT=17684 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Passwords` (
  `UserID` int(11) NOT NULL,
  `hash` varchar(60) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Quotes` (
  `quote` varchar(200) NOT NULL,
  PRIMARY KEY (`quote`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i3_Users` (
  `UserID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) DEFAULT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `YOG` int(11) DEFAULT NULL,
  `Comper` char(1) NOT NULL DEFAULT '0',
  `GroupID` int(11) DEFAULT '0',
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
) ENGINE=MyISAM AUTO_INCREMENT=1872 DEFAULT CHARSET=latin1 PACK_KEYS=1;
/*!40101 SET character_set_client = @saved_cs_client */;
