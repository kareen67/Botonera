-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2025 a las 02:21:51
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
-- Base de datos: `botonera`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fx`
--

CREATE TABLE `fx` (
  `id_fx` int(11) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL,
  `clasificacion_fx` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_programa` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador_programa`
--

CREATE TABLE `operador_programa` (
  `id_operadorprog` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `fecha_asignacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productor_programa`
--

CREATE TABLE `productor_programa` (
  `id_productorprog` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa_radial`
--

CREATE TABLE `programa_radial` (
  `id_programa` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('productor','operador','jefeOp') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `password`, `rol`) VALUES
(2, 'antu', 'antu@gmail.com', '$2y$10$dcxfIQTybTyjov6kk9jTTuFh3crLtBa8cb/c0fxxgAtUs3.n.3KnG', 'operador'),
(3, 'antu2', 'antu2@gmail.com', '$2y$10$TwtEWfkgbWGgTGt9ZowVeO6uK73FDHYZunjNTV2kaTZWN27GTBvxq', 'productor'),
(5, 'antu3', 'antu3@gmail.com', '$2y$10$g04UNYECRQi74b8RyVgQZ.WymHq8FCMYEU51YeiCnRerZByCMC7sy', 'jefeOp');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `fx`
--
ALTER TABLE `fx`
  ADD PRIMARY KEY (`id_fx`),
  ADD KEY `id_programa` (`id_programa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `operador_programa`
--
ALTER TABLE `operador_programa`
  ADD PRIMARY KEY (`id_operadorprog`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_programa` (`id_programa`);

--
-- Indices de la tabla `productor_programa`
--
ALTER TABLE `productor_programa`
  ADD PRIMARY KEY (`id_productorprog`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_programa` (`id_programa`);

--
-- Indices de la tabla `programa_radial`
--
ALTER TABLE `programa_radial`
  ADD PRIMARY KEY (`id_programa`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fx`
--
ALTER TABLE `fx`
  MODIFY `id_fx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operador_programa`
--
ALTER TABLE `operador_programa`
  MODIFY `id_operadorprog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productor_programa`
--
ALTER TABLE `productor_programa`
  MODIFY `id_productorprog` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programa_radial`
--
ALTER TABLE `programa_radial`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fx`
--
ALTER TABLE `fx`
  ADD CONSTRAINT `fx_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programa_radial` (`id_programa`) ON DELETE SET NULL,
  ADD CONSTRAINT `fx_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL;

--
-- Filtros para la tabla `operador_programa`
--
ALTER TABLE `operador_programa`
  ADD CONSTRAINT `operador_programa_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `operador_programa_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa_radial` (`id_programa`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productor_programa`
--
ALTER TABLE `productor_programa`
  ADD CONSTRAINT `productor_programa_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `productor_programa_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa_radial` (`id_programa`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
