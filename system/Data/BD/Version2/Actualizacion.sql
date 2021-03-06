create table puc(
	id serial primary key,
	codigo varchar(30) unique not null,
	nombre varchar(50) not null,
	descripcion text,
	nivel int,
	fechaRegistro timestamp not null
);

create table unidad_medida(
	id serial primary key,
	nombre varchar(50) unique not null,
	sigla varchar(10) unique not null,
	descripcion text,
	fechaRegistro timestamp not null
);

create table presentacion_producto(
	id serial primary key,
	nombre varchar(50) not null,
	descripcion text,
	fechaRegistro timestamp not null
);

create table tercero(
	id serial primary key,
	codPuc varchar(30) references puc (codigo) on delete restrict on update cascade,
	idCliente int references cliente (id) on delete cascade on update cascade,
	fechaRegistro timestamp not null
);

create table producto(
	id serial primary key,
	codPuc varchar(30) references puc (codigo) on delete restrict on update cascade,
	idPresentacion int references presentacion_producto (id) on delete restrict on update cascade null,
	idUnidadMedida int references unidad_medida (id) on delete restrict on update cascade,
	idProvedor int references tercero(id) on delete cascade on update cascade,
	stock float not null,
	stockMinimo int not null,
	stockMaximo int null,
	foto text null,
	costo int not null,
	ingredientes boolean null,
	tipo varchar(1) null,
	fechaRegistro timestamp not null
);
