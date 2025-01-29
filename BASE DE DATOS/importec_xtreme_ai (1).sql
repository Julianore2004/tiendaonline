-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-01-2025 a las 22:46:11
-- Versión del servidor: 10.6.18-MariaDB-cll-lve
-- Versión de PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `importec_xtreme_ai`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(7) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Clave` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `Nombre`, `Clave`) VALUES
(1, 'admin01', '2582fafc5b2648679d4cc5b229662ddb'),
(4, 'xtreme', '2582fafc5b2648679d4cc5b229662ddb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `CodigoCat` varchar(30) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`CodigoCat`, `Nombre`, `Descripcion`) VALUES
('01', 'celulares', 'Celulares que mas mamaguevo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `NIT` varchar(30) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `NombreCompleto` varchar(70) NOT NULL,
  `Apellido` varchar(70) NOT NULL,
  `Clave` text NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`NIT`, `Nombre`, `NombreCompleto`, `Apellido`, `Clave`, `Direccion`, `Telefono`, `Email`) VALUES
('71422155', 'KACHERO', 'Julian', 'Ore', '546157bec0c71cf2589af7507a9fd615', 'luricocha', '987845654', 'julianore79@gmail.com'),
('71422954', 'julian', 'Julian', 'Ore', '338c23e8eafc19ec9236404deac0bef4', 'luricocha', '985845655', 'julianore79@gmail.com'),
('71422955', 'julian', 'Julian', 'Ore', '338c23e8eafc19ec9236404deac0bef4', 'luricocha', '987845654', 'julianore79@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentabanco`
--

CREATE TABLE `cuentabanco` (
  `id` int(50) NOT NULL,
  `NumeroCuenta` varchar(100) NOT NULL,
  `NombreBanco` varchar(100) NOT NULL,
  `NombreBeneficiario` varchar(100) NOT NULL,
  `TipoCuenta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cuentabanco`
--

INSERT INTO `cuentabanco` (`id`, `NumeroCuenta`, `NombreBanco`, `NombreBeneficiario`, `TipoCuenta`) VALUES
(1, '123456', 'BANCO DE LA NACION', 'ALEXIS', 'NO SE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `NumPedido` int(20) NOT NULL,
  `CodigoProd` varchar(30) NOT NULL,
  `CantidadProductos` int(20) NOT NULL,
  `PrecioProd` decimal(30,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`NumPedido`, `CodigoProd`, `CantidadProductos`, `PrecioProd`) VALUES
(1, '51561', 5, 3200.00),
(2, '12445', 12, 1008.00),
(4, '004', 1, 49.00),
(5, '004', 1, 49.00),
(5, '12445', 1, 1008.00),
(6, '004', 12, 49.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(20) NOT NULL,
  `CodigoProd` varchar(30) NOT NULL,
  `NombreProd` varchar(30) NOT NULL,
  `CodigoCat` varchar(30) NOT NULL,
  `Precio` decimal(30,2) NOT NULL,
  `Descuento` int(2) NOT NULL,
  `Modelo` varchar(30) NOT NULL,
  `Marca` varchar(30) NOT NULL,
  `Stock` int(20) NOT NULL,
  `NITProveedor` varchar(30) NOT NULL,
  `Imagen` varchar(150) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `CodigoProd`, `NombreProd`, `CodigoCat`, `Precio`, `Descuento`, `Modelo`, `Marca`, `Stock`, `NITProveedor`, `Imagen`, `Nombre`, `Estado`) VALUES
(1, '51561', 'IPHONE 15 PRO MAX', '01', 3200.00, 5, '6202', 'IPHONE', 290, '123456', '51561.png', 'admin', 'Activo'),
(3, '12445', 's20 FE', '01', 1120.00, 10, 'x1', 'samsung', 28, '123456', '12445.jpg', 'admin', 'Activo'),
(4, '004', 'Palo de Selfie', '01', 49.00, 0, '1.0', 'Hongdak', 16, '123456', '004.png', 'Alexis', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `NITProveedor` varchar(30) NOT NULL,
  `NombreProveedor` varchar(30) NOT NULL,
  `Direccion` varchar(200) NOT NULL,
  `Telefono` varchar(20) NOT NULL,
  `PaginaWeb` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`NITProveedor`, `NombreProveedor`, `Direccion`, `Telefono`, `PaginaWeb`) VALUES
('123456', 'Ruben', 'huanta', '789456123', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `NumPedido` int(20) NOT NULL,
  `Fecha` varchar(150) NOT NULL,
  `NIT` varchar(30) NOT NULL,
  `TotalPagar` decimal(30,2) NOT NULL,
  `Estado` varchar(150) NOT NULL,
  `NumeroDeposito` varchar(50) NOT NULL,
  `TipoEnvio` varchar(37) NOT NULL,
  `Adjunto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`NumPedido`, `Fecha`, `NIT`, `TotalPagar`, `Estado`, `NumeroDeposito`, `TipoEnvio`, `Adjunto`) VALUES
(1, '14-10-2024', '71422955', 16000.00, 'Entregado', '123456', 'Recoger Por Tienda', 'comprobante_1.png'),
(2, '14-10-2024', '71422955', 12096.00, 'Enviado', '123456', 'Envio Por Currier', 'comprobante_2.jpg'),
(4, '17-11-2024', '71422155', 49.00, 'Enviado', '123456', 'Envio Por Currier', 'comprobante_3.jpg'),
(5, '17-11-2024', '71422155', 1057.00, 'Pendiente', '123456', '', 'comprobante_4.jpg'),
(6, '17-11-2024', '71422155', 588.00, 'Entregado', '123456', 'Recoger Por Tienda', 'comprobante_5.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`CodigoCat`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`NIT`);

--
-- Indices de la tabla `cuentabanco`
--
ALTER TABLE `cuentabanco`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD KEY `NumPedido` (`NumPedido`),
  ADD KEY `CodigoProd` (`CodigoProd`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CodigoCat` (`CodigoCat`),
  ADD KEY `NITProveedor` (`NITProveedor`),
  ADD KEY `Agregado` (`Nombre`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`NITProveedor`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`NumPedido`),
  ADD KEY `NIT` (`NIT`),
  ADD KEY `NIT_2` (`NIT`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cuentabanco`
--
ALTER TABLE `cuentabanco`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `NumPedido` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `detalle_ibfk_9` FOREIGN KEY (`NumPedido`) REFERENCES `venta` (`NumPedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_7` FOREIGN KEY (`CodigoCat`) REFERENCES `categoria` (`CodigoCat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_8` FOREIGN KEY (`NITProveedor`) REFERENCES `proveedor` (`NITProveedor`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`NIT`) REFERENCES `cliente` (`NIT`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
