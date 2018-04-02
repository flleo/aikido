-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 31-12-2015 a las 20:58:22
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

/*create database BDAikido;*/

--

-- --------------------------------------------------------
use BDAikido;

--
-- Estructura de tabla para la tabla `tabla_fotos`
--

CREATE TABLE `tabla_fotos` (
  `Id` int(11) NOT NULL,
  `Id_UsuarioFrontEnd` int(11) NOT NULL,
  `Id_Obra` int(11) NOT NULL,
  `Path` varchar(255) CHARACTER SET utf32 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_localidad`
--

CREATE TABLE `tabla_localidad` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tabla_localidad`
--

INSERT INTO `tabla_localidad` (`Id`, `Nombre`) VALUES
(3, 'La Matanza'),
(4, 'La Laguna'),
(5, 'Los Realjos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_presupuesto_empresa`
--

CREATE TABLE `tabla_presupuesto_empresa` (
  `Id` int(11) NOT NULL,
  `Id_UsuarioFrontEnd` int(11) NOT NULL,
  `Id_Obra` int(11) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Fecha` date NOT NULL,
  `Fichero` varchar(255) NOT NULL,
  `Importe` float NOT NULL,
  `PresupuestoAceptado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tabla_presupuesto_empresa`
--

INSERT INTO `tabla_presupuesto_empresa` (`Id`, `Id_UsuarioFrontEnd`, `Id_Obra`, `Titulo`, `Fecha`, `Fichero`, `Importe`, `PresupuestoAceptado`) VALUES
(1, 2, 2, 'Dragados', '2014-08-20', '', 5000, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_usuarios_back_end`
--

CREATE TABLE `tabla_usuarios_back_end` (
  `Id` int(11) NOT NULL,
  `Id_TipoUsuarioBackEnd` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tabla_usuarios_back_end`
--

INSERT INTO `tabla_usuarios_back_end` (`Id`, `Id_TipoUsuarioBackEnd`, `Nombre`, `Email`, `Telefono`, `Usuario`, `Password`) VALUES
(5, 3, 'Perico Delgado', 'perico@fmail.com', 923334434, 'per', 'per'),
(6, 1, 'cz', 'xc<z', 933223344, 'cz', 'cz'),
(7, 1, 'Bartolo Perez', 'sdfadfs@ds.vf', 56556565, 'bartolo', 'bartolo'),
(8, 1, 'jaco perez', 'sdfadfs@ds.vf', 546545646, 'federic', 'surfing');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_usuarios_front_end`
--

CREATE TABLE `tabla_usuarios_front_end` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Grado` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tabla_usuarios_front_end`
--

INSERT INTO `tabla_usuarios_front_end` (`Id`, `Nombre`, `Email`, `Telefono`, `Usuario`, `Password`, `Grado`) VALUES
(6, 'Pepito Ramirez', 'fasd@fsd.com', 2147483647, 'pep', 'pep', 'San-Kyu'),
(8, 'Vitorio Martin', 'vitorio@mkl.es', 933223345, 'vito', 'vito', ''),
(9, 'Vitorio Martin', 'vitorio@mkl.es', 933223344, 'vito', 'vito', ''),
(10, 'Vitorio Martin', 'vitorio@mkl.es', 933223344, 'vito', 'vito', ''),
(11, 'CITELCAN,S.L.', 'citelcxan@#fsd.es', 922212233, 'citel', 'citel', ''),
(12, 'celgan,sl', 'dfsdf@sfa', 32323, 'cel', 'cel', ''),
(13, 'Jesus Gonazalez', 'fadsaf', 3423, 'jesus', 'jesus', ''),
(14, 'Gabriel', 'jkljlk', 7879, 'gabriel', 'bagriel', ''),
(15, 'Casio', 'fsdfa', 234, 'casio', 'casio', 'Ni-Kyu'),
(16, 'poto', 'dsfaf', 3432, 'poto', 'poto', 'San-Kyu');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tabla_fotos`
--
ALTER TABLE `tabla_fotos`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `tabla_localidad`
--
ALTER TABLE `tabla_localidad`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `tabla_presupuesto_empresa`
--
ALTER TABLE `tabla_presupuesto_empresa`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `tabla_usuarios_back_end`
--
ALTER TABLE `tabla_usuarios_back_end`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `tabla_usuarios_front_end`
--
ALTER TABLE `tabla_usuarios_front_end`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tabla_fotos`
--
ALTER TABLE `tabla_fotos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tabla_localidad`
--
ALTER TABLE `tabla_localidad`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tabla_presupuesto_empresa`
--
ALTER TABLE `tabla_presupuesto_empresa`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tabla_usuarios_back_end`
--
ALTER TABLE `tabla_usuarios_back_end`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `tabla_usuarios_front_end`
--
ALTER TABLE `tabla_usuarios_front_end`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
