create table categoria_producto(
        id serial primary key,
        idCategoria int references categoria_producto(id) on delete restrict on update cascade null,
        nombre text unique not null,
        fechaRegistro timestamp not null
);

alter table producto add column idCategoria int references categoria_producto(id) on delete restrict on update cascade;

alter table categoria_producto add column descripcion text null;

alter table categoria_producto add column imagen text null;