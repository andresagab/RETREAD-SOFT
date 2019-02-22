create or replace function registrarTiposServicio(idServicio int, detalles varchar) returns int
as
$$
declare
	varIdTipoServicio int;
	cadena int;
	registro record;
begin
	--almacenar en Detalle_Servicio
	for registro in (select regexp_split_to_table(detalles, E'\\|') as detalle) loop
		cadena:=registro.detalle;
		--select into varIdTipoServicio subString(cadena, 0, position('|' in cadena));--
		select into varIdTipoServicio cadena;
		insert into Detalle_Servicio (idServicio, idTipoServicio, fechaRegistro) values (idServicio, varIdTipoServicio, now());
	end loop;
	--Fin almacenar en Detalle_Servicio
	return idServicio;
end;
$$
language plpgsql;

--select registrarVenta (1, '1|30||1|5')