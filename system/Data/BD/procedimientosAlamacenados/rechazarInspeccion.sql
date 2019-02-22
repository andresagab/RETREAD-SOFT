create or replace function registrarRechazos(idRII int, detalles varchar) returns int
as
$$
declare
	varIdRechazo int;
	cadena int;
	registro record;
begin
	--almacenar en RII_Detalles
	for registro in (select regexp_split_to_table(detalles, E'\\|') as detalle) loop
		cadena:=registro.detalle;
		--select into varIdRechazo subString(cadena, 0, position('|' in cadena));--
		select into varIdRechazo cadena;
		insert into RII_Detalles (idRII, idRechazo, fechaRegistro) values (idRII, varIdRechazo, now());
	end loop;
	--Fin almacenar en RII_Detalles
	return idRII;
end;
$$
language plpgsql;

--select registrarVenta (1, '1|30||1|5')