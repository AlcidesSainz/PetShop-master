CREATE DATABASE  IF NOT EXISTS `pet_shop` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pet_shop`;
-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: pet_shop
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `idproducto` int NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(45) NOT NULL,
  `precio` decimal(5,2) NOT NULL,
  `stock` int NOT NULL,
  `categoria` int NOT NULL,
  `proveedor` int DEFAULT NULL,
  `tipomascota` int NOT NULL,
  `imagen` longblob NOT NULL,
  PRIMARY KEY (`idproducto`),
  UNIQUE KEY `nombre_producto_UNIQUE` (`nombre_producto`),
  KEY `fk.producto a categoria_idx` (`categoria`),
  KEY `fk.producto a proveedor_idx` (`proveedor`),
  KEY `fk.producto a tipoMascota_idx` (`tipomascota`),
  CONSTRAINT `fk.producto a categoria` FOREIGN KEY (`categoria`) REFERENCES `categorias_productos` (`idcategorias_productos`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk.producto a proveedor` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`idproveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk.producto a tipoMascota` FOREIGN KEY (`tipomascota`) REFERENCES `tipomascota` (`idtipoMascota`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (9,'Procan para cachorro',5.00,20,1,1,1,_binary '6501263b81c5c_alimento-seco.png'),(10,'Procan para adultos',6.00,18,1,1,1,_binary '65012a505d944_Adultos-original-pollo-PRONACA2.png'),(11,'Cat Chow para Adultos de pescado',9.00,20,1,1,2,_binary '65012ad25d3f8_CAT-CHOW-DELICIAS-RELLENAS-PESCADO.png'),(12,'Kitten Chow ',10.00,40,1,1,2,_binary '65012b687b0b0_png-transparent-purina-kitten-chow-nurture-dry-cat-food-purina-kitten-chow-nurture-dry-cat-food-nestle-purina-petcare-company-kitten-food-animals-pet-thumbnail.png'),(13,'Whiskas de paté',2.00,10,1,1,2,_binary '6501cdc738478_kisspng-cat-food-whiskas-pet-food-salgadinhos-5b359bcdade227.5320434415302399497122.png'),(14,'Whiskas ',4.00,9,1,1,2,_binary '6501de81efe80_pngegg.png'),(16,'TetraFin',1.00,29,1,1,3,_binary '6509074356921_pngwing.com (1).png'),(18,'Noyo Dragon',5.20,60,1,2,3,_binary '650a684ce420f_pngwing.com (2).png'),(19,'Foster Premium',9.20,20,1,2,1,_binary '650a72d45c4ca_pngwing.com (3).png'),(20,'Biscrok Gravy Bones',1.20,60,1,2,1,_binary '650a72f7dbb40_pngwing.com (4).png'),(21,'Jumbone Medium',1.00,60,1,2,1,_binary '650a731759f1b_pngwing.com (5).png'),(22,'Pedigree Junior',1.00,50,1,2,1,_binary '650a73378a4b8_pngwing.com (6).png'),(23,'Perfect Fit',12.00,10,1,2,1,_binary '650a73505f575_pngwing.com (7).png'),(24,'Brit Premium',1.40,40,1,2,2,_binary '650a736e01a9d_pngwing.com (8).png'),(25,'Pelota para perro',3.00,10,2,2,1,_binary '650a73d3428c5_pngwing.com (2).png'),(26,'Hueso de juguete',2.00,20,2,2,1,_binary '650a73fc50e84_pngwing.com (3).png'),(27,'Masticador para perros',4.00,30,2,2,1,_binary '650a74225feeb_pngwing.com (4).png'),(28,'Hueso de plastico',2.00,10,2,2,1,_binary '650a743e07865_pngwing.com (5).png'),(29,'Cama para perro',15.00,90,3,2,1,_binary '650a7479e47a7_pngwing.com (6).png'),(30,'Cama para gato',20.00,80,3,2,2,_binary '650a74a102263_IGLU-GATO-ROJO-LADO-WEB.png');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-19 23:33:31
