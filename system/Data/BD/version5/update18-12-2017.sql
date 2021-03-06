-- create table referencia_gravado(
--     id serial primary key,
--     idGravadoLlanta int references gravado_llanta(id) on delete cascade on update cascade,
--     referencia text unique not null,
--     observaciones text,
--     fechaRegistro timeStamp not null
-- );
-- 
-- create table dimension_referencia(
--     id serial primary key,
--     idReferenciaGravado int references referencia_gravado(id) on delete cascade on update cascade,
--     base float not null,
--     profundidad float not null,
--     peso float not null,
--     largo float not null,
--     observaciones text,
--     fechaRegistro timeStamp not null
-- );

-- create table servicio(
--     id serial primary key,
--     idCliente int references cliente(id) on delete restrict on update cascade,
--     idVendedor int references empleado (id) on delete restrict on update cascade,
--     os text not null unique,
--     numeroFactura text,
--     observaciones text,
--     fechaRegistro timestamp not null
-- );
-- 
-- create table tipo_servicio(
--     id serial primary key,
--     nombre text not null unique,
--     observaciones text,
--     fechaRegistro timestamp not null
-- );
-- 
-- create table detalle_servicio(
--     id serial primary key,
--     idServicio int references servicio(id) on delete cascade on update cascade,
--     idTipoServicio int references tipo_servicio(id) on delete restrict on update cascade,
--     fechaRegistro timestamp not null
-- );
-- 
-- create table llanta(
-- 	id serial primary key,
-- 	idTipo int references tipo_llanta (id) on delete restrict on update cascade,
-- 	idMarca int references marca_llanta (id) on delete restrict on update cascade,
-- 	rp serial,
-- 	serie int,
-- 	idAplicacionOriginal int references dimension_referencia (id) on delete restrict on update cascade,
-- 	idAplicacionSolicitada int references dimension_referencia (id) on delete restrict on update cascade,
-- 	idAplicacionEntregada int references dimension_referencia (id) on delete restrict on update cascade,
-- 	urgente boolean not null,
-- 	procesado boolean not null,
-- 	observaciones text,
-- 	fechaRegistro timestamp not null
-- );
