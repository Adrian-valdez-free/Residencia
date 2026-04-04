-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-03-2026 a las 03:23:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_control`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes`
--

CREATE TABLE `asistentes` (
  `asistentes` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistentes`
--

INSERT INTO `asistentes` (`asistentes`) VALUES
('E21081350'),
('E21081350'),
('E21081350'),
('E21081350');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_eventos` int(10) NOT NULL,
  `nombre_evento` varchar(50) NOT NULL,
  `nombre_ponente` varchar(30) NOT NULL,
  `horario` time(6) NOT NULL,
  `asistentes` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_eventos`, `nombre_evento`, `nombre_ponente`, `horario`, `asistentes`) VALUES
(1, 'Taller de php 1', 'Juan Carlos Estrada', '14:00:00.000000', 40),
(2, 'Python desde 0', 'Carlos', '11:30:00.000000', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `Nombre`) VALUES
(1, 'Administrador'),
(2, 'Alumno'),
(3, 'Organizador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_registros_eventos`
--

CREATE TABLE `tabla_registros_eventos` (
  `id_registro` int(10) NOT NULL,
  `id_evento` int(10) NOT NULL,
  `id_estudiante` int(10) NOT NULL,
  `asistencia` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabla_registros_eventos`
--

INSERT INTO `tabla_registros_eventos` (`id_registro`, `id_evento`, `id_estudiante`, `asistencia`) VALUES
(2, 1, 10, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `rol` int(15) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `carrera` varchar(30) DEFAULT NULL,
  `semestre` int(11) DEFAULT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `rol`, `matricula`, `carrera`, `semestre`, `correo`) VALUES
(1, 'JOSE ADRIAN VALDEZ GOMEZ', 2, 'C21080059', NULL, NULL, 'LC21080059@merida.tecnm.mx'),
(9, 'ENRIQUE CAMACHO PEREZ', 1, '', NULL, NULL, 'Enrique.cp@merida.tecnm.mx'),
(10, 'JOSUE JACOB CRUZ CHIM', 2, 'E21081350', NULL, NULL, 'LE21081350@merida.tecnm.mx');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD UNIQUE KEY `id_eventos` (`id_eventos`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tabla_registros_eventos`
--
ALTER TABLE `tabla_registros_eventos`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_id_eventos` (`id_evento`),
  ADD KEY `fk_id_estudintes` (`id_estudiante`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_users_rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_eventos` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tabla_registros_eventos`
--
ALTER TABLE `tabla_registros_eventos`
  MODIFY `id_registro` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tabla_registros_eventos`
--
ALTER TABLE `tabla_registros_eventos`
  ADD CONSTRAINT `fk_id_estudintes` FOREIGN KEY (`id_estudiante`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `fk_id_eventos` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_eventos`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
