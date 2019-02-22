alter table corte_banda add column idPreparacion int references preparacion(id) on delete  restrict on update cascade;
alter table corte_banda add column estado boolean;
alter table corte_banda add column empates int;

alter table embandado drop column largobanda;
alter table embandado drop column anchobanda;

alter table embandado add column largoBanda float;
alter table embandado add column anchoBanda float;

alter table llanta add column fechaInicioProceso timeStamp;