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