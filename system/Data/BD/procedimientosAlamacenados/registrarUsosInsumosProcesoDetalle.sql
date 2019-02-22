create or replace function registrarUsosInsumosProcesoDetalle(idUsoInsumoProceso int, idEmpleado int, detalles varchar) returns int
as
$$
declare
	varIdInsumoPT int;
	cadena int;
	registro record;
begin
	--almacenar en Uso_Insumo_Proceso_Detalle
	for registro in (select regexp_split_to_table(detalles, E'\\|') as detalle) loop
		cadena:=registro.detalle;
		select into varIdInsumoPT cadena;
		insert into Uso_Insumo_Proceso_Detalle (idUsoInsumoProceso, idInsumoPT, terminado, idEmpleado, fechaRegistro, usado) values (idUsoInsumoProceso, varIdInsumoPT, 'f', idEmpleado, now(), 't');
	end loop;
	--Fin almacenar en Uso_Insumo_Proceso_Detalle
	return idUsoInsumoProceso;
end;
$$
language plpgsql;

--select registrarVenta (1, '1|30||1|5')