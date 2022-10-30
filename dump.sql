-- MySQL dump 10.13  Distrib 5.1.58, for pc-linux-gnu (x86_64)
--
-- Host: localhost    Database: mebelboom_def
-- ------------------------------------------------------
-- Server version	5.1.58

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `tovars_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Мебель',0,1,50,9),(18,'Готовая мебель',1,2,21,9),(19,'Мебель на заказ',1,22,37,0),(20,'Фурнитура',1,38,49,0),(21,'Готовые комплекты',18,3,6,2),(22,'Мягкая мебель',18,7,8,0),(23,'Корпусная мебель',18,9,10,0),(24,'Столы',18,11,14,0),(25,'Стулья, кресла',18,15,16,0),(26,'Детская мебель',18,17,18,0),(27,'Матрасы и основания',18,19,20,0),(28,'Готовые комплекты',19,23,24,0),(29,'Мягкая мебель',19,25,26,0),(30,'Корпусная мебель',19,27,28,0),(31,'Столы',19,29,30,0),(32,'Стулья, кресла',19,31,32,0),(33,'Детская мебель',19,33,34,0),(34,'Матрасы и основания',19,35,36,0),(35,'Петли',20,39,40,0),(36,'Направляющие',20,41,42,0),(37,'Подъемники',20,43,44,0),(38,'Ручки',20,45,46,0),(39,'Ящики, полки, корзины',20,47,48,0),(40,'Кухонные гарнитуры',21,4,5,2),(41,'Кухонные столы',24,12,13,0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Москва'),(3,'Казань'),(5,'Тюмень'),(7,'Санкт-Петербург'),(8,'Челны');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` int(10) unsigned NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (10,2,4,'Артем Кучергин','После вхождения через контакт, для написания комментария ,я попадаю в личный кабинет, и приходится заново искать товар в каталоге, комментарий которому я хотел написать',1360535574,1),(11,2,4,'Marat Mashkov','Подозрительно дешевая кухня - похоже, что не из натуральных материалов.',1360589381,1),(13,2,2,'Руслан Архипов','test',1361189779,1),(15,1,1,'Артем Кучергин','h',1361866673,1);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `company_name` varchar(250) NOT NULL,
  `opf` varchar(250) DEFAULT NULL,
  `law_name` varchar(250) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_companies_users1_idx` (`user_id`),
  CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (7,37,'Кресло',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(8,38,'test','ИП','test','http://rupromo.ru',3,'test','123456','',0),(9,39,'компания',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(10,40,'Маблос','ООО','МФМ','http://mablos.ru',3,'г. Казань, а/я 159','+7 (843) 599-65-04','Фабрика мягкой мебели \"Маблос\" давно и плодотворно сотрудничает с компаниями, работающими в различных регионах России и Ближнего Зарубежья. Наша дилерская сеть постоянно расширяется. Партнером нашей фабрики может стать любая компания, занимающаяся продажей мягкой, корпусной или офисной мебели. К каждому партнеру мы подходим индивидуально, с максимальной заботой и вниманием.',1),(11,41,'РуПромо alex@rupromo.ru',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(12,42,'Виталий',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(13,43,'Виталий Губкин',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(15,45,'РуПромо','ООО','РуПромо','http://www.rupromo.ru',2,'ул. Петербургская, д. 74','2773209','Мы не продаем мебель, но тоже хотим разместиться на вашем сайте',1),(16,46,'РуПромо',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(17,47,'Sitdikov Irek',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(18,48,'Ситдиков Ирек',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(19,49,'Виктор Кучергин',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(20,50,'Mikhail Rakhimov',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(21,51,'КреслоКо',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(22,52,'Маблос',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(23,53,'Kreslo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(24,54,'123','ИП','123','http://www.mebelboom.com',3,'декабристов 129 кв 77','45645','пукп',0),(25,57,'test','ООО','test','',3,'Лобачевского, 16','123445','',0);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatches`
--

DROP TABLE IF EXISTS `dispatches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispatches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period` int(11) NOT NULL,
  `last` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatches`
--

LOCK TABLES `dispatches` WRITE;
/*!40000 ALTER TABLE `dispatches` DISABLE KEYS */;
INSERT INTO `dispatches` VALUES (1,10,0);
/*!40000 ALTER TABLE `dispatches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `user_id` int(10) unsigned NOT NULL,
  `tovar_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`tovar_id`),
  KEY `fk_id2_idx` (`user_id`),
  KEY `fk_tovar_id1_idx` (`tovar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (41,7);
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `path` varchar(200) NOT NULL,
  `datetime` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,57,'./files/1/slides_-_копия.csv',NULL,NULL),(2,57,'./files/1/tovar.csv',NULL,NULL),(3,59,'./files/1/yml.xml',1369730316,1),(4,59,'./files/1/test2.csv',1369731329,1),(5,59,'./files/1/test2.csv',1369731490,1);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keywords`
--

DROP TABLE IF EXISTS `keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keywords` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keywords`
--

LOCK TABLES `keywords` WRITE;
/*!40000 ALTER TABLE `keywords` DISABLE KEYS */;
INSERT INTO `keywords` VALUES (1,'Стол'),(2,'test'),(3,'Трапеза'),(4,'240'),(5,'2400'),(6,'Кухня'),(7,'Морская'),(8,'волна'),(9,'Все'),(10,'не'),(11,'так'),(12,'В'),(13,'2'),(14,'томах'),(15,'Том'),(16,'1'),(17,'Иваnов'),(18,'и'),(19,'rабинович'),(20,'или'),(21,'Аjгоу'),(22,'ту'),(23,'Хаjфа'),(24,'undefined'),(25,'hilton'),(26,'Дмитрий'),(27,'Хворостовский'),(28,'Национальный'),(29,'филармонический'),(30,'оркестр'),(31,'России'),(32,'Дирижер'),(33,''),(34,'Владимир'),(35,'Спиваков'),(36,'');
/*!40000 ALTER TABLE `keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `service_id` int(11) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  `sum` float(10,2) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `lifetime` int(11) DEFAULT NULL,
  `status_pay` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `content` mediumtext,
  `alt_name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'О проекте','<p>\n	&nbsp;</p>\n<p style=\"color: rgb(0, 0, 0); font-family: \'Times New Roman\', Times, serif; font-size: 16px; margin-bottom: 0.14in;\">\n	<font face=\"Arial, serif\"><font size=\"3\">О проекте&nbsp;</font></font><font face=\"Arial, serif\"><font size=\"3\"><span lang=\"en-US\" xml:lang=\"en-US\">MebelBoom</span></font></font><font face=\"Arial, serif\"><font size=\"3\">.</font></font><font face=\"Arial, serif\"><font size=\"3\"><span lang=\"en-US\" xml:lang=\"en-US\">com</span></font></font></p>\n<p style=\"color: rgb(0, 0, 0); font-family: \'Times New Roman\', Times, serif; font-size: 16px; margin-bottom: 0.14in;\">\n	<font face=\"Arial, serif\"><font size=\"3\"><span lang=\"en-US\" xml:lang=\"en-US\">MebelBoom</span></font></font><font face=\"Arial, serif\"><font size=\"3\">.</font></font><font face=\"Arial, serif\"><font size=\"3\"><span lang=\"en-US\" xml:lang=\"en-US\">com</span></font></font><font face=\"Arial, serif\"><font size=\"3\">&nbsp;&ndash; интернет проект, посвященный мебельной отрасли города Казани и Москвы. </font></font></p>\n<p style=\"color: rgb(0, 0, 0); font-family: \'Times New Roman\', Times, serif; font-size: 16px; margin-bottom: 0.14in;\">\n	<font face=\"Arial, serif\"><font size=\"3\">Главная цель проекта &ndash; быстрый и удобный поиск мебели различного назначения. </font></font></p>\n<p style=\"color: rgb(0, 0, 0); font-family: \'Times New Roman\', Times, serif; font-size: 16px; margin-bottom: 0.14in;\">\n	<font face=\"Arial, serif\"><font size=\"3\">На сайте собрана информация о самых разных видах мебели. Для удобного поиска информация структурируется по категориям и разделам.</font></font><br />\n	<br />\n	&nbsp;</p>\n<p style=\"color: rgb(0, 0, 0); font-family: \'Times New Roman\', Times, serif; font-size: 16px; margin-bottom: 0.14in;\">\n	<font face=\"Arial, serif\"><font size=\"3\">Потенциальный потребитель, заходящий на наш портал с целью покупки мебели, решает следующие задачи:</font></font></p>\n<ul style=\"color: rgb(0, 0, 0); font-family: \'Times New Roman\', Times, serif; font-size: 16px;\">\n	<li>\n		<p style=\"margin-bottom: 0.14in;\">\n			<font face=\"Arial, serif\"><font size=\"3\">Поиск магазина / производства / склада, а также их контактные данные</font></font></p>\n	</li>\n	<li>\n		<p style=\"margin-bottom: 0.14in;\">\n			<font face=\"Arial, serif\"><font size=\"3\">Поиск готового товара (мебель, фурнитура)</font></font></p>\n	</li>\n	<li>\n		<p style=\"margin-bottom: 0.14in;\">\n			<font face=\"Arial, serif\"><font size=\"3\">Поиск производителя мебели на заказ</font></font></p>\n	</li>\n	<li>\n		<p style=\"margin-bottom: 0.14in;\">\n			<font face=\"Arial, serif\"><font size=\"3\">Оформление заказа на готовый товар, либо на производство мебели</font></font></p>\n	</li>\n	<li>\n		<p style=\"margin-bottom: 0.14in;\">\n			<font face=\"Arial, serif\"><font size=\"3\">Подписка на рассылку портала (проходящие акции в городе Казань)</font></font></p>\n	</li>\n	<li>\n		<p style=\"margin-bottom: 0.14in;\">\n			<font face=\"Arial, serif\"><font size=\"3\">Просмотр и выставление рейтинга мебельным магазинам и их товарам, а также возможность оставить отзыв</font></font></p>\n	</li>\n</ul>\n<p style=\"color: rgb(0, 0, 0); font-family: \'Times New Roman\', Times, serif; font-size: 16px; margin-bottom: 0.14in;\">\n	<br />\n	<font face=\"Arial, serif\"><font size=\"3\"><span lang=\"en-US\" xml:lang=\"en-US\"><b>MebelBoom</b></span></font></font><font face=\"Arial, serif\"><font size=\"3\"><b>.</b></font></font><font face=\"Arial, serif\"><font size=\"3\"><span lang=\"en-US\" xml:lang=\"en-US\"><b>com</b></span></font></font><font face=\"Arial, serif\"><font size=\"3\"><b>&nbsp;&ndash; это:</b></font></font><br />\n	<font face=\"Arial, serif\"><font size=\"3\">УДОБНО &ndash; вся информация о мебели в одном портале;<br />\n	ОПЕРАТИВНО &ndash; самая свежая информация;<br />\n	ПРОФЕССИОНАЛЬНО &ndash; сайт специализируется только на мебельной тематики;<br />\n	ВЫГОДНО &ndash; экономия времени и денег;<br />\n	ЭФФЕКТИВНО - покупатель и продавец стали ближе друг к другу.<br />\n	Добро пожаловать на&nbsp;</font></font><font face=\"Arial, serif\"><font size=\"3\"><span lang=\"en-US\" xml:lang=\"en-US\">MebelBoom</span></font></font><font face=\"Arial, serif\"><font size=\"3\">.</font></font><font face=\"Arial, serif\"><font size=\"3\"><span lang=\"en-US\" xml:lang=\"en-US\">com</span></font></font></p>\n<div>\n	&nbsp;</div>\n','about'),(2,'Для продавцов','<p>\n	Раздел в разработке</p>\n','for_resellers'),(3,'Реклама','<p style=\"text-align:left;line-height:19px;\">\n	<span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;\">Ваша компания работает в мебельной отрасли? Размещение рекламы на mebelboom </span><span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;\">&mdash;</span><span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;\"> это прямое обращение к вашей целевой аудитории.</span></p>\n','reclame'),(5,'Ваши магазины и товары на mebelboom.com','<p>\n	<span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;\">Размещение информации о ваших товарных предложениях на mebelboom.com - это надежный способ привлечь внимание потенциальных клиентов.</span></p>\n<p style=\"text-align:left;line-height:19px;\">\n	<span style=\"font-family:Arial;font-size:12px;font-weight:bold;font-style:normal;text-decoration:none;color:#333333;\">Интернет-магазины</span><span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:normal;text-decoration:none;color:#333333;\"> могут разместить свои предложения в каталоге &quot;Мебель&quot;</span></p>\n<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" style=\"width: 550px;\">\n	<tbody>\n		<tr>\n			<td>\n				<p>\n					<img alt=\"\" height=\"155\" src=\"/images/feniks.jpg\" width=\"201\" /></p>\n				<p>\n					<span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:italic;text-decoration:none;color:#333333;\">Предложения в каталоге</span></p>\n			</td>\n			<td>\n				<p>\n					<img alt=\"\" height=\"155\" src=\"/images/gloria.jpg\" width=\"239\" /></p>\n				<p>\n					<span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:italic;text-decoration:none;color:#333333;\">Информация об интернет-магазине</span></p>\n			</td>\n		</tr>\n	</tbody>\n</table>\n<p>\n	&nbsp;</p>\n<p>\n	Оффлайн-магазины могут разместить информацию о своих магазинах в каталоге &quot;Магазины&quot;, и свои товары в каталоге &quot;Мебель&quot;.</p>\n<table align=\"left\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\" style=\"width: 550px;\">\n	<tbody>\n		<tr>\n			<td>\n				<p>\n					<img alt=\"\" src=\"/images/gloria.jpg\" style=\"width: 232px; height: 155px;\" /></p>\n				<p>\n					<span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:italic;text-decoration:none;color:#333333;\">Каталог магазинов</span></p>\n			</td>\n			<td>\n				<p>\n					<img alt=\"\" src=\"/images/feniks.jpg\" style=\"width: 201px; height: 155px;\" /></p>\n				<p>\n					<span style=\"font-family:Arial;font-size:12px;font-weight:normal;font-style:italic;text-decoration:none;color:#333333;\">Информация о магазине</span></p>\n			</td>\n		</tr>\n	</tbody>\n</table>\n<p>\n	&nbsp;</p>\n','your_shops');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producers`
--

DROP TABLE IF EXISTS `producers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producers`
--

LOCK TABLES `producers` WRITE;
/*!40000 ALTER TABLE `producers` DISABLE KEYS */;
INSERT INTO `producers` VALUES (1,'Россия'),(2,'Белоруссия');
/*!40000 ALTER TABLE `producers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rates`
--

DROP TABLE IF EXISTS `rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rate` double DEFAULT '0',
  `rates_count` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates`
--

LOCK TABLES `rates` WRITE;
/*!40000 ALTER TABLE `rates` DISABLE KEYS */;
INSERT INTO `rates` VALUES (23,4,1),(24,4,1),(25,5,1),(26,4,2),(27,4,2),(28,4,1),(29,2,2),(30,5,1);
/*!40000 ALTER TABLE `rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'login',''),(2,'admin',''),(3,'seller','');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_users`
--

DROP TABLE IF EXISTS `roles_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`),
  CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_users`
--

LOCK TABLES `roles_users` WRITE;
/*!40000 ALTER TABLE `roles_users` DISABLE KEYS */;
INSERT INTO `roles_users` VALUES (1,1),(41,1),(42,1),(43,1),(45,1),(48,1),(49,1),(50,1),(54,1),(55,1),(56,1),(57,1),(58,1),(1,2),(47,2),(37,3),(38,3),(39,3),(40,3),(46,3),(51,3),(52,3),(53,3),(57,3),(59,3);
/*!40000 ALTER TABLE `roles_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `searches`
--

DROP TABLE IF EXISTS `searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `searches` (
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `searches`
--

LOCK TABLES `searches` WRITE;
/*!40000 ALTER TABLE `searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `cost` float(10,2) NOT NULL,
  `lifetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Стоимость выделения цветом товара',10.00,1),(2,'Стоимость выделения цветом магазина',270.00,1),(3,'Стоимость одного просмотра страницы товара',1.00,0);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopkinds`
--

DROP TABLE IF EXISTS `shopkinds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopkinds` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopkinds`
--

LOCK TABLES `shopkinds` WRITE;
/*!40000 ALTER TABLE `shopkinds` DISABLE KEYS */;
INSERT INTO `shopkinds` VALUES (1,'Магазин'),(2,'Интернет-магазин');
/*!40000 ALTER TABLE `shopkinds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `address` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `kind_id` int(11) DEFAULT NULL,
  `tovars_count` int(10) unsigned NOT NULL,
  `rate_id` int(10) unsigned DEFAULT NULL,
  `highlight` tinyint(1) DEFAULT NULL,
  `comments_count` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
INSERT INTO `shops` VALUES (1,'Фирменный салон','<p>\n	Самый большой фирменный салон &laquo;Mablos&raquo; в г. Казани. Расположен при выходе из ст. метро &laquo;Козья Слобода&raquo;, ост. &laquo;Энергетический университет&raquo;. Здесь можно воочию увидеть продукцию представленную на сайте mablos.ru</p>\n','Декабристов, д.8','',0,0,'test@test.com','123-45-67',40,2,1,'55.78603658127135','49.115607431860326',1,2,26,NULL,1),(2,'ЦДМ','','Тукая, д.115','',0,0,'test@test.com','123-45-67',40,2,1,'55.76746211226331','49.12693272963861',1,2,NULL,NULL,0),(3,'СуперМебель','<p>\n	Широкий выбор, низкие цены, высокое качество, высокий уровень обслуживания, мы профессионалы своего дела, работаем для вас.</p>\n','ул. Фатыха Карима, д.9','',0,0,'marat@rupromo.ru','(843) 293-81-21',45,2,1,'55.778405','49.11694069999999',1,0,30,1,0),(4,'','','','',0,0,'','',48,2,NULL,NULL,NULL,NULL,0,NULL,NULL,0),(5,'Малос сити','','Чистопольская 35','',0,0,'k-juliya@mail.ru','',52,2,NULL,NULL,NULL,NULL,0,NULL,1,0),(6,'Малос сити','','Чистопольская 35','',0,0,'k-juliya@mail.ru','',52,2,NULL,NULL,NULL,NULL,0,NULL,NULL,0),(7,'Малос сити','','Чистопольская 35','',0,0,'k-juliya@mail.ru','',52,2,NULL,NULL,NULL,NULL,0,NULL,NULL,0),(8,'Малос сити','','Чистопольская 35','',0,0,'k-juliya@mail.ru','',52,2,NULL,NULL,NULL,NULL,0,NULL,NULL,0),(9,'Малос сити','','Чистопольская','',0,0,'k-juliya@mail.ru','',52,2,NULL,NULL,NULL,NULL,0,NULL,NULL,0),(10,'','','','',0,0,'','',52,2,NULL,NULL,NULL,NULL,0,NULL,NULL,0),(11,'Кресла','<p>\n	Самый лучший магазин!</p>\n','ул. Ямашева 51','',0,0,'mikhail@rupromo.ru','',53,2,NULL,NULL,NULL,NULL,0,NULL,NULL,0),(14,'3','','','http://3.ru',0,0,'qwe@qwe.ru','123445',57,0,0,NULL,NULL,2,0,NULL,NULL,0),(15,'4','','Лобачевского, 16','',0,0,'qwe@qwe.ru','123445',57,0,0,'57.14418200000001','65.48733800000002',1,0,NULL,NULL,0),(16,'5','','Лобачевского, 16','',0,0,'qwe@qwe.ru','123445',57,0,0,'55.668031','37.506619',1,0,NULL,NULL,0),(17,'Офисная мебель','','ул. Пушкина, д.24','',0,0,'test@mebelboom.com','123-45-67',40,0,1,'55.790842','49.12495899999999',1,0,NULL,NULL,0),(18,'Мир Мебели','','ул. Тукая, д. 12','',0,0,'test@mebelboom.com','123-45-67',40,0,1,'55.784385','49.10877099999993',1,0,NULL,NULL,0);
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops_cities`
--

DROP TABLE IF EXISTS `shops_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops_cities` (
  `shop_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops_cities`
--

LOCK TABLES `shops_cities` WRITE;
/*!40000 ALTER TABLE `shops_cities` DISABLE KEYS */;
INSERT INTO `shops_cities` VALUES (4,1),(5,3),(6,3),(7,3),(8,7),(9,3),(10,1),(11,3),(3,3),(1,3),(2,3),(12,3),(13,1),(15,5),(16,1),(17,3),(18,3);
/*!40000 ALTER TABLE `shops_cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops_shopservices`
--

DROP TABLE IF EXISTS `shops_shopservices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops_shopservices` (
  `shop_id` int(11) NOT NULL,
  `shopservice_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops_shopservices`
--

LOCK TABLES `shops_shopservices` WRITE;
/*!40000 ALTER TABLE `shops_shopservices` DISABLE KEYS */;
INSERT INTO `shops_shopservices` VALUES (5,1),(5,2),(6,1),(6,2),(7,1),(7,2),(8,1),(8,2),(9,1),(9,2),(11,1),(11,2),(3,1),(1,1),(2,1),(2,2),(12,1),(12,2),(16,1),(16,2),(17,1),(17,2),(18,1),(18,2);
/*!40000 ALTER TABLE `shops_shopservices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops_shoptypes`
--

DROP TABLE IF EXISTS `shops_shoptypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops_shoptypes` (
  `shop_id` int(11) NOT NULL,
  `shoptype_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops_shoptypes`
--

LOCK TABLES `shops_shoptypes` WRITE;
/*!40000 ALTER TABLE `shops_shoptypes` DISABLE KEYS */;
INSERT INTO `shops_shoptypes` VALUES (3,3),(1,1),(2,2),(12,1),(13,3),(15,1),(16,1),(17,1),(18,1);
/*!40000 ALTER TABLE `shops_shoptypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops_stocks`
--

DROP TABLE IF EXISTS `shops_stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops_stocks` (
  `shop_id` int(10) unsigned NOT NULL,
  `stock_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`shop_id`,`stock_id`),
  KEY `fk_stock_id` (`stock_id`),
  CONSTRAINT `shops_stocks_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `shops_stocks_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops_stocks`
--

LOCK TABLES `shops_stocks` WRITE;
/*!40000 ALTER TABLE `shops_stocks` DISABLE KEYS */;
INSERT INTO `shops_stocks` VALUES (3,17);
/*!40000 ALTER TABLE `shops_stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops_tovars`
--

DROP TABLE IF EXISTS `shops_tovars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops_tovars` (
  `shop_id` int(10) unsigned NOT NULL,
  `tovar_id` int(10) unsigned NOT NULL,
  `url` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `best` tinyint(1) NOT NULL,
  PRIMARY KEY (`shop_id`,`tovar_id`),
  KEY `fk_stock_id` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops_tovars`
--

LOCK TABLES `shops_tovars` WRITE;
/*!40000 ALTER TABLE `shops_tovars` DISABLE KEYS */;
INSERT INTO `shops_tovars` VALUES (1,2,'',29500,0),(1,4,'',0,0),(2,2,'',30000,1),(2,4,'',29000,1),(3,3,'',31000,0);
/*!40000 ALTER TABLE `shops_tovars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops_types`
--

DROP TABLE IF EXISTS `shops_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shops_types` (
  `shop_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops_types`
--

LOCK TABLES `shops_types` WRITE;
/*!40000 ALTER TABLE `shops_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `shops_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopservices`
--

DROP TABLE IF EXISTS `shopservices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopservices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopservices`
--

LOCK TABLES `shopservices` WRITE;
/*!40000 ALTER TABLE `shopservices` DISABLE KEYS */;
INSERT INTO `shopservices` VALUES (1,'Доставка мебели'),(2,'Сборка мебели');
/*!40000 ALTER TABLE `shopservices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoptypes`
--

DROP TABLE IF EXISTS `shoptypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shoptypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoptypes`
--

LOCK TABLES `shoptypes` WRITE;
/*!40000 ALTER TABLE `shoptypes` DISABLE KEYS */;
INSERT INTO `shoptypes` VALUES (1,'Магазин'),(2,'Склад'),(3,'Производство');
/*!40000 ALTER TABLE `shoptypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statuses`
--

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `publish_time` int(10) unsigned DEFAULT NULL,
  `anons` text,
  `content` text,
  `pic` varchar(250) DEFAULT NULL,
  `begin_time` int(10) DEFAULT NULL,
  `store` varchar(250) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `expires` int(10) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `status_id` int(11) NOT NULL,
  `created_time` int(10) unsigned DEFAULT NULL,
  `reject_reason` varchar(250) DEFAULT NULL,
  `url` varchar(250) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (17,'Скидка на офисную мебель 30%!',1354698207,'Только в декабре! Глобальная распродажа в магазине \"СуперМебель\"!','Приходите и забирайте! Отдаем, фактически, по себестоимости.','globcon-alert.png',1354824000,NULL,NULL,NULL,NULL,45,0,3,1354697373,'<p>\n	Слишком короткое описание акции - напишите, пожалуйста, побольше.</p>\n','http://www.superofis.ru/action/',1),(18,'Новогодняя акция',1354883604,'До 1-го января скидки на все пуфы!','Точно достоверна!','Koala.jpg',1355947200,NULL,NULL,NULL,NULL,52,0,3,1354883478,'','http://market.yandex.ru/search.xml?text=%D0%B8%D0%BA%D0%B5%D0%B0+%D1%81%D1%82%D0%BE%D0%BB&cvredirect=2',1),(19,'Кресла за пол цены',1354883486,'50%','','16.02.2011.jpg',1354824000,NULL,NULL,NULL,NULL,53,0,3,1354883486,'<p>\n	Хорошо</p>\n','',1),(20,'Текущая акция',1354883931,'Акция очень хорошая','','Chrysanthemum.jpg',1354824000,NULL,NULL,NULL,NULL,52,0,3,1354883931,'','',1),(21,'Столик под телефон',1362171979,'Также такой мини - столик можно использовать в любой другой комнате вашей квартиры или дома, например в спальной комнате, на который можно поставить ночник или положить книгу и поставить чашечку кофе, а также он заменит любой маленький журнальный столик в вашей гостиной. ','Также такой мини - столик можно использовать в любой другой комнате вашей квартиры или дома, например в спальной комнате, на который можно поставить ночник или положить книгу и поставить чашечку кофе, а также он заменит любой маленький журнальный столик в вашей гостиной. ','13_03_.jpg',1358798400,NULL,NULL,NULL,NULL,54,0,3,1358779527,'','http://www.mebelboom.com',0),(24,'Скидка на все 30% до 25 мая!',1362989882,'Выбирайте любую мебель в нашем каталоге, и мы доставим вам ее в течение трех дней.','','1.jpg',1363031999,NULL,NULL,NULL,NULL,40,0,4,1362989882,'','',1),(25,'Новое поступление немецких кухонь!',1362990026,'25 готовых гарнитуров высшего качества ждут вас на нашем складе','',NULL,1363032000,NULL,NULL,NULL,NULL,40,0,4,1362990026,'','',1),(26,'Скидка 50% во всех магазинах сети «Маблос»',1362990367,'Оптимальное соотношение цены и качества','','akciya.jpg',1363032001,NULL,NULL,NULL,NULL,40,0,4,1362990206,'','',1);
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscribers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `code` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribers`
--

LOCK TABLES `subscribers` WRITE;
/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
INSERT INTO `subscribers` VALUES (1,'marat@rupromo.ru','59f418514005ff55d9f337075858e81d'),(2,'julka@artsoda.ru','bf7c7d90c61326e912f2992971c93fbd'),(3,'k-juliya@mail.ru','1aa4bb3c58bee4a57f627aba6e4f691a'),(4,'oops_1111@maill.ru','644df6952d5959604f5fc46a9513f0cc'),(5,'digital7@list.ru','5d8dea9e392e8457cb3c528bc4066090'),(6,'qwe@qwe.ru','c5d64fb3d6fa341e5d5f6d410d12f7a3'),(7,'ArchimedRT@yandex.ru','3db89488715d12a643783123a9fb0de4');
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tovars`
--

DROP TABLE IF EXISTS `tovars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tovars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `producer_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `rate_id` int(10) unsigned DEFAULT NULL,
  `highlight` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `comments_count` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_tovars_producers1_idx` (`producer_id`),
  KEY `fk_tovars_categories1_idx` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tovars`
--

LOCK TABLES `tovars` WRITE;
/*!40000 ALTER TABLE `tovars` DISABLE KEYS */;
INSERT INTO `tovars` VALUES (1,40,1,'Test',2000,1,'',NULL,NULL,1,0),(2,40,40,'Трапеза 2400',31000,1,'Кухонный гарнитур Трапеза 2400 отличается функциональностью, удобством и легкостью в эксплуатации. При производстве большое внимание уделено применению высокотехнологичных материалов, комплектующих и современного дизайна. Использовалось ДСП 16 мм толщины, покрытого защитным слоем ламинатной пленки, фасады из МДФ. Комплектуется фурнитурой HETTICH (Германия), благодаря которой дверцы открываются и закрываются мягко. Пенал можно ставить как с правой, так и с левой стороны.\nВозможные цвета корпус/фасад: серый/лаванда жемчужная, жемчуг глянец, белый глянец, лаванда бронзовая, бронза, звездная пыль салатовая, звездная пыль фиолетовая, звездная пыль лазурь, звездная пыль бирюза, звездная пыль бордо, звездная пыль оранжевая, белый жемчуг, металлик; вишня/вишня; дуб молочный/дуб феррара; венге/венге, бронзовый однотонный. ',28,NULL,1,1),(4,40,40,'Кухня \"Морская волна\"',29000,1,'Идеальный вариант для маленькой кухни — мебель, сделанная на заказ с учетом размеров помещения, количества вещей для хранения и ваших привычек. Многие российские производители предлагают эконом-вариант – готовые компактные гарнитуры из недорогих материалов, которые рассчитаны на малогабаритные кухни и стандартные планировки.',29,1,1,2),(5,59,18,'Все не так. В 2 томах. Том 1',100,1,'\nВсе прекрасно в большом патриархальном семействе Руденко. Но — увы! — впечатление это обманчиво: каждого из многочисленных представителей семьи обуревают свои потаенные страсти и запретные желания.\n',NULL,NULL,NULL,0),(6,59,18,'Иваnов и Rабинович, или Аj\'гоу ту \'Хаjфа!',200,1,'\nПеру Владимира Кунина принадлежат десятки сценариев к кинофильмам, серия книг про КЫСЮ и многое, многое другое.\n',NULL,NULL,NULL,0),(7,59,18,'undefined',450,1,'\nDark Side Of The Moon, поставивший мир на уши невиданным сочетанием звуков, — это всего-навсего девять треков, и даже не все они писались специально для альбома. Порывшись по сусекам, участники Pink Floyd мудро сделали новое из хорошо забытого старого — песен, которые почему-либо не пошли в дело или остались незаконченными. Одним из источников вдохновения стали саундтреки для кинофильмов, которые группа производила в больших количествах.\n',NULL,NULL,NULL,0),(8,59,18,'Hilton',30000,1,'Отдых в Египте.',NULL,NULL,NULL,0),(9,59,18,'\nДмитрий Хворостовский и Национальный филармонический оркестр России. Дирижер — Владимир Спиваков.\n',5000,1,'\nКонцерт Дмитрия Хворостовского и Национального филармонического оркестра России под управлением Владимира Спивакова.\n',NULL,NULL,NULL,0),(10,59,18,'Test',7700,1,'описание 90',NULL,NULL,NULL,0),(11,59,18,'Test',7700,1,'описание 90',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `tovars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tovars_keywords`
--

DROP TABLE IF EXISTS `tovars_keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tovars_keywords` (
  `tovar_id` int(10) NOT NULL,
  `keyword_id` int(10) NOT NULL,
  `weight` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tovars_keywords`
--

LOCK TABLES `tovars_keywords` WRITE;
/*!40000 ALTER TABLE `tovars_keywords` DISABLE KEYS */;
INSERT INTO `tovars_keywords` VALUES (20,2,1000),(4,6,1000),(4,7,999),(4,8,998),(2,3,1000),(2,5,999),(5,10,1000),(5,10,999),(5,10,998),(5,10,997),(5,10,996),(5,10,995),(5,10,994),(5,10,993),(6,10,1000),(6,10,999),(6,10,998),(6,10,997),(6,10,996),(6,10,995),(6,10,994),(7,10,1000),(8,10,1000),(9,10,1000),(9,10,999),(9,10,998),(9,10,997),(9,10,996),(9,10,995),(9,10,994),(9,10,993),(9,10,992),(9,10,991),(9,10,990),(10,10,1000),(11,10,1000);
/*!40000 ALTER TABLE `tovars_keywords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tokens`
--

DROP TABLE IF EXISTS `user_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`),
  KEY `expires` (`expires`),
  CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tokens`
--

LOCK TABLES `user_tokens` WRITE;
/*!40000 ALTER TABLE `user_tokens` DISABLE KEYS */;
INSERT INTO `user_tokens` VALUES (2,1,'38a257377d24da4539f861bd4b49038b146c5ca1','42d3a9d42d767721cef3ec00d024623401969c81','',1349695724,1350905324),(6,1,'7b0e7a9d5cd3fc37a1aec7950c6f23f4cbea421c','2aa86e9af87046929852d0aeae0e50cabe693aef','',1349767273,1350976873);
/*!40000 ALTER TABLE `user_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL,
  `activate_code` varchar(64) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  `phone` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `post` varchar(250) DEFAULT NULL,
  `identity` varchar(250) NOT NULL,
  `url` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'v.gubkin@rupromo.ru','admin','30d7c869fdef9d20e8373f050f7d5ab7507f1751bbf88dc2601e78eb5268784a','UzRSupJVrZFV7nk7Rs',87,1369731151,NULL,NULL,NULL,'',''),(37,'pm@rupromo.ru','pm@rupromo.ru','30d7c869fdef9d20e8373f050f7d5ab7507f1751bbf88dc2601e78eb5268784a','',0,NULL,'','',NULL,'',''),(38,'digital7@list.ru','digital7@list.ru','c608441fdb6823310c1f9e81ff4d8eab2b03316023e49dc028ebb280ce68cfa8','',4,1354222888,'1234567','авав','вава','',''),(39,'admin@8marta.ru','admin@8marta.ru','30d7c869fdef9d20e8373f050f7d5ab7507f1751bbf88dc2601e78eb5268784a','',1,1352363844,'','',NULL,'',''),(40,'anonymous@anonymous.com','Виталий Губкин','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',21,1365582337,'8-800-2222-2222',NULL,NULL,'http://vk.com/id71862494',''),(41,'alex@rupromo.ru','РуПромо alex@rupromo.ru','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',3,1354693363,NULL,NULL,NULL,'https://www.google.com/accounts/o8/id?id=AItOawnKnc3Ins7DZ_Mwx2pkvI-Ao9HWBAs22zg',''),(42,'gubkinvit@yandex.ru','Виталий','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',2,1354650337,NULL,NULL,NULL,'http://openid.yandex.ru/gubkinvit/',''),(43,'anonymous@anonymous.com','Виталий Губкин','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',2,1354650362,NULL,NULL,NULL,'http://twitter.com/vgubkin',''),(45,'marat@rupromo.ru','Marat Mashkov','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',6,1360589343,NULL,NULL,NULL,'http://www.facebook.com/marat.mashkov',''),(46,'m.mashkov@rupromo.ru','m.mashkov@rupromo.ru','74eb1431d59514b95c54e03781f63dd1c8fce1345d64bcaea1431a832d94242c','',1,1354690612,'','Марат',NULL,'',''),(47,'anonymous@anonymous.com','Sitdikov Irek','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',4,1354789386,NULL,NULL,NULL,'http://twitter.com/sitdirek',''),(48,'sitdirek@gmail.com','Ситдиков Ирек','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',7,1368441573,'','','','https://www.google.com/accounts/o8/id?id=AItOawnjKC2WDKXUYBfzdkXBbb-MTTEfQw5mP9g',''),(49,'anonymous@anonymous.com','Виктор Кучергин','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',4,1354882020,NULL,NULL,NULL,'http://vk.com/id42600760',''),(50,'imikhailrakhimov@gmail.com','Mikhail Rakhimov','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',3,1354883011,NULL,NULL,NULL,'http://www.facebook.com/mikhailrakhimov',''),(51,'oops_1111@maill.ru','oops_1111@maill.ru','a3775465eb4f5e9173ca91be8369f2e31480e95f52865cea7bc2dfd1c128bd73','Myd8ylSVN3rGyBGMot',0,NULL,'+79061140132','Михаил',NULL,'',''),(52,'k-juliya@mail.ru','k-juliya@mail.ru','30d7c869fdef9d20e8373f050f7d5ab7507f1751bbf88dc2601e78eb5268784a','',1,1354883213,'89172226261','Юлия ',NULL,'',''),(53,'mikhail@rupromo.ru','mikhail@rupromo.ru','a3775465eb4f5e9173ca91be8369f2e31480e95f52865cea7bc2dfd1c128bd73','',1,1354883352,'','Mikhail',NULL,'',''),(54,'anonymous@anonymous.com','Артем Кучергин','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',14,1362634111,'','','','http://vk.com/id24079736',''),(55,'anonymous@anonymous.com','Michael Rakhimov','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',4,1360322669,NULL,NULL,NULL,'http://vk.com/id1361437',''),(56,'archimedrt@gmail.com','Руслан Архипов','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',3,1361192523,NULL,NULL,NULL,'https://www.google.com/accounts/o8/id?id=AItOawl8N3EdOhHUUcmzMz3sbIjKsjgVYqVD0zo',''),(57,'archimedrt@rambler.ru','archimedrt@rambler.ru','f3eb73c22eb4e6e1dba2818e8c95bc0e8695d5a1ae0108ad2f19bbc1371d8cf0','',2,1361192905,'123445','Руслан',NULL,'',''),(58,'anonymous@anonymous.com',' ArchimedRT','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',3,1361192684,NULL,NULL,NULL,'http://openid.yandex.ru/ArchimedRT/',''),(59,'anonymous@anonymous.com','Ирек Ситдиков','e83dcaabc9c340e8b70a7f848d1955bf2586f42690223100fd3e2ef985cf7ae5','',6,1369730292,NULL,NULL,NULL,'http://vk.com/id1501714','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_rates`
--

DROP TABLE IF EXISTS `users_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_rates` (
  `user_id` int(10) unsigned NOT NULL,
  `model` varchar(45) NOT NULL,
  `object_id` int(10) unsigned NOT NULL,
  `rate` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`,`object_id`,`model`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_rates`
--

LOCK TABLES `users_rates` WRITE;
/*!40000 ALTER TABLE `users_rates` DISABLE KEYS */;
INSERT INTO `users_rates` VALUES (1,'shop',1,5),(40,'shop',1,4),(40,'shop',2,5),(40,'tovar',19,4),(54,'shop',1,3),(54,'tovar',2,4),(54,'tovar',3,3),(54,'tovar',4,3),(55,'tovar',3,5),(56,'shop',3,5),(56,'tovar',4,1);
/*!40000 ALTER TABLE `users_rates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-28 13:32:44
