insert into rol(nombre, estado, fechaRegistro) 
values (
    'administrador',
    't',
    now()
);

insert into usuario(usuario, clave, idRol, estado, fechaRegistro)
values (
    'admin',
    md5('utilizar'),
    1,
    't',
    now()
);