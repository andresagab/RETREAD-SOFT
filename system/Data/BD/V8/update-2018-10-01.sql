create table carga_producto(
  id serial primary key,
  idProducto int references producto(id) on delete cascade on update cascade,
  idEmpleado int references empleado(id) on delete cascade on update cascade,
  cantidad double precision not null,
  fechaRegistro timestamp not null
);

create table carga_producto_puesto_trabajo(
  id serial primary key,
  idInsumoPuestoTrabajo int references insumo_puestotrabajo(id) on delete cascade on update cascade,
  idEmpleado int references empleado(id) on delete cascade on update cascade,
  cantidad double precision not null,
  fechaRegistro timestamp not null
);

create or replace function actualizarStockProductoCarga() returns trigger as
$$
begin
  if TG_OP='INSERT' then
    update producto set stock=stock+new.cantidad where id=new.idproducto;
  else
    if TG_OP='UPDATE' then
      update producto set stock=(stock+old.cantidad)-new.cantidad where id=old.idproducto;
    else
      if TG_OP='DELETE' then
        update producto set stock=stock-old.cantidad where id=old.idproducto;
      end if;
    end if;
  end if;
  return null;
end;
$$

language plpgsql;

drop trigger actualizarStockProductoCarga on carga_producto;
create trigger actualizarStockProductoCarga after INSERT or DELETE or UPDATE on carga_producto for EACH row EXECUTE PROCEDURE actualizarStockProductoCarga();

create or replace function actualizarStockProductoCargaPuestoTrabajo() returns trigger as
$$
begin
  if TG_OP='INSERT' then
    update insumo_puestotrabajo set cantidad=cantidad+new.cantidad where id=new.idinsumopuestotrabajo;
  else
    if TG_OP='UPDATE' then
      update insumo_puestotrabajo set cantidad=(cantidad+old.cantidad)-new.cantidad where id=old.idinsumopuestotrabajo;
    else
      if TG_OP='DELETE' then
        update insumo_puestotrabajo set cantidad=cantidad-old.cantidad where id=old.idinsumopuestotrabajo;
      end if;
    end if;
  end if;
  return null;
end;
$$

language plpgsql;

drop trigger actualizarStockProductoCargaPuestoTrabajo on carga_producto_puesto_trabajo;
create trigger actualizarStockProductoCargaPuestoTrabajo after INSERT or DELETE or UPDATE on carga_producto_puesto_trabajo for EACH row EXECUTE PROCEDURE actualizarStockProductoCargaPuestoTrabajo();