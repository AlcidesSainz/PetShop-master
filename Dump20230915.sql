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
-- Table structure for table `carrito_compra`
--

DROP TABLE IF EXISTS `carrito_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrito_compra` (
  `id_sesion` varchar(255) NOT NULL,
  `id_producto` int NOT NULL,
  KEY `fk_carrito a producto_idx` (`id_producto`),
  CONSTRAINT `fk_carrito a producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrito_compra`
--

LOCK TABLES `carrito_compra` WRITE;
/*!40000 ALTER TABLE `carrito_compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `carrito_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias_productos`
--

DROP TABLE IF EXISTS `categorias_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_productos` (
  `idcategorias_productos` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(45) NOT NULL,
  PRIMARY KEY (`idcategorias_productos`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_productos`
--

LOCK TABLES `categorias_productos` WRITE;
/*!40000 ALTER TABLE `categorias_productos` DISABLE KEYS */;
INSERT INTO `categorias_productos` VALUES (1,'Comida'),(2,'Juguete');
/*!40000 ALTER TABLE `categorias_productos` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (8,'Cat Chow Complete',8.00,5,1,1,2,_binary '650126292579e_pngwing.com.png'),(9,'Procan para cachorro',5.00,10,1,1,1,_binary '6501263b81c5c_alimento-seco.png'),(10,'Procan para adultos',6.00,20,1,1,1,_binary '65012a505d944_Adultos-original-pollo-PRONACA2.png'),(11,'Cat Chow para Adultos de pescado',9.00,50,1,1,2,_binary '65012ad25d3f8_CAT-CHOW-DELICIAS-RELLENAS-PESCADO.png'),(12,'Kitten Chow ',10.00,2,1,1,2,_binary '65012b687b0b0_png-transparent-purina-kitten-chow-nurture-dry-cat-food-purina-kitten-chow-nurture-dry-cat-food-nestle-purina-petcare-company-kitten-food-animals-pet-thumbnail.png'),(13,'Whiskas de paté',2.00,10,1,1,2,_binary '6501cdc738478_kisspng-cat-food-whiskas-pet-food-salgadinhos-5b359bcdade227.5320434415302399497122.png'),(14,'Whiskas ',4.00,20,1,1,2,_binary '6501de81efe80_pngegg.png'),(15,'Avant para adultos',12.30,5,1,1,1,_binary '65039afa3f4ed_producto-adult-med-1.png');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `idproveedor` int NOT NULL AUTO_INCREMENT,
  `nombreProveedor` varchar(45) NOT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idproveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'Juanito el proveedor','10 de agosto','0987654321','juan@gmail.com');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipomascota`
--

DROP TABLE IF EXISTS `tipomascota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipomascota` (
  `idtipoMascota` int NOT NULL AUTO_INCREMENT,
  `mascota` varchar(45) NOT NULL,
  PRIMARY KEY (`idtipoMascota`),
  UNIQUE KEY `mascota_UNIQUE` (`mascota`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipomascota`
--

LOCK TABLES `tipomascota` WRITE;
/*!40000 ALTER TABLE `tipomascota` DISABLE KEYS */;
INSERT INTO `tipomascota` VALUES (2,'Gato'),(1,'Perro');
/*!40000 ALTER TABLE `tipomascota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idusuarios` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contrasena` varchar(45) NOT NULL,
  `esAdmin` tinyint DEFAULT NULL,
  PRIMARY KEY (`idusuarios`),
  UNIQUE KEY `correo_UNIQUE` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Alcides','alcidessainz99@gmail.com','123',1),(2,'Gabriela','gabriela@gmail.com','123',NULL),(3,'Judith','judith@gmail.com','123',NULL),(5,'pez','pez@gmail.com','123',NULL),(6,'Alcides','alcidessain1z99@gmail.com','123',NULL),(8,'gabriela','gabriela2@gmail.com','123',NULL),(9,'Alc','alcidessain11z99@gmail.com','123',NULL),(10,'lucy','lucy@gmail.com','1234',NULL),(11,'a','a@gmail.com','123',NULL),(12,'as','as@gmail.com','123',NULL),(13,'Gabita','gabita@gmail.com','123',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-15  0:26:14
