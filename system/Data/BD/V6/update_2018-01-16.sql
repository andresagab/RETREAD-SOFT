
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