-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2024 a las 10:22:48
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
  `tFinal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `tEmpieza`, `tFinal`) VALUES
(' fhmk m', '2024-12-13 07:48:51', '2024-12-13 07:48:51'),
('bhyn', '2024-12-13 08:50:09', '2024-12-13 08:50:09'),
('bnhgm5n', '2024-12-13 09:08:36', '2024-12-13 09:08:36'),
('brhyh', '2024-12-13 08:37:29', '2024-12-13 08:37:29'),
('brtb', '2024-12-13 08:31:18', '2024-12-13 08:31:18'),
('brytbh', '2024-12-13 09:04:55', '2024-12-13 09:04:55'),
('bthum5n', '2024-12-13 08:23:04', '2024-12-13 08:23:04'),
('byhtn', '2024-12-13 08:43:45', '2024-12-13 08:43:45'),
('cefvgs', '2024-12-13 07:39:34', '2024-12-13 07:39:34'),
('cefvgstr', '2024-12-13 08:45:41', '2024-12-13 08:45:41'),
('cewvc', '2024-12-13 08:51:10', '2024-12-13 08:51:10'),
('cferwg', '2024-12-13 08:22:20', '2024-12-13 08:22:20'),
('de43gf', '2024-12-13 08:58:42', '2024-12-13 08:58:42'),
('dewrfrew', '2024-12-13 08:59:58', '2024-12-13 08:59:58'),
('f5rg', '2024-12-13 08:40:22', '2024-12-13 08:40:22'),
('fd bg', '2024-12-13 09:12:45', '2024-12-13 09:12:45'),
('fjm', '2024-12-13 08:54:12', '2024-12-13 08:54:12'),
('fraegt', '2024-12-13 07:23:42', '2024-12-13 07:23:42'),
('fraegtbtr', '2024-12-13 09:12:57', '2024-12-13 09:12:57'),
('fraegtg', '2024-12-13 08:47:08', '2024-12-13 08:47:08'),
('fraegttf', '2024-12-13 09:13:05', '2024-12-13 09:13:05'),
('freg', '2024-12-13 08:58:21', '2024-12-13 08:58:21'),
('frew4gf', '2024-12-13 09:01:34', '2024-12-13 09:01:34'),
('GFSN', '2024-12-13 08:34:57', '2024-12-13 08:34:57'),
('gtrb', '2024-12-13 08:01:05', '2024-12-13 08:01:05'),
('holaaaa', '2024-12-12 11:27:53', '2024-12-12 11:27:53'),
('ik8y7o', '2024-12-13 07:19:13', '2024-12-13 07:19:13'),
('ik8y7ofrt', '2024-12-13 09:14:44', '2024-12-13 09:14:44'),
('je67kj', '2024-12-13 08:57:45', '2024-12-13 08:57:45'),
('jiy,h', '2024-12-13 08:57:00', '2024-12-13 08:57:00'),
('juyj', '2024-12-13 08:45:26', '2024-12-13 08:45:26'),
('mjhm', '2024-12-13 08:13:24', '2024-12-13 08:13:24'),
('myum', '2024-12-13 08:29:45', '2024-12-13 08:29:45'),
('nbhdn', '2024-12-13 08:20:10', '2024-12-13 08:20:10'),
('ndhgmn', '2024-12-13 09:07:11', '2024-12-13 09:07:11'),
('ndtyn', '2024-12-13 08:39:02', '2024-12-13 08:39:02'),
('njyrum', '2024-12-13 08:36:30', '2024-12-13 08:36:30'),
('ntuyn', '2024-12-13 08:55:04', '2024-12-13 08:55:04'),
('nury', '2024-12-13 08:39:37', '2024-12-13 08:39:37'),
('nuym', '2024-12-13 08:19:12', '2024-12-13 08:19:12'),
('nytmj', '2024-12-13 09:13:38', '2024-12-13 09:13:38'),
('Pacho', '2024-12-13 07:48:29', '2024-12-13 07:48:29'),
('pppp', '2024-12-13 07:33:37', '2024-12-13 07:33:37'),
('rawefgare', '2024-12-13 09:01:03', '2024-12-13 09:01:03'),
('uyk', '2024-12-13 09:12:20', '2024-12-13 09:12:20'),
('vfdtbv', '2024-12-13 08:13:44', '2024-12-13 08:13:44'),
('vraegv', '2024-12-13 08:00:31', '2024-12-13 08:00:31'),
('vstbv', '2024-12-13 08:38:53', '2024-12-13 08:38:53'),
('wtrh', '2024-12-13 08:42:01', '2024-12-13 08:42:01'),
('ygfewgfy', '2024-12-13 07:25:51', '2024-12-13 07:25:51'),
('ygfewgfyg', '2024-12-13 07:41:09', '2024-12-13 07:41:09'),
('ygfewgfygf', '2024-12-13 09:17:40', '2024-12-13 09:17:40'),
('ygfewgfygfsdfe', '2024-12-13 09:20:16', '2024-12-13 09:20:16'),
('ygfewgfyght', '2024-12-13 09:19:18', '2024-12-13 09:19:18'),
('yui,m', '2024-12-13 08:34:32', '2024-12-13 08:34:32');

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
