-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-03-2020 a las 22:06:42
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lumeni_bd_seleccion_imagenes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL,
  `Likes` int(11) NOT NULL DEFAULT 0,
  `EA` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `TI` varchar(100) NOT NULL,
  `Dislikes` int(11) NOT NULL DEFAULT 0,
  `tittle` varchar(200) NOT NULL,
  `tags` varchar(200) NOT NULL,
  `video_PA_category` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`id_item`, `Likes`, `EA`, `descripcion`, `TI`, `Dislikes`, `tittle`, `tags`, `video_PA_category`, `url`) VALUES
(13, 0, 'EA7', ' suma de operaciones homogeneas ', 'TI6,TI5,TI2', 0, 'Suma de operaciones homogeneas', ' homogeneas', 'sumas', 'https://www.youtube.com/embed/r61eNEp8eB4'),
(14, 0, 'EA7', ' suma heterogenea   ', 'TI6,TI5,TI2', 0, 'suma de fracciones heterogeneas', 'heterogenea', 'suma', 'https://www.youtube.com/embed/BQo8VZ8NVMs'),
(15, 0, 'EA6', ' resta homogenea ', 'TI1,TI5,TI6', 0, 'resta de fracciones homogeneas', 'resta homogenea', 'resta', 'https://www.youtube.com/embed/dTrYam7pL7E'),
(16, 0, 'EA6', ' resta heterogenea ', 'TI1,TI5,TI6', 0, 'resta de fracciones heterogeneas', 'resta heterogenea', 'resta', 'https://www.youtube.com/embed/acdHVJ67WKw'),
(17, 0, 'EA5', ' multiplicación de fracciones ', 'TI1,TI3,TI5,TI6', 0, 'Multiplicación de Fracciones', 'multiplicación', 'multiplicación', 'https://www.youtube.com/embed/uxGeSS9cWCo'),
(18, 0, 'EA1', ' divisores de un numero ', 'TI1,TI2,TI3,TI4,TI5,TI6', 0, 'divisores de un numero', 'divisores', 'divisores', 'https://www.youtube.com/embed/uxGeSS9cWCo'),
(19, 0, 'EA6', 'Reduccion de Fracciones ', 'TI1,TI5,TI6', 0, 'Reduccion de Fracciones', 'Fracciones ', 'Fracciones ', 'https://www.youtube.com/embed/sZ9V7hGTajk'),
(21, 0, 'EA6', ' Lectura de fracciones', 'TI1,TI5,TI6', 0, 'Lectura de fracciones', 'fracciones', 'Fracciones', 'https://www.youtube.com/embed/dskJ5IuGBp8'),
(22, 0, 'EA6', 'Fracciones unitarias ', 'TI1,TI5,TI6', 0, 'Fracciones Unitarias', 'fracciones ', 'Fracciones', 'https://www.youtube.com/embed/pF6pHO68Nyw'),
(23, 0, 'EA6', ' Fracciones Propias ', 'TI1,TI5,TI6', 0, 'Fracciones Propias', 'Fracciones', 'Fracciones', 'https://www.youtube.com/embed/A8ctgnv5lKc'),
(24, 0, 'EA6', 'Fracciones Mixtas  ', 'TI1,TI5,TI6', 0, 'Fracciones Mixtas ', 'Fracciones', 'Fracciones', 'https://www.youtube.com/embed/kGB-7JQJtH4'),
(25, 0, 'EA5', ' Fracciones Impropias', 'TI1,TI3,TI5,TI6', 0, 'Fracciones Impropias', 'Fracciones, Impropias', 'Fracciones', 'https://www.youtube.com/embed/iLxEOh0j8xg'),
(26, 0, 'EA5', ' Multiplos de un Numero', 'TI1,TI3,TI5,TI6', 0, 'Multiplos de un Numero', 'Multiplos, Numero', 'Multiplos', 'https://www.youtube.com/embed/MT9aPRmgTjA'),
(27, 0, 'EA5', 'Numero primos y compuestos ', 'TI1,TI3,TI5,TI6', 0, 'Numero primos y compuestos', 'Primos, compuestos', 'Compuestos', 'https://www.youtube.com/embed/2n0IRK0wOKc'),
(28, 0, 'EA5', 'Números Naturales ', 'TI1,TI3,TI5,TI6', 0, 'Numeros Naturales', 'Números, Naturales', 'Naturales', 'https://www.youtube.com/embed/7YnMrpGoHlc'),
(29, 0, 'EA5', ' Criterio Divisibilidad ', 'TI1,TI3,TI5,TI6', 0, 'Criterio Divisibilidad 7 10', 'Criterio, Divisibilidad', 'Divisibilidad', 'https://www.youtube.com/embed/DO96d7jZJeg'),
(30, 0, 'EA5', 'Criterio Divisibilidad ', 'TI1,TI3,TI5,TI6', 0, 'Criterio Divisibilidad 1 6', 'Divisibilidad', 'Divisibilidad', 'https://www.youtube.com/embed/1XBLCxokf5k'),
(31, 0, 'EA4', ' sistema de numeracion', 'TI3,TI5,TI6', 0, 'sistema de numeracion', 'numeracion', 'numeracion', 'https://www.youtube.com/embed/ol78PGvRay8'),
(32, 0, 'EA1', ' dinamica de numeros', 'TI1,TI2,TI3,TI4,TI5,TI6', 0, 'dinamica de los numeros', 'numeros', 'numeros', 'https://www.youtube.com/embed/vNDAIj16-xI'),
(33, 0, 'EA8', ' como descomponer un numero paso, a paso', 'TI1,TI2,TI3,TI6', 0, 'descomposición de números', 'descomposición', 'descomposición', 'https://www.youtube.com/embed/lQWDcPzRmPM'),
(34, 0, 'EA3', ' los números decimales, canción', 'TI1,TI2,TI3,TI5,TI6', 0, 'números decimales', 'decimales', 'decimales', 'https://www.youtube.com/embed/05PHoT3R_Hc'),
(35, 0, 'EA3', ' como saber e identificar los números decimales\r\n ', 'TI1,TI2,TI3,TI5,TI6', 0, 'números decimales', 'decimales', 'decimales', 'https://www.youtube.com/embed/wkVzA9TOisw'),
(36, 0, 'EA4', ' como conocer los números decimales', 'TI3,TI5,TI6', 0, 'números decimales', 'decimales', 'decimales', 'https://www.youtube.com/embed/OYjW1gV8SJU'),
(37, 0, 'EA5', ' como sumar, restar, multiplicar y dividir con fracciones', 'TI1,TI3,TI5,TI6', 0, 'operaciones con fracciones', 'fracciones', 'Fracciones', 'https://www.youtube.com/embed/LgMptyzudXU'),
(38, 0, 'EA1', ' Operaciones con fracciones', 'TI1,TI2,TI3,TI4,TI5,TI6', 0, 'Fracciones', 'fracciones', 'Fracciones', 'https://www.youtube.com/embed/IvYK2UaFrAU'),
(39, 0, 'EA2', ' como sumar y restar fracciones', 'TI1,TI4,TI6', 0, 'suma y resta de fracciones ', 'fracciones', 'Fracciones', 'https://www.youtube.com/embed/qSe4X6eyd-g'),
(40, 0, 'EA5', ' Definición de una numero fraccionario y como se lee.', 'TI1,TI3,TI5,TI6', 0, 'Definición de números fraccionarios', 'fracciones', 'Fracciones', 'https://www.youtube.com/embed/U9M2Sp3wQYM'),
(41, 0, 'EA5', ' Ubicación de fracciones en la recta numérica', 'TI1,TI3,TI5,TI6', 0, 'Ubicación de fracciones en la recta', 'fracciones, recta', 'Fracciones', 'https://www.youtube.com/embed/UiJZwbqT06U'),
(42, 0, 'EA5', ' que son las fracciones, propias e impropias', 'TI1,TI3,TI5,TI6', 0, 'Que son las fracciones', 'fracciones, propias, impropias', 'Fracciones', 'https://www.youtube.com/embed/zI9Jz0uS9Sg'),
(44, 1, 'EA6', ' fracciones sus partes, números fraccionarios', 'TI1,TI5,TI6', 0, 'Fracciones y sus partes', 'fracciones, partes', 'Fracciones', 'https://www.youtube.com/embed/OzefMY_m2eg'),
(45, 0, 'EA7', ' convertir numero mixto a fracción y viceversa', 'TI6,TI5,TI2', 1, 'Convertir numero mixto a fracción ', 'convertir,mixto, fracción', 'Fraccion', 'https://www.youtube.com/embed/Zf4KEQfm1aY'),
(46, 0, 'EA7', ' Convertir un decimal exacto a fraccion', 'TI6,TI5,TI2', 0, 'Convertir un decimal exacto a fracción', 'decimal, fraccion', 'convertir', 'https://www.youtube.com/embed/F5TT9lzXJW8'),
(47, 0, 'EA6', ' suma, resta, multiplicación y division', 'TI1,TI5,TI6', 0, 'Si te parecen difíciles las fracciones mira este video', 'fracciones', 'Fracciones', 'https://www.youtube.com/embed/LgMptyzudXU'),
(48, 0, 'EA1', ' Fracciones', 'TI1,TI2,TI3,TI4,TI5,TI6', 0, 'Fracciones Sumas, Restas, Multiplicacion y Division', 'Fraccion,Suma,Resta,Multiplicacion,Division', 'fraccion', 'https://www.youtube.com/embed/blOiy-Eo09I'),
(49, 0, 'EA7', ' fracciones', 'TI6,TI5,TI2', 0, 'Fracciones Sumas, Restas, Multiplicacion y Division', 'fracciones', 'fracciones', 'https://www.youtube.com/embed/Z4m-ouXWtP8'),
(50, 0, 'EA8', 'Fraccion ', 'TI1,TI2,TI3,TI6', 0, 'Fracciones', 'Fraccion', 'Fracciones', 'https://www.youtube.com/embed/c9cTIjBqFTw'),
(51, 0, 'EA8', 'fracciones ', 'TI1,TI2,TI3,TI6', 0, 'Suma, resta, multiplicacion y division de fracciones', 'fracciones', 'fracciones', 'https://www.youtube.com/embed/LgMptyzudXU'),
(52, 0, 'EA2', 'fracciones ', 'TI1,TI4,TI6', 0, 'Suma, resta, multiplicacion y division de fracciones', 'fracciones', 'fracciones', 'https://www.youtube.com/embed/GauFxSmLbCw'),
(53, 0, 'EA3', ' fracciones', 'TI1,TI2,TI3,TI5,TI6', 0, 'Como sumar,restar, multiplicar y dividir fracciones', 'fracciones', 'fracciones', 'https://www.youtube.com/embed/oivWaRR9HuM'),
(54, 0, 'EA4', ' fraccion', 'TI3,TI5,TI6', 0, 'Suma, resta, multiplicacion y division de fracciones', 'fraccion', 'fraccion', 'https://www.youtube.com/embed/84BGHYmhFgs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likesdislikes`
--

CREATE TABLE `likesdislikes` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idVid` int(11) NOT NULL,
  `Accion` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `likesdislikes`
--

INSERT INTO `likesdislikes` (`id`, `idUser`, `idVid`, `Accion`) VALUES
(18, 54, 44, 'L');

-- --------------------------------------------------------

--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasenna` varchar(100) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `rol` int(1) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `telefono` varchar(12) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `edad` int(3) DEFAULT NULL,
  `foto` varchar(100) NOT NULL DEFAULT '0',
  `TI` varchar(255) DEFAULT NULL,
  `EA` varchar(255) DEFAULT NULL,
  `iniSesion` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasenna`, `apellido`, `usuario`, `rol`, `email`, `estado`, `telefono`, `fecha_nac`, `edad`, `foto`, `TI`, `EA`, `iniSesion`) VALUES
(27, 'adm', '$2y$10$1t/jtnJM9Sb3TrKL05mnZ.l.vL4J/NaIYbXH.L2olX3cVsPEkpSdi', 'ingeniero0123', 'ingeniero0123', 2, 'ingeniero0123@gmail.com', 1, '000', '2019-11-30', 22, '0', NULL, NULL, 41),
(40, 'Johan David Zuñiga ', '$2y$10$if4YAjxdO3Xb7Z13U4xmzOvWSvQXmtp3CzbobMuOalZ8dZvm2h5rS', 'Masculino', 'jdavid', 1, 'jdavidzuni01@gmail.com', 1, NULL, NULL, NULL, '0', 'TI6', 'EA5', 8),
(41, 'Yulieth Ceron Cruz ', '$2y$10$xr0w63dSXyx9IFUFxzUyZuwIv3gdicXwyUqP70eSZ76Nw1XXU5uBy', 'Femenino', 'yulieth', 1, 'yulieth@gmail.com', 1, NULL, NULL, NULL, '0', 'TI3', 'EA7', 3),
(42, 'johan Davi', '$2y$10$OnbkbgYNP9qVs60mI5Tn/ulVGV.3NBCnDSahwLUFtlHOBmS1UCJtC', 'Masculino', 'johan', 1, 'johan@gmail.com', 1, NULL, NULL, NULL, '0', 'TI1', 'EA2', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vidsgroups`
--

CREATE TABLE `vidsgroups` (
  `idEA` varchar(10) CHARACTER SET utf8 NOT NULL,
  `nameEA` varchar(255) CHARACTER SET utf8 NOT NULL,
  `asocTI` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `vidsgroups`
--

INSERT INTO `vidsgroups` (`idEA`, `nameEA`, `asocTI`) VALUES
('EA1', 'Activo', 'TI1,TI2,TI4,TI5,TI6'),
('EA2', 'Reflexivo', 'TI1,TI2,TI3,TI4,TI5'),
('EA3', 'Sensitivo', 'TI1,TI2,TI4,TI5'),
('EA4', 'Intuitivo', 'TI2,TI4,TI5'),
('EA5', 'Visual', 'TI1,TI2,TI3,TI4,TI5,TI6'),
('EA6', 'Verbal', 'TI1,TI2,TI3,TI4,TI5,TI6'),
('EA7', 'Secuencial', 'TI1,TI2,TI4,TI5'),
('EA8', 'Global', 'TI1,TI2,TI4,TI5');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indices de la tabla `likesdislikes`
--
ALTER TABLE `likesdislikes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_resp_imagenes`
--
ALTER TABLE `user_resp_imagenes`
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `vidsgroups`
--
ALTER TABLE `vidsgroups`
  ADD PRIMARY KEY (`idEA`),
  ADD UNIQUE KEY `nameEA` (`nameEA`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `likesdislikes`
--
ALTER TABLE `likesdislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
