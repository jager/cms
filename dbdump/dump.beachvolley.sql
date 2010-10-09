-- MySQL dump 10.11
--
-- Host: localhost    Database: smspzps
-- ------------------------------------------------------
-- Server version	5.0.75-0ubuntu10.5

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
-- Table structure for table `Adminusers`
--

DROP TABLE IF EXISTS `Adminusers`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Adminusers` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(40) collate utf8_polish_ci NOT NULL,
  `password` varchar(40) collate utf8_polish_ci NOT NULL,
  `mailadr` varchar(150) collate utf8_polish_ci NOT NULL,
  `fname` varchar(50) collate utf8_polish_ci NOT NULL,
  `sname` varchar(100) collate utf8_polish_ci NOT NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `edited` timestamp NOT NULL default '0000-00-00 00:00:00',
  `lastcorrectlogin` timestamp NOT NULL default '0000-00-00 00:00:00',
  `lastfaultylogin` timestamp NOT NULL default '0000-00-00 00:00:00',
  `loginamount` int(11) default '0',
  `active` char(1) collate utf8_polish_ci NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Adminusers`
--

LOCK TABLES `Adminusers` WRITE;
/*!40000 ALTER TABLE `Adminusers` DISABLE KEYS */;
INSERT INTO `Adminusers` VALUES (1,'jager','f0a3ed059c40bbc4b213da3367573041','jagmaster@o2.pl','Michal','Jagusiak','2010-06-03 12:21:55','0000-00-00 00:00:00','2010-09-12 20:31:28','0000-00-00 00:00:00',24,'1');
/*!40000 ALTER TABLE `Adminusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Aktuals`
--

DROP TABLE IF EXISTS `Aktuals`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Aktuals` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(150) collate utf8_polish_ci default NULL,
  `shortcontent` text collate utf8_polish_ci,
  `fullcontent` text collate utf8_polish_ci,
  `tags` text collate utf8_polish_ci,
  `created` datetime default '0000-00-00 00:00:00',
  `edited` timestamp NOT NULL default '0000-00-00 00:00:00',
  `active` char(1) collate utf8_polish_ci default NULL,
  `link` varchar(160) collate utf8_polish_ci default NULL,
  `published` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Aktuals`
--

LOCK TABLES `Aktuals` WRITE;
/*!40000 ALTER TABLE `Aktuals` DISABLE KEYS */;
INSERT INTO `Aktuals` VALUES (1,'Inne aktualnoÅ›ci','asdf','<p>asdf</p>','asdf','2010-04-20 12:34:53','2010-06-13 15:27:29','0','inne_aktualnosci.html','0000-00-00 00:00:00'),(2,'asdf','asdf','<p>asdf</p>','asdf','2010-04-20 12:34:53','2010-06-13 14:43:49','1','asdf.html','0000-00-00 00:00:00'),(3,'Nowe informacje ','Nowe informacje o stronie','<p>PeÅ‚na treÅ›Ä‡ nowych informacji o stronie</p>','szkoÅ‚a, informacje, nowoÅ›ci, okolicznoÅ›ciowe','2010-04-20 12:34:53','2010-06-17 10:25:40','1','nowe_informacje_.html','0000-00-00 00:00:00'),(4,'asd','asdfasdf','<p>asdfa</p>','szkoÅ‚a, informacje, nowoÅ›ci, okolicznoÅ›ciowe','2010-04-20 12:34:53','2010-06-17 21:18:39','0','asd.html','2010-06-16 22:00:00'),(5,'aahh','askjg','<p>sdf</p>','','2010-04-20 12:34:53','2010-06-17 21:38:35','1','aahh.html','2010-06-16 22:00:00'),(6,'aahh','askjg','<p>sdf</p>','','2010-04-20 12:34:53','2010-06-17 21:40:54','1','aahh.html','2010-06-16 22:00:00'),(7,'nowy artykuÅ‚','Kilka zdaÅ„ dziwnej treÅ›ci','<p>CoÅ› jeszcze tu trzeba napisaÄ‡</p>','tag1, tag2','2010-04-20 12:34:53','2010-06-21 16:36:45','1','nowy_artykul.html','0000-00-00 00:00:00'),(8,'nowy artykuÅ‚ stworzony na nowy sposÃ³b','jakiÅ› nowy wstÄ™p','<p>nowe rozwiniÄ™cie artykuÅ‚u</p>','','2010-06-21 18:09:28','2010-06-21 16:30:13','1','nowy_artykul_stworzony_na_nowy_sposob.html','0000-00-00 00:00:00'),(9,'Nowe informacje','JakiÅ› wstÄ™p','<p>CoÅ› jeszcze opr&oacute;cz wstÄ™pu</p>','','2010-07-24 20:07:19','2010-07-24 18:07:19','0','nowe_informacje.html','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `Aktuals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AktualsLabels`
--

DROP TABLE IF EXISTS `AktualsLabels`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `AktualsLabels` (
  `aktuals_id` int(11) NOT NULL default '0',
  `labels_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`aktuals_id`,`labels_id`),
  KEY `AktualsLabels_labels_id_Labels_id` (`labels_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `AktualsLabels`
--

LOCK TABLES `AktualsLabels` WRITE;
/*!40000 ALTER TABLE `AktualsLabels` DISABLE KEYS */;
INSERT INTO `AktualsLabels` VALUES (3,1),(6,2),(7,3),(8,1);
/*!40000 ALTER TABLE `AktualsLabels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Categories`
--

DROP TABLE IF EXISTS `Categories`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Categories` (
  `id` int(11) NOT NULL default '0',
  `cname` varchar(100) collate utf8_polish_ci default NULL,
  `description` text collate utf8_polish_ci,
  `lft` int(11) default NULL,
  `rgt` int(11) default NULL,
  `added` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Categories`
--

LOCK TABLES `Categories` WRITE;
/*!40000 ALTER TABLE `Categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `Categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Catsettings`
--

DROP TABLE IF EXISTS `Catsettings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Catsettings` (
  `id` int(11) NOT NULL default '0',
  `sname` varchar(100) collate utf8_polish_ci default NULL,
  `stype` varchar(20) collate utf8_polish_ci default NULL,
  `predefinedvalues` text collate utf8_polish_ci,
  `skey` varchar(100) collate utf8_polish_ci default NULL,
  `added` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `categories_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `categories_id_idx` (`categories_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Catsettings`
--

LOCK TABLES `Catsettings` WRITE;
/*!40000 ALTER TABLE `Catsettings` DISABLE KEYS */;
/*!40000 ALTER TABLE `Catsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Fotos`
--

DROP TABLE IF EXISTS `Fotos`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Fotos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sourcename` varchar(50) collate utf8_polish_ci NOT NULL,
  `description` varchar(200) collate utf8_polish_ci default NULL,
  `tags` text collate utf8_polish_ci,
  `owner` int(11) NOT NULL,
  `author` varchar(100) collate utf8_polish_ci default NULL,
  `added` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `galeries_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `galeries_id_idx` (`galeries_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Fotos`
--

LOCK TABLES `Fotos` WRITE;
/*!40000 ALTER TABLE `Fotos` DISABLE KEYS */;
INSERT INTO `Fotos` VALUES (15,'6f3d89fae6e9cdb9fe4a99c4b9038802.jpg',NULL,NULL,0,NULL,'2010-09-12 21:13:58',2),(14,'be8987dfad1e7eee6996f898d3394e25.jpg',NULL,NULL,0,NULL,'2010-09-12 21:12:48',2),(13,'df79a717972c63cb90e383b1fef69318.jpg',NULL,NULL,0,NULL,'2010-09-12 21:08:02',2),(12,'51794cc687b377a142e1a5ab78c13b28.jpg',NULL,NULL,0,NULL,'2010-09-12 21:06:11',2),(11,'873027e9b69afc6d9508dfb9b6d6b66d.jpg',NULL,NULL,0,NULL,'2010-09-12 20:54:10',2),(10,'9a54c270f61153d1df05bcc5da9d76e5.jpg',NULL,NULL,0,NULL,'2010-09-12 20:53:08',2),(9,'7f2bd9fec62c74174924e47957bbfa55.jpg',NULL,NULL,0,NULL,'2010-09-12 20:36:21',2),(8,'e67695bee5eeb66697ec15249687a18b.jpg',NULL,NULL,0,NULL,'2010-09-12 20:32:01',2),(16,'12187e55b7024bcd6e5809b929636cd7.jpg',NULL,NULL,0,NULL,'2010-09-12 21:14:00',2),(17,'9d0e9741c3881807adbb66ff38a13cb4.jpg',NULL,NULL,0,NULL,'2010-09-12 21:14:01',2),(18,'1a49d1ada50264662096102f19e1b14b.jpg',NULL,NULL,0,NULL,'2010-09-12 21:14:02',2),(19,'c5a7ca3c65f3cf62ea10f883d95b0316.jpg',NULL,NULL,0,NULL,'2010-09-12 21:14:03',2),(20,'798bedf72d08420897570bb8335e6272.jpg',NULL,NULL,0,NULL,'2010-09-12 21:14:05',2),(21,'7aded7ee8e9ff4954ee133e769cabb81.jpg',NULL,NULL,0,NULL,'2010-09-12 21:18:51',2),(22,'0a058298bd44cfe5f6440b49a65565c5.jpg',NULL,NULL,0,NULL,'2010-09-12 21:20:40',2),(23,'9d6086a0f996cc07f37f4c1e19d5081d.jpg',NULL,NULL,0,NULL,'2010-09-12 21:22:54',2);
/*!40000 ALTER TABLE `Fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Galeries`
--

DROP TABLE IF EXISTS `Galeries`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Galeries` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gname` varchar(100) collate utf8_polish_ci NOT NULL,
  `gdescription` text collate utf8_polish_ci,
  `owner` int(11) NOT NULL,
  `publishtype` varchar(1) collate utf8_polish_ci NOT NULL default 'g',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Galeries`
--

LOCK TABLES `Galeries` WRITE;
/*!40000 ALTER TABLE `Galeries` DISABLE KEYS */;
INSERT INTO `Galeries` VALUES (1,'nazwa','asdfas asfd asdf asd fasdf asdf asdf asdf',1,'g'),(2,'inna galeria','opis sadfsadf ',0,'g'),(3,'asdf123','asdf',0,'s');
/*!40000 ALTER TABLE `Galeries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Itemfeatures`
--

DROP TABLE IF EXISTS `Itemfeatures`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Itemfeatures` (
  `intvalue` int(11) default NULL,
  `charvalue` varchar(255) collate utf8_polish_ci default NULL,
  `textvalue` text collate utf8_polish_ci,
  `datevalue` date default NULL,
  `catsettings_id` int(11) NOT NULL default '0',
  `items_id` int(11) NOT NULL default '0',
  `added` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `edited` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`catsettings_id`,`items_id`),
  KEY `Itemfeatures_items_id_Items_id` (`items_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Itemfeatures`
--

LOCK TABLES `Itemfeatures` WRITE;
/*!40000 ALTER TABLE `Itemfeatures` DISABLE KEYS */;
/*!40000 ALTER TABLE `Itemfeatures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Itemhistory`
--

DROP TABLE IF EXISTS `Itemhistory`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Itemhistory` (
  `id` int(11) NOT NULL default '0',
  `itemvalue` varchar(45) collate utf8_polish_ci default NULL,
  `edited` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `itemfeatures_catsettings_id` int(11) NOT NULL,
  `itemfeatures_items_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `itemfeatures_catsettings_id_idx` (`itemfeatures_catsettings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Itemhistory`
--

LOCK TABLES `Itemhistory` WRITE;
/*!40000 ALTER TABLE `Itemhistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `Itemhistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Items`
--

DROP TABLE IF EXISTS `Items`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Items` (
  `id` int(11) NOT NULL default '0',
  `iname` varchar(255) collate utf8_polish_ci default NULL,
  `description` text collate utf8_polish_ci,
  `added` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `tags` text collate utf8_polish_ci,
  `categories_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `categories_id_idx` (`categories_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Items`
--

LOCK TABLES `Items` WRITE;
/*!40000 ALTER TABLE `Items` DISABLE KEYS */;
/*!40000 ALTER TABLE `Items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Labels`
--

DROP TABLE IF EXISTS `Labels`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Labels` (
  `id` int(11) NOT NULL auto_increment,
  `gname` varchar(50) collate utf8_polish_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Labels`
--

LOCK TABLES `Labels` WRITE;
/*!40000 ALTER TABLE `Labels` DISABLE KEYS */;
INSERT INTO `Labels` VALUES (1,'SzkoÅ‚a'),(2,'Sms'),(3,'Turnieje');
/*!40000 ALTER TABLE `Labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Menus`
--

DROP TABLE IF EXISTS `Menus`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Menus` (
  `id` int(11) NOT NULL auto_increment,
  `mname` varchar(20) collate utf8_polish_ci default NULL,
  `type` varchar(10) collate utf8_polish_ci default NULL,
  `link` varchar(100) collate utf8_polish_ci default NULL,
  `parent_id` int(11) default NULL,
  `active` char(1) collate utf8_polish_ci default NULL,
  `pages_id` int(10) unsigned NOT NULL,
  `ord` smallint(6) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pages_id_idx` (`pages_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Menus`
--

LOCK TABLES `Menus` WRITE;
/*!40000 ALTER TABLE `Menus` DISABLE KEYS */;
INSERT INTO `Menus` VALUES (1,'strona gÅ‚Ã³wna','static','/pages/strona_glowna.html',0,'1',1,1),(2,'Strona pierwsza','static','/pages/strona_pierwsza.html',1,'1',2,2),(3,'Podstrona2','static','/pages/podstrona2.html',1,'1',3,3),(4,'Subhome3','static','/pages/subhome3.html',3,'1',4,4),(5,'Podstrona3','static','/pages/podstrona3.html',3,'1',5,5),(6,'Podstrona7','static','/pages/podstrona7.html',2,'1',7,6);
/*!40000 ALTER TABLE `Menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pages`
--

DROP TABLE IF EXISTS `Pages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Pages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pname` varchar(100) collate utf8_polish_ci default NULL,
  `link` varchar(120) collate utf8_polish_ci default NULL,
  `hd_title` varchar(200) collate utf8_polish_ci default NULL,
  `hd_keywords` text collate utf8_polish_ci,
  `content` text collate utf8_polish_ci,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `edited` timestamp NOT NULL default '0000-00-00 00:00:00',
  `active` char(1) collate utf8_polish_ci default NULL,
  `owner` varchar(30) collate utf8_polish_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Pages`
--

LOCK TABLES `Pages` WRITE;
/*!40000 ALTER TABLE `Pages` DISABLE KEYS */;
INSERT INTO `Pages` VALUES (1,'strona gÅ‚Ã³wna','strona_glowna.html','TytuÅ‚ strony gÅ‚Ã³wnej','sÅ‚owa kluczowe, kluczowe, sÅ‚owa','<p>TreÅ›Ä‡ strony<strong> gÅ‚&oacute;wnej, <span style=\"text-decoration: underline;\">treÅ›Ä‡ strony gÅ‚&oacute;wnej, <em>treÅ›Ä‡ strony gÅ‚&oacute;wnej</em></span></strong>!!!!!</p>','2010-07-24 17:13:32','2010-07-24 17:13:32','1','jager'),(2,'Strona pierwsza','strona_pierwsza.html','TytuÅ‚ strony pierwszej','sÅ‚owa kluczowe, kluczowe, sÅ‚owa','<p>JakaÅ› treÅ›Ä‡ pierwszej strony.</p>','2010-09-08 20:37:22','2010-09-08 20:37:22','1','jager'),(3,'Podstrona2','podstrona2.html','TytuÅ‚ strony drugiej','sÅ‚owa kluczowe, kluczowe, sÅ‚owa','<p>JakaÅ› treÅ› drugiej strony.</p>','2010-09-06 20:11:26','2010-09-06 20:11:26','1','jager'),(4,'Podstrona3','podstrona3.html','TytuÅ‚ strony trzeciej','sÅ‚owa kluczowe, kluczowe, sÅ‚owa','<p>TreÅ›Ä‡ strony trzeciej</p>','2010-07-24 17:09:06','2010-07-24 17:09:06','0','jager'),(5,'Podstrona3','podstrona3.html','TytuÅ‚ strony czwartej','sÅ‚owa kluczowe, kluczowe, sÅ‚owa','<p>Lorem ipsum.... dalej nie pamiÄ™tam...</p>','2010-07-24 17:24:16','2010-07-24 17:24:16','0','jager'),(6,'Podstrona5','podstrona5.html','TytuÅ‚ strony piÄ…tej','sÅ‚owa kluczowe, kluczowe, sÅ‚owa','<p>JakaÅ› treÅ›Ä‡</p>','2010-07-24 18:23:48','2010-07-24 18:23:48','0','jager'),(7,'Podstrona7','podstrona7.html','TytuÅ‚ strony 7','sÅ‚owa kluczowe, kluczowe, sÅ‚owa','<p>JakaÅ› treÅ› strony si&oacute;dmej</p>','2010-07-24 18:06:26','2010-07-24 18:06:26','1','jager');
/*!40000 ALTER TABLE `Pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pageshistory`
--

DROP TABLE IF EXISTS `Pageshistory`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Pageshistory` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `backedup` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `content` varchar(45) collate utf8_polish_ci default NULL,
  `backedup_by` varchar(30) collate utf8_polish_ci default NULL,
  `pages_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `pages_id_idx` (`pages_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Pageshistory`
--

LOCK TABLES `Pageshistory` WRITE;
/*!40000 ALTER TABLE `Pageshistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `Pageshistory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tags`
--

DROP TABLE IF EXISTS `Tags`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tname` varchar(50) collate utf8_polish_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ind_tag_name_idx` (`tname`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Tags`
--

LOCK TABLES `Tags` WRITE;
/*!40000 ALTER TABLE `Tags` DISABLE KEYS */;
INSERT INTO `Tags` VALUES (1,'asdf'),(2,'szkoÅ‚a'),(3,'informacje'),(4,'nowoÅ›ci'),(5,'okolicznoÅ›ciowe'),(6,'tag'),(7,'tag1'),(8,'tag2'),(9,'tag3');
/*!40000 ALTER TABLE `Tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `TagsRelations`
--

DROP TABLE IF EXISTS `TagsRelations`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `TagsRelations` (
  `tags_id` int(10) unsigned NOT NULL default '0',
  `rel_id` int(11) NOT NULL default '0',
  `relname` varchar(45) collate utf8_polish_ci NOT NULL default '',
  PRIMARY KEY  (`tags_id`,`rel_id`,`relname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `TagsRelations`
--

LOCK TABLES `TagsRelations` WRITE;
/*!40000 ALTER TABLE `TagsRelations` DISABLE KEYS */;
INSERT INTO `TagsRelations` VALUES (1,1,'Aktual'),(1,2,'Aktual'),(2,3,'Aktual'),(2,4,'Aktual'),(3,3,'Aktual'),(3,4,'Aktual'),(4,3,'Aktual'),(4,4,'Aktual'),(5,3,'Aktual'),(5,4,'Aktual'),(7,7,'Aktual'),(8,7,'Aktual');
/*!40000 ALTER TABLE `TagsRelations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-09-14 20:46:21
