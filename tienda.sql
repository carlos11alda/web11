-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-08-2024 a las 21:39:35
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
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `expiry_date` varchar(10) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `name`, `address`, `card_number`, `expiry_date`, `cvv`, `payment_date`, `payment_amount`) VALUES
(2, 'pepe', 'tena', '1234567890123456', '23/29', '543', '2024-06-20 21:13:55', 0.00),
(3, 'pepe', 'tena', '1234567890123456', '23/29', '543', '2024-06-20 21:13:58', 0.00),
(4, 'pepe', 'tena', '1234567890123456', '23/29', '543', '2024-06-21 21:02:03', 0.00),
(5, 'jorge', 'tena', '1234567890123456', '23/29', '543', '2024-06-23 20:58:22', 0.00),
(6, 'jorge', 'tena', '1234567890123456', '23/29', '543', '2024-06-23 21:00:07', 0.00),
(7, 'jorge', 'tena', '1234567890123456', '23/29', '543', '2024-06-24 20:15:56', 0.00),
(8, 'jorge', 'tena', '1234567890123456', '23/29', '543', '2024-06-24 21:38:51', 0.00),
(9, 'Luisss', '1501050', '2457895435764325', '26/29', '435', '2024-06-24 21:44:52', 0.00),
(10, 'carlos andy', 'tena', '1234567890123456', '23/29', '543', '2024-06-25 02:35:20', 0.00),
(11, 'carlos andy', 'tena', '1234567890123456', '23/29', '543', '2024-06-25 21:29:21', 0.00),
(12, 'jorge', 'tena', '1234567890123456', '23/29', '543', '2024-06-26 19:25:07', 0.00),
(13, 'jorgee', 'tena', '1234567890123456', '23/29', '543', '2024-06-26 19:49:44', 949.83),
(14, 'pepe', 'tena', '1234567890123456', '23/29', '543', '2024-06-26 19:52:15', 1748.53),
(15, 'carlos andy', 'tena', '1234567890123456', '23/29', '543', '2024-06-26 19:56:07', 1289.19),
(16, 'jorgee', 'tena', '1234567890123456', '23/29', '543', '2024-06-26 20:00:56', 1748.53),
(18, 'jorgee', 'tena', '1234567890123456', '23/29', '543', '2024-08-01 15:40:32', 1748.53);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `vendido` tinyint(10) DEFAULT 0,
  `fecha_venta` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `vendido`, `fecha_venta`) VALUES
(1, 'LAVADORA WHIRLPOOL IMPELLER 19KG', 'Modelo: WW19LTAHLA\r\nLa nueva lavadora Whirlpool WW19LTAHLA viene con un sistema de re-circulación Xpert CoverWash de Lavado Impeller mejorando el sistema intelicarga el cual podrás ahorrar hasta 24,000 litros de agua utilizando solo lo que necesitas dependiendo del tamaño de tu carga.\r\nCuenta con una garantía directamente de la marca de 10 años en el motor - 3 años en el panel', 490.49, 'LAVADORA ', 1, NULL),
(2, 'Aire Acondicionado Split TAC-18CSA/Z2 18000BTU ON/OFF TCL', 'Modelo: TAC-18CSA/Z2\r\nModo de Dormir (Sleep Mode)\r\nDiseño seguro\r\nAuto-Diagnostico\r\nReinicio Automático ante el apagón\r\nCaños de cobre\r\nMarca: TCL', 459.34, 'Aire Acondicionado Split TAC', 2, NULL),
(3, 'REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17\"', 'Modelo: WRE57BKTWW\r\nLa refrigeradora bottom mount de whirlpool modelo WRE57BKTWW cuenta con tecnología Xpert Inverter que te da mayor ahorro de energía y conservación de alimentos. Además tiene lámina anti huellas y capacidad de 484 Litros Marca: Whirlpool', 798.70, 'REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17\"', 2, '2024-06-18'),
(4, 'REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17\"', 'Modelo: WRE57BKTWW\r\nLa refrigeradora bottom mount de whirlpool modelo WRE57BKTWW cuenta con tecnología Xpert Inverter que te da mayor ahorro de energía y conservación de alimentos. Además tiene lámina anti huellas y capacidad de 484 Litros Marca: Whirlpool', 798.70, 'REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17\"', 1, '2024-06-18'),
(5, 'REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17\"', 'Modelo: WRE57BKTWW\r\nLa refrigeradora bottom mount de whirlpool modelo WRE57BKTWW cuenta con tecnología Xpert Inverter que te da mayor ahorro de energía y conservación de alimentos. Además tiene lámina anti huellas y capacidad de 484 Litros Marca: Whirlpool', 798.70, 'REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17\"', 1, '2024-06-18'),
(6, 'REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17\"', 'Modelo: WRE57BKTWW\r\nLa refrigeradora bottom mount de whirlpool modelo WRE57BKTWW cuenta con tecnología Xpert Inverter que te da mayor ahorro de energía y conservación de alimentos. Además tiene lámina anti huellas y capacidad de 484 Litros Marca: Whirlpool', 798.70, 'REFRIGERADORA BOTTOM MOUNT WHIRLPOOL 17\"', 2, '2024-06-18'),
(7, 'LAVADORA WHIRLPOOL IMPELLER 19KG', 'Modelo: WW19LTAHLA\r\nLa nueva lavadora Whirlpool WW19LTAHLA viene con un sistema de re-circulación Xpert CoverWash de Lavado Impeller mejorando el sistema intelicarga el cual podrás ahorrar hasta 24,000 litros de agua utilizando solo lo que necesitas dependiendo del tamaño de tu carga.\r\nCuenta con una garantía directamente de la marca de 10 años en el motor - 3 años en el panel', 490.49, 'lavadora', 1, '2024-06-18'),
(8, 'LAVADORA WHIRLPOOL IMPELLER 19KG', 'Modelo: WW19LTAHLA\r\nLa nueva lavadora Whirlpool WW19LTAHLA viene con un sistema de re-circulación Xpert CoverWash de Lavado Impeller mejorando el sistema intelicarga el cual podrás ahorrar hasta 24,000 litros de agua utilizando solo lo que necesitas dependiendo del tamaño de tu carga.\r\nCuenta con una garantía directamente de la marca de 10 años en el motor - 3 años en el panel', 490.49, 'lavadora', 1, '2024-06-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` int(11) DEFAULT 0,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `username`, `password`, `rol`, `imagen`) VALUES
(7, 'luis', NULL, 'luis@gmail.com', NULL, '$2y$10$T4P51c9h8NnG9BlSv./bs.UGpqHxRxEpj27qMM.Jv5/mLgDjvnun6', 1, NULL),
(8, 'carlos', 'andy', 'carlos@gmail.com', NULL, '$2y$10$qXjUnuBtR.AyGJ.mTXxOje66Knjbh7JTzzjZvUz2gZJX4Jon9wuoe', 1, NULL),
(13, 'jorge', 'lopez', 'jorge@gmail.com', 'jorgeeee', '$2y$10$qXnEv6b6PuPLZI0/.S65MeZ0.T1uU8al.xOc.MIdo9fgk5x1zHR66', 0, NULL),
(15, 'carlos', 'grefa', 'carlos.aldak12@gmail.com', 'carlos12', '$2y$10$ZXOTuIViAP9yNvBehb3e6eiqfZTLrXh3pxW7KxB4f/Dcj1i7bA3Iu', 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
