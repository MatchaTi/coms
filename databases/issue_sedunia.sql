CREATE DATABASE  IF NOT EXISTS `issue_sedunia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `issue_sedunia`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: issue_sedunia
-- ------------------------------------------------------
-- Server version	8.0.30

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

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'front-end'),(2,'back-end'),(3,'full-stack');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (11,1,1,'Great introduction to HTML!','2024-10-27 00:55:11'),(12,1,2,'CSS basics are a must for any front-end developer.','2024-10-27 00:55:11'),(13,1,3,'JavaScript really brings webpages to life!','2024-10-27 00:55:11'),(14,1,4,'Node.js is powerful for backend work!','2024-10-27 00:55:11'),(15,1,5,'Express makes API development simpler.','2024-10-27 00:55:11'),(16,2,1,'HTML is indeed the foundation. Thanks for sharing!','2024-10-27 00:55:11'),(17,2,6,'Databases are an integral part of full-stack development.','2024-10-27 00:55:11'),(20,2,3,'JavaScript is versatile and essential for web development.','2024-10-27 00:55:11'),(21,1,2,'Aku lho jago','2024-10-27 02:45:15'),(23,7,17,'haloooo\r\n','2024-11-04 13:04:05');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `photo` varchar(255) DEFAULT NULL,
  `watching_counter` int DEFAULT '0',
  `share_counter` int DEFAULT '0',
  `isSolve` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,1,'Introduction to HTML','HTML is the foundation of the web...','2024-10-27 00:54:56','img/posts/html.jpg',20,0,0),(2,1,1,'CSS Basics','Styling with CSS is essential for front-end...','2024-10-27 00:54:56','img/posts/css.jpg',0,0,0),(3,1,2,'JavaScript Essentials','Learn JavaScript to add interactivity...','2024-10-27 00:54:56','img/posts/javascript.jpg',0,0,0),(4,2,2,'Backend with Node.js','Node.js allows you to run JavaScript on the server...','2024-10-27 00:54:56','img/posts/node.jpg',0,0,0),(5,2,2,'Express.js for REST APIs','Express is a minimalistic web framework...','2024-10-27 00:54:56','img/posts/express.jpg',0,0,0),(6,2,3,'Database Basics','Understanding databases is crucial...','2024-10-27 00:54:56','img/posts/database.jpg',0,0,0),(13,1,1,'malas','coba coba aja','2024-10-27 02:30:40','img/posts/post_671da5d0b25c41.58708372.jpeg',0,0,0),(14,1,2,'Aku lho back-end','apa aja','2024-10-27 02:34:59',NULL,0,0,0),(15,1,1,'aku','coba deh','2024-10-27 03:13:38','img/posts/post_671dafe2182ed2.46440354.jpeg',0,0,0),(17,7,1,'test','Test Post','2024-11-04 12:38:54','img/posts/post_6728c05ec20b33.32530706.jpg',7,0,0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `bio` varchar(255) DEFAULT 'Hai selamat datang',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'johndoe','John Doe','Hai selamat datang','johndoe@example.com','password123','img/profiles/profile.jpg','user','2024-10-27 00:54:56'),(2,'janedoe','Jane Doe','Hai selamat datang','janedoe@example.com','password123','img/profiles/profile.jpg','user','2024-10-27 00:54:56'),(3,'adminuser','Admin User','Hai selamat datang','admin@example.com','adminpassword','img/profiles/profile.jpg','admin','2024-10-27 00:54:56'),(7,'EXOGAMER007','Daffa Sampe','Hai selamat datang','daffa8110@gmail.com','$2y$10$Z1HGo/QEFQZKRQjrjTNhx.5I.lPqlZ4kam49xwV0vqNku9A0GAN.i','img/profiles/profile_672465a454ebf1.99464232.png','user','2024-11-01 05:21:02'),(8,'admin','admin','Hai selamat datang','admin@gmail.com','$2y$10$WozFYhXtC7hMwTQMjzv5SeKdnOA/ft3/MIhksakd.BsOKwPOSvQ4G','img/profiles/profile.jpg','admin','2024-11-04 12:18:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'issue_sedunia'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-06  9:02:24
