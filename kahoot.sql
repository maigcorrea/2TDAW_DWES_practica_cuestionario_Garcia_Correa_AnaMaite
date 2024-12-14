-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2024 a las 23:51:00
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
-- Base de datos: `kahoot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `cod` int(11) NOT NULL,
  `enunciado` varchar(200) NOT NULL,
  `respuesta` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`cod`, `enunciado`, `respuesta`) VALUES
(1, '¿De qué color es el caballo blanco de Santiago?', 'Blanco'),
(2, '¿Cuántos minutos tiene una hora?', '60'),
(3, '¿Qué lenguajes damos en la escuela?', 'Java,PHP'),
(4, '¿Qué país tiene forma de bota en Europa?', 'Italia'),
(5, '¿En qué país está la Torre Eiffel?', 'Francia'),
(6, '¿Qué animal es famoso por dormir durante el invierno?', 'Oso'),
(7, '¿Qué animal se dice que es el mejor amigo del ser humano?', 'Perro'),
(8, '¿Qué animal es famoso por su capacidad de cambiar de color?', 'Camaleón'),
(9, '¿Qué animal se conoce como el rey de la selva?', 'León'),
(10, '¿Qué animales viven en el agua?', 'Delfín, Tiburón'),
(11, '¿Cuántas horas tiene un día?', '24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre` varchar(200) NOT NULL,
  `tEmpieza` timestamp NOT NULL DEFAULT current_timestamp(),
  `tFinal` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `tEmpieza`, `tFinal`) VALUES
('Ana', '2024-12-14 22:33:01', '2024-12-14 22:33:15'),
('Eustaquio', '2024-12-14 22:34:16', '2024-12-14 22:34:30'),
('Maite', '2024-12-14 22:32:20', '2024-12-14 22:32:37'),
('Rogelio', '2024-12-14 22:33:26', '2024-12-14 22:33:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
