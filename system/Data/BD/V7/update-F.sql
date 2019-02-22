--FIle create 12-09-2018--

/*
select r.anchobanda, r.largobanda
from llanta as ll, inspeccion_inicial as ii, raspado as r
where ll.idservicio=1
and ii.idllanta=ll.id
and r.idinspeccion=ii.id;*/

--Lines inserts since 2018-09-14

insert into persona (identificacion, nombres, apellidos, celular, fecharegistro)
values ('1085343280', 'Andres Geovanny', 'Angulo Botina', '3128293384', now()),
       ('1089459281', 'Jhonatan Alexander', 'Jojoa Rosero', '3183843057', now());

insert into empleado (identificacion, idcargo, fecharegistro)
values ('1085343280', 2, now()),
       ('1089459281', 3, now());

insert into usuario_persona (identificacion, idusuario, fecharegistro)
values ('1085343280', 3, now()),
       ('1089459281', 2, now()),
       ('98397416', 4, now());