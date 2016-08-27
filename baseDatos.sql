CREATE DATABASE  IF NOT EXISTS `baseDatos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `baseDatos`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: baseDatos
-- ------------------------------------------------------
-- Server version	5.5.22

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
-- Table structure for table `partidas_ahorro`
--

DROP TABLE IF EXISTS `partidas_ahorro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partidas_ahorro` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idprestamo` bigint(20) DEFAULT NULL,
  `idusuario` bigint(20) DEFAULT NULL,
  `idcliente` bigint(20) DEFAULT NULL,
  `fechacobro` date DEFAULT NULL,
  `parcialidad` decimal(10,2) DEFAULT NULL,
  `abonado` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articulos`
--

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(200) NOT NULL,
  `descripcion` varchar(90) NOT NULL,
  `clasificacion` varchar(45) NOT NULL DEFAULT 'S',
  `precioVenta` decimal(10,2) NOT NULL,
  `unidad` varchar(10) NOT NULL DEFAULT 'PZA',
  `idusuario` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `informacion_fiscal`
--

DROP TABLE IF EXISTS `informacion_fiscal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `informacion_fiscal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idUsuario` int(10) NOT NULL,
  `rfc` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigoPostal` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pais` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estadoRepublica` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `municipio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localidad` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `colonia` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noInterior` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `noExterior` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `calle` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_codigoPostal` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_pais` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_estado` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_municipio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_localidad` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_colonia` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_noInterior` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_noExterior` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `e_calle` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regimen` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ahorro`
--

DROP TABLE IF EXISTS `ahorro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ahorro` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `idcliente` bigint(20) DEFAULT NULL,
  `plazo` varchar(10) DEFAULT NULL,
  `fechaprimerpago` date DEFAULT NULL,
  `totalprestado` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `tipo` varchar(5) DEFAULT 'M',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_cobro` int(11) DEFAULT '0',
  `tipo_cobro` varchar(45) DEFAULT 'OXXO',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `archivos_fiscal`
--

DROP TABLE IF EXISTS `archivos_fiscal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archivos_fiscal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` varchar(45) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `logoSistema` varchar(45) DEFAULT NULL,
  `logoMime` varchar(45) DEFAULT NULL,
  `certificado` varchar(45) DEFAULT NULL,
  `certificadoSistema` varchar(45) DEFAULT NULL,
  `llave` varchar(45) DEFAULT NULL,
  `llaveSistema` varchar(45) DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT NULL,
  `num_certificado` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `formatos_cfdi`
--

DROP TABLE IF EXISTS `formatos_cfdi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formatos_cfdi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_Formato` varchar(90) DEFAULT NULL,
  `disponibilidad` int(11) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cfdi_compras`
--

DROP TABLE IF EXISTS `cfdi_compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cfdi_compras` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `folio` bigint(20) DEFAULT NULL,
  `emisor` varchar(45) DEFAULT NULL,
  `receptor` varchar(45) DEFAULT NULL,
  `total_facturado` decimal(10,2) DEFAULT NULL,
  `uuid` varchar(45) DEFAULT NULL,
  `cadena_original` text,
  `observaciones` text,
  `factura` blob,
  `estado` int(11) DEFAULT NULL,
  `cancelacion` blob,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `compras`
--

DROP TABLE IF EXISTS `compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compras` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tipo_pago` varchar(45) DEFAULT NULL,
  `ultimos4` varchar(5) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `referencia` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT '0000-00-00 00:00:00',
  `updated_at` varchar(45) DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `addendas`
--

DROP TABLE IF EXISTS `addendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `addenda` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `puesto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bienvenida` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` int(11) DEFAULT '0',
  `formato` int(11) DEFAULT '1',
  `forma_pago` int(11) DEFAULT NULL,
  `customer_key` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `folios` bigint(20) DEFAULT '0',
  `recordatorios` bigint(20) DEFAULT '0',
  `suscripcion` int(11) DEFAULT NULL,
  `fechaSucripcion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_sistema_correoelectronico_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `suscripcion`
--

DROP TABLE IF EXISTS `suscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suscripcion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `inicioSuscripcion` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `proximaFecha` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `finSuscripcion` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `itemsAsignados` int(11) DEFAULT NULL,
  `itemsConsumidos` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(400) DEFAULT NULL,
  `respuestas` varchar(200) DEFAULT NULL,
  `valores` varchar(200) DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `formatos_usuario`
--

DROP TABLE IF EXISTS `formatos_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formatos_usuario` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `idformato` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prestamo`
--

DROP TABLE IF EXISTS `prestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prestamo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `idcliente` bigint(20) DEFAULT NULL,
  `plazo` varchar(10) DEFAULT NULL,
  `fechaprestamo` date DEFAULT NULL,
  `fechaprimerpago` date DEFAULT NULL,
  `totalprestado` decimal(10,2) DEFAULT NULL,
  `ahorro` decimal(10,2) DEFAULT NULL,
  `rendimiento` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_cobro` int(11) DEFAULT '0',
  `tipo_cobro` varchar(45) DEFAULT 'OXXO',
  PRIMARY KEY (`id`),
  KEY `usuarios` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partidascfdi`
--

DROP TABLE IF EXISTS `partidascfdi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partidascfdi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `codigoArticulo` varchar(45) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precioUnitario` decimal(10,2) DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `descripcion` varchar(90) DEFAULT NULL,
  `idVenta` bigint(20) DEFAULT NULL,
  `idFactura` bigint(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `partidas_prestamo`
--

DROP TABLE IF EXISTS `partidas_prestamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partidas_prestamo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idprestamo` bigint(20) DEFAULT NULL,
  `idusuario` bigint(20) DEFAULT NULL,
  `idcliente` bigint(20) DEFAULT NULL,
  `fechacobro` date DEFAULT NULL,
  `parcialidad` decimal(10,2) DEFAULT NULL,
  `abonado` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `prestamo` (`idprestamo`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `encuesta_clientes`
--

DROP TABLE IF EXISTS `encuesta_clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encuesta_clientes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `idcliente` bigint(20) DEFAULT NULL,
  `idpregunta` int(11) DEFAULT NULL,
  `respuesta` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cfdi`
--

DROP TABLE IF EXISTS `cfdi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cfdi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `folio` bigint(20) DEFAULT NULL,
  `emisor` varchar(45) DEFAULT NULL,
  `receptor` varchar(45) DEFAULT NULL,
  `total_facturado` decimal(10,2) DEFAULT NULL,
  `uuid` varchar(45) DEFAULT NULL,
  `cadena_original` text,
  `observaciones` text,
  `factura` blob,
  `addenda` blob,
  `estado_addenda` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT '0',
  `cancelacion` blob,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recordatorio`
--

DROP TABLE IF EXISTS `recordatorio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recordatorio` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `idcliente` bigint(20) DEFAULT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechaactual` date DEFAULT NULL,
  `fechafinal` date DEFAULT NULL,
  `lapso` int(11) DEFAULT NULL,
  `motivo` varchar(45) DEFAULT NULL,
  `monto` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `recurso` longtext,
  `sms` int(11) DEFAULT '0',
  `hora` int(11) DEFAULT '18',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` bigint(20) DEFAULT NULL,
  `correo` varchar(255) DEFAULT 'correo@dominio.com',
  `telefono` varchar(45) DEFAULT NULL,
  `nombrecompleto` text,
  `rfc` varchar(45) DEFAULT NULL,
  `codigoPostal` varchar(250) DEFAULT NULL,
  `pais` varchar(250) DEFAULT NULL,
  `estado` varchar(250) DEFAULT NULL,
  `colonia` varchar(250) DEFAULT NULL,
  `noInterior` varchar(250) DEFAULT NULL,
  `noExterior` varchar(250) DEFAULT NULL,
  `calle` varchar(250) DEFAULT NULL,
  `sms` int(11) DEFAULT '1',
  `mail` int(11) DEFAULT '1',
  `cuenta` varchar(45) DEFAULT 'NO APLICA',
  `ingresomensual` decimal(10,2) DEFAULT '1000.00',
  `limitecredito` decimal(10,2) DEFAULT '500.00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-26 19:25:56
