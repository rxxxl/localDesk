-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-12-2023 a las 23:54:04
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `localdesk`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `area` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `area`) VALUES
(1, 'OFICINAS'),
(2, 'PRODUCCION EPS'),
(3, 'PRINT EPS'),
(4, 'QC EPS'),
(5, 'QC PAPEL'),
(6, 'QC TERMO'),
(7, 'ALMACEN PT'),
(8, 'MANTENIMIENTO EPS'),
(9, 'MANTENIMIENTO TERMO'),
(10, 'MANTENIMIENTO PAPEL'),
(11, 'PRODUCCION TERMO'),
(12, 'PRODUCCION PAPEL'),
(13, 'IT'),
(14, 'TRUCK GARAGE'),
(15, 'CONTABILIDAD'),
(16, 'VENTAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `area` varchar(255) DEFAULT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `issue` text DEFAULT NULL,
  `desired_resolution_date` date DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `creation_time` time DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `assigned_technician` int(11) DEFAULT NULL,
  `resolution_date` date DEFAULT NULL,
  `resolution_time` time DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `solution` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `jobProfile` varchar(50) NOT NULL DEFAULT '',
  `area` int(11) NOT NULL DEFAULT 0,
  `rol` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `jobProfile`, `area`, `rol`) VALUES
(2, 'admin@admin', 'admin', '$2y$10$QTkZHiXkRQ3men4B/QYot./W5SsFYn3re2PMb7m8cfE97ogMNOJLe', '1', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_technician` (`assigned_technician`),
  ADD KEY `created_by` (`created_by`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area` (`area`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_areas` FOREIGN KEY (`area`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
