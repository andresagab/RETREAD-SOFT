insert into rol (nombre, estado, fechaRegistro) values ('Desarrollador', 't', now());
insert into rol (nombre, estado, fechaRegistro) values ('Administrador', 't', now());
insert into rol (nombre, estado, fechaRegistro) values ('Jefe de planta', 't', now());
insert into rol (nombre, estado, fechaRegistro) values ('Operario', 't', now());
insert into rol (nombre, estado, fechaRegistro) values ('Operario CB', 't', now());
insert into rol (nombre, estado, fechaRegistro) values ('Bodega', 't', now());
insert into usuario (usuario, clave, idrol, estado, fechaRegistro) values ('admin', md5('12345'), 1, 't', now());

INSERT INTO opcion VALUES (1, NULL, '<span class="fa fa-gear"></span>', NULL, 'Configuracion', now());
INSERT INTO opcion VALUES (2, NULL, '<span class="fa fa-list"></span>', NULL, 'Informes', now());
INSERT INTO opcion VALUES (3, 2, 'Bodega', 'system/Pages/informeBodega.php', '', now());
INSERT INTO opcion VALUES (4, 1, 'Cargos empleado', 'system/Pages/cargosEmpleado.php', '', now());
INSERT INTO opcion VALUES (5, 1, 'Gravados de llanta', 'system/Pages/gravadosLlanta.php', '', now());
INSERT INTO opcion VALUES (6, 1, 'Puestos de trabajo', 'system/Pages/puestosTrabajo.php', '', now());
INSERT INTO opcion VALUES (7, 1, 'Unidades de medida', 'system/Pages/unidadesMedida.php', '', now());
INSERT INTO opcion VALUES (8, 1, 'Presentaciones de producto', 'system/Pages/presentacionesProducto.php', '', now());
INSERT INTO opcion VALUES (9, 1, 'Marcas de llanta', 'system/Pages/marcasLlantas.php', '', now());
INSERT INTO opcion VALUES (10, 1, 'Marcas de vehiculos', 'system/Pages/marcasVehiculo.php', '', now());
INSERT INTO opcion VALUES (11, 1, 'Tipos de llanta', 'system/Pages/tiposLlantas.php', '', now());
INSERT INTO opcion VALUES (12, 1, 'Rechazos', 'system/Pages/rechazos.php', '', now());
INSERT INTO opcion VALUES (13, 1, 'Tipos de servicio', 'system/Pages/tiposServicio.php', '', now());
INSERT INTO opcion VALUES (14, 1, 'Dimensiones de llantas', 'system/Pages/dimensionesLlanta.php', '', now());
INSERT INTO opcion VALUES (15, NULL, 'Funcionarios', 'system/Pages/empleados.php', '', now());
INSERT INTO opcion VALUES (16, NULL, 'Clientes', 'system/Pages/clientes.php', '', now());
INSERT INTO opcion VALUES (17, NULL, 'Kardex', 'system/Pages/categoriasProducto.php', '', now());
INSERT INTO opcion VALUES (18, NULL, 'Ordenes de servicio', 'system/Pages/ordenesServicio.php', '', now());
INSERT INTO opcion VALUES (19, 2, 'Rencauche', 'system/Pages/informeRencauche.php', '', now());
INSERT INTO opcion VALUES (20, NULL, 'Cortes de banda', 'system/Pages/cortesBandas.php', '', now());
INSERT INTO opcion VALUES (21, 2, 'Insumos y Herramientas', 'system/Pages/informeInsumos.php', '', now());
INSERT INTO opcion VALUES (22, NULL, 'Facturacion', 'system/Pages/facturacion.php', '', now());

SELECT pg_catalog.setval('opcion_id_seq', 22, false);

INSERT INTO gravado_llanta VALUES (1, 'Direccional', '', now());
INSERT INTO gravado_llanta VALUES (2, 'Mixta', '', now());
INSERT INTO gravado_llanta VALUES (3, 'Traccion', '', now());
INSERT INTO gravado_llanta VALUES (4, 'OTR', '', now());

SELECT pg_catalog.setval('gravado_llanta_id_seq', 4, false);

INSERT INTO rechazo VALUES (1, 'Lonas expuestas', '', now());
INSERT INTO rechazo VALUES (2, 'Separacion de lonas en la corona', '', now());
INSERT INTO rechazo VALUES (3, 'Separacion de lonas en los costados', '', now());
INSERT INTO rechazo VALUES (4, 'Hombros o carcasa soplada', '', now());
INSERT INTO rechazo VALUES (5, 'Reparacion cerca a la pestana', '', now());
INSERT INTO rechazo VALUES (6, 'Area pestana deteriorada', '', now());
INSERT INTO rechazo VALUES (7, 'Alambres pestana expuestos', '', now());
INSERT INTO rechazo VALUES (8, 'Reparacion fuera de limite permitido', '', now());
INSERT INTO rechazo VALUES (9, 'Contaminada con aceites o solventes', '', now());
INSERT INTO rechazo VALUES (10, 'Cortes radiales', '', now());
INSERT INTO rechazo VALUES (11, 'Lonas fatigadas internamente', '', now());
INSERT INTO rechazo VALUES (12, 'Rodada a baja presion', '', now());
INSERT INTO rechazo VALUES (13, 'Exceso de ponchaduras por clavo', '', now());
INSERT INTO rechazo VALUES (14, 'Oxidacion entre cinturones', '', now());
INSERT INTO rechazo VALUES (15, 'Separacion entre cinturones', '', now());
INSERT INTO rechazo VALUES (16, 'Motivos administrativos', '', now());

SELECT pg_catalog.setval('rechazo_id_seq', 16, false);

INSERT INTO tipo_servicio VALUES (1, 'Servicio de rencauche', '', now());
INSERT INTO tipo_servicio VALUES (2, 'Compra de cascos', '', now());
INSERT INTO tipo_servicio VALUES (3, 'Reparacion', '', now());
INSERT INTO tipo_servicio VALUES (4, 'Garantia de servicio', '', now());
INSERT INTO tipo_servicio VALUES (5, 'Garantia panam', '', now());

SELECT pg_catalog.setval('tipo_servicio_id_seq', 5, false);

INSERT INTO presentacion_producto VALUES (1, 'No definido', null, now());
INSERT INTO unidad_medida VALUES (1, 'No definido', 'ND', null, now());
INSERT INTO marca_llanta VALUES (1, 'No definido', null, now());
INSERT INTO marca_vehiculo VALUES (1, 'No definido', null, now());
INSERT INTO tipo_llanta VALUES (1, 'Radial', null, now());
INSERT INTO tipo_llanta VALUES (2, 'Convencional', null, now());

insert into referencia_tipo_llanta (idtipollanta, referencia, fecharegistro) VALUES
(1, 'IDE2', now()),
(1, 'I711', now()),
(1, 'I729', now()),
(1, 'L726', now()),
(1, 'IZT', now()),
(1, 'IT4', now()),
(1, 'LZL', now()),
(1, 'IZL', now()),
(1, 'IZA', now()),
(1, 'LT+1', now()),
(1, 'LZE2', now()),
(1, 'LZA+1', now()),
(1, 'IZH', now()),
(1, 'IZHL', now()),
(1, 'L840', now()),
(1, 'I840L', now()),
(1, 'LZY3', now()),
(1, 'I85', now()),
(1, 'ITX2', now()),
(1, 'IDY3', now()),
(1, 'IDY', now()),
(1, 'LZY2', now()),
(1, 'IZY2', now()),
(1, 'IDA', now()),
(1, 'L86', now()),
(1, 'I86', now()),
(1, 'LTE2', now()),
(2, 'TX', now()),
(2, 'TXX', now()),
(2, 'IMB', now()),
(2, 'IRP', now()),
(2, 'I88', now()),
(2, 'IHR', now()),
(2, 'IZB OTR', now()),
(2, 'I78', now()),
(2, 'CTR', now()),
(2, 'TUK', now()),
(2, 'IZB', now()),
(2, 'ZYK', now()),
(2, 'ZZY', now()),
(2, 'LWX', now()),
(2, 'RIB', now());

INSERT INTO dimension_referencia (idreferenciatipollanta, base, profundidad, peso, largo, fecharegistro) values
  (1, 190, 14.0, 3.0, -11.03, now()),
  (1, 220, 22.0, 5.16, -11.07, now()),
  (1, 235, 22.0, 5.60, -11., now()),
  (1, 245, 22.5, 5.94, -11., now()),
  (1, 255, 22.5, 5.93, -11., now()),
  (1, 265, 22.5, 6.51, -11., now()),
  (2, 200, 21.0, 4.21, -11.09, now()),
  (2, 210, 21.0, 4.40, -11.03, now()),
  (2, 220, 21.0, 4.69, -11.05, now()),
  (2, 230, 21.0, 3.13, -11.00, now()),
  (2, 235, 21.0, 4.95, -11.09, now()),
  (3, 170, 13.0, 0, -11.00, now()),
  (3, 220, 18.0, 4.48, -11.02, now()),
  (3, 235, 19.0, 5.02, -11.11, now()),
  (3, 265, 21.0, 6.30, -11.08, now()),
  (4, 220, 22.0, 5.12, -3.23, now()),
  (5, 180, 17.0, 3.28, -11.08, now()),
  (5, 190, 17.5, 0, -11.00, now()),
  (5, 255, 20.0, 5.20, -11.00, now()),
  (6, 220, 17.5, 4.02, -10.96, now()),
  (6, 235, 19.0, 4.91, -3.41, now()),
  (6, 255, 19.0, 5.08, -3.37, now()),
  (7, 250, 16.0, 4.72, -10.90, now()),
  (7, 260, 16.0, 4.79, -10.56, now()),
  (8, 190, 15.5, 3.47, -11.06, now()),
  (8, 200, 15.5, 3.54, -11.00, now()),
  (8, 210, 15.5, 3.89, -11.05, now()),
  (8, 220, 16.0, 4.26, -11.00, now()),
  (8, 235, 16.0, 4.32, -10.96, now()),
  (8, 255, 17.0, 5.13, -10.95, now()),
  (8, 265, 17.5, 5.40, 0, now()),
  (8, 245, 17, 4.80, 0, now()),
  (9, 190, 14.0, 3.12, -10.71, now()),
  (9, 200, 14.0, 3.32, -11.00, now()),
  (9, 210, 14.0, 3.49, -11.00, now()),
  (9, 220, 14.0, 3.66, -10.90, now()),
  (9, 235, 14.0, 3.86, -3.42, now()),
  (9, 245, 14.0, 4.12, -3.42, now()),
  (9, 255, 14.0, 4.46, -11.05, now()),
  (10, 195, 11.0, 2.83, -11.00, now()),
  (10, 200, 11.0, 2.85, -11.00, now()),
  (10, 215, 11.0, 3.11, -11.00, now()),
  (10, 220, 11.0, 3.15, -11.00, now()),
  (10, 230, 11.0, 3.38, -11.00, now()),
  (10, 240, 11.0, 3.68, -11.00, now()),
  (11, 250, 17.0, 5.00, -10.88, now()),
  (11, 260, 17.0, 5.06, -3.31, now()),
  (12, 20, 14.0, 3.79, -10.64, now()),
  (12, 220, 14.0, 3.78, -10.64, now()),
  (12, 235, 16.0, 3.84, -10.83, now()),
  (13, 235, 24.0, 5.85, -11.11, now()),
  (13, 245, 24.0, 6.10, -11.10, now()),
  (13, 255, 25.5, 6.42, -11.02, now()),
  (14, 220, 21.0, 5.03, -11.08, now()),
  (14, 235, 21.0, 5.37, -11.03, now()),
  (14, 245, 21.0, 5.64, -10.90, now()),
  (15, 250, 18.0, 5.16, -10.98, now()),
  (16, 210, 15.0, 3.65, -11.10, now()),
  (16, 220, 15.0, 3.82, -11.00, now()),
  (16, 230, 15.0, 3.90, -11.04, now()),
  (17, 325, 19.0, 7.00, -11.00, now()),
  (17, 350, 19.0, 7.17, -10.87, now()),
  (18, 328, 16.0, 5.82, -10.98, now()),
  (19, 190, 12.0, 2.59, -11.00, now()),
  (19, 220, 12.0, 2.98, -11.00, now()),
  (20, 220, 21.0, 0, -11.00, now()),
  (20, 235, 21.0, 5.33, -11.00, now()),
  (20, 245, 21.0, 5.66, -11.00, now()),
  (20, 255, 21.0, 5.78, -11.00, now()),
  (20, 265, 21.0, 5.93, -11.00, now()),
  (21, 200, 21.5, 4.55, -11.08, now()),
  (21, 210, 22.0, 4.81, -11.12, now()),
  (21, 220, 22.0, 5.08, -11.07, now()),
  (21, 235, 22.0, 5.49, -11.02, now()),
  (21, 245, 22.0, 5.70, -11.10, now()),
  (22, 250, 18.5, 5.45, -10.94, now()),
  (23, 20, 18.5, 4.02, -3.24, now()),
  (23, 210, 18.5, 4.12, -3.30, now()),
  (23, 220, 18.5, 4.54, -11.07, now()),
  (23, 235, 18.5, 4.81, -11.05, now()),
  (23, 245, 18.5, 5.08, -11.07, now()),
  (23, 255, 18.5, 5.34, -11.06, now()),
  (23, 265, 18.5, 5.57, -11.03, now()),
  (24, 210, 18.0, 4.24, -11.07, now()),
  (24, 220, 18.0, 4.46, -11.05, now()),
  (24, 230, 18.0, 4.60, -11.01, now()),
  (24, 235, 18.0, 5.03, -11.10, now()),
  (25, 260, 17.5, 5.24, -4.00, now()),
  (26, 190, 16.0, 3.50, -11.09, now()),
  (26, 210, 16.0, 3.70, -10.97, now()),
  (26, 220, 16.0, 3.83, -11.01, now()),
  (26, 235, 16.0, 4.08, -11.07, now()),
  (26, 245, 17.5, 4.64, -10.98, now()),
  (26, 255, 19.0, 5.17, -10.97, now()),
  (27, 325, 17.0, 6.87, -10.88, now()),
  (27, 350, 17.0, 7.69, -11.00, now()),
  (28, 140, 11.0, 1.94, -3.56, now()),
  (28, 160, 12.5, 2.34, -3.66, now()),
  (28, 180, 14.0, 2.86, -10.98, now()),
  (28, 190, 14.0, 3.20, -3.11, now()),
  (28, 200, 14.0, 3.34, -3.20, now()),
  (28, 220, 14.0, 4.24, -3.23, now()),
  (28, 235, 17.5, 4.94, -3.35, now()),
  (29, 160, 12.5, 2.25, -11.02, now()),
  (29, 190, 16.0, 3.42, -10.98, now()),
  (29, 200, 17.0, 3.68, -11.05, now()),
  (29, 220, 19.0, 4.38, -11.08, now()),
  (30, 150, 11.0, 2.05, -3.71, now()),
  (30, 160, 11.0, 2.14, -3.65, now()),
  (30, 190, 12.0, 2.80, -3.13, now()),
  (30, 200, 12.0, 2.92, -3.35, now()),
  (30, 220, 12.0, 3.62, -3.39, now()),
  (31, 190, 12.5, 2.61, -11.00, now()),
  (31, 180, 12.5, 2.80, -10.91, now()),
  (31, 210, 12.5, 3.22, -10.93, now()),
  (31, 220, 14.0, 3.78, -10.98, now()),
  (31, 235, 16.0, 4.27, -10.94, now()),
  (31, 245, 16.0, 4.48, -3.42, now()),
  (31, 255, 16.0, 4.95, -3.42, now()),
  (31, 305, 8.8, 3.68, -4.12, now()),
  (32, 235, 22.0, 5.32, -10.98, now()),
  (32, 255, 25.5, 6.72, -3.43, now()),
  (32, 265, 25.5, 6.76, -3.49, now()),
  (33, 255, 24.0, 6.72, -3.45, now()),
  (33, 235, 22.0, 5.64, -11.13, now()),
  (34, 235, 24.0, 5.88, -10.98, now()),
  (34, 255, 24.0, 6.51, -3.46, now()),
  (35, 350, 24.0, 8.49, -3.50, now()),
  (36, 125, 9.0, 1.37, -3.79, now()),
  (36, 140, 11.0, 1.71, -3.69, now()),
  (37, 130, 12.5, 1.84, -11.12, now()),
  (37, 140, 13.5, 2.14, -11.10, now()),
  (37, 150, 14.0, 2.48, -11.06, now()),
  (37, 160, 15.0, 2.72, -11.12, now()),
  (37, 170, 15.0, 2.88, -11.11, now()),
  (37, 180, 17.5, 3.54, -11.08, now()),
  (37, 190, 17.5, 3.62, -11.08, now()),
  (37, 200, 17.5, 3.92, -11.10, now()),
  (37, 210, 17.5, 4.04, -11.10, now()),
  (37, 220, 19.0, 4.48, -11.10, now()),
  (37, 235, 20.5, 5.14, -11.04, now()),
  (38, 180, 16.0, 3.48, -10.86, now()),
  (38, 190, 16.0, 3.65, -11.01, now()),
  (38, 200, 16.0, 3.95, -10.97, now()),
  (38, 210, 17.5, 4.00, -11.02, now()),
  (38, 220, 19.0, 4.40, -10.98, now()),
  (38, 235, 19.0, 4.72, -11.01, now()),
  (39, 150, 15.0, 2.54, -11.06, now()),
  (39, 160, 15.0, 2.68, -11.07, now()),
  (39, 170, 15.0, 2.82, -11.08, now()),
  (39, 180, 17.5, 3.36, -11.16, now()),
  (39, 190, 17.5, 3.65, -11.06, now()),
  (39, 200, 17.5, 3.86, -11.10, now()),
  (39, 210, 17.5, 4.03, -11.10, now()),
  (40, 190, 14.0, 3.08, -10.10, now()),
  (40, 200, 16.0, 3.72, -11.06, now()),
  (40, 210, 16.0, 3.67, -10.99, now()),
  (40, 220, 16.0, 3.74, -11.05, now()),
  (40, 230, 16.0, 4.15, -11.04, now()),
  (40, 235, 16.0, 4.36, -11.04, now()),
  (40, 245, 16.0, 4.34, -11.00, now()),
  (41, 160, 14.0, 2.54, -11.06, now()),
  (41, 170, 14.0, 2.68, -11.07, now()),
  (41, 180, 17.5, 3.30, -3.21, now()),
  (41, 190, 17.5, 3.60, -11.04, now()),
  (41, 200, 17.5, 3.90, -11.05, now()),
  (41, 210, 17.5, 3.88, -10.95, now()),
  (41, 220, 19.5, 4.38, -10.92, now()),
  (41, 235, 19.5, 4.52, -11.05, now()),
  (42, 180, 11.0, 2.27, -3.66, now());
