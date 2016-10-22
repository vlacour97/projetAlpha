-- MySQL dump 10.13  Distrib 5.5.52, for debian-linux-gnu (armv7l)
--
-- Host: localhost    Database: projetIUT
-- ------------------------------------------------------
-- Server version	5.5.52-0+deb8u1-log

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
-- Table structure for table `action_report`
--

DROP TABLE IF EXISTS `action_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_report` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de l''action',
  `ID_USER` int(11) DEFAULT NULL COMMENT 'Identifiant de l''utilisateur liès à l''action',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description de l''action',
  `requested_date` datetime NOT NULL COMMENT 'Date de l''action',
  PRIMARY KEY (`ID`),
  KEY `ID_USER` (`ID_USER`),
  CONSTRAINT `action_report_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_report`
--

LOCK TABLES `action_report` WRITE;
/*!40000 ALTER TABLE `action_report` DISABLE KEYS */;
INSERT INTO `action_report` VALUES (1,NULL,'Étudiant N°8 modifié','2016-10-21 19:58:44'),(2,NULL,'Questionnaire répondus pour l\'étudiant N°8','2016-10-21 19:58:44'),(3,NULL,'Suppression d\'un étudiant : ddd dd','2016-10-21 20:02:10'),(4,NULL,'Création d\'un nouvel étudiant','2016-10-21 20:02:50'),(5,NULL,'Création d\'un nouvel étudiant','2016-10-21 20:02:51'),(6,NULL,'Suppression d\'un étudiant : ddd ddd','2016-10-21 20:03:01'),(7,NULL,'Suppression définitive de l\'étudiant \"ddd ddd\"','2016-10-21 20:03:32'),(8,7,'Modification d\'un utilisateur','2016-10-21 20:20:26'),(9,7,'Modification d\'un utilisateur','2016-10-21 20:21:09'),(10,7,'Utilisateur en demande de suppression','2016-10-21 20:21:09'),(11,7,'Modification d\'un utilisateur','2016-10-21 20:21:36'),(12,7,'Modification d\'un utilisateur','2016-10-21 20:21:43'),(13,7,'Modification d\'un utilisateur','2016-10-21 20:22:18'),(14,7,'Modification d\'un utilisateur','2016-10-21 20:23:18'),(15,7,'Utilisateur en demande de suppression','2016-10-21 20:30:53'),(16,7,'Utilisateur autorisé à publier','2016-10-21 20:33:47'),(17,7,'Utilisateur Activé','2016-10-21 20:34:40'),(18,7,'Utilisateur en demande de suppression','2016-10-21 20:34:52'),(19,7,'Mot de passe utilisateur modifié','2016-10-21 20:36:47'),(20,7,'Un utilisateur a publier un message dans le fil d\'actualité','2016-10-21 20:48:22'),(21,7,'Un Utilisateur a supprimer sa publication','2016-10-21 20:51:34'),(23,NULL,' {comment_action}','2016-10-21 21:04:56'),(24,7,'Utilisateur modifié','2016-10-21 21:08:33'),(25,7,'Utilisateur modifié','2016-10-21 21:08:40'),(28,NULL,'Suppression d\'un utilisateur :Lacour Valentin','2016-10-21 21:44:29'),(29,NULL,'Création d\'un nouvel étudiant','2016-10-21 21:51:47'),(30,NULL,'Étudiant N°11 modifié','2016-10-22 08:46:51'),(31,NULL,'Étudiant N°11 modifié','2016-10-22 08:46:54'),(32,NULL,'Création d\'un nouvel étudiant','2016-10-22 08:47:18'),(33,NULL,'Étudiant N°12 modifié','2016-10-22 08:47:51'),(34,NULL,'Étudiant N°12 modifié','2016-10-22 08:47:56'),(35,NULL,'Étudiant N°12 modifié','2016-10-22 08:47:58'),(36,NULL,'Étudiant N°11 en demande de suppression ','2016-10-22 13:55:00'),(37,NULL,'Étudiant N°12 en demande de suppression ','2016-10-22 13:55:00'),(38,NULL,'Étudiant N°11 en demande de suppression ','2016-10-22 13:58:00'),(39,NULL,'Étudiant N°12 en demande de suppression ','2016-10-22 13:58:00'),(40,NULL,'Étudiant N°11 en demande de suppression ','2016-10-22 13:59:00'),(41,NULL,'Étudiant N°12 en demande de suppression ','2016-10-22 13:59:00'),(42,NULL,'Étudiant N°11 en demande de suppression ','2016-10-22 14:00:30'),(43,NULL,'Étudiant N°12 en demande de suppression ','2016-10-22 14:00:30'),(44,NULL,'Étudiant N°11 en demande de suppression ','2016-10-22 14:01:30'),(45,NULL,'Étudiant N°12 en demande de suppression ','2016-10-22 14:01:30'),(46,7,'Un utilisateur a publier un message dans le fil d\'actualité','2016-10-22 15:22:41'),(47,7,'Utilisateur modifié','2016-10-22 17:42:33'),(48,9,'Création d\'un nouveau Tuteur Entreprise','2016-10-22 17:43:41'),(49,7,'Utilisateur modifié','2016-10-22 17:46:58'),(50,9,'Utilisateur modifié','2016-10-22 17:47:02'),(51,7,'Utilisateur modifié','2016-10-22 19:39:27'),(52,7,'Utilisateur modifié','2016-10-22 19:39:38'),(53,9,'Utilisateur modifié','2016-10-22 19:40:04'),(54,9,'Utilisateur modifié','2016-10-22 19:40:08'),(55,9,'Utilisateur modifié','2016-10-22 19:40:11');
/*!40000 ALTER TABLE `action_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la réponse',
  `ID_student` int(11) NOT NULL COMMENT 'id de l''étudiant',
  `id_survey` int(11) NOT NULL COMMENT 'id du questionnaire',
  `id_question` int(11) NOT NULL COMMENT 'id de la question',
  `id_answer` int(11) NOT NULL COMMENT 'id de la réponse',
  `comments` longtext COMMENT 'commentaires de la réponse',
  `request_date` datetime NOT NULL COMMENT 'date de la requete',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_student_2` (`ID_student`,`id_survey`,`id_question`),
  KEY `ID_student` (`ID_student`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`ID_student`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='table des réponses';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (6,7,1,1,1,NULL,'0000-00-00 00:00:00'),(10,7,1,2,2,NULL,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liked_post`
--

DROP TABLE IF EXISTS `liked_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liked_post` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant du "like"',
  `ID_POST` int(11) NOT NULL COMMENT 'identifiant de la publication "likée"',
  `ID_USER` int(11) NOT NULL COMMENT 'identifiant de l''utilisateur qui a "liké"',
  `requested_date` datetime NOT NULL COMMENT 'date du "like"',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID_POST_2` (`ID_POST`,`ID_USER`),
  KEY `ID_POST` (`ID_POST`,`ID_USER`),
  KEY `ID_USER` (`ID_USER`),
  CONSTRAINT `liked_post_ibfk_1` FOREIGN KEY (`ID_POST`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `liked_post_ibfk_2` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='table des likes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liked_post`
--

LOCK TABLES `liked_post` WRITE;
/*!40000 ALTER TABLE `liked_post` DISABLE KEYS */;
INSERT INTO `liked_post` VALUES (4,6,7,'2016-10-22 15:38:33');
/*!40000 ALTER TABLE `liked_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_attachments`
--

DROP TABLE IF EXISTS `message_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_attachments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la pièce jointe',
  `ID_message` int(11) NOT NULL COMMENT 'id du message',
  `link` text NOT NULL COMMENT 'lien de la pièce jointe',
  `description` text COMMENT 'description de la pièce jointe',
  `type_file` text NOT NULL COMMENT 'type de la pièce jointe',
  PRIMARY KEY (`ID`),
  KEY `ID_message` (`ID_message`),
  CONSTRAINT `message_attachments_ibfk_1` FOREIGN KEY (`ID_message`) REFERENCES `messages` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des pièces jointes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_attachments`
--

LOCK TABLES `message_attachments` WRITE;
/*!40000 ALTER TABLE `message_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id du message',
  `id_sender` int(11) NOT NULL COMMENT 'id de l''expéditeur',
  `id_recipient` int(11) NOT NULL COMMENT 'id du destinataire',
  `object` text NOT NULL COMMENT 'objet du message',
  `content` text NOT NULL COMMENT 'contenu du message',
  `viewed` tinyint(1) DEFAULT NULL COMMENT 'drapeau de vue',
  `deleted` tinyint(1) DEFAULT NULL COMMENT 'drapeau de suppression',
  `id_respond` int(11) DEFAULT NULL COMMENT 'id du message auquel on répond',
  `send_date` datetime NOT NULL COMMENT 'date d''envoi',
  PRIMARY KEY (`ID`),
  KEY `id_sender` (`id_sender`,`id_recipient`,`id_respond`),
  KEY `id_recipient` (`id_recipient`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`id_sender`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`id_recipient`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='tables des messages';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (3,7,7,'Whouuu','Contenue',NULL,NULL,0,'2016-10-22 15:28:43'),(4,7,9,'Whouuu','Equitis Romani autem esse filium criminis loco poni ab accusatoribus neque his iudicantibus oportuit neque defendentibus nobis. Nam quod de pietate dixistis, est quidem ista nostra existimatio, sed iudicium certe parentis; quid nos opinemur, audietis ex iuratis; quid parentes sentiant, lacrimae matris incredibilisque maeror, squalor patris et haec praesens maestitia, quam cernitis, luctusque declarat.\n\nEt hanc quidem praeter oppida multa duae civitates exornant Seleucia opus Seleuci regis, et Claudiopolis quam deduxit coloniam Claudius Caesar. Isaura enim antehac nimium potens, olim subversa ut rebellatrix interneciva aegre vestigia claritudinis pristinae monstrat admodum pauca.\n\nCognitis enim pilatorum caesorumque funeribus nemo deinde ad has stationes appulit navem, sed ut Scironis praerupta letalia declinantes litoribus Cypriis contigui navigabant, quae Isauriae scopulis sunt controversa.',NULL,NULL,0,'2016-10-22 15:29:04');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la notification',
  `ID_USER` int(11) DEFAULT NULL COMMENT 'identifiant de l''utilisateur lié à la notification',
  `content` text NOT NULL COMMENT 'contenu de la notification',
  `link` text COMMENT 'lien de la notification',
  `viewed` tinyint(1) DEFAULT NULL COMMENT 'drapeau de vue de la notification',
  `requested_date` datetime NOT NULL COMMENT 'date de requête',
  `deleted` tinyint(1) DEFAULT NULL COMMENT 'drapeau de suppression',
  PRIMARY KEY (`ID`),
  KEY `ID_USER` (`ID_USER`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='table des notifications';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (7,7,'Salut','',NULL,'2016-10-22 09:11:05',NULL),(8,7,'Salut','',NULL,'2016-10-22 09:11:17',NULL),(9,7,'name[7] {comment_action}','',NULL,'2016-10-22 15:23:25',NULL),(10,7,'name[7] {comment_action}','',NULL,'2016-10-22 15:23:29',NULL);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la publication',
  `ID_USER` int(11) NOT NULL COMMENT 'identifiant de l''utilisateur publicateur',
  `content` text NOT NULL COMMENT 'contenu de la publication',
  `deleted` tinyint(1) DEFAULT NULL COMMENT 'drapeau de suppression de la publication',
  `publication_date` datetime NOT NULL COMMENT 'date de publication',
  PRIMARY KEY (`ID`),
  KEY `ID_USER` (`ID_USER`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='table des posts des utilisateurs';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (6,7,'Salut à tous',NULL,'2016-10-22 15:22:41');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_insert_posts AFTER INSERT
ON posts FOR EACH ROW
BEGIN
  DECLARE insert_content TEXT;
  SET insert_content = 'Un utilisateur a publier un message dans le fil d\'actualité';
  INSERT INTO action_report(ID_USER, content, requested_date) VALUES (new.ID_USER,insert_content,NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_delete_posts AFTER DELETE
ON posts FOR EACH ROW
BEGIN
  DECLARE delete_content TEXT;
  SET delete_content = CONCAT('Un utilisateur a supprimer sa publication');
  INSERT INTO action_report(ID_USER, content, requested_date) VALUES (old.ID_USER,delete_content,NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `posts_attachments`
--

DROP TABLE IF EXISTS `posts_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_attachments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la pièce jointe',
  `ID_POST` int(11) NOT NULL COMMENT 'identifiant de la publication',
  `link` text NOT NULL COMMENT 'len de la pièce jointe',
  `description` text COMMENT 'description de la pièce jointe',
  `type_file` text NOT NULL COMMENT 'type de la pièce jointe',
  PRIMARY KEY (`ID`),
  KEY `ID_POST` (`ID_POST`),
  CONSTRAINT `posts_attachments_ibfk_1` FOREIGN KEY (`ID_POST`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table de pièces jointes des posts';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_attachments`
--

LOCK TABLES `posts_attachments` WRITE;
/*!40000 ALTER TABLE `posts_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_comments`
--

DROP TABLE IF EXISTS `posts_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant du commentaire',
  `ID_POST` int(11) NOT NULL COMMENT 'identifiant de la publication',
  `ID_USER` int(11) NOT NULL COMMENT 'identifiant de l''utilisateur',
  `content` text NOT NULL COMMENT 'contenu du commentaire',
  `deleted` tinyint(1) DEFAULT NULL COMMENT 'drapeau de suppression',
  `publication_date` datetime NOT NULL COMMENT 'date de publication',
  PRIMARY KEY (`ID`),
  KEY `ID_POST` (`ID_POST`,`ID_USER`),
  KEY `ID_USER` (`ID_USER`),
  CONSTRAINT `posts_comments_ibfk_2` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_comments_ibfk_1` FOREIGN KEY (`ID_POST`) REFERENCES `posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='table des commentaires des posts';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_comments`
--

LOCK TABLES `posts_comments` WRITE;
/*!40000 ALTER TABLE `posts_comments` DISABLE KEYS */;
INSERT INTO `posts_comments` VALUES (20,6,7,'0',NULL,'2016-10-22 15:23:25'),(21,6,7,'0',NULL,'2016-10-22 15:23:29');
/*!40000 ALTER TABLE `posts_comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_insert_posts_comments AFTER INSERT
ON posts_comments FOR EACH ROW
BEGIN
  DECLARE insert_content TEXT;
  DECLARE id_user INT;
  SELECT posts.ID_USER INTO id_user FROM posts WHERE posts.ID=new.ID_POST;
  SET insert_content = CONCAT('name[',new.ID_USER,'] {comment_action}');
  CALL add_notification(id_user,insert_content,'');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_delete_posts_comment AFTER DELETE
ON posts_comments FOR EACH ROW
BEGIN
  DELETE FROM notifications WHERE content LIKE CONCAT('name[',old.ID_USER,']%') AND requested_date = old.publication_date;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary table structure for view `show_action_report`
--

DROP TABLE IF EXISTS `show_action_report`;
/*!50001 DROP VIEW IF EXISTS `show_action_report`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_action_report` (
  `ID` tinyint NOT NULL,
  `ID_USER` tinyint NOT NULL,
  `content` tinyint NOT NULL,
  `requested_date` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_all_students`
--

DROP TABLE IF EXISTS `show_all_students`;
/*!50001 DROP VIEW IF EXISTS `show_all_students`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_all_students` (
  `ID` tinyint NOT NULL,
  `ID_TE` tinyint NOT NULL,
  `ID_TI` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `fname` tinyint NOT NULL,
  `group` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `zip_code` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `birth_date` tinyint NOT NULL,
  `informations` tinyint NOT NULL,
  `creation_date` tinyint NOT NULL,
  `delete_date` tinyint NOT NULL,
  `deadline_date` tinyint NOT NULL,
  `answered` tinyint NOT NULL,
  `name_TE` tinyint NOT NULL,
  `name_TI` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_all_users`
--

DROP TABLE IF EXISTS `show_all_users`;
/*!50001 DROP VIEW IF EXISTS `show_all_users`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_all_users` (
  `ID` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `fname` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `pwd` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `zip_code` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `language` tinyint NOT NULL,
  `registration_date` tinyint NOT NULL,
  `activation_date` tinyint NOT NULL,
  `delete_date` tinyint NOT NULL,
  `last_login_date` tinyint NOT NULL,
  `publication_entitled` tinyint NOT NULL,
  `viewing_date` tinyint NOT NULL,
  `ID_USER` tinyint NOT NULL,
  `last_ip_viewer` tinyint NOT NULL,
  `country_viewer` tinyint NOT NULL,
  `platform_viewer` tinyint NOT NULL,
  `os_viewer` tinyint NOT NULL,
  `browser_viewer` tinyint NOT NULL,
  `activated` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_answered_students`
--

DROP TABLE IF EXISTS `show_answered_students`;
/*!50001 DROP VIEW IF EXISTS `show_answered_students`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_answered_students` (
  `ID` tinyint NOT NULL,
  `ID_TE` tinyint NOT NULL,
  `ID_TI` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `fname` tinyint NOT NULL,
  `group` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `zip_code` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `birth_date` tinyint NOT NULL,
  `informations` tinyint NOT NULL,
  `creation_date` tinyint NOT NULL,
  `delete_date` tinyint NOT NULL,
  `deadline_date` tinyint NOT NULL,
  `answered` tinyint NOT NULL,
  `name_TE` tinyint NOT NULL,
  `name_TI` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_deleted_students`
--

DROP TABLE IF EXISTS `show_deleted_students`;
/*!50001 DROP VIEW IF EXISTS `show_deleted_students`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_deleted_students` (
  `ID` tinyint NOT NULL,
  `ID_TE` tinyint NOT NULL,
  `ID_TI` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `fname` tinyint NOT NULL,
  `group` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `zip_code` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `birth_date` tinyint NOT NULL,
  `informations` tinyint NOT NULL,
  `creation_date` tinyint NOT NULL,
  `delete_date` tinyint NOT NULL,
  `deadline_date` tinyint NOT NULL,
  `answered` tinyint NOT NULL,
  `name_TE` tinyint NOT NULL,
  `name_TI` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_deleted_users`
--

DROP TABLE IF EXISTS `show_deleted_users`;
/*!50001 DROP VIEW IF EXISTS `show_deleted_users`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_deleted_users` (
  `ID` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `fname` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `pwd` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `zip_code` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `language` tinyint NOT NULL,
  `registration_date` tinyint NOT NULL,
  `activation_date` tinyint NOT NULL,
  `delete_date` tinyint NOT NULL,
  `last_login_date` tinyint NOT NULL,
  `publication_entitled` tinyint NOT NULL,
  `viewing_date` tinyint NOT NULL,
  `ID_USER` tinyint NOT NULL,
  `last_ip_viewer` tinyint NOT NULL,
  `country_viewer` tinyint NOT NULL,
  `platform_viewer` tinyint NOT NULL,
  `os_viewer` tinyint NOT NULL,
  `browser_viewer` tinyint NOT NULL,
  `activated` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_last_stats_by_user`
--

DROP TABLE IF EXISTS `show_last_stats_by_user`;
/*!50001 DROP VIEW IF EXISTS `show_last_stats_by_user`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_last_stats_by_user` (
  `viewing_date` tinyint NOT NULL,
  `ID_USER` tinyint NOT NULL,
  `last_ip_viewer` tinyint NOT NULL,
  `country_viewer` tinyint NOT NULL,
  `platform_viewer` tinyint NOT NULL,
  `os_viewer` tinyint NOT NULL,
  `browser_viewer` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_posts`
--

DROP TABLE IF EXISTS `show_posts`;
/*!50001 DROP VIEW IF EXISTS `show_posts`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_posts` (
  `ID` tinyint NOT NULL,
  `ID_USER` tinyint NOT NULL,
  `content` tinyint NOT NULL,
  `deleted` tinyint NOT NULL,
  `publication_date` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_te_users`
--

DROP TABLE IF EXISTS `show_te_users`;
/*!50001 DROP VIEW IF EXISTS `show_te_users`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_te_users` (
  `ID` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `fname` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `pwd` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `zip_code` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `language` tinyint NOT NULL,
  `registration_date` tinyint NOT NULL,
  `activation_date` tinyint NOT NULL,
  `delete_date` tinyint NOT NULL,
  `last_login_date` tinyint NOT NULL,
  `publication_entitled` tinyint NOT NULL,
  `viewing_date` tinyint NOT NULL,
  `ID_USER` tinyint NOT NULL,
  `last_ip_viewer` tinyint NOT NULL,
  `country_viewer` tinyint NOT NULL,
  `platform_viewer` tinyint NOT NULL,
  `os_viewer` tinyint NOT NULL,
  `browser_viewer` tinyint NOT NULL,
  `activated` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_ti_users`
--

DROP TABLE IF EXISTS `show_ti_users`;
/*!50001 DROP VIEW IF EXISTS `show_ti_users`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_ti_users` (
  `ID` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `fname` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `pwd` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `zip_code` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `language` tinyint NOT NULL,
  `registration_date` tinyint NOT NULL,
  `activation_date` tinyint NOT NULL,
  `delete_date` tinyint NOT NULL,
  `last_login_date` tinyint NOT NULL,
  `publication_entitled` tinyint NOT NULL,
  `viewing_date` tinyint NOT NULL,
  `ID_USER` tinyint NOT NULL,
  `last_ip_viewer` tinyint NOT NULL,
  `country_viewer` tinyint NOT NULL,
  `platform_viewer` tinyint NOT NULL,
  `os_viewer` tinyint NOT NULL,
  `browser_viewer` tinyint NOT NULL,
  `activated` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `show_unactivated_users`
--

DROP TABLE IF EXISTS `show_unactivated_users`;
/*!50001 DROP VIEW IF EXISTS `show_unactivated_users`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `show_unactivated_users` (
  `ID` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `fname` tinyint NOT NULL,
  `type` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `pwd` tinyint NOT NULL,
  `phone` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `zip_code` tinyint NOT NULL,
  `city` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `language` tinyint NOT NULL,
  `registration_date` tinyint NOT NULL,
  `activation_date` tinyint NOT NULL,
  `delete_date` tinyint NOT NULL,
  `last_login_date` tinyint NOT NULL,
  `publication_entitled` tinyint NOT NULL,
  `viewing_date` tinyint NOT NULL,
  `ID_USER` tinyint NOT NULL,
  `last_ip_viewer` tinyint NOT NULL,
  `country_viewer` tinyint NOT NULL,
  `platform_viewer` tinyint NOT NULL,
  `os_viewer` tinyint NOT NULL,
  `browser_viewer` tinyint NOT NULL,
  `activated` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stats` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la statistique',
  `ID_USER` int(11) NOT NULL COMMENT 'identifiant de l''utilisateur',
  `page_viewed` text NOT NULL COMMENT 'page vue',
  `ip_viewer` text COMMENT 'adresse IP de l''utilisateur',
  `country_viewer` varchar(2) DEFAULT NULL COMMENT 'pays de l''utilisateur',
  `platform_viewer` text COMMENT 'plateforme de l''utilisateur',
  `os_viewer` text COMMENT 'système d''exploitation del''utilisateur',
  `browser_viewer` text COMMENT 'navigateur de l''utilisateur',
  `viewing_date` datetime NOT NULL COMMENT 'date de chargement de la page',
  PRIMARY KEY (`ID`),
  KEY `ID_USER` (`ID_USER`),
  CONSTRAINT `stats_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='table de statistiques enregistrées';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de l''étudiant',
  `ID_TE` int(11) NOT NULL COMMENT 'id du tuteur entreprise',
  `ID_TI` int(11) NOT NULL COMMENT 'id du tuteur IUT',
  `name` text NOT NULL COMMENT 'nom de l''étudiant',
  `fname` text NOT NULL COMMENT 'prénom de l''étudiant',
  `group` text NOT NULL COMMENT 'groupe de l''étudiant',
  `email` text COMMENT 'email del''étudiant',
  `phone` text COMMENT 'tel de l''étudiant',
  `address` text COMMENT 'adresse de l''étudiant',
  `zip_code` text COMMENT 'code postal',
  `city` text COMMENT 'ville de résidence',
  `country` varchar(2) DEFAULT NULL COMMENT 'pays',
  `birth_date` date NOT NULL COMMENT 'date de naissance de l''étudiant',
  `informations` longtext COMMENT 'informations sur l''étudiant',
  `creation_date` datetime NOT NULL COMMENT 'date de création',
  `delete_date` datetime DEFAULT NULL COMMENT 'Drapeau de la suppression de l’étudiant',
  `deadline_date` date NOT NULL COMMENT 'date butoire du questionnaire',
  `answered` tinyint(1) DEFAULT NULL COMMENT 'Drapeau de réponse au questionnaire',
  PRIMARY KEY (`ID`),
  KEY `ID_TE` (`ID_TE`,`ID_TI`),
  KEY `ID_TI` (`ID_TI`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`ID_TE`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `students_ibfk_2` FOREIGN KEY (`ID_TI`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='table des étudiants';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (11,7,7,'dds','dsdsds','',NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00',NULL,'0000-00-00 00:00:00','2016-10-22 14:01:30','0000-00-00',NULL),(12,7,7,'Lacour','Valentin','',NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00',NULL,'0000-00-00 00:00:00','2016-10-22 14:01:30','0000-00-00',NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_insert_student AFTER INSERT
ON students FOR EACH ROW
BEGIN
  DECLARE insert_content TEXT;
  SET insert_content = 'Création d\'un nouvel étudiant';
  INSERT INTO action_report(ID_USER, content, requested_date) VALUES (NULL,insert_content,NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_update_students AFTER UPDATE
ON students FOR EACH ROW
BEGIN
  DECLARE delete_content TEXT;
  CASE
    WHEN new.answered = 1 and new.answered <> old.answered THEN SET delete_content = CONCAT('Questionnaire répondus pour l\'étudiant N°',new.ID);
    WHEN new.delete_date IS NOT NULL and new.delete_date <> old.delete_date THEN SET delete_content = CONCAT('Étudiant N°',new.ID,' en demande de suppression ');
    WHEN new.delete_date IS NULL and new.delete_date <> old.delete_date THEN SET delete_content = CONCAT('Étudiant N°',new.ID,' remis en service');
    ELSE SET delete_content = CONCAT('Étudiant N°',new.ID,' modifié');
  END CASE;
  IF new.name <> old.name OR new.fname <> old.fname OR new.group <> old.group OR new.email <> old.email OR new.phone <> old.phone OR new.address <> old.address OR new.zip_code <> old.zip_code OR new.city <> old.city OR new.country <> old.country OR new.birth_date <> old.birth_date OR new.informations <> old.informations OR new.creation_date <> old.creation_date OR new.delete_date <> old.delete_date OR new.deadline_date <> old.deadline_date OR new.answered <> old.answered THEN
    INSERT INTO action_report(ID_USER, content, requested_date) VALUES (NULL,delete_content,NOW());
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_delete_students AFTER DELETE
ON students FOR EACH ROW
BEGIN
  DECLARE delete_content TEXT;
  SET delete_content = CONCAT('Suppression définitive de l\'étudiant "',old.fname,' ',old.name,'"');
  INSERT INTO action_report(ID_USER, content, requested_date) VALUES (NULL,delete_content,NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de l''utilisateur',
  `fname` text COMMENT 'prénom de l''utilisateur',
  `name` text COMMENT 'nom de l''utilisateur',
  `type` int(11) NOT NULL COMMENT 'type de l''utilisateur',
  `email` varchar(255) NOT NULL COMMENT 'email de l''utilisateur',
  `pwd` text COMMENT 'mdp de l''utilisateur',
  `phone` text COMMENT 'tel de l''utilisateur',
  `address` text COMMENT 'adresse de l''utilisateur',
  `zip_code` text COMMENT 'code postal',
  `city` text COMMENT 'ville de résidence',
  `country` varchar(2) DEFAULT NULL COMMENT 'pays',
  `language` varchar(5) DEFAULT NULL COMMENT 'langue de l''utilisateur',
  `registration_date` datetime NOT NULL COMMENT 'date d''enregistrement',
  `activation_date` datetime DEFAULT NULL COMMENT 'date d''activation',
  `delete_date` datetime DEFAULT NULL COMMENT 'date de suppression',
  `last_login_date` datetime DEFAULT NULL COMMENT 'date de dernière connexion',
  `publication_entitled` tinyint(1) DEFAULT '0' COMMENT 'drapeau de droit à la publication',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='table des utilisateurs';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (7,'Jean-Francois','Lapiche',2,'','28de27d629b57507919b8afe70fa417f','','','','','','fr_FR','2016-10-21 18:27:16','2016-10-22 08:55:59',NULL,NULL,1),(9,'Valentin','Lacour',2,'vlacour97@icloud.com',NULL,NULL,NULL,NULL,NULL,NULL,'fr_FR','0000-00-00 00:00:00',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_insert_users AFTER INSERT
ON users FOR EACH ROW
BEGIN
  DECLARE insert_content TEXT;
  CASE NEW.type
    WHEN 1 THEN SET insert_content = 'Création d\'un nouvel administrateur';
    WHEN 2 THEN SET insert_content = 'Création d\'un nouveau Tuteur Entreprise';
    WHEN 3 THEN SET insert_content = 'Création d\'un nouveau Tuteur IUT';
  END CASE;
  INSERT INTO action_report(ID_USER, content, requested_date) VALUES (NEW.ID,insert_content,NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER after_update_users AFTER UPDATE ON users
 FOR EACH ROW BEGIN
  DECLARE update_content TEXT;
  CASE
    WHEN new.activation_date IS NOT NULL and new.activation_date <> old.activation_date THEN SET update_content = 'Utilisateur Activé';
    WHEN new.delete_date IS NOT NULL and new.delete_date <> old.delete_date THEN SET update_content = 'Utilisateur en demande de suppression';
    WHEN new.delete_date IS NULL and new.delete_date <> old.delete_date THEN SET update_content = 'Utilisateur remis en service';
    WHEN new.publication_entitled = 1 and new.publication_entitled <> old.publication_entitled THEN SET update_content = 'Utilisateur autorisé à publier';
    WHEN new.pwd <> old.pwd THEN SET update_content = 'Mot de passe utilisateur modifié';
    ELSE SET update_content = 'Utilisateur modifié';
  END CASE;
  IF new.name <> old.name OR new.fname <> old.fname OR new.type <> old.type OR new.email <> old.email OR new.pwd <> old.pwd OR new.phone <> old.phone OR new.address <> old.address OR new.zip_code <> old.zip_code OR new.city <> old.city OR new.country <> old.country OR new.language <> old.language OR new.registration_date <> old.registration_date OR new.activation_date <> old.activation_date OR new.delete_date <> old.delete_date OR new.publication_entitled <> old.publication_entitled THEN
    INSERT INTO action_report(ID_USER, content, requested_date) VALUES (new.ID,update_content,NOW());
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `after_delete_users` AFTER DELETE ON `users` FOR EACH ROW BEGIN
  DECLARE delete_content TEXT;
  SET delete_content = CONCAT('Suppression d\'un utilisateur :',OLD.fname,' ',OLD.name);
  INSERT INTO action_report(ID_USER, content, requested_date) VALUES (NULL,delete_content,NOW());
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `show_action_report`
--

/*!50001 DROP TABLE IF EXISTS `show_action_report`*/;
/*!50001 DROP VIEW IF EXISTS `show_action_report`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_action_report` AS select `action_report`.`ID` AS `ID`,`action_report`.`ID_USER` AS `ID_USER`,`action_report`.`content` AS `content`,`action_report`.`requested_date` AS `requested_date` from `action_report` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_all_students`
--

/*!50001 DROP TABLE IF EXISTS `show_all_students`*/;
/*!50001 DROP VIEW IF EXISTS `show_all_students`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_all_students` AS select `students`.`ID` AS `ID`,`students`.`ID_TE` AS `ID_TE`,`students`.`ID_TI` AS `ID_TI`,`students`.`name` AS `name`,`students`.`fname` AS `fname`,`students`.`group` AS `group`,`students`.`email` AS `email`,`students`.`phone` AS `phone`,`students`.`address` AS `address`,`students`.`zip_code` AS `zip_code`,`students`.`city` AS `city`,`students`.`country` AS `country`,`students`.`birth_date` AS `birth_date`,`students`.`informations` AS `informations`,`students`.`creation_date` AS `creation_date`,`students`.`delete_date` AS `delete_date`,`students`.`deadline_date` AS `deadline_date`,`students`.`answered` AS `answered`,concat(`u1`.`fname`,' ',`u1`.`name`) AS `name_TE`,concat(`u2`.`fname`,' ',`u2`.`name`) AS `name_TI` from ((`students` join `users` `u1`) join `users` `u2`) where ((`students`.`ID_TE` = `u1`.`ID`) and (`students`.`ID_TI` = `u2`.`ID`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_all_users`
--

/*!50001 DROP TABLE IF EXISTS `show_all_users`*/;
/*!50001 DROP VIEW IF EXISTS `show_all_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_all_users` AS select `users`.`ID` AS `ID`,`users`.`name` AS `name`,`users`.`fname` AS `fname`,`users`.`type` AS `type`,`users`.`email` AS `email`,`users`.`pwd` AS `pwd`,`users`.`phone` AS `phone`,`users`.`address` AS `address`,`users`.`zip_code` AS `zip_code`,`users`.`city` AS `city`,`users`.`country` AS `country`,`users`.`language` AS `language`,`users`.`registration_date` AS `registration_date`,`users`.`activation_date` AS `activation_date`,`users`.`delete_date` AS `delete_date`,`users`.`last_login_date` AS `last_login_date`,`users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`users`.`activation_date`) then 0 else 1 end) AS `activated` from (`users` left join `show_last_stats_by_user` `s1` on((`users`.`ID` = `s1`.`ID_USER`))) where isnull(`users`.`delete_date`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_answered_students`
--

/*!50001 DROP TABLE IF EXISTS `show_answered_students`*/;
/*!50001 DROP VIEW IF EXISTS `show_answered_students`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_answered_students` AS select `students`.`ID` AS `ID`,`students`.`ID_TE` AS `ID_TE`,`students`.`ID_TI` AS `ID_TI`,`students`.`name` AS `name`,`students`.`fname` AS `fname`,`students`.`group` AS `group`,`students`.`email` AS `email`,`students`.`phone` AS `phone`,`students`.`address` AS `address`,`students`.`zip_code` AS `zip_code`,`students`.`city` AS `city`,`students`.`country` AS `country`,`students`.`birth_date` AS `birth_date`,`students`.`informations` AS `informations`,`students`.`creation_date` AS `creation_date`,`students`.`delete_date` AS `delete_date`,`students`.`deadline_date` AS `deadline_date`,`students`.`answered` AS `answered`,concat(`u1`.`fname`,' ',`u1`.`name`) AS `name_TE`,concat(`u2`.`fname`,' ',`u2`.`name`) AS `name_TI` from ((`students` join `users` `u1`) join `users` `u2`) where ((`students`.`ID_TE` = `u1`.`ID`) and (`students`.`ID_TI` = `u2`.`ID`) and (`students`.`answered` = 1)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_deleted_students`
--

/*!50001 DROP TABLE IF EXISTS `show_deleted_students`*/;
/*!50001 DROP VIEW IF EXISTS `show_deleted_students`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_deleted_students` AS select `students`.`ID` AS `ID`,`students`.`ID_TE` AS `ID_TE`,`students`.`ID_TI` AS `ID_TI`,`students`.`name` AS `name`,`students`.`fname` AS `fname`,`students`.`group` AS `group`,`students`.`email` AS `email`,`students`.`phone` AS `phone`,`students`.`address` AS `address`,`students`.`zip_code` AS `zip_code`,`students`.`city` AS `city`,`students`.`country` AS `country`,`students`.`birth_date` AS `birth_date`,`students`.`informations` AS `informations`,`students`.`creation_date` AS `creation_date`,`students`.`delete_date` AS `delete_date`,`students`.`deadline_date` AS `deadline_date`,`students`.`answered` AS `answered`,concat(`u1`.`fname`,' ',`u1`.`name`) AS `name_TE`,concat(`u2`.`fname`,' ',`u2`.`name`) AS `name_TI` from ((`students` join `users` `u1`) join `users` `u2`) where ((`students`.`ID_TE` = `u1`.`ID`) and (`students`.`ID_TI` = `u2`.`ID`) and (`students`.`delete_date` is not null)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_deleted_users`
--

/*!50001 DROP TABLE IF EXISTS `show_deleted_users`*/;
/*!50001 DROP VIEW IF EXISTS `show_deleted_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_deleted_users` AS select `users`.`ID` AS `ID`,`users`.`name` AS `name`,`users`.`fname` AS `fname`,`users`.`type` AS `type`,`users`.`email` AS `email`,`users`.`pwd` AS `pwd`,`users`.`phone` AS `phone`,`users`.`address` AS `address`,`users`.`zip_code` AS `zip_code`,`users`.`city` AS `city`,`users`.`country` AS `country`,`users`.`language` AS `language`,`users`.`registration_date` AS `registration_date`,`users`.`activation_date` AS `activation_date`,`users`.`delete_date` AS `delete_date`,`users`.`last_login_date` AS `last_login_date`,`users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`users`.`activation_date`) then 0 else 1 end) AS `activated` from (`users` left join `show_last_stats_by_user` `s1` on((`users`.`ID` = `s1`.`ID_USER`))) where (`users`.`delete_date` is not null) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_last_stats_by_user`
--

/*!50001 DROP TABLE IF EXISTS `show_last_stats_by_user`*/;
/*!50001 DROP VIEW IF EXISTS `show_last_stats_by_user`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_last_stats_by_user` AS select max(`stats`.`viewing_date`) AS `viewing_date`,`stats`.`ID_USER` AS `ID_USER`,`stats`.`ip_viewer` AS `last_ip_viewer`,`stats`.`country_viewer` AS `country_viewer`,`stats`.`platform_viewer` AS `platform_viewer`,`stats`.`os_viewer` AS `os_viewer`,`stats`.`browser_viewer` AS `browser_viewer` from `stats` group by `stats`.`ID_USER` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_posts`
--

/*!50001 DROP TABLE IF EXISTS `show_posts`*/;
/*!50001 DROP VIEW IF EXISTS `show_posts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_posts` AS select `posts`.`ID` AS `ID`,`posts`.`ID_USER` AS `ID_USER`,`posts`.`content` AS `content`,`posts`.`deleted` AS `deleted`,`posts`.`publication_date` AS `publication_date` from `posts` order by `posts`.`publication_date` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_te_users`
--

/*!50001 DROP TABLE IF EXISTS `show_te_users`*/;
/*!50001 DROP VIEW IF EXISTS `show_te_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_te_users` AS select `users`.`ID` AS `ID`,`users`.`name` AS `name`,`users`.`fname` AS `fname`,`users`.`type` AS `type`,`users`.`email` AS `email`,`users`.`pwd` AS `pwd`,`users`.`phone` AS `phone`,`users`.`address` AS `address`,`users`.`zip_code` AS `zip_code`,`users`.`city` AS `city`,`users`.`country` AS `country`,`users`.`language` AS `language`,`users`.`registration_date` AS `registration_date`,`users`.`activation_date` AS `activation_date`,`users`.`delete_date` AS `delete_date`,`users`.`last_login_date` AS `last_login_date`,`users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`users`.`activation_date`) then 0 else 1 end) AS `activated` from (`users` left join `show_last_stats_by_user` `s1` on((`users`.`ID` = `s1`.`ID_USER`))) where (isnull(`users`.`delete_date`) and (`users`.`type` = 2)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_ti_users`
--

/*!50001 DROP TABLE IF EXISTS `show_ti_users`*/;
/*!50001 DROP VIEW IF EXISTS `show_ti_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_ti_users` AS select `users`.`ID` AS `ID`,`users`.`name` AS `name`,`users`.`fname` AS `fname`,`users`.`type` AS `type`,`users`.`email` AS `email`,`users`.`pwd` AS `pwd`,`users`.`phone` AS `phone`,`users`.`address` AS `address`,`users`.`zip_code` AS `zip_code`,`users`.`city` AS `city`,`users`.`country` AS `country`,`users`.`language` AS `language`,`users`.`registration_date` AS `registration_date`,`users`.`activation_date` AS `activation_date`,`users`.`delete_date` AS `delete_date`,`users`.`last_login_date` AS `last_login_date`,`users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`users`.`activation_date`) then 0 else 1 end) AS `activated` from (`users` left join `show_last_stats_by_user` `s1` on((`users`.`ID` = `s1`.`ID_USER`))) where (isnull(`users`.`delete_date`) and (`users`.`type` = 3)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `show_unactivated_users`
--

/*!50001 DROP TABLE IF EXISTS `show_unactivated_users`*/;
/*!50001 DROP VIEW IF EXISTS `show_unactivated_users`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `show_unactivated_users` AS select `users`.`ID` AS `ID`,`users`.`name` AS `name`,`users`.`fname` AS `fname`,`users`.`type` AS `type`,`users`.`email` AS `email`,`users`.`pwd` AS `pwd`,`users`.`phone` AS `phone`,`users`.`address` AS `address`,`users`.`zip_code` AS `zip_code`,`users`.`city` AS `city`,`users`.`country` AS `country`,`users`.`language` AS `language`,`users`.`registration_date` AS `registration_date`,`users`.`activation_date` AS `activation_date`,`users`.`delete_date` AS `delete_date`,`users`.`last_login_date` AS `last_login_date`,`users`.`publication_entitled` AS `publication_entitled`,`s1`.`viewing_date` AS `viewing_date`,`s1`.`ID_USER` AS `ID_USER`,`s1`.`last_ip_viewer` AS `last_ip_viewer`,`s1`.`country_viewer` AS `country_viewer`,`s1`.`platform_viewer` AS `platform_viewer`,`s1`.`os_viewer` AS `os_viewer`,`s1`.`browser_viewer` AS `browser_viewer`,(case when isnull(`users`.`activation_date`) then 0 else 1 end) AS `activated` from (`users` left join `show_last_stats_by_user` `s1` on((`users`.`ID` = `s1`.`ID_USER`))) where (isnull(`users`.`delete_date`) and isnull(`users`.`activation_date`)) */;
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

-- Dump completed on 2016-10-22 21:06:00
