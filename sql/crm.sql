-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-11-2024 a las 09:48:00
-- Versión del servidor: 5.7.11
-- Versión de PHP: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `crm`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crm_asignaciones`
--

CREATE TABLE IF NOT EXISTS `crm_asignaciones` (
`id` int(11) NOT NULL,
  `id_incidencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `crm_asignaciones`
--

INSERT INTO `crm_asignaciones` (`id`, `id_incidencia`, `id_usuario`) VALUES
(3, 2, 1),
(4, 3, 2),
(6, 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crm_incidencias`
--

CREATE TABLE IF NOT EXISTS `crm_incidencias` (
`id` int(11) NOT NULL,
  `titulo` text CHARACTER SET utf8 NOT NULL,
  `Descripcion` text CHARACTER SET utf8 NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `crm_incidencias`
--

INSERT INTO `crm_incidencias` (`id`, `titulo`, `Descripcion`, `Estado`) VALUES
(2, 'Hola', 'Test', 2),
(3, 'Incidencia Manolo', 'Descripcion Manolo', 1),
(6, 'Prueba Creacion', 'Prueba de Creacion de Incidencias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crm_users`
--

CREATE TABLE IF NOT EXISTS `crm_users` (
`id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `email` text CHARACTER SET utf8 NOT NULL,
  `password` text CHARACTER SET utf8 NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `crm_users`
--

INSERT INTO `crm_users` (`id`, `name`, `email`, `password`, `rol`) VALUES
(1, 'Paco Fiestas', 'Paquito098@gmail.com', '.abc123.', 1),
(2, 'Manolo Manises', 'Manolo@gmail.com', '.abc123.', 1),
(3, 'Administrador Chachi', 'Admin@gmail.com', '.abc123.', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `crm_asignaciones`
--
ALTER TABLE `crm_asignaciones`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `crm_incidencias`
--
ALTER TABLE `crm_incidencias`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `crm_users`
--
ALTER TABLE `crm_users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `crm_asignaciones`
--
ALTER TABLE `crm_asignaciones`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `crm_incidencias`
--
ALTER TABLE `crm_incidencias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `crm_users`
--
ALTER TABLE `crm_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
