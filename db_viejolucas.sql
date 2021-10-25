-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2021 a las 07:21:23
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_viejolucas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adicional`
--

CREATE TABLE `adicional` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `mermelada_tocino` bit(1) NOT NULL,
  `aji` bit(1) NOT NULL,
  `mayonesa` bit(1) NOT NULL,
  `mostaza` bit(1) NOT NULL,
  `vigencia` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `adicional`
--

INSERT INTO `adicional` (`id`, `mermelada_tocino`, `aji`, `mayonesa`, `mostaza`, `vigencia`) VALUES
(1, b'1', b'0', b'0', b'0', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `vigencia` bit(1) NOT NULL,
  `idUsuario` smallint(10) UNSIGNED NOT NULL,
  `idProducto` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `nombres` varchar(244) NOT NULL,
  `apellidos` varchar(244) NOT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `correo` varchar(244) NOT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `vigencia` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombres`, `apellidos`, `dni`, `correo`, `telefono`, `vigencia`) VALUES
(1, 'Adan', 'Vinchales', NULL, 'avinchalesl@unprg.edu.pe', '981837592', b'1'),
(2, 'Carlos', 'Gutierrez', NULL, 'CarGuti12@gmail.com', '981845721', b'1'),
(3, 'Juan', 'Vasquez', NULL, 'juanVas1223@gmail.com', '924045721', b'1'),
(4, 'Frank', 'Castro', NULL, 'FrankCa124@gmail.com', '981234511', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden`
--

CREATE TABLE `detalle_orden` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `vigencia` bit(1) NOT NULL,
  `idDetalleProducto` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producto`
--

CREATE TABLE `detalle_producto` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `carne` int(11) DEFAULT NULL,
  `queso` int(11) DEFAULT NULL,
  `huevo` int(11) DEFAULT NULL,
  `platanoFrito` int(11) DEFAULT NULL,
  `jamon` int(11) DEFAULT NULL,
  `piña` bit(1) DEFAULT NULL,
  `tocino` int(11) DEFAULT NULL,
  `salcHuachana` int(11) DEFAULT NULL,
  `lechuga` bit(1) DEFAULT NULL,
  `tomate` bit(1) DEFAULT NULL,
  `vigencia` bit(1) NOT NULL,
  `idProducto` smallint(5) UNSIGNED NOT NULL,
  `idAdicional` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_producto`
--

INSERT INTO `detalle_producto` (`id`, `carne`, `queso`, `huevo`, `platanoFrito`, `jamon`, `piña`, `tocino`, `salcHuachana`, `lechuga`, `tomate`, `vigencia`, `idProducto`, `idAdicional`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, 0, NULL, b'1', b'1', b'0', 5, 1),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, b'1', b'1', b'1', 6, NULL),
(3, 1, 1, NULL, NULL, NULL, NULL, 1, NULL, b'1', b'1', b'1', 7, NULL),
(4, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, b'1', b'1', b'1', 8, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `calle` varchar(244) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `referencia` varchar(244) NOT NULL,
  `ciudad` int(11) NOT NULL,
  `vigencia` bit(1) NOT NULL,
  `idCliente` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `nombres` varchar(244) NOT NULL,
  `apellidos` varchar(244) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `correo` varchar(244) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `vigencia` bit(1) NOT NULL,
  `idUbicacion` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `costoEnvio` decimal(10,2) NOT NULL,
  `lugarEnvio` varchar(244) NOT NULL,
  `vigencia` bit(1) NOT NULL,
  `idOrden` smallint(5) UNSIGNED NOT NULL,
  `idEmpleado` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modo_pago`
--

CREATE TABLE `modo_pago` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `tipo` int(11) NOT NULL,
  `fraccionPago` int(11) NOT NULL,
  `montoEfectivo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `vigencia` bit(1) NOT NULL,
  `idModoPago` smallint(5) UNSIGNED NOT NULL,
  `idUsuario` smallint(5) UNSIGNED NOT NULL,
  `idDetalleOrden` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `nombre` varchar(244) NOT NULL,
  `descripcion` varchar(244) NOT NULL,
  `categoria` enum('Hamburguesas','Parrillas','Complementos') NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `imagen` varchar(244) NOT NULL,
  `vigencia` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `categoria`, `precio`, `imagen`, `vigencia`) VALUES
(5, 'La Matty', 'Pan brioche, lechuga, tomate, carne de res, queso chedar y mermelada de tocino.', 'Hamburguesas', '12', 'https://i.ibb.co/sJT2wvm/Maty.jpg', b'1'),
(6, 'La Huachana', 'Pan brioche, lechuga, tomate y salchicha huachana con cerdo.', 'Hamburguesas', '14', 'https://i.ibb.co/TYxGxbF/huachana.jpg', b'1'),
(7, 'La Poderotza', 'Pan brioche, lechuga, tomate, carne de res con cerdo, queso cheddar y tocino.', 'Hamburguesas', '14', 'https://i.ibb.co/0jzDJpg/Poderotza.jpg', b'1'),
(8, 'La Clásica', 'Pan brioche, lechuga, tomate, carne de res y queso chedar.', 'Hamburguesas', '10', 'https://i.ibb.co/f9CHXWJ/clasica.jpg', b'1'),
(9, 'xd', 'Pan brioche, lechuga, tomate, carne de res y queso chedar.', 'Hamburguesas', '10', 'https://i.ibb.co/f9CHXWJ/clasica.jpg', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumen`
--

CREATE TABLE `resumen` (
  `id` smallint(10) UNSIGNED NOT NULL,
  `pagoTotal` decimal(10,2) NOT NULL,
  `vigencia` bit(1) NOT NULL,
  `idOrden` smallint(5) UNSIGNED NOT NULL,
  `idEnvio` smallint(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `rol` varchar(30) NOT NULL,
  `vigencia` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `rol`, `vigencia`) VALUES
(1, 'Cliente', b'1'),
(2, 'Administrador', b'1'),
(3, 'Empleado', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `ubicacion` varchar(60) NOT NULL,
  `vigencia` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `usuario` varchar(244) NOT NULL,
  `contraseña` varchar(244) NOT NULL,
  `vigencia` bit(1) NOT NULL,
  `idCliente` smallint(5) UNSIGNED DEFAULT NULL,
  `idEmpleado` smallint(5) UNSIGNED DEFAULT NULL,
  `idRol` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `contraseña`, `vigencia`, `idCliente`, `idEmpleado`, `idRol`) VALUES
(3, 'Asmith98', '12345', b'1', 1, NULL, 1),
(4, 'CarGu91', '123456', b'1', 2, NULL, 1),
(5, 'VasQJuan12', '1234', b'1', 3, NULL, 1),
(6, 'Frank221', '12345', b'1', 4, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adicional`
--
ALTER TABLE `adicional`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDetalleProducto` (`idDetalleProducto`);

--
-- Indices de la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idAdicional` (`idAdicional`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUbicacion` (`idUbicacion`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOrden` (`idOrden`),
  ADD KEY `idEmpleado` (`idEmpleado`);

--
-- Indices de la tabla `modo_pago`
--
ALTER TABLE `modo_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idModoPago` (`idModoPago`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idDetalleOrden` (`idDetalleOrden`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resumen`
--
ALTER TABLE `resumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEnvio` (`idEnvio`),
  ADD KEY `idOrden` (`idOrden`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idEmpleado` (`idEmpleado`),
  ADD KEY `idRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adicional`
--
ALTER TABLE `adicional`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modo_pago`
--
ALTER TABLE `modo_pago`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `resumen`
--
ALTER TABLE `resumen`
  MODIFY `id` smallint(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD CONSTRAINT `detalle_orden_ibfk_1` FOREIGN KEY (`idDetalleProducto`) REFERENCES `detalle_producto` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD CONSTRAINT `detalle_producto_ibfk_2` FOREIGN KEY (`idAdicional`) REFERENCES `adicional` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_producto_ibfk_3` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`idUbicacion`) REFERENCES `ubicacion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`id`) REFERENCES `envio` (`idEmpleado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`id`) REFERENCES `envio` (`idOrden`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orden_ibfk_2` FOREIGN KEY (`idModoPago`) REFERENCES `modo_pago` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `orden_ibfk_3` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orden_ibfk_4` FOREIGN KEY (`idDetalleOrden`) REFERENCES `detalle_orden` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `resumen`
--
ALTER TABLE `resumen`
  ADD CONSTRAINT `resumen_ibfk_1` FOREIGN KEY (`idEnvio`) REFERENCES `envio` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `resumen_ibfk_2` FOREIGN KEY (`idOrden`) REFERENCES `orden` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`idRol`) REFERENCES `rol` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
