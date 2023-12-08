-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2023 a las 23:46:43
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
-- Estructura de tabla para la tabla `job_profiles`
--

CREATE TABLE `job_profiles` (
  `id` int(11) NOT NULL,
  `job_profile` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `job_profiles`
--

INSERT INTO `job_profiles` (`id`, `job_profile`) VALUES
(1, 'Supervisor de IT'),
(2, 'Gerente de Produccion EPS'),
(3, 'Supervisor de Produccion Print EPS'),
(4, 'Gerente de Calidad EPS'),
(5, 'Gerente de Mantenimiento EPS'),
(6, 'Gerente de Recursos Humanos EPS'),
(7, 'Gerente de Almacen EPS'),
(8, 'Lider de Almacen de Refacciones EPS'),
(9, 'Supervisor de PICAPS y Electronica EPS'),
(10, 'Lider de Excelencia Operativa EPS'),
(11, 'Auxiliar IT'),
(12, 'Jefa de Produccion EPS'),
(13, 'Supervisor de Turno de Produccion EPS'),
(14, 'Supervisor de Termoformado'),
(15, 'Lider de Calidad de Termoformado'),
(16, 'Supervisor de Producción de Vaso de Papel'),
(17, 'Lider de Calidad de Vaso de Papel'),
(18, 'Gerente de Produccion de Vaso de Papel '),
(19, 'Gerente de Planta EPS'),
(20, 'Lider de Mantenimiento de Termoformado'),
(21, 'Lider de Mantenimiento de Vaso de Papel'),
(22, 'Lider de Turno de Mantenimiento de Vaso de Papel'),
(23, 'Operador de cortadora de fondo de Vaso de Papel'),
(24, 'Operador de Blanket de Vaso de Papel'),
(25, 'Lider de COMEXI de Vaso de Papel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `rol`) VALUES
(1, 'administrator'),
(2, 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `area` int(11) DEFAULT NULL,
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
  `rating` int(11) DEFAULT NULL,
  `photo_route` varchar(255) DEFAULT NULL
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
  `jobProfile` int(11) NOT NULL DEFAULT 0,
  `area` int(11) NOT NULL DEFAULT 0,
  `rol` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `password`, `jobProfile`, `area`, `rol`, `token`) VALUES
(2, 'diego.dominguez@dart.biz', 'admin', '$2y$10$hKhryTw9rChn7dl2RN6HPefht8DRg6Y4bftmv82JbwxhJSBVEG7IK', 1, 1, 1, NULL),
(3, 'joaqui.lovera@dart.biz', 'Joaquin Lovera Mejia', '$2y$10$ZuG0D9O3Zw291jkQDU0VQuF7pvI60B4fttOlb.w.jg6K2E8MahwQ6', 11, 1, 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `job_profiles`
--
ALTER TABLE `job_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_technician` (`assigned_technician`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `area` (`area`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area` (`area`),
  ADD KEY `jobProfile` (`jobProfile`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `job_profiles`
--
ALTER TABLE `job_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `FK_tickets_areas` FOREIGN KEY (`area`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_areas` FOREIGN KEY (`area`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_job_profiles` FOREIGN KEY (`jobProfile`) REFERENCES `job_profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_roles` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
