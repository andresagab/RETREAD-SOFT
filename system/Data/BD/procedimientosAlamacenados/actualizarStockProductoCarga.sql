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