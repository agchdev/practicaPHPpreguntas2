-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2024 a las 23:15:22
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
-- Base de datos: `practica2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `idPregunta` int(11) NOT NULL,
  `textPregunta` varchar(300) NOT NULL,
  `respuestaPregunta` varchar(300) NOT NULL,
  `numRespuestas` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`idPregunta`, `textPregunta`, `respuestaPregunta`, `numRespuestas`) VALUES
(1, '¿Qué tipo de animal es la ballena?', 'mamífero', 1),
(2, '¿Quién pintó “la última cena”?', 'Leonardo da Vinci', 1),
(3, '¿En qué país se encuentra la torre de Pisa?', 'Italia', 1),
(4, '¿Cuál es el cuadrado ? 64?	', '8', 1),
(5, '¿Cuántos segundos hay en un día?', '86400', 1),
(6, '¿Valor de cos 360°?', '1', 1),
(7, '¿En qué país y año se usó la primera bomba atómica?', 'Japón,1945', 2),
(8, '¿Dónde y cuando ganó España el mundial?', 'Sudáfrica,2010', 2),
(9, '¿Quienes son los favoritos de Erica?', 'Alejandro Aguayo,Juanca', 2),
(10, 'Nombra los colores primarios:', 'rojo,amarillo,azul', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` varchar(50) NOT NULL,
  `tmpInicio` timestamp NULL DEFAULT current_timestamp(),
  `tmpFinal` timestamp NULL DEFAULT NULL,
  `tmpTotal` timestamp NULL DEFAULT NULL,
  `arrayPreg` varchar(20) NOT NULL,
  `arrayAciertos` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `tmpInicio`, `tmpFinal`, `tmpTotal`, `arrayPreg`, `arrayAciertos`) VALUES
('', '2024-12-12 16:38:53', NULL, NULL, ',9,2,10,6,1', NULL),
('agch', '2024-12-12 16:30:32', NULL, NULL, ',4,8,6,1,9', NULL),
('agch.obj', '2024-12-12 16:31:35', NULL, NULL, ',5,4,3,9,8', NULL),
('agch.obj2', '2024-12-12 16:36:14', NULL, NULL, ',7,9,4,6,2', NULL),
('agch12', '2024-12-12 16:33:54', NULL, NULL, ',6,3,1,8,10', NULL),
('agch222222', '2024-12-12 16:43:53', NULL, NULL, ',5,10,7,2,1', NULL),
('agchobj on yt', '2024-12-12 16:33:16', NULL, NULL, ',9,10,1,4,5', NULL),
('agchobj22', '2024-12-12 16:37:44', NULL, NULL, ',6,3,4,10,2', NULL),
('asdfawdf', '2024-12-12 16:40:16', NULL, NULL, ',5,7,4,10,2', NULL),
('dw', '2024-12-12 16:34:29', NULL, NULL, ',9,7,4,3,5', NULL),
('dwdw', '2024-12-12 16:34:42', NULL, NULL, ',6,10,5,2,1', NULL),
('dwdwdwdwdasdfasdf', '2024-12-12 16:45:00', NULL, NULL, ',9,5,6,7,1', NULL),
('jijija', '2024-12-12 17:07:27', NULL, NULL, ',10,3,5,8,6', NULL),
('jijija2', '2024-12-12 17:08:39', NULL, NULL, ',9,6,8,2,1', NULL),
('perroflauta', '2024-12-12 16:45:33', NULL, NULL, ',4,7,9,2,6', NULL),
('perry', '2024-12-12 19:43:17', NULL, NULL, ',5,6,9,2,3', NULL),
('perry2', '2024-12-12 19:44:10', NULL, NULL, ',8,4,3,2,9', NULL),
('perry3', '2024-12-12 19:48:06', NULL, NULL, ',8,5,6,3,2', NULL),
('wdwd', '2024-12-12 16:38:04', NULL, NULL, ',5,4,3,10,7', NULL),
('wewe', '2024-12-12 16:39:47', NULL, NULL, ',7,3,10,4,8', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`idPregunta`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `idPregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
