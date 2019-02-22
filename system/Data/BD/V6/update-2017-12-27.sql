
create table rechazo_llanta (
    id serial primary key,
    idLlanta int not null references llanta(id) on delete restrict on update cascade,
    proceso int not null,
    idProceso int not null,
    fechaRegistro timeStamp not null
);

create table RLlanta_Detalle (
    id serial primary key,
    idRechazoLlanta int not null references rechazo_llanta(id) on delete restrict on update cascade,
    idRechazo int not null references rechazo(id) on delete restrict on update cascade,
    fechaRegistro timeStamp not null
);