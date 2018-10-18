-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2018 a las 08:56:48
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventas_ci`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_categoria_producto` (IN `_cat` INT)  NO SQL
SELECT p.id as 'prod_id',p.abreviatura as 'prod_abrev',p.nombre as 'prod_nom',p.descripcion as 'prod_desc',p.precio as 'prod_prec',c.nombre as 'cat_nom',c.abreviatura as 'cat_abrev',c.imagen as 'cat_img'  
FROM productos p 
INNER JOIN categorias c ON c.id = p.categoria_id
WHERE c.id = _cat$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_venta_info` (IN `_venta` INT)  NO SQL
SELECT v.id as 'v_id', v.fecha as 'v_fecha', v.subtotal as 'v_subtotal',v.igv as 'v_igv', v.descuento as 'v_descuento', v.total as 'v_total', tc.nombre as 'tc_comprobante',v.num_documento as 'v_num_doc',
concat(c.nombre,' ',c.ape_paterno,' ',c.ape_materno) as 'c_nombres',c.tipo_documento_id as 'c_tipo_doc', c.num_documento as 'c_num_doc',p.abreviatura as 'p_abrev', p.nombre as 'p_nombre',p.precio as 'p_precio',ct.nombre as 'ct_nombre',
dv.cantidad as 'dv_cantidad',dv.importe as 'dv_importe',dv.detalle as 'dv_detalle'
FROM detalle_venta dv 
INNER JOIN ventas v ON dv.venta_id = v.id
INNER JOIN productos p ON dv.producto_id = p.id
INNER JOIN categorias ct ON p.categoria_id = ct.id
INNER JOIN tipo_comprobante tc ON v.tipo_comprobante_id = tc.id 
INNER JOIN clientes c ON v.cliente_id = c.id  
WHERE v.id = _venta$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_TotalVentasDia` (IN `fechaIn` DATE)  BEGIN
SELECT SUM(v.total) as 'Total', SUM(dt.cantidad) 'Cantidad', p.nombre 'Nombre'
, p.precio 'Precio', (dt.cantidad * CAST( p.precio AS DECIMAL(18, 2))) 'SubTotal',
v.igv 'Igv' FROM ventas v
INNER JOIN detalle_venta dt ON v.id = dt.venta_id
INNER JOIN productos p ON dt.producto_id = p.id
WHERE fecha = fechaIn
GROUP BY v.id, dt.producto_id
HAVING v.id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `abreviatura` varchar(15) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `imagen` varchar(500) NOT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `abreviatura`, `descripcion`, `imagen`, `estado`) VALUES
(1, 'HAMBURGUESAS', 'HAMB', '', 'storage/categoria/hamburguesas.jpg', 1),
(2, 'SALCHIPAPAS', 'SALCH', '', 'storage/categoria/sachipapa.jpg', 1),
(3, 'SANDWICH DE FILETE DE POLLO', 'SAND', '', 'storage/categoria/sandwich.jpg', 1),
(4, 'CERVEZAS ARTESANALES ', 'CERV', '', 'storage/categoria/cervezas.jpg', 1),
(5, 'BEBIDAS', 'BEB', '', 'storage/categoria/bebidas.jpg', 1),
(6, 'BEBIDAS CALIENTES', 'BEB_CAL', '', 'storage/categoria/bebidas_calientes.jpg', 1),
(7, 'EXTRAS', 'EXT', NULL, 'storage/categoria/extra.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ape_paterno` varchar(50) NOT NULL,
  `ape_materno` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `tipo_cliente_id` int(11) DEFAULT NULL,
  `tipo_documento_id` int(11) DEFAULT NULL,
  `num_documento` varchar(45) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `ape_paterno`, `ape_materno`, `telefono`, `direccion`, `tipo_cliente_id`, `tipo_documento_id`, `num_documento`, `estado`) VALUES
(1, 'Yamilet', 'Polo', 'Jaramillo', 'admin', 'admin', 1, 1, '12345678', 1),
(3, 'Ana', 'Soriano', 'Suarez', '974547854', 'Caraz', 1, 1, '70609373', 1),
(4, 'Milagross', 'Rojas', 'Cadillo', '95478414', 'Av. no me acuerdo', 1, 1, '70609370', 1),
(5, 'Andres', 'Caceres', 'Mendoza', '914523658', 'miraflowers', 1, 1, '70609375', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `precio` varchar(45) DEFAULT NULL,
  `cantidad` varchar(45) DEFAULT NULL,
  `importe` varchar(45) DEFAULT NULL,
  `detalle` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `producto_id`, `venta_id`, `precio`, `cantidad`, `importe`, `detalle`) VALUES
(111, 16, 59, '8.0', '1', '8.0', ''),
(112, 30, 59, '10.0', '3', '30', 'helada'),
(113, 41, 59, '3.0', '1', '3.0', ''),
(114, 2, 59, '7.0', '1', '7.0', 'poco queso'),
(115, 17, 60, '9.0', '1', '9.0', ''),
(116, 21, 60, '5.9', '2', '11.8', ''),
(117, 31, 60, '10.0', '1', '10.0', ''),
(118, 16, 61, '8.0', '1', '8.0', ''),
(119, 35, 61, '4.0', '3', '12', 'bien helena'),
(120, 29, 61, '10.0', '1', '10.0', ''),
(121, 6, 62, '9.0', '1', '9.0', ''),
(122, 25, 62, '7.5', '1', '7.5', ''),
(123, 33, 62, '3.0', '2', '6', 'calientes'),
(124, 11, 63, '9.0', '2', '18', 'sin piña'),
(125, 29, 63, '10.0', '1', '10.0', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `emp_id` int(11) NOT NULL,
  `per_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `emp_estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `nombre`, `link`) VALUES
(1, 'Inicio', 'dashboard'),
(2, 'Categorias', 'mantenimiento/categorias'),
(3, 'Clientes', 'mantenimiento/clientes'),
(4, 'Productos', 'mantenimiento/productos'),
(5, 'Ventas', 'movimientos/ventas'),
(6, 'Reporte Ventas', 'reportes/ventas'),
(7, 'Usuarios', 'administrador/usuarios'),
(8, 'Permisos', 'administrador/permisos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `mes_id` int(11) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`mes_id`, `numero`, `descripcion`, `estado`) VALUES
(1, 'Mesa 01', 'Mesa para 4', 'libre'),
(2, 'Mesa 02', 'Mesa Para 2', 'libre'),
(3, 'Mesa 03', 'Mesa para 1', 'libre'),
(4, 'Mesa 04', 'Mesa para 2', 'libre'),
(5, 'Mesa 05', 'barra de bancas', 'libre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `read` int(11) DEFAULT NULL,
  `insert` int(11) DEFAULT NULL,
  `update` int(11) DEFAULT NULL,
  `delete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `menu_id`, `rol_id`, `read`, `insert`, `update`, `delete`) VALUES
(1, 1, 2, 1, 1, 1, 1),
(2, 2, 2, 1, 1, 0, 0),
(3, 3, 2, 1, 1, 1, 0),
(4, 4, 2, 1, 1, 1, 1),
(5, 5, 2, 1, 1, 1, 1),
(7, 6, 2, 1, 1, 1, 1),
(8, 7, 2, 1, 1, 1, 1),
(9, 8, 2, 1, 1, 1, 1),
(10, 1, 1, 1, 1, 1, 1),
(11, 2, 1, 1, 1, 1, 1),
(12, 4, 1, 1, 1, 1, 1),
(13, 5, 1, 1, 1, 1, 1),
(14, 6, 1, 1, 1, 1, 1),
(15, 7, 1, 1, 1, 1, 1),
(16, 3, 1, 1, 1, 1, 1),
(17, 8, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `per_id` int(11) NOT NULL,
  `per_dni` char(8) NOT NULL,
  `per_nombres` varchar(50) NOT NULL,
  `per_apellidos` varchar(50) NOT NULL,
  `per_email` varchar(50) NOT NULL,
  `per_telefono` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `abreviatura` varchar(10) NOT NULL DEFAULT '0',
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `precio` varchar(45) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `abreviatura`, `nombre`, `descripcion`, `precio`, `stock`, `categoria_id`, `estado`) VALUES
(2, 'C-QUES', 'CON QUESO', 'Carne de res, queso, lechuga y tomate. Acompañado con papas fritas.', '7.0', 30, 1, 1),
(3, 'MONT', 'MONTADA', 'Carne de res, huevo, lechuga y tomate. Acompañado con papas fritas.', '7.0', 18, 1, 1),
(4, 'DOB-QUES', 'DOBLE QUESO ', 'Carne de res, doble queso, lechuga y tomate. Acompañado con papas fritas.', '7.5', 19, 1, 1),
(5, 'LAROY', 'LAROYALE ', 'Carne de res, huevo, queso, lechuga y tomate. Acompañado con papas fritas.', '9.0', 13, 1, 1),
(6, 'ITAL', 'ITALIANA', 'Carne de res, queso al orégano, albaca fresca, lechuga y tomate. Acompañado con papas fritas.', '9.0', 13, 1, 1),
(7, 'MEX', 'MEXICANA', 'Carne de res, queso, guaca-mole, nachos, lechuga y tomate. Acompañado con papas fritas.', '8.5', 19, 1, 1),
(10, 'HUACH', 'HUACHANA', 'Carne de res, salchicha huachana, papas al hilo, lechuga y tomate. Acompañado con papas fritas.', '8.5', 20, 1, 1),
(11, 'HAWAI', 'HAWAIANA', 'Carne de res, piña fresca, queso, jamón ingles, lechuga y tomate. Acompañado con papas fritas.', '9.0', 17, 1, 1),
(12, 'GAU', 'GAUCHA', 'Carne de res, chorizo parrillero, chimichurri, lechuga y tomate. Acompañado de papas fritas.', '9.5', 20, 1, 1),
(14, 'CLAS', 'CLASICA', 'Papas fritas y salchicha ahumada.', '7.0', 9, 2, 1),
(16, 'MONT', 'MONTADA ', 'Papas fritas, salchicha ahumada y huevo.', '8.0', 6, 2, 1),
(17, 'LAROY', 'LAROYALE', 'Papas fritas, salchicha ahumada, huevo y queso.', '9.0', 0, 2, 1),
(18, 'POBR', 'A LO POBRE', 'Papas fritas, salchicha ahumada, huevo y plátano.', '9.0', 7, 2, 1),
(20, 'CHORPP', 'CHORIPAPA', 'Papas fritas, mix de salchicha y chorizo ahumado.', '12.0', 8, 2, 1),
(21, 'SIMP', 'SIMPLE', 'Filete de pollo, lechuga y tomate. Acompañado de papas fritas.', '5.9', 10, 3, 1),
(23, 'MONT', 'MONTADA', 'Filete de pollo,huevo, lechuga y tomate. Acompañado de papas fritas.', '7.0', 9, 3, 1),
(24, '--', 'LAROYALE', 'Filete de pollo,huevo, queso,lechuga y tomate. Acompañado de papas fritas.', '8.0', 10, 3, 1),
(25, '--', 'ITALIANA', 'Filete de pollo, queso al orégano, albaca fresca,lechuga y tomate. Acompañado de papas fritas.', '7.5', 9, 3, 1),
(26, '--', 'AMERICANA', 'Filete de pollo,tocino ahumado, queso,lechuga y tomate. Acompañado de papas fritas.', '9.0', 9, 3, 1),
(28, '--', 'CLUB SANDWICH', 'Filete de pollo,tocino ahumado,huevo,jamón ingles, queso,lechuga y tomate. Acompañado de papas frita', '10.0', 9, 3, 1),
(29, '--', 'INTI GOLDEN ALE ', 'Cerveza ligera y suave ', '10.0', 6, 4, 1),
(30, '--', 'ALPAMAYO AMBER ALE', 'Balance perfecto de lúpulo y malta con toques de caramelo y cebada.', '10.0', 6, 4, 1),
(31, '--', 'SHAMAN IPA ', 'Sabor a magno, toronja y maracuyá.', '10.0', 8, 4, 1),
(32, '--', 'CHICHA MORADA 12oz', '12 Oz.', '3.0', 0, 5, 1),
(33, '--', 'MARACUYA 12oz', '12 Oz.', '3.0', 0, 5, 1),
(34, '--', 'PIÑA 16oz', '16 Oz.', '5.0', 0, 5, 1),
(35, '--', 'CHICHA MORADA 16oz', '16 Oz', '4.0', 0, 5, 1),
(36, '--', 'MARACUYÁ 16oz', '16 Oz', '4.0', 10, 5, 1),
(37, '--', 'COCA COLA 500ml', '500 ml ', '3.0', 0, 5, 1),
(38, '--', 'INCA COLA 500ml', '500 ml ', '3.0', -1, 5, 1),
(39, '--', 'COCA COLA 1.5lt', '1.5 Lt.', '8.0', -1, 5, 1),
(40, '--', 'INCA KOLA 1.5lt', '1.5 Lt.', '8.0', 0, 5, 1),
(41, '--', 'FANTA 500ml', '500 ml', '3.0', -1, 5, 1),
(42, '--', 'SPRITE 500ml', '500 ml', '3.0', 0, 5, 1),
(43, '--', ' INFUSIONES ', '', '3.0', 8, 6, 1),
(44, '--', 'CAFÉ', '', '3.0', -4, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`) VALUES
(1, 'superadmin', NULL),
(2, 'admin', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cliente`
--

CREATE TABLE `tipo_cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_cliente`
--

INSERT INTO `tipo_cliente` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Publico General', NULL),
(2, 'Empresa', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comprobante`
--

CREATE TABLE `tipo_comprobante` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `igv` int(11) DEFAULT NULL,
  `serie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_comprobante`
--

INSERT INTO `tipo_comprobante` (`id`, `nombre`, `cantidad`, `igv`, `serie`) VALUES
(1, 'Factura', 9, 18, 1),
(2, 'Boleta', 20, 0, 1),
(3, 'Nota de Venta', 15, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `nombre`, `cantidad`) VALUES
(1, 'DNI', 8),
(2, 'RUC', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `telefono`, `email`, `username`, `password`, `rol_id`, `estado`) VALUES
(1, 'Eduardo', 'Cruz', '94784756', 'eduardo@hotmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 2, 1),
(2, 'Carlos', 'Ramos', '904785469', 'carlos@gmail.com', 'coda', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `subtotal` varchar(45) DEFAULT NULL,
  `igv` varchar(45) DEFAULT NULL,
  `descuento` varchar(45) DEFAULT NULL,
  `total` varchar(45) DEFAULT NULL,
  `tipo_comprobante_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `num_documento` varchar(45) DEFAULT NULL,
  `serie` varchar(45) DEFAULT NULL,
  `tipo_consumo` varchar(30) NOT NULL,
  `destino` varchar(300) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `subtotal`, `igv`, `descuento`, `total`, `tipo_comprobante_id`, `cliente_id`, `usuario_id`, `num_documento`, `serie`, `tipo_consumo`, `destino`, `estado`) VALUES
(59, '2018-10-16', '48', '', '', '', 0, 0, 0, '', '', 'presencial', 'Mesa 04', 'pedido'),
(60, '2018-10-16', '30.8', '', '', '', 0, 0, 0, '', '', 'deliveri', 'Long islad', 'pedido'),
(61, '2018-10-16', '30', '', '', '', 0, 0, 0, '', '', 'presencial', 'Mesa 05', 'pedido'),
(62, '2018-10-16', '22.5', '', '', '', 0, 0, 0, '', '', 'presencial', 'Mesa 03', 'pedido'),
(63, '2018-10-16', '28', '', '', '', 0, 0, 0, '', '', 'deliveri', 'jr union civil', 'pedido');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tipo_cliente_idx` (`tipo_cliente_id`),
  ADD KEY `fk_tipo_documento_idx` (`tipo_documento_id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_venta_detalle_idx` (`venta_id`),
  ADD KEY `fk_producto_detalle_idx` (`producto_id`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `per_id` (`per_id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`mes_id`),
  ADD UNIQUE KEY `mes_id` (`mes_id`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menus_idx` (`menu_id`),
  ADD KEY `fk_rol_idx` (`rol_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`per_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria_producto_idx` (`categoria_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `tipo_cliente`
--
ALTER TABLE `tipo_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD KEY `fk_rol_usuarios_idx` (`rol_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_venta_idx` (`usuario_id`),
  ADD KEY `fk_cliente_venta_idx` (`cliente_id`),
  ADD KEY `fk_tipo_comprobante_venta_idx` (`tipo_comprobante_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;
--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `mes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipo_cliente`
--
ALTER TABLE `tipo_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_tipo_cliente` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipo_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tipo_documento` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`per_id`) REFERENCES `persona` (`per_id`),
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `fk_menus` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
