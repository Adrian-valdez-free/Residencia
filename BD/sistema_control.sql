-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 00:16:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id_carrera` int(2) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `nombre_evento` varchar(40) DEFAULT NULL,
  `ponente` varchar(30) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `hora_inicio` timestamp NULL DEFAULT NULL,
  `hora_finalizar` timestamp NULL DEFAULT NULL,
  `capacidad_e` int(3) DEFAULT NULL,
  `recintos_id` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `nombre_evento`, `ponente`, `descripcion`, `hora_inicio`, `hora_finalizar`, `capacidad_e`, `recintos_id`) VALUES
(4, 'dawdawdawd', 'adawdawd', 'adwadwadwdw', '2026-03-12 23:08:00', '2026-04-02 23:08:00', 1232, 1),
(5, 'Resident evil 4', 'Carlos trejo', 'Cinnamon roll', '2026-03-26 18:00:00', '2026-03-26 19:00:00', 120, NULL),
(6, 'Convencion de fedelobos', 'Fedelobo', 'Hay muchos fedelobos', '2026-03-26 17:57:00', '2026-03-26 17:59:00', 212, NULL),
(8, 'dasdasdsad', 'dawdwadwadwa', 'dawdwadwad', '2026-03-26 20:21:00', '2026-03-26 21:16:00', 123123, NULL),
(9, 'Como sobrevivir al tec', 'adawdawd', 'Ver como meten una nueva', '2026-04-03 19:45:00', '2026-04-04 19:45:00', 121, NULL),
(10, 'Reunion de CTA', 'Manuel de la fuente', 'dasdw', '2026-04-06 21:55:00', '2026-04-07 21:55:00', 4, 1),
(11, 'ETES', 'ascascas', 'dsadasdwdaw', '2026-04-06 22:12:00', '2026-04-07 22:12:00', 1, 1),
(12, 'ETES', 'ascascas', 'sasasa', '2026-04-06 22:13:00', '2026-04-07 22:13:00', 1, 1),
(13, 'dawdwa', 'dadsdasd', 'dawdawdawdaw', '2026-04-06 22:19:00', '2026-04-07 22:19:00', 10, 1),
(14, 'E3', 'Alfonso obregon', 'sdasdad', '2026-04-06 23:07:00', '2026-04-07 23:07:00', 30, 4),
(15, 'El chavo club edition', 'Victoria regia', 'dsd', '2026-04-06 23:07:00', '2026-04-07 23:07:00', 20, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recinto`
--

CREATE TABLE `recinto` (
  `id_recinto` int(3) NOT NULL,
  `nombre_recinto` varchar(40) NOT NULL,
  `capacidad` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recinto`
--

INSERT INTO `recinto` (`id_recinto`, `nombre_recinto`, `capacidad`) VALUES
(1, 'Auditorio Lic. Miguel Peon Toledo', 150),
(4, 'H1', 30),
(5, 'H2', 30),
(6, 'H8', 30);

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
  `id_registro` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `asistencia` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabla_registros_eventos`
--

INSERT INTO `tabla_registros_eventos` (`id_registro`, `id_estudiante`, `id_evento`, `fecha_registro`, `asistencia`) VALUES
(3, 9, 8, '2026-04-03 16:22:58', 0),
(4, 66, 4, '2026-04-03 20:55:07', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `rol` int(15) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `semestre` int(11) DEFAULT NULL,
  `correo` varchar(50) NOT NULL,
  `carrera` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `rol`, `matricula`, `semestre`, `correo`, `carrera`) VALUES
(1, 'JOSE ADRIAN VALDEZ GOMEZ', 1, 'C21080059', NULL, 'LC21080059@merida.tecnm.mx', 0),
(9, 'ENRIQUE CAMACHO PEREZ', 1, '', NULL, 'Enrique.cp@merida.tecnm.mx', 0),
(66, 'JOSE ADRIAN VALDEZ GOMEZ', 2, 'E21080059', NULL, 'LE21080059@merida.tecnm.mx', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `recintos_id` (`recintos_id`);

--
-- Indices de la tabla `recinto`
--
ALTER TABLE `recinto`
  ADD PRIMARY KEY (`id_recinto`);

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
  ADD UNIQUE KEY `inscripcion_unica` (`id_estudiante`,`id_evento`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_users_rol` (`rol`),
  ADD KEY `carrera` (`carrera`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id_carrera` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `recinto`
--
ALTER TABLE `recinto`
  MODIFY `id_recinto` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tabla_registros_eventos`
--
ALTER TABLE `tabla_registros_eventos`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `carreras_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `users` (`carrera`);

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`recintos_id`) REFERENCES `recinto` (`id_recinto`);

--
-- Filtros para la tabla `tabla_registros_eventos`
--
ALTER TABLE `tabla_registros_eventos`
  ADD CONSTRAINT `tabla_registros_eventos_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `tabla_registros_eventos_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
