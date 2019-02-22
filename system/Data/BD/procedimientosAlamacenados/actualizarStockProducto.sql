/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Andres Geovanny Angulo Botina <andrescabj981@gmail.com>
 * Created: 9/10/2017
 */

create or replace function actualizarStockProducto() returns trigger as
$$
    begin
        if TG_OP='INSERT' then
            update producto set stock=stock-new.cantidad where id=new.idInsumo;
        else
            if TG_OP='UPDATE' then
                update producto set stock=(stock+old.cantidad)-new.cantidad where id=old.idInsumo;
            else
                if TG_OP='DELETE' then
                    update producto set stock=stock+old.cantidad where id=old.idInsumo;
                end if;
            end if;
        end if;
        return null;
    end;
$$

language plpgsql;

drop trigger actualizarStockProducto on insumo_puestoTrabajo;
create trigger actualizarStockProducto after INSERT or DELETE or UPDATE on insumo_puestoTrabajo for EACH row EXECUTE PROCEDURE actualizarStockProducto();