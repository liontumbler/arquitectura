INSERT INTO 
`plan` (`id`, `nombre`, `descripcion`, `trabajadores`, `numCampHora`, `ligas`, `tienda`, `pagos`, `productos`, `graficas`) 
VALUES (NULL, 'Dynamic', NULL, '4', '10', '500', '500', '500', '50', '0');

INSERT INTO 
`gimnasio` (`id`, `nombre`, `clave`, `color`, `background`, `direccion`, `telefono`, `descripcion`, `habilitado`, `minDeMasLiga`, `idPlan`) 
VALUES (NULL, 'Dynamic', '$2y$11$mjwkbMoRVY/tlZ9ttblRzOomcrFL2JhbGJRz1bpEPcrr9Pn/NtYHy', '#fff', '#000', NULL, '3102742576', NULL, '1', '5', '1');

INSERT INTO `trabajador` (`id`, `nombresYapellidos`, `nickname`, `documento`, `clave`, `claveCaja`, `idGimnasio`) 
VALUES (NULL, 'admin', 'admin@admin', '111000111', '$2y$11$mjwkbMoRVY/tlZ9ttblRzOomcrFL2JhbGJRz1bpEPcrr9Pn/NtYHy', '1234', '1');




INSERT INTO `trabajado` (`id`, `fechaInicio`, `fechaFin`, `iniciCaja`, `FinCaja`, `idGimnasio`, `idTrabajador`) 
VALUES (NULL, current_timestamp(), NULL, '500000', NULL, '1', '1');


SELECT * FROM `trabajado` 
WHERE `fechaInicio` > '2023-04-24 00:00:00' AND `fechaInicio` < '2023-04-24 23:59:59' 
AND `idGimnasio` = 1 
AND `idTrabajador` = 1 
AND fechaFin is null;