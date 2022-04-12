-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: it490
-- ------------------------------------------------------
-- Server version	8.0.28-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test1','$2y$10$al7BF5lwz1eXM.iOegVpeu9PHubDVgRXyXj9sQuJkhkXpkYwBhrhm','2022-03-24 23:09:13','aaa@gmail.com','123'),(2,'cameron9167','$2y$10$8qgVXRF5DyT4Y8Zsqayly.yE7hsI23KzDN.9yC.sIjvCJ9ILZXOme','2022-03-24 23:23:31','cameronb6546@gmail.com','7323722709'),(3,'test2','$2y$10$xgFjHOuDrfmUIB/5faRxDu4XxCK/CCCRcujXvrW7WVRq2TqrUFFs.','2022-03-28 23:02:54','test2@gmail.com','1234567890'),(4,'Raji','$2y$10$S6UkrEt1vVRuh453efMy9Oxw/H7hdxiTdC5qo4gpiSTDx.7qsrhRq','2022-03-29 01:30:23','rajharajesuwari@gmail.com','1234567890'),(5,'rajhees','5f4dcc3b5aa765d61d8327deb882cf99','2022-03-29 01:36:03','rajhees@rediffmail.com','1234567890'),(6,'rajis','5f4dcc3b5aa765d61d8327deb882cf99','2022-03-29 01:39:09','raji@gmail.com','1234567890'),(7,'test3','5f4dcc3b5aa765d61d8327deb882cf99','2022-03-29 01:41:43','test3@gmail.com','1234567890'),(8,'test5','5f4dcc3b5aa765d61d8327deb882cf99','2022-03-29 15:38:21','test5@gmail.com','1234567890'),(9,'test10','5f4dcc3b5aa765d61d8327deb882cf99','2022-03-29 17:00:00','test10@gmail.com`','1234567890'),(10,'test20','5f4dcc3b5aa765d61d8327deb882cf99','2022-03-29 19:47:49','test20@gmail.com','1234567890'),(11,'test65','5f4dcc3b5aa765d61d8327deb882cf99','2022-04-03 22:06:01','test65@gmail.com','1234567890'),(12,'test67','5f4dcc3b5aa765d61d8327deb882cf99','2022-04-04 21:42:24','test67@gmail.com','1234567890'),(13,'julian','iloveIT490','2022-04-05 18:41:01','evil@evil.net','6116626063'),(17,'test457','password','2022-04-05 19:57:42','test457@yahoo.com','1234567890'),(19,'test690','password','2022-04-05 19:57:58','test690@gmail.com','1234567890'),(32,'test375','password','2022-04-05 20:33:12','test375@gmail.com','password');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-12 19:13:48
