create or replace function rechazarLlanta(idRLlanta int, detalles varchar) returns int
as
$$
declare
	varIdRechazo int;
	cadena int;
	registro record;
begin
	--almacenar en RLlanta_Detalle
	for registro in (select regexp_split_to_table(detalles, E'\\|') as detalle) loop
		cadena:=registro.detalle;
		select into varIdRechazo cadena;
		insert into RLlanta_Detalle (idRechazoLlanta, idRechazo, fechaRegistro) values (idRLlanta, varIdRechazo, now());
	end loop;
	--Fin almacenar en RLlanta_Detalle
	return idRLlanta;
end;
$$
language plpgsql;
