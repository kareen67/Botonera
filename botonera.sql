-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2025 a las 14:57:13
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

--
-- Volcado de datos para la tabla `fx`
--

INSERT INTO `fx` (`id_fx`, `ruta_archivo`, `clasificacion_fx`, `nombre`, `id_programa`, `id_usuario`) VALUES
(3, 'uploads/fx/pedoo-2.mp3', 'a', 'a', NULL, 8),
(4, 'uploads/fx/anime-wow-sound-effect.mp3', 'waw', 'waw', NULL, 8);

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

--
-- Volcado de datos para la tabla `programa_radial`
--

INSERT INTO `programa_radial` (`id_programa`, `nombre`, `horario`, `descripcion`) VALUES
(1, 'nose algo', '12:00 - 11:00', 'prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('productor','operador','jefe') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `password`, `rol`) VALUES
(6, 'antu nahuel', 'antunahuel@gmail.com', '$2y$10$7W7fWjmOc5XYY/ssmUhHXecmVJRrob0hx6rLhz8LppuQOOd/iiU3a', 'jefe'),
(7, 'antu paladea', 'antupaladea@gmail.com', '$2y$10$HeRmgiBb7bqV/uo3ukLCS.uOivoLsOAI31NXKwzZk37u7ke9vIwm2', 'productor'),
(8, 'antu torres', 'antutorres@gmail.com', '$2y$10$OaefLqI9.bVMmb1uht8Fgup0OyA6qaKwOZdhd8gtXbOwSgl542ZYS', 'operador');

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
  MODIFY `id_fx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
