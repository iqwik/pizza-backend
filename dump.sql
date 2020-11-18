-- MySQL dump 10.13  Distrib 8.0.20, for Win64 (x86_64)
--
-- Host: localhost    Database: pizza
-- ------------------------------------------------------
-- Server version	8.0.20

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
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userId` int DEFAULT NULL,
  `order` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orders_users_id_fk` (`userId`),
  CONSTRAINT `orders_users_id_fk` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,'{\"customer\":{\"name\":\"Tom\",\"email\":\"demo@demo.com\"},\"cart\":{\"items\":{\"1\":{\"id\":\"1\",\"title\":\"Margherita\",\"img\":\"/assets/img/margherita.jpeg\",\"cost\":{\"eur\":4.25,\"usd\":5},\"qty\":1},\"2\":{\"id\":\"2\",\"title\":\"Pepperoni\",\"img\":\"/assets/img/pepperoni.jpg\",\"cost\":{\"eur\":5.1,\"usd\":6},\"qty\":1},\"3\":{\"id\":\"3\",\"title\":\"Hawaiian\",\"img\":\"/assets/img/hawaiian.jpg\",\"cost\":{\"eur\":4.68,\"usd\":5.5},\"qty\":1}},\"quantity\":3,\"delivery\":{\"usd\":5,\"eur\":4.21},\"selectedCurrency\":\"usd\"},\"comment\":\"sdasadas dasdsa dsadasdasd\",\"address\":{\"street\":\"asdsaddsa\",\"house\":\"12\",\"apartment\":\"1\",\"entrance\":\"1\",\"floor\":\"1\"}}','2020-11-16 09:26:57'),(2,1,'{\"customer\":{\"name\":\"Tom\",\"email\":\"demo@demo.com\"},\"cart\":{\"items\":{\"2\":{\"id\":\"2\",\"title\":\"Pepperoni\",\"img\":\"/assets/img/pepperoni.jpg\",\"cost\":{\"eur\":5.1,\"usd\":6},\"qty\":1},\"3\":{\"id\":\"3\",\"title\":\"Hawaiian\",\"img\":\"/assets/img/hawaiian.jpg\",\"cost\":{\"eur\":4.68,\"usd\":5.5},\"qty\":1}},\"quantity\":2,\"delivery\":{\"usd\":5,\"eur\":4.21},\"selectedCurrency\":\"usd\"},\"comment\":\"sadasdasdasdasdasdasd\",\"address\":{\"street\":\"asdasdasdas\",\"house\":\"12\",\"apartment\":\"1\",\"entrance\":\"1\",\"floor\":\"1\"}}','2020-11-17 09:29:42'),(3,1,'{\"customer\":{\"name\":\"Demo\",\"email\":\"demo@demo.com\"},\"cart\":{\"items\":{\"7\":{\"id\":\"7\",\"title\":\"Meat Feast\",\"img\":\"/assets/img/meat-fest.jpg\",\"cost\":{\"eur\":6.17,\"usd\":7.25},\"qty\":1},\"8\":{\"id\":\"8\",\"title\":\"Double Pepperoni\",\"img\":\"/assets/img/double-pepperoni.jpg\",\"cost\":{\"eur\":5.95,\"usd\":7},\"qty\":1}},\"quantity\":2,\"delivery\":{\"usd\":5,\"eur\":4.21},\"selectedCurrency\":\"eur\"},\"comment\":\"sadasdasdasdasdasdasdsad\",\"address\":{\"street\":\"sadasdasd\",\"house\":\"12\",\"apartment\":\"1\",\"entrance\":\"1\",\"floor\":\"1\"}}','2020-11-18 11:19:02');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pizza`
--

DROP TABLE IF EXISTS `pizza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pizza` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `prices` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizza`
--

LOCK TABLES `pizza` WRITE;
/*!40000 ALTER TABLE `pizza` DISABLE KEYS */;
INSERT INTO `pizza` VALUES (1,'Margherita','Tomato sauce & mozzarella','margherita.jpeg','{\"eur\": 4.25, \"usd\": 5}'),(2,'Pepperoni','Tomato sauce, mozzarella & pepperoni','pepperoni.jpg','{\"eur\": 5.1, \"usd\": 6}'),(3,'Hawaiian','Tomato sauce, mozzarella, ham & pineapple','hawaiian.jpg','{\"eur\": 4.68, \"usd\": 5.5}'),(4,'Mexican','Cheese sauce, triple cheese blend, chicken, pepperoni, jalapenos','mexican.jpg','{\"eur\": 5.95, \"usd\": 7}'),(5,'Chicken BBQ','BBQ sauce, mozzarella, chicken breast, sweetcorn & BBQ drizzle','chicken-bbq.jpg','{\"eur\": 5.32, \"usd\": 6.25}'),(6,'Vegan Veggie','Tomato sauce, vegan cheese, sweetcorn, peppers, red onions & mushrooms','vegan-veggie.jpeg','{\"eur\": 4.68, \"usd\": 5.5}'),(7,'Meat Feast','Tomato sauce, mozzarella, pepperoni, ham, beef & chicken breast','meat-fest.jpg','{\"eur\": 6.17, \"usd\": 7.25}'),(8,'Double Pepperoni','Tomato sauce, mozzarella & double pepperoni','double-pepperoni.jpg','{\"eur\": 5.95, \"usd\": 7}'),(9,'Cheese','Tomato sauce, mozzarella, cheddar, dorblu & parmesan','cheese.jpg','{\"eur\": 5.95, \"usd\": 7}');
/*!40000 ALTER TABLE `pizza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_uindex` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Demo','demo@demo.com','$2y$10$61kcHrqACl9CiBfVrSN9Se3Qjg7EX7A1drFfeE4EJyAwhoDewoxXq','{\"street\":\"asdasdasdas\",\"house\":\"12\",\"apartment\":\"1\",\"entrance\":\"1\",\"floor\":\"1\"}');
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

-- Dump completed on 2020-11-18 18:16:53
