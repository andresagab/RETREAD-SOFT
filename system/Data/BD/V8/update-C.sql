ALTER TABLE insumo_puestotrabajo drop column cantidad;
ALTER TABLE insumo_puestotrabajo add column cantidad double precision;

alter table uso_insumo_proceso_detalle add column cantidad double precision;

alter table bitacora add column sesion int;