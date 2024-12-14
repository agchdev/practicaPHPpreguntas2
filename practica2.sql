-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2024 a las 19:39:19
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
  `tmpTotal` int(3) DEFAULT NULL,
  `arrayPreg` varchar(20) NOT NULL,
  `arrayAciertos` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `tmpInicio`, `tmpFinal`, `tmpTotal`, `arrayPreg`, `arrayAciertos`) VALUES
('agch', '2024-12-14 17:35:02', '2024-12-14 18:13:40', 2318, '', NULL),
('andres', '2024-12-14 18:14:06', '2024-12-14 18:37:58', 1432, '', NULL);

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
