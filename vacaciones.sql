-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-05-2025 a las 07:08:01
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
-- Base de datos: `vacaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `numero_reloj` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `motivo` text DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'pendiente',
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `numero_reloj`, `fecha_inicio`, `fecha_fin`, `motivo`, `estado`, `fecha_solicitud`) VALUES
(6, 1018, '0000-00-00', '0000-00-00', 'g', 'Aprobada', '2025-05-14 05:38:12'),
(10, 1018, '2025-05-13', '2025-05-16', 'prueba', 'pendiente', '2025-05-15 23:53:02'),
(11, 1037, '2025-05-14', '2025-05-16', '', 'pendiente', '2025-05-16 00:54:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `turno` int(1) DEFAULT NULL,
  `numero_reloj` int(6) DEFAULT NULL,
  `tipo_usuario` varchar(11) NOT NULL DEFAULT 'user',
  `nombre` varchar(60) DEFAULT NULL,
  `fecha_ingreso` varchar(10) DEFAULT NULL,
  `antigüedad` int(2) DEFAULT NULL,
  `puesto` varchar(36) DEFAULT NULL,
  `area` varchar(30) DEFAULT NULL,
  `aprobador` varchar(60) NOT NULL,
  `fecha_nacimiento` varchar(8) DEFAULT NULL,
  `edad` varchar(2) DEFAULT NULL,
  `numero_telefono` varchar(10) DEFAULT NULL,
  `dias_vacaciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `turno`, `numero_reloj`, `tipo_usuario`, `nombre`, `fecha_ingreso`, `antigüedad`, `puesto`, `area`, `aprobador`, `fecha_nacimiento`, `edad`, `numero_telefono`, `dias_vacaciones`) VALUES
(1, 1, 1234, 'user', 'GONZALES GARCIA LUIS', '2/9/2010', 14, 'Entrenador de Extrusores', 'Producción', 'Antonio Garza', '23-09-65', '59', '1111111111', 15),
(2, 1, 5678, 'admin', 'GARZA AGUAPRIETA MARIO ANTONIO', '2/9/2000', 24, 'Gerente de Mantenimiento', 'Mantenimiento', 'Antonio Garza', '23-09-65', '59', '1111111111', 20);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
