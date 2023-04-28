INSERT INTO `plan` (`id`, `nombre`, `descripcion`, `trabajadores`, `numCampHora`, `ligas`, `tienda`, `pagos`, `productos`, `graficas`) 
VALUES (NULL, 'gratis', 'gratis', '4', '10', '500', '500', '500', '50', '0');

INSERT INTO `gimnasio` (`id`, `correo`, `nombre`, `clave`, `color`, `background`, `direccion`, `telefono`, `descripcion`, `habilitado`, `minDeMasLiga`, `idPlan`) 
VALUES (NULL, 'lion_3214@hotmail.com', 'gim test', '$2y$11$mjwkbMoRVY/tlZ9ttblRzOomcrFL2JhbGJRz1bpEPcrr9Pn/NtYHy', '#fff', '#000', NULL, '3102742576', NULL, '1', '5', '1');

INSERT INTO `trabajador` (`id`, `nombresYapellidos`, `nickname`, `correo`, `documento`, `clave`, `claveCaja`, `idGimnasio`) 
VALUES (NULL, 'test', 'test@test', 'lion_3214@hotmail.com', '1033741932', '$2y$11$mjwkbMoRVY/tlZ9ttblRzOomcrFL2JhbGJRz1bpEPcrr9Pn/NtYHy', NULL, '1');

INSERT INTO `equipo` (`id`, `nombre`) VALUES (NULL, 'N/A'), (NULL, 'BCA');

INSERT INTO `cliente` (`id`, `nombresYapellidos`, `documento`, `idGimnasio`, `idEquipo`) 
VALUES (NULL, 'Nicolás Cuadros', '1033741944', '1', '2');

INSERT INTO `horaliga` (`id`, `nombre`, `horas`, `precio`, `idGimnasio`) 
VALUES (NULL, '1 Hora', '1.0', '7000', '1');

INSERT INTO `producto` (`id`, `nombre`, `precio`, `idGimnasio`) 
VALUES (NULL, 'papa 35gr', '3500', '1');


SELECT * FROM `trabajado` 
WHERE `fechaInicio` > '2023-04-24 00:00:00' AND `fechaInicio` < '2023-04-24 23:59:59' 
AND `idGimnasio` = 1 
AND `idTrabajador` = 1 
AND fechaFin is null;

INSERT INTO `tienda` (`id`, `cantidad`, `total`, `tipoPago`, `fecha`, `idProducto`, `idGimnasio`, `idTrabajado`, `idTrabajador`, `idCliente`) 
VALUES (NULL, '1', '100000', 'debe', CURRENT_TIMESTAMP, '1', '1', '1', '2', '1');

DELETE FROM `listapagos` WHERE pago = "Tienda"