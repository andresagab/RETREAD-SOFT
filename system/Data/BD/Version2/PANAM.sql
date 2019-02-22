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

create table rol(
	id serial primary key,
	nombre varchar(30) not null unique,
	estado boolean not null,
	fechaRegistro timestamp not null
);

create table opcion(
	id serial primary key,
	idMenu int references opcion(id) on delete cascade on update cascade,
	nombre varchar(50) not null,
	ruta varchar(100),
	descripcion text,
	fechaRegistro timestamp not null
);

create table rol_accesos(
	id serial primary key,
	idOpcion int references opcion(id) on delete restrict on update cascade,
	idRol int references rol(id) on delete restrict on update cascade,
	orden int,
	fechaRegistro timestamp not null
);

create table usuario(
	id serial primary key,
	usuario varchar(30) not null unique,
	clave varchar(35) not null,--Las contraseñas manejara metodo de encriptacion md5---
	idRol int references rol(id) on delete restrict on update cascade,
	estado boolean not null,
	fechaRegistro timestamp not null
);

create table persona(
	identificacion varchar(20) primary key,
	nombres varchar(50) not null,
	apellidos varchar(50),
	email varchar(50),
	fechaNacimiento date,
	fechaRegistro timestamp not null
);

create table usuario_persona(
	id serial primary key,
	identificacion varchar(20) references persona(identificacion) on delete restrict on update cascade,
	idUsuario int references usuario(id) on delete restrict on update cascade,
	fechaRegistro timestamp not null
);

create table telefono_persona(
	id serial primary key,
	identificacion varchar(20) references persona(identificacion) on delete restrict on update cascade,
	numero varchar(20) not null,
	extension varchar(5),
	tipo varchar(3) not null,
	fechaRegistro timestamp not null
);

create table cliente(
	id serial primary key,
	identificacion varchar(20) references persona(identificacion) on delete restrict on update cascade,
	nit varchar(20),
	razonsocial varchar(50),
	direccion varchar(100),
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

create table cargo_empleado(
	id serial primary key,
	nombre varchar(50) not null,
	descripcion text,
	fechaRegistro timestamp not null
);

create table empleado(
	id serial primary key,
	identificacion varchar(20) references persona(identificacion) on delete restrict on update cascade,
	idCargo int references cargo_empleado(id) on delete restrict on update cascade,
	fechaRegistro timestamp not null
);

create table tipo_llanta(
	id serial primary key,
	nombre varchar(50) not null unique,
	descripcion text,
	fechaRegistro timestamp not null
);

create table marca_llanta(
	id serial primary key,
	nombre varchar(50) not null unique,
	descripcion text,
	fechaRegistro timestamp not null
);

create table llanta(
	id serial primary key,
	idCliente int references cliente(id) on delete restrict on update cascade,
	idTipo int references tipo_llanta(id) on delete restrict on update cascade,
	idMarca int references marca_llanta(id) on delete restrict on update cascade,
	dimension varchar(50) not null,
	serie int,
	diseno varchar(50),
	rp serial,
	observaciones text,
	procesado boolean not null,
	fechaRegistro timestamp not null
);

create table servicio(
	id serial primary key,
	idLlanta int references llanta(id) on delete restrict on update cascade,
	observaciones text,
	os varchar(20) not null
	--serie int,--
	fechaRegistro timestamp not null
);

create table inspeccion_inicial(
	id serial primary key,
	idServicio int references servicio(id) on delete restrict on update cascade,
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion--
	numeroRencauche serial,
	codInspeccion int references inspeccion_inicial(id) null,
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table raspado(
	id serial primary key,
	idInspeccion int references inspeccion_inicial(id) on delete restrict on update cascade,
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	anchoBanda varchar(15) not null,
	largoBanda varchar(15) not null,
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table preparacion(
	id serial primary key,
	idRaspado int references raspado(id) on delete restrict on update cascade,
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table reparacion(
	id serial primary key,
	idPreparacion int references preparacion(id) on delete restrict on update cascade,
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table parche_llanta(
	id serial primary key,
	nombre varchar(50) not null,
	descripcion text,
	fechaRegistro timestamp not null
);

create table reparacion_parche(
	id serial primary key,
	idReparacion int references reparacion(id) on delete restrict on update cascade,
	idParche int references parche_llanta(id) on delete restrict on update cascade,
	cantidad int not null,
	fechaRegistro timestamp not null
	
);

create table cementado(
	id serial primary key,
	idReparacion int references reparacion(id) on delete restrict on update cascade,
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table relleno(
	id serial primary key,
	idCemnetado int references cementado(id) on delete restrict on update cascade,
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	empates int,
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table embandado(
	id serial primary key,
	idRelleno int references relleno(id) on delete restrict on update cascade,
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	empates int,
	anchoBanda varchar(15) not null,
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table vulcanizado(
	id serial primary key,
	idEmbandado int references embandado(id) on delete restrict on update cascade,
	idEmpleado_Enrinador int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table inspeccion_final(
	id serial primary key,
	idVulcanizado int references vulcanizado(id) on delete restrict on update cascade,
	idEmpleado_Enrinador int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table terminacion(
	id serial primary key,
	idInspeccion_final int references inspeccion_final(id) on delete restrict on update cascade,
	idEmpleado_Enrinador int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	idEmpleado int references empleado(id) on delete restrict on update cascade,--Campo para registrar el operario responsable de la inspeccion --
	observaciones text,
	checked boolean not null,
	estado varchar(3) not null,
	fechaRegistro timestamp not null
);

create table servicio_fin(
	id serial primary key,
	idServicio int references servicio(id) on delete restrict on update cascade,
	estado varchar(3) not null,
	observaciones text,
	fechaRegistro timestamp not null
);





















