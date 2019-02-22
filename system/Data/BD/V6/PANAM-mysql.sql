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
    clave varchar(35) not null,
    idRol int references rol(id) on delete restrict on update cascade,
    estado boolean not null,
    fechaRegistro timestamp not null
);

create table bitacora(
    id serial primary key,
    usuario varchar (30) references usuario(usuario) on delete restrict on update cascade,
    suceso varchar(1) not null,
    ip varchar(30) not null,
    detalles text,
    registroAnterior text,
    fechaRegistro timestamp
);

create table persona(
    identificacion varchar(20) primary key,
    nombres varchar(50) not null,
    apellidos varchar(50),
    celular varchar(15) not null,
    email varchar(50),
    direccion text,
    fechaNacimiento date,
    fechaRegistro timestamp not null
);

create table contacto_persona(
    id serial primary key,
    identificacionPersona varchar(20) references persona(identificacion) on delete cascade on update cascade,
    nombres varchar(50) not null,
    apellidos varchar(50) not null,
    telefono varchar(15),
    celular varchar(15),
    direccion varchar(100),
    fechaRegistro timeStamp not null
);


create table dimension_llanta(
    id serial primary key,
    ancho float not null,
    perfil int not null,
    diametro float not null,
    descripcion text,
    fechaRegistro timestamp not null
);

create table marca_vehiculo(
    id serial primary key,
    nombre varchar(50) not null unique,
    descripcion text,
    fechaRegistro timeStamp not null
);

create table vehiculo(
    id serial primary key,
    identificacion varchar(20) references persona(identificacion) on delete restrict on update cascade,
    idMarcaVehiculo int references marca_vehiculo on delete restrict on update cascade,
    placa varchar(10) not null unique,
    linea varchar(20),
    modelo varchar(30),
    clase varchar(30),
    combustible int not null,
    numeroLlantas int not null,
    idDimension int references dimension_llanta(id) on delete restrict on update cascade,
    fechaRegistro timeStamp not null
);

create table soat(
    id serial primary key,
    idVehiculo int references vehiculo(id) on delete restrict on update cascade,
    fechaInicioVigencia date not null,
    fechaFinVigencia date not null,
    fechaRegistro timeStamp not null
);

create table revision_tecnomecanica(
    id serial primary key,
    idVehiculo int references vehiculo(id) on delete restrict on update cascade,
    fechaExpedicion date not null,
    fechaFinVigencia date not null,
    fechaRegistro timeStamp not null
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
    fechaRegistro timestamp not null
);

create table tercero(
    id serial primary key,
    codPuc varchar(30) references puc (codigo) on delete restrict on update cascade,
    idCliente int references cliente (id) on delete cascade on update cascade,
    fechaRegistro timestamp not null
);

create table categoria_producto(
    id serial primary key,
    idCategoria int references categoria_producto(id) on delete restrict on update cascade,
    nombre varchar(100) unique not null,
    descripcion text,
    imagen text,
    fechaRegistro timeStamp not null
);

create table producto(
    id serial primary key,
    codPuc varchar(30) references puc (codigo) on delete restrict on update cascade,
    idCategoria int references categoria_producto (id) on delete restrict on update cascade,
    idPresentacion int references presentacion_producto (id) on delete restrict on update cascade,
    idUnidadMedida int references unidad_medida (id) on delete restrict on update cascade,
    idProvedor int references tercero(id) on delete cascade on update cascade,
    grupo int,
    stock float not null,
    stockMinimo int not null,
    stockMaximo int null,
    peso float,
    foto text,
    costo int not null,
    ingredientes boolean,
    tipo varchar(1) null,
    fechaRegistro timestamp not null
);

create table cargo_empleado(
    id serial primary key,
    nombre varchar(50) not null unique,
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


create table gravado_llanta(
    id serial primary key,
    nombre varchar(50) not null,
    descripcion text,
    fechaRegistro timestamp not null
);

create table referencia_gravado(
    id serial primary key,
    idGravadoLlanta int references gravado_llanta(id) on delete cascade on update cascade,
    referencia varchar(30) unique not null,
    observaciones text,
    fechaRegistro timeStamp not null
);

create table dimension_referencia(
    id serial primary key,
    idReferenciaGravado int references referencia_gravado(id) on delete cascade on update cascade,
    base float not null,
    profundidad float not null,
    peso float not null,
    largo float not null,
    observaciones text,
    fechaRegistro timeStamp not null
);

create table servicio(
    id serial primary key,
    idCliente int references cliente(id) on delete restrict on update cascade,
    idVendedor int references empleado (id) on delete restrict on update cascade,
    os varchar(100) not null unique,
    numeroFactura text,
    observaciones text,
    fechaRegistro timestamp not null
);

create table tipo_servicio(
    id serial primary key,
    nombre varchar(80) not null unique,
    observaciones text,
    fechaRegistro timestamp not null
);

create table detalle_servicio(
    id serial primary key,
    idServicio int references servicio(id) on delete cascade on update cascade,
    idTipoServicio int references tipo_servicio(id) on delete restrict on update cascade,
    fechaRegistro timestamp not null
);

create table llanta(
    id serial primary key,
    idTipo int references tipo_llanta (id) on delete restrict on update cascade,
    idMarca int references marca_llanta (id) on delete restrict on update cascade,
    serie int,
    idAplicacionOriginal int references dimension_referencia (id) on delete restrict on update cascade,
    idAplicacionSolicitada int references dimension_referencia (id) on delete restrict on update cascade,
    idAplicacionEntregada int references dimension_referencia (id) on delete restrict on update cascade,
    urgente boolean not null,
    procesado boolean not null,
    observaciones text,
    fechaRegistro timestamp not null
);

create table inspeccion_inicial(
    id serial primary key,
    idLlanta int references llanta(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null
);

create table rechazo(
    id serial primary key,
    nombre varchar(50) not null unique,
    observaciones text,
    fechaRegistro timestamp not null
);

create table rechazo_inspeccion_inicial(
    id serial primary key,
    idInspeccionInicial int unique references inspeccion_inicial(id) on delete cascade on update cascade,
    observaciones text,
    fechaRegistro timestamp not null
);

create table rii_detalles(
    id serial primary key,
    idRii int references rechazo_inspeccion_inicial (id) on delete cascade on update cascade,
    idRechazo int references rechazo(id) on delete restrict on update cascade,
    fechaRegistro timestamp not null	
);

create table raspado(
    id serial primary key,
    idInspeccion int references inspeccion_inicial(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    anchoBanda float not null,
    largoBanda float not null,
    cinturon boolean not null,
    cinturonCantidad int not null,
    profundidad float,
    radio float,
    estado varchar(3) not null,
    checked boolean not null,
    foto text,
    observaciones text,
    fechaRegistro timestamp not null
);

create table puesto_trabajo(
    id serial primary key,
    nombre varchar(30) not null unique,
    proceso int not null,
    fechaRegistro timestamp not null
);

create table insumo_puestotrabajo(
    id serial primary key,
    idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
    idInsumo int references producto(id) on delete restrict on update cascade,
    usuario varchar(30) references usuario(usuario) on delete restrict on update cascade,
    cantidad int,
    estado boolean not null,
    fechaRegistro timestamp not null
);

create table carga_producto(
    id serial primary key,
    idProducto int references producto(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    cantidad float not null,
    valor float,
    iva float,
    observaciones text,
    fechaRegistro timeStamp not null
);

create table insumo_terminacion(
    id serial primary key,
    idInsumoPT int references insumo_puestotrabajo (id) on delete restrict on update cascade,
    idEmpleado int references empleado (id) on delete restrict on update cascade,
    foto text not null,
    observaciones text,
    fechaRegistro timeStamp not null
);

create table novedad_puesto_trabajo(
    id serial primary key,
    idPuestoTrabajo int references puesto_trabajo(id) on delete cascade on update cascade,
    idEmpleado int references empleado (id) on delete restrict on update cascade,
    novedad text not null,
    fechaRegistro timeStamp not null
);

create table preparacion(
    id serial primary key,
    idRaspado int references raspado(id) on delete restrict on update cascade,
    idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null
);

create table reparacion(
    id serial primary key,
    idPreparacion int references preparacion(id) on delete restrict on update cascade,
    idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null
);

create table reparacion_parche(
    id serial primary key,
    idReparacion int references reparacion(id) on delete restrict on update cascade,
    idProducto int references producto(id) on delete restrict on update cascade,
    usuario varchar(30) references usuario(usuario) on delete restrict on update cascade,
    cantidad int not null,
    fechaRegistro timestamp not null
);

create table cementado(
    id serial primary key,
    idReparacion int references reparacion(id) on delete restrict on update cascade,
    idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null
);

create table relleno(
    id serial primary key,
    idCementado int references cementado(id) on delete restrict on update cascade,
    idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    empates int,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null
);

create table corte_banda(
    id serial primary key,
    idRelleno int references relleno(id) on delete restrict on update cascade,
    idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    foto text,
    observaciones text,
    fechaRegistro timeStamp not null
);

create table embandado(
    id serial primary key,
    idCorteBanda int references corte_banda(id) on delete restrict on update cascade,
    idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    idGravado int references gravado_llanta(id) on delete restrict on update cascade,
    anchoBanda float not null,
    largoBanda float not null,
    empates int,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null
);

create table vulcanizado(
    id serial primary key,
    idEmbandado int references embandado(id) on delete restrict on update cascade,
    idPuestoTrabajo int references puesto_trabajo(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    idEnvelope int references producto(id) on delete restrict on update cascade,
    metodo int not null,
    idTubo int references producto(id) on delete restrict on update cascade,
    idNeumatico int references producto(id) on delete restrict on update cascade,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null,
    fechaFinalizacion timeStamp
);

create table posicion_camara(
    id serial primary key,
    idVulcanizado int references vulcanizado(id) on delete restrict on update cascade,
    idServicio int references servicio (id) on delete restrict on update cascade,
    posicion varchar(20),
    foto text,
    fechaRegistro timeStamp not null
);

create table inspeccion_final(
    id serial primary key,
    idVulcanizado int references vulcanizado(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null
);

create table terminacion(
    id serial primary key,
    idInspeccion_final int references inspeccion_final(id) on delete restrict on update cascade,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    foto text,
    observaciones text,
    estado varchar(3) not null,
    checked boolean not null,
    fechaRegistro timestamp not null
);

create table servicio_fin(
    id serial primary key,
    idLlanta int references llanta(id) on delete restrict on update cascade,
    estado varchar(3) not null,
    observaciones text,
    fechaRegistro timestamp not null
);

create table solicitud_eliminar_llanta(
    id serial primary key,
    idLlanta int,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    motivo text not null,
    estado boolean not null,
    llantaJSON text not null,
    fechaRegistro timeStamp not null
);

create table rechazo_llanta (
    id serial primary key,
    idLlanta int not null unique references llanta(id) on delete restrict on update cascade,
    proceso int not null,
    idProceso int not null,
    observaciones text,
    fechaRegistro timeStamp not null
);

create table RLlanta_Detalle (
    id serial primary key,
    idRechazoLlanta int not null references rechazo_llanta(id) on delete restrict on update cascade,
    idRechazo int not null references rechazo(id) on delete restrict on update cascade,
    fechaRegistro timeStamp not null
);

create table Uso_Insumo_Proceso(
    id serial primary key,
    idEmpleado int not null references empleado(id) on delete restrict on update cascade,
    idProceso int not null,
    proceso int not null,
    fechaRegistro timeStamp not null
);

create table Uso_Insumo_Proceso_Detalle(
    id serial primary key,
    idUsoInsumoProceso int not null references Uso_Insumo_Proceso(id) on delete cascade on update cascade,
    idInsumoPT int not null references Insumo_PuestoTrabajo(id) on delete restrict on update cascade,
    terminado boolean,
    idEmpleado int references empleado(id) on delete restrict on update cascade,
    fechaRegistro timeStamp not null
);

insert into rol (nombre, estado, fechaRegistro) values ('Desarrollador', 't', now());
insert into usuario (usuario, clave, idrol, estado, fechaRegistro) values ('admin', md5('12345'), 1, 't', now());