INSERT INTO `plan` (`id`, `nombre`, `descripcion`, `trabajadores`, `numCampHora`, `ligas`, `tienda`, `pagos`, `productos`, `descuentos`, `equipos`) 
VALUES 
(NULL, 'Gratis', 'Gratis', '4', '10', '40', '40', '40', '50', '40', '15'),
(NULL, 'Standar', 'Standar', '10', '10', '95', '95', '95', '150', '95', '15'),
(NULL, 'Mega', 'Mega', '20', '20', '190', '190', '190', '300', '190', '25'),
(NULL, 'Iper', 'Iper', '20', '20', '380', '380', '380', '300', '380', '25'),
(NULL, 'Master', 'Master', '40', '40', '570', '570', '570', '400', '570', '45');

INSERT INTO `gimnasio` (`id`, `correo`, `nickname`, `nombre`, `clave`, `color`, `background`, `direccion`, `telefono`, `descripcion`, `habilitado`, `minDeMasLiga`, `idPlan`)
VALUES (NULL, 'lion_3214@hotmail.com', 'admin@admin', 'Liga Gim', '$2y$11$mjwkbMoRVY/tlZ9ttblRzOomcrFL2JhbGJRz1bpEPcrr9Pn/NtYHy', '#ffffff', '#000000', NULL, '3102742576', NULL, '1', '5', '1');

INSERT INTO `trabajador` (`id`, `nombresYapellidos`, `nickname`, `correo`, `documento`, `clave`, `claveCaja`, `idGimnasio`) 
VALUES (NULL, 'test', 'test@test', 'lion_3214@hotmail.com', '1033741932', '$2y$11$mjwkbMoRVY/tlZ9ttblRzOomcrFL2JhbGJRz1bpEPcrr9Pn/NtYHy', NULL, '1');

INSERT INTO `equipo` (`id`, `nombre`, `idGimnasio`) 
VALUES (NULL, 'BCA - extreme', '1'), (NULL, 'NPC', '1');

INSERT INTO `cliente` (`id`, `correo`, `telefono`, `nombresYapellidos`, `documento`, `idGimnasio`, `idEquipo`) 
VALUES (NULL, 'lion_3214@hotmail.com', '3102742576', 'edwin Velasquez', '1033741931', '1', '1');

INSERT INTO `horaliga` (`id`, `nombre`, `horas`, `precio`, `fecha`, `idGimnasio`) 
VALUES (NULL, '1H normal', '1.0', '7000', CURRENT_TIMESTAMP, '1');

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `precio`, `fecha`, `idGimnasio`) 
VALUES (NULL, 'Coca-cola 350ml', 'Bebida refrescante azucarada', '2800', CURRENT_TIMESTAMP, '1');







SELECT * FROM `trabajado` 
WHERE `fechaInicio` > '2023-04-24 00:00:00' AND `fechaInicio` < '2023-04-24 23:59:59' 
AND `idGimnasio` = 1 
AND `idTrabajador` = 1 
AND fechaFin is null;

INSERT INTO `tienda` (`id`, `cantidad`, `total`, `tipoPago`, `fecha`, `idProducto`, `idGimnasio`, `idTrabajado`, `idTrabajador`, `idCliente`) 
VALUES (NULL, '1', '100000', 'debe', CURRENT_TIMESTAMP, '1', '1', '1', '2', '1');

DELETE FROM `listapagos` WHERE pago = "Tienda"