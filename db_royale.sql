-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2018 a las 06:26:25
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
-- Base de datos: `db_royale`
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_pedido_buscar` (IN `_id` INT)  NO SQL
SELECT 
p.ped_id as 'pedido_id',
p.ped_fecha as 'pedido_fecha',
p.ped_subtotal as 'pedido_subtotal',
p.ped_tipo_consumo as 'pedido_tipo_consumo',
p.ped_destino as 'pedido_destino',
dp.dp_id as 'detalle_id',
pr.abreviatura as 'prod_abrev',
pr.nombre as 'prod_nombre',
ct.nombre as 'prod_categoria',
dp.dp_precio as 'prod_precio',
dp.dp_cantidad as 'prod_cantidad',
dp.dp_importe as 'prod_importe',
dp.dp_detalle as 'prod_detalle'
FROM pedido p 
INNER JOIN detalle_pedido dp ON dp.pedido_id=p.ped_id
INNER JOIN productos pr ON dp.producto_id = pr.id 
INNER JOIN categorias ct ON pr.categoria_id = ct.id
WHERE p.ped_id = _id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ventas_dia` (IN `_fecha` DATE)  NO SQL
SELECT v.ven_id,concat(cl.nombre,' ',cl.ape_paterno,' ',cl.ape_materno) as 'cliente',v.ven_fecha,v.ven_igv,pd.ped_tipo_consumo,pd.ped_subtotal,v.ven_igv,v.ven_total,tc.nombre as 'comprobante' FROM ventas v INNER JOIN clientes cl ON cl.id = v.cliente_id INNER JOIN pedido pd ON pd.ped_id = v.pedido_id INNER JOIN tipo_comprobante tc ON tc.id = v.tipo_comprobante_id WHERE v.ven_fecha = _fecha$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_venta_info` (IN `_venta` INT)  NO SQL
SELECT v.ven_id,v.ven_fecha,pd.ped_subtotal,v.ven_total, pd.ped_tipo_consumo,pd.ped_destino,pr.abreviatura,pr.nombre as 'prod_nombre',pr.precio as 'prod_precio',ct.nombre as 'cat_nombre',ct.abreviatura as 'cat_abrev',dp.dp_cantidad,dp.dp_importe,dp.dp_detalle,
concat(cl.nombre,' ',cl.ape_paterno,'',cl.ape_materno) as 'cli_nombres',concat(us.nombres,' ',us.apellidos) as 'usu_nombres'
FROM ventas v 
INNER JOIN pedido pd ON pd.ped_id = v.pedido_id 
INNER JOIN detalle_pedido dp ON dp.pedido_id = pd.ped_id 
INNER JOIN productos pr ON dp.producto_id = pr.id 
INNER JOIN categorias ct ON ct.id = pr.categoria_id
INNER JOIN clientes cl ON cl.id = v.cliente_id 
INNER JOIN usuarios us ON us.id = v.usuario_id 
WHERE v.ven_id = _venta$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_TotalVentasDia` (IN `fechaIn` DATE)  BEGIN
SELECT v.ven_id,ct.nombre as 'categoria', p.nombre 'Nombre'
, p.precio 'Precio', SUM(dp.dp_cantidad) 'Cantidad', dp.dp_importe 'SubTotal',
v.ven_igv 'Igv',SUM(v.ven_total) as 'Total' FROM ventas v
INNER JOIN pedido pd ON v.pedido_id = pd.ped_id
INNER JOIN detalle_pedido dp ON pd.ped_id = dp.pedido_id
INNER JOIN productos p ON dp.producto_id = p.id
INNER JOIN categorias ct ON p.categoria_id = ct.id
WHERE v.ven_fecha = fechaIn
GROUP BY v.ven_id, dp.producto_id,ct.id
HAVING v.ven_id;
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
(5, 'Andres', 'Caceres', 'Mendoza', '914523658', 'miraflowers', 1, 1, '70609375', 1),
(6, 'Gustavo', 'Castro', 'Peña', '958745214', 'Casma', 1, 1, '79841230', 1),
(7, 'Mario', 'Castañeda', 'Cosio', '901478542', 'Av. pardo', 1, 1, '98547514', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `dp_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `dp_precio` decimal(8,2) NOT NULL,
  `dp_cantidad` int(3) NOT NULL,
  `dp_importe` decimal(8,2) NOT NULL,
  `dp_detalle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`dp_id`, `pedido_id`, `producto_id`, `dp_precio`, `dp_cantidad`, `dp_importe`, `dp_detalle`) VALUES
(24, 11, 16, '8.00', 2, '16.00', 'con extra ensalada'),
(25, 11, 33, '3.00', 2, '6.00', ''),
(26, 12, 7, '8.50', 1, '8.50', ''),
(27, 12, 31, '10.00', 1, '10.00', ''),
(28, 13, 18, '9.00', 1, '9.00', ''),
(29, 13, 35, '4.00', 1, '4.00', ''),
(30, 13, 44, '3.00', 1, '3.00', ''),
(31, 14, 18, '9.00', 1, '9.00', ''),
(32, 14, 26, '9.00', 1, '9.00', ''),
(33, 15, 5, '9.00', 3, '27.00', ''),
(34, 16, 31, '10.00', 1, '10.00', ''),
(35, 16, 18, '9.00', 2, '18.00', ''),
(36, 16, 44, '3.00', 1, '3.00', ''),
(37, 17, 2, '7.00', 3, '21.00', ''),
(38, 17, 25, '7.50', 2, '15.00', ''),
(39, 17, 32, '3.00', 4, '12.00', ''),
(40, 18, 10, '8.50', 3, '25.50', ''),
(41, 19, 7, '8.50', 4, '34.00', ''),
(42, 19, 7, '8.50', 1, '8.50', ''),
(43, 20, 25, '7.50', 2, '15.00', ''),
(44, 21, 6, '9.00', 2, '18.00', ''),
(45, 21, 26, '9.00', 3, '27.00', '');

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
  `mesa_id` int(11) NOT NULL,
  `mesa_numero` varchar(20) NOT NULL,
  `mesa_descripcion` varchar(100) NOT NULL,
  `mesa_estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`mesa_id`, `mesa_numero`, `mesa_descripcion`, `mesa_estado`) VALUES
(1, 'Mesa 01', 'Mesa para 6', 'activo'),
(2, 'Mesa 02', 'Mesa Para 2', 'libre'),
(3, 'Mesa 03', 'Mesa para 4', 'activo'),
(4, 'Mesa 04', 'Mesa para 4', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ped_id` int(11) NOT NULL,
  `ped_fecha` date NOT NULL,
  `ped_subtotal` decimal(8,2) NOT NULL,
  `ped_tipo_consumo` varchar(50) NOT NULL,
  `ped_destino` varchar(100) NOT NULL,
  `ped_estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`ped_id`, `ped_fecha`, `ped_subtotal`, `ped_tipo_consumo`, `ped_destino`, `ped_estado`) VALUES
(11, '2018-10-26', '22.00', 'presencial', 'Mesa 05', 'finalizado'),
(12, '2018-10-26', '18.50', 'presencial', 'Mesa 03', 'finalizado'),
(13, '2018-10-26', '16.00', 'delivery', 'Cambio puente.', 'finalizado'),
(14, '2018-10-27', '18.00', 'presencial', 'Mesa 05', 'finalizado'),
(15, '2018-10-27', '27.00', 'presencial', 'Mesa 02', 'finalizado'),
(16, '2018-10-27', '31.00', 'presencial', 'Mesa 01', 'finalizado'),
(17, '2018-10-27', '48.00', 'delivery', 'Urb. 15 de enero', 'finalizado'),
(18, '2018-10-28', '25.50', 'presencial', 'Mesa 02', 'finalizado'),
(19, '2018-10-28', '42.50', 'delivery', 'Jr union', 'finalizado'),
(20, '2018-10-28', '15.00', 'presencial', 'Mesa 05', 'finalizado'),
(21, '2018-10-28', '45.00', 'presencial', 'Mesa 05', 'finalizado');

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
(1, 'Factura', 11, 18, 1),
(2, 'Boleta', 36, 0, 1),
(3, 'Nota de Venta', 16, 0, 1);

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
  `ven_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `ven_fecha` date NOT NULL,
  `ven_igv` int(3) NOT NULL,
  `ven_descuento` decimal(8,2) NOT NULL,
  `ven_total` decimal(8,2) NOT NULL,
  `tipo_comprobante_id` int(11) NOT NULL,
  `num_documento` varchar(30) NOT NULL,
  `serie` varchar(30) NOT NULL,
  `ven_monto_recibido` decimal(8,2) NOT NULL,
  `ven_monto_devuelto` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`ven_id`, `pedido_id`, `cliente_id`, `usuario_id`, `ven_fecha`, `ven_igv`, `ven_descuento`, `ven_total`, `tipo_comprobante_id`, `num_documento`, `serie`, `ven_monto_recibido`, `ven_monto_devuelto`) VALUES
(10, 11, 1, 1, '2018-10-25', 0, '0.00', '22.00', 2, '000029', '1', '10.00', '-12.00'),
(11, 12, 6, 1, '2018-10-26', 0, '0.00', '18.50', 2, '000030', '1', '18.50', '0.00'),
(12, 13, 5, 1, '2018-10-28', 18, '2.88', '18.88', 1, '000010', '1', '100.00', '81.12'),
(13, 16, 1, 1, '2018-10-28', 0, '0.00', '31.00', 2, '000031', '1', '50.00', '19.00'),
(14, 17, 6, 1, '2018-10-28', 0, '0.00', '48.00', 2, '000032', '1', '48.00', '0.00'),
(15, 18, 7, 1, '2018-10-28', 0, '0.00', '25.50', 2, '000033', '1', '25.50', '0.00'),
(16, 19, 7, 1, '2018-10-28', 0, '0.00', '42.50', 2, '000034', '1', '50.00', '7.50'),
(17, 15, 7, 1, '2018-10-28', 0, '0.00', '27.00', 2, '000035', '1', '100.00', '73.00'),
(18, 14, 6, 1, '2018-10-28', 0, '0.00', '18.00', 3, '000016', '1', '20.00', '2.00'),
(19, 20, 1, 1, '2018-10-28', 0, '0.00', '15.00', 2, '000036', '1', '15.00', '0.00'),
(20, 21, 7, 1, '2018-10-28', 18, '8.10', '53.10', 1, '000011', '1', '100.00', '46.90');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_productos_vendidos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_productos_vendidos` (
`fecha` date
,`categoria` varchar(45)
,`producto` varchar(45)
,`precio` varchar(45)
,`cantidad` int(3)
,`importe` decimal(8,2)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_productos_vendidos`
--
DROP TABLE IF EXISTS `vista_productos_vendidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_productos_vendidos`  AS  select `v`.`ven_fecha` AS `fecha`,`ct`.`nombre` AS `categoria`,`pr`.`nombre` AS `producto`,`pr`.`precio` AS `precio`,`dp`.`dp_cantidad` AS `cantidad`,`dp`.`dp_importe` AS `importe` from ((((`ventas` `v` join `pedido` `pd` on((`v`.`pedido_id` = `pd`.`ped_id`))) join `detalle_pedido` `dp` on((`pd`.`ped_id` = `dp`.`pedido_id`))) join `productos` `pr` on((`dp`.`producto_id` = `pr`.`id`))) join `categorias` `ct` on((`ct`.`id` = `pr`.`categoria_id`))) order by `v`.`ven_fecha` ;

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
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`dp_id`),
  ADD UNIQUE KEY `dp_id` (`dp_id`);

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
  ADD PRIMARY KEY (`mesa_id`),
  ADD UNIQUE KEY `mes_id` (`mesa_id`),
  ADD UNIQUE KEY `numero` (`mesa_numero`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ped_id`);

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
  ADD PRIMARY KEY (`ven_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `dp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
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
  MODIFY `mesa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ped_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
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
  MODIFY `ven_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
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
