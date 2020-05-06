--ESTRUCTURA DADA POR PHPMYADMIN





-- Estructura de tabla para la tabla `incidente`
--
DROP TABLE IF EXISTS incidente;
CREATE TABLE `incidente` (
  `idLugar` int(11) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--
DROP TABLE IF EXISTS lugar;
CREATE TABLE `lugar` (
  `idLugar` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`idLugar`, `nombre`) VALUES
(1, 'Centro Turístico'),
(2, 'Laboratorios'),
(3, 'Restaurante'),
(4, 'Centro Operativo'),
(5, 'Triceraptops'),
(6, 'Dilofosaurios'),
(7, 'Velociraptors'),
(8, 'TRex'),
(9, 'Planicie de los herbívoros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_incidente`
--
DROP TABLE IF EXISTS tipo_incidente;
CREATE TABLE `tipo_incidente` (
  `idTipo` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_incidente`
--

INSERT INTO `tipo_incidente` (`idTipo`, `nombre`) VALUES
(1, 'Falla Eléctrica'),
(2, 'Fuga Herbívoro'),
(3, 'Fuga velociraptors'),
(4, 'Fuga de TRex'),
(5, 'Robo de ADN'),
(6, 'Auto Descompuesto'),
(7, 'Visitantes en zona no autorizada');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `incidente`
--
ALTER TABLE `incidente`
  ADD PRIMARY KEY (`fecha`),
  ADD KEY `idLugar` (`idLugar`),
  ADD KEY `idTipo` (`idTipo`);


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `incidente`
--
ALTER TABLE `incidente`
  ADD CONSTRAINT `incidente_ibfk_1` FOREIGN KEY (`idTipo`) REFERENCES `tipo_incidente` (`idTipo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `incidente_ibfk_2` FOREIGN KEY (`idLugar`) REFERENCES `lugar` (`idLugar`) ON UPDATE CASCADE;
COMMIT;

