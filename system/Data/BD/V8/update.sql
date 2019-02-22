--ALTER TABLE dimension_llanta DROP COLUMN ancho;
--ALTER TABLE dimension_llanta DROP COLUMN perfil;
--ALTER TABLE dimension_llanta DROP COLUMN diametro;
--ALTER TABLE dimension_llanta ADD COLUMN dimension text NOT NULL;

--ALTER TABLE servicio ADD COLUMN fechaRecoleccion date;

--ALTER TABLE llanta ADD COLUMN idReferenciaOriginal int REFERENCES referencia_tipo_llanta(id) ON DELETE RESTRICT ON UPDATE CASCADE;
--ALTER TABLE llanta ADD COLUMN idReferenciaSolicitada int REFERENCES referencia_tipo_llanta(id) ON DELETE RESTRICT ON UPDATE CASCADE;
--ALTER TABLE llanta ADD COLUMN idDimension INT REFERENCES dimension_llanta(id) ON DELETE RESTRICT ON UPDATE CASCADE;
--ALTER TABLE llanta ADD COLUMN consecutivo INT;

--create table salida_llanta(
  --id serial primary key,
  --idLlanta int not null unique references llanta(id) on delete restrict on update cascade,
  --valor text not null,
  --fechaRegistro timestamp not null
--);

--alter table inspeccion_inicial drop column numerorencauche;
--alter table inspeccion_inicial add column numerorencauche int;

--create table registro_banda(
--  id serial primary key,
--  idPreparacion int not null unique references preparacion(id) on delete restrict on update cascade,
--  idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
--  estado boolean not null,
--  idGravado int references gravado_llanta(id) on delete restrict on update cascade,
--  anchoBanda float,
--  largoBanda float,
--  empates int,
--  observaciones text,
--  fechaRegistro timestamp not null
--);
