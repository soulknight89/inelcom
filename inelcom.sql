-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 09-03-2018 a las 19:34:44
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inelcom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_temp`
--

DROP TABLE IF EXISTS `codigo_temp`;
CREATE TABLE IF NOT EXISTS `codigo_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actual` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `codigo_temp`
--

INSERT INTO `codigo_temp` (`id`, `actual`) VALUES
(1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapa`
--

DROP TABLE IF EXISTS `etapa`;
CREATE TABLE IF NOT EXISTS `etapa` (
  `idEtapa` int(11) NOT NULL AUTO_INCREMENT,
  `nombreEtapa` varchar(100) NOT NULL,
  PRIMARY KEY (`idEtapa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `etapa`
--

INSERT INTO `etapa` (`idEtapa`, `nombreEtapa`) VALUES
(1, 'Oferta'),
(2, 'Adjudicado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exito`
--

DROP TABLE IF EXISTS `exito`;
CREATE TABLE IF NOT EXISTS `exito` (
  `idExito` int(11) NOT NULL AUTO_INCREMENT,
  `nombreExito` varchar(20) NOT NULL,
  PRIMARY KEY (`idExito`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `exito`
--

INSERT INTO `exito` (`idExito`, `nombreExito`) VALUES
(1, 'baja'),
(2, 'media'),
(3, 'alta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfil` int(2) NOT NULL,
  `menu` json NOT NULL COMMENT 'Atributos guardados en json',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

DROP TABLE IF EXISTS `perfil`;
CREATE TABLE IF NOT EXISTS `perfil` (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idPerfil`, `nombre`, `descripcion`) VALUES
(1, 'administrador', 'Administrador del sistema'),
(2, 'preventa', 'Usuario que genera cotizaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
CREATE TABLE IF NOT EXISTS `proyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `codigo` varchar(13) NOT NULL COMMENT 'Formato: 18010300004S',
  `rubro` int(2) NOT NULL,
  `proyecto` varchar(300) NOT NULL,
  `version` varchar(4) NOT NULL DEFAULT 'v1',
  `status` int(2) NOT NULL DEFAULT '1',
  `actualizacion` date NOT NULL,
  `alcance` text NOT NULL,
  `ofertante_alternativo` varchar(150) NOT NULL,
  `cantidad_recursos` varchar(150) DEFAULT NULL,
  `fact_mensual` double DEFAULT NULL,
  `duracion_meses` int(2) DEFAULT NULL,
  `valor_total_adjudicado` double DEFAULT NULL,
  `valor_ofertado` double DEFAULT NULL,
  `valor_estimado` double DEFAULT NULL,
  `contacto_tdp` varchar(150) NOT NULL,
  `cargo_tdp` varchar(150) NOT NULL,
  `probabilidad_exito` varchar(20) NOT NULL,
  `orden_compra` varchar(50) DEFAULT NULL,
  `fecha_oc` date DEFAULT NULL,
  `inicio_servicio` date DEFAULT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `usuario_registra` int(11) NOT NULL,
  `fecha_registra` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Registro de proyectos/ofertas';

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`id`, `fecha`, `codigo`, `rubro`, `proyecto`, `version`, `status`, `actualizacion`, `alcance`, `ofertante_alternativo`, `cantidad_recursos`, `fact_mensual`, `duracion_meses`, `valor_total_adjudicado`, `valor_ofertado`, `valor_estimado`, `contacto_tdp`, `cargo_tdp`, `probabilidad_exito`, `orden_compra`, `fecha_oc`, `inicio_servicio`, `motivo`, `usuario_registra`, `fecha_registra`) VALUES
(1, '2018-03-08', '080318_0001S', 1, 'Propuesta_Especialista_Min. Vivienda', 'v1', 1, '2018-03-08', 'Propuesta_Especialista_Min. Vivienda', 'Ninguno', NULL, NULL, NULL, NULL, NULL, NULL, 'Alexis Guerrero', 'JP', '3', NULL, NULL, NULL, NULL, 1, '2018-03-09 04:44:30'),
(2, '2018-03-08', '080318_0002S', 1, 'Propuesta_Especialista_Min. Vivienda 2', 'v1', 1, '2018-03-08', 'Propuesta_Especialista_Min. Vivienda', 'Ninguno', NULL, NULL, NULL, NULL, NULL, NULL, 'Alexis Guerrero', 'JP', '3', NULL, NULL, NULL, NULL, 1, '2018-03-09 04:44:53'),
(3, '2018-03-08', '080318_0003T', 3, 'Propuesta Servicio de TSOFT', 'v1', 1, '2018-03-08', 'Pruebas de estrés para un servidor. Tiempo aprox. 2 semanas', 'Ninguno', NULL, NULL, NULL, NULL, NULL, NULL, 'Sheyla Hinostroza', 'JP', '1', NULL, NULL, NULL, NULL, 1, '2018-03-09 04:49:38'),
(4, '2018-03-07', '070318_0004S', 1, 'Ingeniero de Proyecto APM Terminals', 'v1', 1, '2018-03-08', 'Ingeniero de Proyecto APM Terminals', 'Ninguno', NULL, NULL, NULL, NULL, NULL, NULL, 'Fredy Tasayco', 'Preventa Tgestiona', '2', NULL, NULL, NULL, NULL, 1, '2018-03-09 04:54:43'),
(5, '2018-03-07', '070318_0005C', 2, 'Proyecto de Prueba', 'v1', 2, '2018-03-09', 'Prueba 99', 'Ninguno', NULL, NULL, NULL, NULL, NULL, NULL, 'Carlos Paz', 'Jefe Red', '1', NULL, NULL, NULL, NULL, 5, '2018-03-09 05:20:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubro`
--

DROP TABLE IF EXISTS `rubro`;
CREATE TABLE IF NOT EXISTS `rubro` (
  `idRubro` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRubro` varchar(100) NOT NULL,
  PRIMARY KEY (`idRubro`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rubro`
--

INSERT INTO `rubro` (`idRubro`, `nombreRubro`) VALUES
(1, 'SERPRO'),
(2, 'CONEIM'),
(3, 'TRANSFECO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `idStatus` int(11) NOT NULL AUTO_INCREMENT,
  `nombreStatus` varchar(50) NOT NULL,
  `idEtapa` int(2) NOT NULL,
  PRIMARY KEY (`idStatus`),
  KEY `idEtapa` (`idEtapa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`idStatus`, `nombreStatus`, `idEtapa`) VALUES
(1, 'No Iniciado', 1),
(2, 'En Elaboracion', 1),
(3, 'Entregado', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `apellido` varchar(120) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clave` varchar(150) NOT NULL,
  `idPerfil` int(2) NOT NULL,
  `documento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `usuario_documento_uindex` (`documento`),
  KEY `fk_usuario_perfil_idx` (`idPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `correo`, `usuario`, `clave`, `idPerfil`, `documento`) VALUES
(1, 'Admin', 'INELCOM', 'admin@inelcom.com', 'administrador', '$2a$10$YlYPkVaTDShVzwIvDzNLz.h8.vTLPA0vWZgVNJ/QVw0h0/QTrljr2', 1, '123456'),
(2, 'Erick', 'Miranda', 'emiranda@hotmail.com', 'emiranda', '$2a$10$4Rb8ibDGh6J.6qaaAkxc5.nU0t4huAOHtVfbBgJWC5rhlMa3yV6lW', 1, '654321'),
(5, 'Daniel', 'Ascarza', 'dascarza@gmail.com', 'preventa', '$2a$10$SLDok2NcunooPbAo8IbL0OjlUOft/Eg2kZ.iOKy2S8ntleHhXdjfO', 2, '999999');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `fk_status_etapa` FOREIGN KEY (`idEtapa`) REFERENCES `etapa` (`idEtapa`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
