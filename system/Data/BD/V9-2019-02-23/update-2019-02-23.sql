/* ACTUALIZACIÓN PARA REFERENCIAS_TIPO_LLANTA - AHORA ESTA INCLUYE UNA RELACION A MARCA_LLANTA */
ALTER TABLE referencia_tipo_llanta
ADD COLUMN idMarcaLlanta int references marca_llanta(id) on delete restrict on update cascade;

-- MODIFICACIONES PARA RASPADO

alter table raspado
add column fechainicioproceso timestamp;

alter table raspado
add column fotoSerial text;

-- MODIFICACIONES PARA RASPADO
